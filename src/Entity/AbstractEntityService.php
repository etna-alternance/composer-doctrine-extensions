<?php

namespace ETNA\Doctrine\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractEntityService
{
    /** @var EntityManagerInterface L'entity manager */
    protected $em;

    /** @var ValidatorInterface Le service pour la validation des data */
    protected $validator;

    protected function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em        = $em;
        $this->validator = $validator;
    }

    /**
     * Filtre les champs directs (pas les jointures) de $datas, en fonction des groupes de validation
     * Et rempli l'entité avec les données filtrées, et éventuellement re-typées.

     * Permet de scénariser les modifications d'entités grace aux groupes de validation.
     *
     * @see https://symfony.com/doc/current/validation/groups.html
     *
     * @param array          $datas
     * @param array          $validation_groups
     * @param AbstractEntity $entity
     *
     * @return array
     */
    protected function setPropertiesToEntity(array $datas, array $validation_groups, AbstractEntity $entity)
    {
        $filtered_datas            = [];
        $validation_field_metadata = $this->validator->getMetadataFor($entity)->members;
        $doctrine_field_metadata   = $this->em->getClassMetadata(get_class($entity))->fieldMappings;
        $all_fields                = array_keys($doctrine_field_metadata);

        foreach ($datas as $field_name => $data_value) {
            $is_field_concerned = false;

            if (isset($validation_field_metadata[$field_name])) {
                $constraints             = array_shift($validation_field_metadata[$field_name]);
                $field_validation_groups = array_keys($constraints->constraintsByGroup);
                $is_field_concerned      = !empty(array_intersect($validation_groups, $field_validation_groups));
            }

            switch (true) {
                // Si la data concerne un champ qui ne fait pas parti de l'entité, on passe
                case !in_array($field_name, $all_fields) || !$is_field_concerned:
                    break;
                // Si la data concerne un champ date ou assimilé, et que c'est une string, on sette un DateTime
                case 1 === preg_match(
                    "#^(date|datetime|time)[a-z_]*$#",
                    $doctrine_field_metadata[$field_name]["type"]
                ):
                    if (is_string($data_value)) {
                        $filtered_datas[$field_name] = new \DateTime($data_value);
                    }
                    break;
                // Sinon on sette tel quel
                default:
                    $filtered_datas[$field_name] = $data_value;
                    break;
            }
        }

        $entity->setProperties($filtered_datas);
    }
}

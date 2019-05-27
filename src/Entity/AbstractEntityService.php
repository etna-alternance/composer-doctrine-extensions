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
     * Filtre les champs de $datas qui correspondent à ceux de $entity en se basant sur les groupes de validations.
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
    protected function filterDataByValidationGroups(array $datas, array $validation_groups, AbstractEntity $entity)
    {
        $entity_members_metadatas = $this->validator->getMetadataFor($entity)->members;
        $filtered_datas           = [];

        foreach ($entity_members_metadatas as $field_name => $all_field_metadatas) {
            $constraints             = array_shift($all_field_metadatas);
            $field_validation_groups = array_keys($constraints->constraintsByGroup);
            $is_field_concerned      = !empty(array_intersect($validation_groups, $field_validation_groups));

            if ($is_field_concerned && isset($datas[$field_name])) {
                $filtered_datas[$field_name] = $datas[$field_name];
            }
        }
        return $filtered_datas;
    }
}

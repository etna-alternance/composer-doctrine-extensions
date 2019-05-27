<?php

namespace ETNA\Doctrine\Extensions;

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;

/**
 * Le trait qui ajoute à une entité un ID tout ce qu'il y'a de plus classique
 */
trait AutoIncrementID
{
    /**
     * @var integer
     *
     * @Id @GeneratedValue
     * @Column(type="integer", name="id")
     */
    protected $id;

    /**
     * Retourne l'ID de l'entité concernée
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sette l'id de l'entité concernée.
     * Mais en fait c'est une blague, on veut pas faire ca :)
     *
     * @param integer $id Le nouvel ID
     */
    public function setId($id)
    {
        throw new \Exception(__METHOD__ . " : method not implemented");
    }
}

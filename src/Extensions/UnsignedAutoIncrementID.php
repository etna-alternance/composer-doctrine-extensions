<?php

namespace ETNA\Doctrine\Extensions;

use Doctrine\ORM\Mapping as ORM;

/**
 * Le trait qui ajoute à une entité un ID tout ce qu'il y'a de plus classique, sauf que celui la est unsigned
 */
trait UnsignedAutoIncrementID
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id", options={"unsigned"=true})
     */
    protected $id;

    /**
     * Retourne l'ID de l'entité concernée
     *
     * @return integer
     */
    public function getId(): ?int
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

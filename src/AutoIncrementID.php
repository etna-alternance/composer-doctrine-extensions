<?php

namespace ETNA\Doctrine\Extensions;

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;

trait AutoIncrementID
{
    /**
     * @Id @GeneratedValue
     * @Column(type="integer", name="id")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        throw new \Exception(__METHOD__ . " : method not implemented");
    }
}

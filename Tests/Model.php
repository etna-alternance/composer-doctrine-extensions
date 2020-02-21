<?php

namespace Tests;

use ETNA\Doctrine\Extensions\AutoIncrementID;
use ETNA\Doctrine\Extensions\CreatedAt;
use ETNA\Doctrine\Extensions\UpdatedAt;
use ETNA\Doctrine\Extensions\DoNotDelete;
use ETNA\Doctrine\Entity\AbstractEntity;
use ETNA\Doctrine\Extensions\GetSetDate;

/**
 * @Entity(repositoryClass="Tests\ModelRepository")
 * @Table(name="model")
 * @HasLifecycleCallbacks
 */
class Model extends AbstractEntity
{
    use AutoIncrementID;
    use CreatedAt;
    use UpdatedAt;
    use DoNotDelete;
    use GetSetDate;

    private $model_value;

    public function __construct()
    {
        $this->model_value = '';
    }

    public function setModelValue($value)
    {
        $this->model_value = $value;
    }

    public function getModelValue()
    {
        return $this->model_value;
    }

    public function populate($date)
    {
        $this->created_at = $this->updated_at = $this->deleted_at = $date;
    }

    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;
    }

    public function jsonSerialize()
    {
        return [
            'id'         => $this->getId(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_at' => $this->getDeletedAt()
        ];
    }
}

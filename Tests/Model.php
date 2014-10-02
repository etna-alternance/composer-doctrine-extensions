<?php

namespace Tests;

use ETNA\Doctrine\Extensions\AutoIncrementID;
use ETNA\Doctrine\Extensions\CreatedAt;
use ETNA\Doctrine\Extensions\UpdatedAt;
use ETNA\Doctrine\Extensions\DoNotDelete;

/**
 * @Entity(repositoryClass="Tests\ModelRepository")
 * @Table(name="model")
 * @HasLifecycleCallbacks
 */
class Model implements \JsonSerializable
{
    use AutoIncrementID;
    use CreatedAt;
    use UpdatedAt;
    use DoNotDelete;

    public function populate($date)
    {
        $this->created_at = $this->updated_at = $this->deleted_at = $date;
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

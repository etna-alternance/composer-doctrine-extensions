<?php

namespace ETNA\Doctrine\Extensions;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

trait UpdatedAt
{
    /**
     * @Column(type="datetime", name="updated_at")
     */
    private $updated_at;

    /**
     * Getter
     */
    public function getUpdatedAt($format = null)
    {
        switch (true) {
            case is_string($this->updated_at):
            case is_object($this->updated_at) && get_class($this->updated_at) !== 'DateTime':
                throw new \Exception("updated_at is not a datetime", 400);
            case $this->updated_at === null:
            case $format === null:
                return $this->updated_at;
            default:
                return $this->updated_at->format($format);
        }
    }

    /**
     * @PreUpdate
     * @PrePersist
     */
    public function setUpdatedAt()
    {
        $this->updated_at = new \DateTime(date('Y-m-d H:i:s'));
    }
}

<?php

namespace ETNA\Doctrine\Extensions;

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
            case is_object($this->updated_at) && get_class($this->updated_at) !== 'DateTime':
                throw new \Exception("updated_at is not a datetime", 400);
            case $this->updated_at === null:
            case is_string($this->updated_at):
            case $format === null:
                return $this->updated_at;
            default:
                return $this->updated_at->format($format);
        }
    }

    /**
     * @PrePersist
     */
    public function setUpdatedAtBeforePersist()
    {
        $this->updated_at = new \DateTime(date('Y-m-d H:i:s'));
    }

    /**
     * @PreUpdate
     */
    public function setUpdatedAtBeforeUpdate()
    {
        $this->updated_at = new \DateTime(date('Y-m-d H:i:s'));
    }
}

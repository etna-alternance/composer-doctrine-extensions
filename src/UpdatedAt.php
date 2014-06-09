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
        if (
            $format              === null ||
            $this->updated_at    === null ||
            !is_object($this->updated_at) ||
            get_class($this->updated_at)  !== 'DateTime'
        ) {
            return $this->updated_at;
        }
        return $this->updated_at->format($format);
    }

    /**
     * @PrePersist
     */
    public function setUpdatedAtBeforePersist()
    {
        $this->updated_at = new \DateTime("now");
    }

    /**
     * @PreUpdate
     */
    public function setUpdatedAtBeforeUpdate()
    {
        $this->updated_at = new \DateTime("now");
    }
}

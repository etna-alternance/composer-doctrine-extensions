<?php

namespace ETNA\Doctrine\Extensions;

trait CreatedAt
{
    /**
     * @Column(type="datetime", name="created_at")
     */
    private $created_at;

    /**
     * Getter
     */
    public function getCreatedAt($format = null)
    {
        if (
            $format              === null ||
            $this->created_at    === null ||
            !is_object($this->created_at) ||
            get_class($this->created_at)  !== 'DateTime'
        ) {
            return $this->created_at;
        }
        return $this->created_at->format($format);
    }

    /**
     * @PrePersist
     */
    public function setCreatedAtBeforePersist()
    {
        $this->created_at = new \DateTime("now");
    }
}

<?php

namespace ETNA\Doctrine\Extensions;

use Doctrine\ORM\Mapping as ORM;

trait CreatedAt
{
    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $created_at;

    /**
     * Getter
     */
    public function getCreatedAt($format = null)
    {
        return $this->getDateField('created_at', $format);
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtBeforePersist()
    {
        $this->created_at = new \DateTime(date('Y-m-d H:i:s'));
    }
}

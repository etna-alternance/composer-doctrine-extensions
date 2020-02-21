<?php

namespace ETNA\Doctrine\Extensions;

use Doctrine\ORM\Mapping as ORM;

trait UpdatedAt
{
    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private $updated_at;

    /**
     * Getter
     */
    public function getUpdatedAt($format = null)
    {
        return $this->getDateField('updated_at', $format);
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function setUpdatedAt()
    {
        $this->updated_at = new \DateTime(date('Y-m-d H:i:s'));
    }
}

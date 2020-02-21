<?php

namespace ETNA\Doctrine\Extensions;

use Doctrine\ORM\Mapping as ORM;

trait DoNotDelete
{
    /**
     * @ORM\Column(type="datetime", name="deleted_at", nullable=true)
     */
    private $deleted_at;

    /**
     * Getter
     */
    public function getDeletedAt($format = null)
    {
        return $this->getDateField('deleted_at', $format);
    }

    /**
     * Setter
     */
    public function setDeletedAt($datetime)
    {
        return $this->setDateField('deleted_at', $datetime);
    }

    /**
     * @ORM\PreRemove
     */
    public function canNotDelete()
    {
        throw new \Exception("Cannot delete " . get_class($this));
    }
}

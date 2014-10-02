<?php

namespace ETNA\Doctrine\Extensions;

trait DoNotDelete
{
    /**
     * @Column(type="datetime", name="deleted_at", nullable=true)
     */
    private $deleted_at;

    /**
     * Getter
     */
    public function getDeletedAt($format = null)
    {
        switch (true) {
            case is_object($this->deleted_at) && get_class($this->deleted_at) !== 'DateTime':
                throw new \Exception("deleted_at is not a datetime", 400);
            case $this->deleted_at === null:
            case is_string($this->deleted_at):
            case $format === null:
                return $this->deleted_at;
            default:
                return $this->deleted_at->format($format);
        }
    }

    /**
     * Setter
     */
    public function setDeletedAt($datetime)
    {
        switch (true) {
            case is_object($datetime) && get_class($datetime) !== 'DateTime':
            case is_string($datetime) && !preg_match("#^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$#", trim($datetime)):
                throw new \Exception("bad deleted_at provided", 400);
            default:
                $this->deleted_at = (is_object($datetime)) ? $datetime : new \DateTime($datetime);
        }

        return $this;
    }

    /**
     * @preRemove
     */
    public function canNotDelete()
    {
        throw new \Exception("Cannot delete " . get_class($this));
    }
}

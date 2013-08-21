<?php

namespace ETNA\Doctrine\Extensions;

trait DoNotDelete {
    /**
     * @Column(type="datetime", name="deleted_at", nullable=true)
     */
    private $deleted_at;
    
    /**
     * Getter
     */
    public function getDeletedAt($format = null)
    {
        if ($format === null || $this->deleted_at === null) {
            return $this->deleted_at;
        }
        return $this->deleted_at->format($format);
    }
    
    /**
     * Setter
     */
    public function setDeletedAt($datetime)
    {
        if ($datetime === null) {
            $this->deleted_at = null;
            return $this;
        }

        if (trim($datetime) == "" || !preg_match("#^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$#", $datetime)) {
            throw new \Exception("Bad datetime format ({$datetime})", 400);
        }

        $this->deleted_at = new \DateTime($datetime);
        return $this;
    }
    
    /**
     * @preRemove
     */
    public function doNotDelete()
    {
        throw new \Exception("Cannot delete " . get_class($this));
    }
}

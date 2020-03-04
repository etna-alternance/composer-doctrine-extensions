<?php

namespace ETNA\Doctrine\Extensions;

/**
 * Ce trait permet de mettre a disposition un getter et setter générique pour des dates
 */
trait GetSetDate
{
    /**
     * Recupère un champs date
     *
     * @param  string      $field_name nom du champs
     * @param  string|null $format     format du datetime
     *
     * @return \Datetime
     */
    protected function getDateField($field_name, $format = null)
    {
        if (!property_exists($this, $field_name)) {
            throw new \InvalidArgumentException(
                "No property {$field_name} found",
                400
            );
        }

        switch (true) {
            case is_string($this->{$field_name}):
            case is_object($this->{$field_name}) && 'DateTime' !== get_class($this->{$field_name}):
                throw new \Exception("{$field_name} is not a datetime", 400);
            case null === $this->{$field_name}:
            case null === $format:
                return $this->{$field_name};
            default:
                return $this->{$field_name}->format($format);
        }
    }

    /**
     * @param string $field_name
     * @param mixed  $date
     */
    protected function setDateField($field_name, $date)
    {
        if (!property_exists($this, $field_name)) {
            throw new \InvalidArgumentException(
                "No property {$field_name} found",
                400
            );
        }

        switch (true) {
            case is_object($date) && 'DateTime' !== get_class($date):
            case is_string($date) && !preg_match("#^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$#", trim($date)):
                throw new \Exception("bad {$field_name} provided", 400);
            case null === $date:
                $this->{$field_name} = null;
                break;
            default:
                $this->{$field_name} = $date instanceof \DateTime ? $date : new \DateTime($date);
        }

        return $this;
    }
}

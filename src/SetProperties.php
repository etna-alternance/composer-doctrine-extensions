<?php

namespace ETNA\Doctrine\Extensions;

/**
 * Ce trait permet aux classes concernées de setter ses propriétés depuis un array associatif
 */
trait SetProperties
{
    /**
     * Sette toute les valeurs d'un array associatif à $this
     *
     * @param  array $request_data
     *
     * @return self
     */
    public function setProperties(array $request_data)
    {
        foreach ($request_data as $field_name => $field_value) {
            $setter_name = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field_name)));
            if (method_exists($this, $setter_name)) {
                $this->{$setter_name}($field_value);
            }
        }

        return $this;
    }
}

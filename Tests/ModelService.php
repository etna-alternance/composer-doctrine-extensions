<?php

namespace Tests;

use ETNA\Doctrine\Entity\AbstractEntityService;

class ModelService extends AbstractEntityService
{
    public function __construct($em, $validator)
    {
        parent::__construct($em, $validator);
    }

    public function create($datas)
    {
        $model = new Model();

        $this->setPropertiesToEntity($datas, ['create'], $model);

        return $model;
    }
}

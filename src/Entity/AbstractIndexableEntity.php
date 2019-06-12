<?php

namespace ETNA\Doctrine\Entity;

abstract class AbstractIndexableEntity extends AbstractEntity
{
    abstract public function getId(): int;

    abstract public function toIndex(): array;
}

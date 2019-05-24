<?php

namespace ETNA\Doctrine\Entity;

use ETNA\Doctrine\Extensions\SetProperties;

abstract class AbstractEntity implements \JsonSerializable
{
    use SetProperties;
}

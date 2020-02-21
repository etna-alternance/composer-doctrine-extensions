<?php

namespace ETNA\Doctrine\Entity;

use ETNA\Doctrine\Extensions\ChangeSet;
use ETNA\Doctrine\Extensions\GetSetDate;
use ETNA\Doctrine\Extensions\SetProperties;

abstract class AbstractEntity implements \JsonSerializable
{
    use SetProperties;
    use GetSetDate;
    use ChangeSet;
}

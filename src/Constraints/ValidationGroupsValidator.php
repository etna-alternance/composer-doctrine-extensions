<?php

namespace ETNA\Doctrine\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidationGroupsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        return true;
    }
}

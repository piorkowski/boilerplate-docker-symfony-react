<?php

declare(strict_types=1);

namespace App\UI\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class NameRequiredWhenNewsletterMember extends Constraint
{
    public function validatedBy(): string
    {
        return NameRequiredWhenNewsletterMemberValidator::class;
    }

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}

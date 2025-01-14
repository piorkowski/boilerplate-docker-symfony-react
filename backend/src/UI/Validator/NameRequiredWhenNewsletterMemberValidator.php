<?php

declare(strict_types=1);

namespace App\UI\Validator;

use App\UI\DTO\RegistrationUserData;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NameRequiredWhenNewsletterMemberValidator extends ConstraintValidator
{
    private const string NAME_HAVE_TO_BE_PROVIDED = 'The "name" have to be provided';
    private const string NAME_CANNOT_BE_EMPTY = 'The "name" field cannot be null.';

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof NameRequiredWhenNewsletterMember) {
            throw new UnexpectedTypeException($constraint, NameRequiredWhenNewsletterMember::class);
        }

        if (!$value instanceof RegistrationUserData) {
            throw new UnexpectedTypeException($value, RegistrationUserData::class);
        }

        if (true === $value->newsletterMember && false === isset($value->name)) {
            $this->context->buildViolation(self::NAME_HAVE_TO_BE_PROVIDED)
                ->atPath('name')
                ->addViolation();
        }

        if (true === $value->newsletterMember && null === $value->name) {
            $this->context->buildViolation(self::NAME_CANNOT_BE_EMPTY)
                ->atPath('name')
                ->addViolation();
        }
    }
}

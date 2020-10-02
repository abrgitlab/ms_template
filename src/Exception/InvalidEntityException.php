<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidEntityException extends Exception
{
    protected object $entity;
    protected ConstraintViolationListInterface $violations;

    public static function onEntity($entity, ConstraintViolationListInterface $violations): InvalidEntityException
    {
        $violationsString = '';

        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $violationsString .=
                'Violation: ' . PHP_EOL .
                '  Property: ' . $violation->getPropertyPath() . PHP_EOL .
                '  Invalid value: ' . (is_array($violation->getInvalidValue()) ? json_encode($violation->getInvalidValue()) : $violation->getInvalidValue()) . PHP_EOL .
                '  Message: ' . $violation->getMessage() . PHP_EOL;
        }

        $exception = new static(
            'Entity validation failed for ' . get_class($entity).
            ' with ' . $violations->count() . ' violation(s).' . PHP_EOL .
            $violationsString
        );

        $exception->entity = $entity;
        $exception->violations = $violations;

        return $exception;
    }

    /**
     * @return object
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations()
    {
        return $this->violations;
    }
}

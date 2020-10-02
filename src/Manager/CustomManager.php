<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Action;
use App\Exception\InvalidEntityException;
use App\Model\AddModel;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CustomManager
{
    private ValidatorInterface $validator;
    private ManagerRegistry $managerRegistry;

    public function __construct(ValidatorInterface $validator, ManagerRegistry $managerRegistry)
    {
        $this->validator = $validator;
        $this->managerRegistry = $managerRegistry;
    }

    public function addModel(
        string $parameter,
        AddModel $addModel
    ): void {
        $action = (new Action())
            ->setPlayerId($addModel->playerId)
            ->setPeriodStart($this->getPeriodStart(new DateTime()));

        $violations = $this->validator->validate($action);
        if ($violations->count()) {
            throw InvalidEntityException::onEntity($action, $violations);
        }

        $em = $this->managerRegistry->getManagerForClass(Action::class);
        $em->persist($action);
        $em->flush();
    }

    public function getPeriodStart(DateTimeInterface $refDate, int $shift = 0): DateTimeInterface
    {
        return new DateTimeImmutable();
    }
}

<?php declare(strict_types=1);

namespace Somnambulist\Components\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Somnambulist\Components\Models\AggregateRoot;
use Somnambulist\Components\Models\Exceptions\EntityNotFoundException;

abstract class AbstractAggregateRepository
{
    public function __construct(protected EntityManagerInterface $em, protected string $class)
    {
    }

    public function get(string $id): AggregateRoot
    {
        return $this->em->find($this->class, $id) ?? throw EntityNotFoundException::entityNotFound($this->class, $id);
    }

    public function store(AggregateRoot $aggregate): void
    {
        $this->em->persist($aggregate);
        $this->em->flush();
    }

    public function destroy(AggregateRoot $aggregate): void
    {
        $this->em->remove($aggregate);
        $this->em->flush();
    }
}

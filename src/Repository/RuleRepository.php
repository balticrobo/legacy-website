<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Event\EventCompetition;
use BalticRobo\Website\Entity\Rule\Rule;
use BalticRobo\Website\Exception\Rule\RuleNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RuleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rule::class);
    }

    public function getById(int $id): Rule
    {
        $record = $this->find($id);
        if (!$record) {
            throw new RuleNotFoundException();
        }

        return $record;
    }

    public function getRulesByEventAndLocale(Event $event, string $locale): Collection
    {
        $records = $this->createQueryBuilder('r')
            ->join(EventCompetition::class, 'ec', Join::WITH, 'r.eventCompetition = ec.competition')
            ->join(Event::class, 'e', Join::WITH, 'ec.event = e.id')
            ->where('e.id = :eventId')
            ->andWhere('r.locale = :locale')
            ->getQuery()
            ->setParameter('eventId', $event->getId())
            ->setParameter('locale', $locale)
            ->getResult();

        return new ArrayCollection($records);
    }

    public function getRulesByEvent(Event $event): Collection
    {
        $records = $this->createQueryBuilder('r')
            ->join(Event::class, 'e')
            ->where('e.id = :eventId')
            ->getQuery()
            ->setParameter('eventId', $event->getId())
            ->getResult();

        return new ArrayCollection($records);
    }

    public function save(Rule $rule): void
    {
        $this->getEntityManager()->persist($rule);
        $this->getEntityManager()->flush();
    }
}

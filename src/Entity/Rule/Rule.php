<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Rule;

use BalticRobo\Website\Entity\Event\EventCompetition;
use BalticRobo\Website\Model\Cms\EditRuleDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="rules")
 * @ORM\Entity(repositoryClass="BalticRobo\Website\Repository\RuleRepository")
 */
class Rule
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $locale;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $lastUpdateAt;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Event\EventCompetition", inversedBy="rules")
     */
    private $eventCompetition;

    public static function createFromEditDTO(self $entity, EditRuleDTO $dto, \DateTimeImmutable $now): self
    {
        $entity->content = $dto->getContent();
        $entity->lastUpdateAt = $now;

        return $entity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getLastUpdateAt(): \DateTimeImmutable
    {
        return $this->lastUpdateAt;
    }

    public function getEventCompetition(): EventCompetition
    {
        return $this->eventCompetition;
    }
}

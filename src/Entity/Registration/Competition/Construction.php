<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Registration\Competition;

use BalticRobo\Website\Entity\Competition\Competition;
use BalticRobo\Website\Model\Registration\Competition\AddConstructionDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="registration_constructions")
 * @ORM\Entity
 */
class Construction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Registration\Competition\Team",
     *     inversedBy="constructions"
     * )
     */
    private $team;

    /**
     * @ORM\ManyToMany(targetEntity="BalticRobo\Website\Entity\Competition\Competition")
     * @ORM\JoinTable(name="registration_constructions_competitions",
     *     joinColumns={@ORM\JoinColumn(name="construction_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="competition_id", referencedColumnName="id")}
     * )
     *
     * @var Collection|Competition[]
     */
    private $competitions;

    /**
     * @ORM\ManyToMany(targetEntity="BalticRobo\Website\Entity\Registration\Competition\Member")
     * @ORM\JoinTable(name="registration_constructions_creators",
     *     joinColumns={@ORM\JoinColumn(name="construction_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="creator_id", referencedColumnName="id")}
     * )
     *
     * @var Collection|Member[]
     */
    private $creators;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    public function __construct()
    {
        $this->competitions = new ArrayCollection();
        $this->creators = new ArrayCollection();
    }

    public static function createFromAddDTO(AddConstructionDTO $dto, Team $team, \DateTimeImmutable $now): self
    {
        $entity = new self();
        $entity->name = $dto->getName();
        $entity->competitions = $dto->getCompetitions();
        $entity->creators = $dto->getCreators();
        $entity->team = $team;
        $entity->createdAt = $now;

        return $entity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    public function getCreators(): Collection
    {
        return $this->creators;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

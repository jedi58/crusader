<?php

namespace App\Entity;

use App\Repository\ForceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ForceRepository::class)
 * @ORM\Table(name="`force`")
 */
class Force
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true, nullable=false)
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     */
    private $public_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="forces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity=Faction::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $faction;

    /**
     * @ORM\OneToMany(targetEntity=Card::class, mappedBy="parent_force", orphanRemoval=true,cascade={"persist"})
     */
    private $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPublicId(): ?int
    {
        return $this->public_id;
    }

    /**
     * @param mixed $public_id
     */
    public function setPublicId(int $public_id): self
    {
        $this->public_id = $public_id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getFaction(): ?Faction
    {
        return $this->faction;
    }

    public function setFaction(?Faction $faction): self
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setParentForce($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getParentForce() === $this) {
                $card->setParentForce(null);
            }
        }

        return $this;
    }
}

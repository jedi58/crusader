<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
 */
class Card
{
    /**
     *
     */
    const RANK_BLOODIED = 'Bloodied';

    /**
     *
     */
    const RANK_BATTLE_HARDENED = 'Battle-Hardened';

    /**
     *
     */
    const RANK_HEROIC = 'Heroic';

    /**
     *
     */
    const RANK_LEGENDARY = 'Legendary';

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Force::class, inversedBy="cards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parent_force;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=BattlefieldRole::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $keywords;

    /**
     * @ORM\Column(type="integer")
     */
    private $power_rating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $exp;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $crusade_points;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $equipment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $psychic;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $warlord_traits;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $relics;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $other_upgrades;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $battles_played = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $battles_survived = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $kills_battle_count = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $kills_battle_psychic = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $kills_battle_ranged = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $kills_battle_melee = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $kills_total_count = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $kills_total_psychic = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $kills_total_ranged = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $kills_total_melee = 0;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $rank;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $agenda1;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $agenda2;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $agenda3;

    /**

     */
    private $scars = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $honours = [];

    public function getId(): ?string
    {
        return $this->id;
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

    public function getRole(): ?BattlefieldRole
    {
        return $this->role;
    }

    public function setRole(?BattlefieldRole $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getPowerRating(): ?int
    {
        return $this->power_rating;
    }

    public function setPowerRating(int $power_rating): self
    {
        $this->power_rating = $power_rating;

        return $this;
    }

    public function getExp(): ?int
    {
        return $this->exp;
    }

    /**
     * @param int|null $exp
     * @return $this
     */
    public function setExp(?int $exp): self
    {
        $this->exp = $exp;

        return $this;
    }

    public function getCrusadePoints(): ?int
    {
        return $this->crusade_points;
    }

    /**
     * Should be >= count of battle honours
     * @param int|null $crusade_points
     * @return $this
     */
    public function setCrusadePoints(?int $crusade_points): self
    {
        $this->crusade_points = $crusade_points;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEquipment(): ?string
    {
        return $this->equipment;
    }

    public function setEquipment(?string $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getPsychic(): ?string
    {
        return $this->psychic;
    }

    public function setPsychic(?string $psychic): self
    {
        $this->psychic = $psychic;

        return $this;
    }

    public function getWarlordTraits(): ?string
    {
        return $this->warlord_traits;
    }

    public function setWarlordTraits(?string $warlord_traits): self
    {
        $this->warlord_traits = $warlord_traits;

        return $this;
    }

    public function getRelics(): ?string
    {
        return $this->relics;
    }

    public function setRelics(?string $relics): self
    {
        $this->relics = $relics;

        return $this;
    }

    public function getOtherUpgrades(): ?string
    {
        return $this->other_upgrades;
    }

    public function setOtherUpgrades(?string $other_upgrades): self
    {
        $this->other_upgrades = $other_upgrades;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getParentForce(): ?Force
    {
        return $this->parent_force;
    }

    public function setParentForce(?Force $parent_force): self
    {
        $this->parent_force = $parent_force;

        return $this;
    }

    public function getBattlesPlayed(): ?int
    {
        return $this->battles_played;
    }

    public function setBattlesPlayed(?int $battles_played): self
    {
        $this->battles_played = $battles_played;

        return $this;
    }

    public function getBattlesSurvived(): ?int
    {
        return $this->battles_survived;
    }

    public function setBattlesSurvived(?int $battles_survived): self
    {
        $this->battles_survived = $battles_survived;

        return $this;
    }

    public function getKillsBattleCount(): ?int
    {
        return $this->kills_battle_count;
    }

    public function setKillsBattleCount(?int $kills_battle_count): self
    {
        $this->kills_battle_count = $kills_battle_count;

        return $this;
    }

    public function getKillsBattlePsychic(): ?int
    {
        return $this->kills_battle_psychic;
    }

    public function setKillsBattlePsychic(?int $kills_battle_psychic): self
    {
        $this->kills_battle_psychic = $kills_battle_psychic;

        return $this;
    }

    public function getKillsBattleRanged(): ?int
    {
        return $this->kills_battle_ranged;
    }

    public function setKillsBattleRanged(?int $kills_battle_ranged): self
    {
        $this->kills_battle_ranged = $kills_battle_ranged;

        return $this;
    }

    public function getKillsBattleMelee(): ?int
    {
        return $this->kills_battle_melee;
    }

    public function setKillsBattleMelee(?int $kills_battle_melee): self
    {
        $this->kills_battle_melee = $kills_battle_melee;

        return $this;
    }

    public function getKillsTotalCount(): ?int
    {
        return $this->kills_total_count;
    }

    public function setKillsTotalCount(?int $kills_total_count): self
    {
        $this->kills_total_count = $kills_total_count;

        return $this;
    }

    public function getKillsTotalPsychic(): ?int
    {
        return $this->kills_total_psychic;
    }

    public function setKillsTotalPsychic(?int $kills_total_psychic): self
    {
        $this->kills_total_psychic = $kills_total_psychic;

        return $this;
    }

    public function getKillsTotalRanged(): ?int
    {
        return $this->kills_total_ranged;
    }

    public function setKillsTotalRanged(?int $kills_total_ranged): self
    {
        $this->kills_total_ranged = $kills_total_ranged;

        return $this;
    }

    public function getKillsTotalMelee(): ?int
    {
        return $this->kills_total_melee;
    }

    public function setKillsTotalMelee(?int $kills_total_melee): self
    {
        $this->kills_total_melee = $kills_total_melee;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     */
    public function setRank($rank): void
    {
        $this->rank = $rank;
    }

    /**
     * @return mixed
     */
    public function getAgenda1()
    {
        return $this->agenda1;
    }

    /**
     * @param mixed $agenda1
     */
    public function setAgenda1($agenda1): void
    {
        $this->agenda1 = $agenda1;
    }

    /**
     * @return mixed
     */
    public function getAgenda2()
    {
        return $this->agenda2;
    }

    /**
     * @param mixed $agenda2
     */
    public function setAgenda2($agenda2): void
    {
        $this->agenda2 = $agenda2;
    }

    /**
     * @return mixed
     */
    public function getAgenda3()
    {
        return $this->agenda3;
    }

    /**
     * @param mixed $agenda3
     */
    public function setAgenda3($agenda3): void
    {
        $this->agenda3 = $agenda3;
    }

    /**
     * @return array
     */
    public function getScars(): array
    {
        return $this->scars;
    }

    /**
     * @param array $scars
     */
    public function setScars(array $scars): void
    {
        $this->scars = $scars;
    }

    public function addScar($scar): void
    {
        if (sizeof($this->scar) < 6) {
            $this->scar[] = $scar;
        }
    }

    /**
     * @return array
     */
    public function getHonours(): array
    {
        return $this->honours;
    }

    /**
     * @param array $honours
     */
    public function setHonours(array $honours): void
    {
        $this->honours = $honours;
    }

    public function addHonour($honour): void
    {
        if (sizeof($this->honours) < 6) {
            $this->honours[] = $honour;
        }
    }
}

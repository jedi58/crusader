<?php

namespace App\Entity;

use App\Repository\BattlefieldRoleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BattlefieldRoleRepository::class)
 */
class BattlefieldRole
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

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
}

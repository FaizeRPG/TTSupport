<?php

namespace App\Entity;

use App\Repository\JdrPlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JdrPlayerRepository::class)
 */
class JdrPlayer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dices;

    /**
     * @ORM\Column(type="integer")
     */
    private $diceCount;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $result;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="jdrPlayers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=Jdr::class, inversedBy="jdrPlayers")
     */
    private $jdr;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_add;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_upd;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    public function __construct()
    {
		$this->diceCount = 0;
		$this->isActive = TRUE;
		$this->token = $this->createToken();
		$this->date_add = new \Datetime();
		$this->date_upd = new \Datetime();
    }
	
	public function __toString() {
         		return $this->getName();
         	}

    public function getId(): ?int
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDices(): ?string
    {
        return $this->dices;
    }

    public function setDices(?string $dices): self
    {
        $this->dices = $dices;

        return $this;
    }

    public function getDiceCount(): ?int
    {
        return $this->diceCount;
    }

    public function setDiceCount(int $diceCount): self
    {
        $this->diceCount = $diceCount;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
	
    public function getToken()
    {
        return $this->token;
    }

    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }
	
	public function createToken() {
         		$token = random_bytes(15);
         		$token = base64_encode($token);
         		
         		$this->apiToken = substr($token, 0, 31);
         	}

    public function getResult()
    {
        return $this->result;
    }

    public function setResult(string $result)
    {
        $this->result = $result;

        return $this;
    }

    public function getJdr(): ?Jdr
    {
        return $this->jdr;
    }

    public function setJdr(?Jdr $jdr): self
    {
        $this->jdr = $jdr;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->date_add;
    }

    public function setDateAdd(\DateTimeInterface $date_add): self
    {
        $this->date_add = $date_add;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->date_upd;
    }

    public function setDateUpd(\DateTimeInterface $date_upd): self
    {
        $this->date_upd = $date_upd;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}

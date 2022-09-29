<?php

namespace App\Entity;

use App\Repository\JdrRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JdrRepository::class)
 */
class Jdr
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=31)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="jdrs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $admin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_add;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_upd;

    /**
     * @ORM\OneToMany(targetEntity=JdrPlayer::class, mappedBy="jdr")
     */
    private $jdrPlayers;

    public function __construct()
    {
		$this->date_add = new \Datetime();
		$this->date_upd = new \Datetime();
		$this->jdrPlayers = new ArrayCollection();
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

    public function getAdmin(): ?User
    {
        return $this->admin;
    }

    public function setAdmin(?User $admin): self
    {
        $this->admin = $admin;

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

    /**
     * @return Collection<int, JdrPlayer>
     */
    public function getJdrPlayers(): Collection
    {
        return $this->jdrPlayers;
    }

    public function addJdrPlayer(JdrPlayer $jdrPlayer): self
    {
        if (!$this->jdrPlayers->contains($jdrPlayer)) {
            $this->jdrPlayers[] = $jdrPlayer;
            $jdrPlayer->setJdr($this);
        }

        return $this;
    }

    public function removeJdrPlayer(JdrPlayer $jdrPlayer): self
    {
        if ($this->jdrPlayers->removeElement($jdrPlayer)) {
            // set the owning side to null (unless already changed)
            if ($jdrPlayer->getJdr() === $this) {
                $jdrPlayer->setJdr(null);
            }
        }

        return $this;
    }
}

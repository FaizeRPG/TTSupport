<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=31, nullable=true, unique=true)
     */
    private $apiToken;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_add;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_upd;

    /**
     * @ORM\OneToMany(targetEntity=JdrPlayer::class, mappedBy="owner")
     */
    private $jdrPlayers;

    /**
     * @ORM\OneToMany(targetEntity=Jdr::class, mappedBy="admin")
     */
    private $jdrs;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    public function __construct()
    {
		$this->token = $this->createToken();
		$this->date_add = new \Datetime();
		$this->date_upd = new \Datetime();
		$this->jdrPlayers = new ArrayCollection();
		$this->jdrs = new ArrayCollection();
		$this->isActive = TRUE;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

	public function __toString() {
                  		return $this->getUsername();
                  	}

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }
	
	public function createToken() {
         		$token = random_int(0, 999999999999999);
         		
         		$this->apiToken = str_pad($token, 31, "0", STR_PAD_LEFT);
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
	
    /**
     * @return Collection<int, Jdr>
     */
    public function getJdrs(): Collection
    {
        return $this->jdrs;
    }

    public function addJdrs(Jdr $jdrs): self
    {
        if (!$this->jdrs->contains($jdrs)) {
            $this->jdrs[] = $jdrs;
            $jdrs->setJdr($this);
        }

        return $this;
    }

    public function removeJdrs(Jdr $jdrs): self
    {
        if ($this->jdrs->removeElement($jdrs)) {
            // set the owning side to null (unless already changed)
            if ($jdrs->getJdr() === $this) {
                $jdrs->setJdr(null);
            }
        }

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

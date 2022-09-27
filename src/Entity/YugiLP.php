<?php

namespace App\Entity;

use App\Repository\YugiLPRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=YugiLPRepository::class)
 */
class YugiLP
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $ref;

    /**
     * @ORM\Column(type="integer")
     */
    private $lpa;

    /**
     * @ORM\Column(type="integer")
     */
    private $lpb;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_add;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_upd;

    public function __construct()
    {
	$this->lpa = 8000;
	$this->lpb = 8000;
	$this->date_add = new \Datetime();
	$this->date_upd = new \Datetime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getLpa(): ?int
    {
        return $this->lpa;
    }

    public function setLpa(int $lpa): self
    {
        $this->lpa = $lpa;

        return $this;
    }

    public function getLpb(): ?int
    {
        return $this->lpb;
    }

    public function setLpb(int $lpb): self
    {
        $this->lpb = $lpb;

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
}

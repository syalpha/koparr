<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetrans;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     */
    private $idcompte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     */
    private $iduser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDatetrans(): ?\DateTimeInterface
    {
        return $this->datetrans;
    }

    public function setDatetrans(\DateTimeInterface $datetrans): self
    {
        $this->datetrans = $datetrans;

        return $this;
    }

    public function getIdcompte(): ?Compte
    {
        return $this->idcompte;
    }

    public function setIdcompte(?Compte $idcompte): self
    {
        $this->idcompte = $idcompte;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }
}

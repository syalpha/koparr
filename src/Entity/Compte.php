<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 */
class Compte
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
    private $numcompte;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="comptes")
     */
    private $identreprise;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="idcompte")
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumcompte(): ?int
    {
        return $this->numcompte;
    }

    public function setNumcompte(int $numcompte): self
    {
        $this->numcompte = $numcompte;

        return $this;
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

    public function getIdentreprise(): ?Entreprise
    {
        return $this->identreprise;
    }

    public function setIdentreprise(?Entreprise $identreprise): self
    {
        $this->identreprise = $identreprise;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setIdcompte($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getIdcompte() === $this) {
                $transaction->setIdcompte(null);
            }
        }

        return $this;
    }
}

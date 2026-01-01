<?php

namespace App\Entity;

use App\Repository\Sikla0Repository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Sikla0Repository::class)]
class Sikla0
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $realise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getRealise(): ?\DateTime
    {
        return $this->realise;
    }

    public function setRealise(?\DateTime $realise): static
    {
        $this->realise = $realise;

        return $this;
    }
}

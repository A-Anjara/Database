<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Id;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255,unique:true,nullable:true)]
    private ?string $email = null;

    #[ORM\Column(length: 7,unique: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fokontany = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $activite = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nif = null;

    #[ORM\Column(length: 30)]
    private ?string $personne = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $parent = null;

    #[ORM\Column]
    private ?int $solde = 0;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): static{
        $this->id = $id;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {

        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        
        if(preg_match('/.+?@.+?\..+/',$email)){
            $this->email = $email;
        }
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $telephone = str_replace(" ","",$telephone);
        if(preg_match('/^[0-9]+$/',$telephone)){

            $this->telephone = $telephone;
        }

        return $this;
    }

    public function getFokontany(): ?string
    {
        return $this->fokontany;
    }

    public function setFokontany(?string $fokontany): static
    {
        $this->fokontany = $fokontany;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(?string $activite): static
    {
        $this->activite = $activite;

        return $this;
    }

    public function getNif(): ?string
    {
        return $this->nif;
    }

    public function setNif(?string $nif): static
    {
        $nif = str_replace(" ","",$nif);
        if(preg_match('/^[0-9]+$/',$nif)){
            $this->nif = $nif;
        }

        return $this;
    }

    public function getPersonne(): ?string
    {
        return $this->personne;
    }

    public function setPersonne(string $personne): static
    {
        if(preg_match('/(MORALE)/i',$personne)){
            $personne = "MORALE";
        }
        else{
            $personne = "PHYSIQUE";
        }
        $this->personne = $personne;

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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        if($this->id == $parent->id){
            return $this;
        }
        $this->parent = $parent;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): static
    {
        $this->solde = $solde;

        return $this;
    }
}

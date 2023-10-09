<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    const ETAT_ENREGISTREE_PAYEE = 0;
    const ETAT_EN_PREPARATION = 1;
    const ETAT_EN_COURS_LIVRAISON = 2;
    const ETAT_LIVREE = 3;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $total = null;

    #[ORM\Column(type: "integer")]
    private ?int $etat = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Detail::class)]
    private Collection $details;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $adresseLivraison = null;

    #[ORM\Column(type: "string", length: 5, nullable: true)]
    private ?string $codePostalLivraison = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $villeLivraison = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $adresseFacturation = null;

    #[ORM\Column(type: "string", length: 5, nullable: true)]
    private ?string $codePostalFacturation = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $villeFacturation = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private ?string $modePaiement = null;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): static
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->details->contains($detail)) {
            $this->details->add($detail);
            $detail->setCommande($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getCommande() === $this) {
                $detail->setCommande(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }


    public function getAdresseLivraison(): ?string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(?string $adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    public function getCodePostalLivraison(): ?string
    {
        return $this->codePostalLivraison;
    }

    public function setCodePostalLivraison(?string $codePostalLivraison): self
    {
        $this->codePostalLivraison = $codePostalLivraison;

        return $this;
    }

    public function getVilleLivraison(): ?string
    {
        return $this->villeLivraison;
    }

    public function setVilleLivraison(?string $villeLivraison): self
    {
        $this->villeLivraison = $villeLivraison;

        return $this;
    }

    public function getAdresseFacturation(): ?string
    {
        return $this->adresseFacturation;
    }

    public function setAdresseFacturation(?string $adresseFacturation): self
    {
        $this->adresseFacturation = $adresseFacturation;

        return $this;
    }

    public function getCodePostalFacturation(): ?string
    {
        return $this->codePostalFacturation;
    }

    public function setCodePostalFacturation(?string $codePostalFacturation): self
    {
        $this->codePostalFacturation = $codePostalFacturation;

        return $this;
    }

    public function getVilleFacturation(): ?string
    {
        return $this->villeFacturation;
    }

    public function setVilleFacturation(?string $villeFacturation): self
    {
        $this->villeFacturation = $villeFacturation;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(?string $modePaiement): self
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    #[ORM\Column(type: "boolean")]
    private ?bool $accepterCGU = false;

    public function getAccepterCGU(): ?bool
    {
        return $this->accepterCGU;
    }

    public function setAccepterCGU(bool $accepterCGU): self
    {
        $this->accepterCGU = $accepterCGU;

        return $this;
    }
}

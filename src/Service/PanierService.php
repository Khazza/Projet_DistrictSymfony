<?php 

namespace App\Service;

use App\Entity\Plat;
use App\Repository\PlatRepository;

class PanierService
{
    private $platRepository;

    public function __construct(PlatRepository $platRepository)
    {
        $this->platRepository = $platRepository;
    }

    public function getPanier(array $sessionPanier): array
    {
        return $sessionPanier;
    }

    public function getPanierTotal(array $sessionPanier): int
    {
        return array_sum($sessionPanier);
    }

    public function add(Plat $plat, array $sessionPanier): array
    {
        if (isset($sessionPanier[$plat->getId()])) {
            $sessionPanier[$plat->getId()]++;
        } else {
            $sessionPanier[$plat->getId()] = 1;
        }

        return $sessionPanier;
    }

    public function removeOne(Plat $plat, array $sessionPanier): array
    {
        if (isset($sessionPanier[$plat->getId()])) {
            if ($sessionPanier[$plat->getId()] > 1) {
                $sessionPanier[$plat->getId()]--;
            } else {
                unset($sessionPanier[$plat->getId()]);
            }
        }

        return $sessionPanier;
    }

    public function removeItem(Plat $plat, array $sessionPanier): array
    {
        if (isset($sessionPanier[$plat->getId()])) {
            unset($sessionPanier[$plat->getId()]);
        }

        return $sessionPanier;
    }

    public function clear(): array
    {
        return [];
    }

    public function getDetailPanier(array $sessionPanier): array
    {
        $detailPanier = [];

        foreach ($sessionPanier as $id => $quantite) {
            $plat = $this->platRepository->find($id);
            if ($plat) {
                $detailPanier[] = [
                    'plat' => $plat,
                    'quantite' => $quantite,
                    'categorie' => $plat->getCategorie(),
                ];
            }
        }

        return $detailPanier;
    }

    public function updatePanierTotal(array $sessionPanier): int
    {
        return array_sum($sessionPanier);
    }
}

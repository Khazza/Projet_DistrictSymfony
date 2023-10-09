<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use App\Entity\Plat;
use App\Service\PanierService;

class PanierController extends AbstractController
{
    private $panierService;

    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService;
    }

    #[Route('/', name: 'app_panier')]
    public function index(SessionInterface $session, PlatRepository $repo, CategorieRepository $catRepo): Response
    {
        $plats = $repo->findAll();
        $categories = $catRepo->findAll();
        $panierTotal = $this->getPanierTotal($session);

        $platsByCategories = [];
        foreach ($categories as $category) {
            $platsByCategories[$category->getLibelle()] = [];
        }
        foreach ($plats as $plat) {
            $platsByCategories[$plat->getCategorie()->getLibelle()][] = $plat;
        }

        return $this->render('catalogue/listPlat.html.twig', [
            'platsByCategories' => $platsByCategories,
            'panierTotal' => $panierTotal,
        ]);
    }

    #[Route('/panier/ajout/{id}', name: 'panier_ajout')]
    public function add(Plat $plat, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        $updatedPanier = $this->panierService->add($plat, $panier);
        $session->set('panier', $updatedPanier);
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier', name: 'panier')]
    public function panier(SessionInterface $session, Request $request): Response
    {
        $panier = $session->get('panier', []);
        $detailPanier = $this->panierService->getDetailPanier($panier);

        $referer = $request->headers->get('referer');

        return $this->render('panier/panier.html.twig', [
            'panier' => $panier,
            'detailPanier' => $detailPanier,
            'referer' => $referer,
        ]);
    }

    #[Route('/panier/retrait/{id}', name: 'panier_retrait')]
    public function removeOne(Plat $plat, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        $updatedPanier = $this->panierService->removeOne($plat, $panier);
        $session->set('panier', $updatedPanier);
        return $this->redirectToRoute("panier");
    }

    #[Route('/panier/supprimer/{id}', name: 'panier_supprimer')]
    public function removeItem(Plat $plat, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        $updatedPanier = $this->panierService->removeItem($plat, $panier);
        $session->set('panier', $updatedPanier);
        return $this->redirectToRoute("panier");
    }

    #[Route('/panier/vider', name: 'panier_vider')]
    public function clear(SessionInterface $session): Response
    {
        $session->set("panier", []);
        return $this->redirectToRoute("panier");
    }

    public function getPanierTotal(SessionInterface $session): int
    {
        $panier = $session->get("panier", []);
        return $this->panierService->getPanierTotal($panier);
    }

    public function updatePanierTotal(SessionInterface $session): void
    {
        $panierTotal = $this->getPanierTotal($session);
        $session->set('panierTotal', $panierTotal);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;


class CatalogueController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(CategorieRepository $categorieRepository, PlatRepository $platRepository): Response
    {
        $popularCategories = $categorieRepository->findPopularCategories();
        $popularPlats = $platRepository->findMostPopularPlats();

        return $this->render('catalogue/index.html.twig', [
            'popularCategories' => $popularCategories,
            'popularPlats' => $popularPlats,
        ]);
    }

    #[Route('/categories/{page?1}', name: 'categories_list')]
    public function list(CategorieRepository $categorieRepo, int $page): Response
    {
        $limit = 6;
        $offset = ($page - 1) * $limit;

        $categories = $categorieRepo->findBy([], null, $limit, $offset);
        $totalCategories = count($categorieRepo->findAll());
        $numberOfPages = ceil($totalCategories / $limit);

        return $this->render('catalogue/list.html.twig', [
            'categories' => $categories,
            'current_page' => $page,
            'total_pages' => $numberOfPages,
        ]);
    }


    #[Route('/category/{id}/plats/{page?1}', name: 'category_plats')]
    public function show(Categorie $categorie, int $page, PlatRepository $platRepo): Response
    {
        $limit = 4;  // nombre de plats par page
        $offset = ($page - 1) * $limit;

        $plats = $platRepo->findBy(['categorie' => $categorie], null, $limit, $offset);
        $totalPlats = count($platRepo->findBy(['categorie' => $categorie]));
        $numberOfPages = ceil($totalPlats / $limit);

        return $this->render('catalogue/show.html.twig', [
            'categorie' => $categorie,
            'plats' => $plats,
            'current_page' => $page,
            'total_pages' => $numberOfPages,
        ]);
    }

    #[Route('/plats', name: 'plats_list')]
    public function listPlat(PlatRepository $platRepo, CategorieRepository $categorieRepo): Response
    {
        $categories = $categorieRepo->findAll();
        $platsByCategories = [];

        foreach ($categories as $categorie) {
            $platsByCategories[$categorie->getLibelle()] = $platRepo->findBy(['categorie' => $categorie]);
        }

        return $this->render('catalogue/listPlat.html.twig', [
            'platsByCategories' => $platsByCategories,
        ]);
    }

    #[Route('/recherche/{page?1}', name: 'app_recherche')]
    public function recherche(Request $request, PlatRepository $platRepo, CategorieRepository $catRepo, int $page): Response
    {
        $query = trim($request->query->get('q'));

        if (empty($query)) {
            $this->addFlash('danger', 'Le champ de recherche ne peut pas être vide.');
            return $this->redirectToRoute('app_home');
        }
        
        // $query = $request->query->get('q');
    
        $limit = 4; // Nombre de plats par page
        $offset = ($page - 1) * $limit;
    
        if ($query) {
            $platsQuery = $platRepo->createQueryBuilder('p')
                ->leftJoin('p.categorie', 'c')
                ->where('p.libelle LIKE :query')
                ->orWhere('c.libelle LIKE :query')
                ->setParameter('query', '%' . $query . '%');
    
            // Pour obtenir le nombre total de plats
            $totalPlats = count($platsQuery->getQuery()->getResult());
    
            // Calculer le nombre de pages
            $numberOfPages = ceil($totalPlats / $limit);
    
            // Puis pour obtenir les plats pour la page actuelle
            $plats = $platsQuery
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
    
            $categories = $catRepo->createQueryBuilder('c')
                ->where('c.libelle LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();
        } else {
            $plats = [];
            $categories = [];
            $totalPlats = 0;
            $numberOfPages = 1;
        }
    
        return $this->render('catalogue/recherche.html.twig', [
            'plats' => $plats,
            'categories' => $categories,
            'query' => $query,
            'current_page' => $page,
            'total_pages' => $numberOfPages,
        ]);
    }
    
}
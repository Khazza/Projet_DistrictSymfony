<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CommandeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\PlatRepository;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commande;
use App\Entity\Detail;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use App\Event\OrderConfirmedEvent;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->redirectToRoute('commande_formulaire');
    }


    #[Route('/commande/formulaire', name: 'commande_formulaire')]
    public function formulaire(
        Request $request,
        SessionInterface $session,
        PlatRepository $repo,
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $user = $this->getUser();

        $panier = $session->get("panier", []);

        $nouveau_panier = [];
        foreach ($panier as $id => $quantite) {
            $plat = $repo->find($id);
            if ($plat) {
                $nouveau_panier[] = [
                    'plat' => $plat,
                    'quantite' => $quantite,
                ];
            }
        }

        $form = $this->createForm(CommandeType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $total = 0;
            foreach ($nouveau_panier as $item) {
                $total += $item['plat']->getPrix() * $item['quantite'];
            }
        
            $data = $form->getData();

            $orderData = [
                'panier' => $nouveau_panier,
                'total' => $total,
                'adresseLivraison' => $data['adresseLivraison'],
                'codePostalLivraison' => $data['codePostalLivraison'],
                'villeLivraison' => $data['villeLivraison'],
            ];

            $userData = [
                'email' => $user->getEmail(),
                'username' => $user->getUserIdentifier(),
            ];

            // code pour enregistrer la commande en base de données
            $commande = new Commande();
            $commande->setDateCommande(new \DateTime());
            $commande->setTotal($total);
            $commande->setEtat(Commande::ETAT_ENREGISTREE_PAYEE);
            $commande->setUtilisateur($user);
            $commande->setAdresseLivraison($data['adresseLivraison']);
            $commande->setCodePostalLivraison($data['codePostalLivraison']);
            $commande->setVilleLivraison($data['villeLivraison']);
            $commande->setAdresseFacturation($data['adresseFacturation']);
            $commande->setCodePostalFacturation($data['codePostalFacturation']);
            $commande->setVilleFacturation($data['villeFacturation']);
            $commande->setModePaiement($data['modePaiement']);
            $commande->setAccepterCGU($data['accepterCGU']);

            foreach ($nouveau_panier as $item) {
                $detail = new Detail();
                $detail->setQuantite($item['quantite']);
                $detail->setPlat($item['plat']);
                $detail->setCommande($commande);
                $entityManager->persist($detail);
            }

            $entityManager->persist($commande);
            $entityManager->flush();

            $event = new OrderConfirmedEvent($userData, $orderData);
            $eventDispatcher->dispatch($event, OrderConfirmedEvent::NAME);

            $session->remove('panier');
            $session->set('panierTotal', 0);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('commande/formulaire.html.twig', [
            'form' => $form->createView(),
            'nouveau_panier' => $nouveau_panier,
        ]);
    }
}

<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    #[Route('/mentions-legales', name: 'legal_mentions')]
    public function mentionsLegales(): Response
    {
        return $this->render('legal/mentions.html.twig');
    }

    #[Route('/politique-confidentialite', name: 'privacy_policy')]
    public function politiqueConfidentialite(): Response
    {
        return $this->render('legal/privacy.html.twig');
    }
}

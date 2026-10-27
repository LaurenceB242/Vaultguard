<?php

namespace App\Controller;

use App\Entity\Credential;
use App\Form\CredentialType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VaultController extends AbstractController
{
    #[Route('/vault', name: 'app_vault')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Sécurité : s'assurer que l'utilisateur est connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $credential = new Credential();
        $form = $this->createForm(CredentialType::class, $credential);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Associe l'utilisateur connecté pour éviter l'erreur SQL "user_id cannot be null"
            $credential->setUser($this->getUser());

            $entityManager->persist($credential);
            $entityManager->flush();

            $this->addFlash('success', 'Identifiant enregistré avec succès !');

            return $this->redirectToRoute('app_vault');
        }

        // Récupère uniquement les identifiants de l'utilisateur connecté
        $credentials = $entityManager->getRepository(Credential::class)->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render('vault/index.html.twig', [
            'form' => $form->createView(),
            'credentials' => $credentials,
        ]);
    }
}
<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Vérifie si le mot de passe actuel est correct
            if ($passwordHasher->isPasswordValid($user, $data['currentPassword'])) {
                // Encode et met à jour le nouveau mot de passe
                $newEncodedPassword = $passwordHasher->hashPassword($user, $data['newPassword']);
                $user->setPassword($newEncodedPassword);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a été changé avec succès.');

                return $this->redirectToRoute('app_profile');
            } else {
                $this->addFlash('error', 'Le mot de passe actuel est incorrect.');
            }
        }

        return $this->render('profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Form\ResetPasswordRequestFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ResetPasswordController extends AbstractController
{
    #[Route('/reset-password', name: 'app_forgot_password_request')]
    public function request(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();

            // Générer un token de réinitialisation et l'envoyer par email
            $resetToken = bin2hex(random_bytes(32));

            // Stocker le token et l'email dans la base de données ou une autre méthode de stockage

            // Envoyer l'email
            $resetEmail = (new Email())
                ->from('no-reply@yourdomain.com')
                ->to($email)
                ->subject('Password Reset Request')
                ->html(
                    $this->renderView(
                        'emails/reset_password.html.twig',
                        ['resetToken' => $resetToken]
                    )
                );

            $mailer->send($resetEmail);

            $this->addFlash('success', 'Un email de réinitialisation de mot de passe a été envoyé.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    #[Route('/reset-password/{token}', name: 'app_reset_password')]
    public function reset(Request $request, string $token): Response
    {
        // Vérifier le token (par exemple, le rechercher dans la base de données)
        // Si le token est valide, afficher le formulaire de réinitialisation du mot de passe

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('plainPassword')->getData();

            // Rechercher l'utilisateur par le token et mettre à jour le mot de passe

            // Effacer le token pour empêcher une réutilisation

            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
    ]);
    }
}

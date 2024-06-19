<?php

// src/Controller/LlanController.php

namespace App\Controller;

use App\Entity\LlanRegistration;
use App\Entity\Team;
use App\Form\LlanRegistrationType;
use App\Form\TeamType;
use App\Repository\LlanRegistrationRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class LlanController extends AbstractController
{
    #[Route('/llan', name: 'llan')]
    public function about(LlanRegistrationRepository $registrationRepository): Response
    {
        $user = $this->getUser();
        $isRegistered = false;
        $registration = null;
        $teamMembers = [];
        $soloRegistrations = [];

        if ($user) {
            $registration = $registrationRepository->findOneBy(['email' => $user->getEmail()]);
            $isRegistered = ($registration !== null);

            if ($isRegistered && $registration->getTeam()) {
                $teamMembers = $registration->getTeam()->getMembers()->toArray();
            }

            if (!$registration || !$registration->getTeam()) {
                $soloRegistrations = $registrationRepository->findBy(['team' => null]);
            }
        }

        return $this->render('llan/llan.html.twig', [
            'isRegistered' => $isRegistered,
            'registration' => $registration,
            'teamMembers' => $teamMembers,
            'soloRegistrations' => $soloRegistrations,
        ]);
    }

    #[Route('/register-alone', name: 'register_alone')]
    public function registerAlone(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $registration = new LlanRegistration();
        if ($user) {
            $registration->setName($user->getUsername());
            $registration->setEmail($user->getEmail());
        }

        $form = $this->createForm(LlanRegistrationType::class, $registration, ['user' => $user]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($registration);
            $entityManager->flush();

            return $this->redirectToRoute('llan');
        }

        return $this->render('llan/register_alone.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create-team', name: 'create_team')]
    public function createTeam(Request $request, EntityManagerInterface $entityManager, LlanRegistrationRepository $registrationRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($team);
            $entityManager->flush();

            // Inscrire automatiquement l'utilisateur dans l'équipe
            $registration = $registrationRepository->findOneBy(['email' => $user->getEmail()]);
            if (!$registration) {
                $registration = new LlanRegistration();
                $registration->setName($user->getUsername());
                $registration->setEmail($user->getEmail());
            }
            $registration->setTeam($team);
            $entityManager->persist($registration);
            $entityManager->flush();

            return $this->redirectToRoute('llan');
        }

        return $this->render('llan/create_team.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/join-team', name: 'join_team')]
    public function joinTeam(Request $request, TeamRepository $teamRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour rejoindre une équipe.');
            return $this->redirectToRoute('app_login');
        }

        $teams = $teamRepository->findAll();
        $registration = new LlanRegistration();
        if ($user) {
            $registration->setName($user->getUsername());
            $registration->setEmail($user->getEmail());
        }

        $form = $this->createForm(LlanRegistrationType::class, $registration, ['user' => $user]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team = $teamRepository->find($request->get('team_id'));
            if ($team) {
                $registration->setTeam($team);
                $entityManager->persist($registration);
                $entityManager->flush();

                return $this->redirectToRoute('llan');
            }
        }

        return $this->render('llan/join_team.html.twig', [
            'form' => $form->createView(),
            'teams' => $teams,
        ]);
    }

    #[Route('/unregister', name: 'unregister')]
    public function unregister(EntityManagerInterface $entityManager, LlanRegistrationRepository $registrationRepository, TeamRepository $teamRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $registration = $registrationRepository->findOneBy(['email' => $user->getEmail()]);

        if ($registration) {
            $team = $registration->getTeam();
            $entityManager->remove($registration);
            $entityManager->flush();

            if ($team) {
                $this->checkAndRemoveEmptyTeam($team, $entityManager);
            }

            $this->addFlash('success', 'Vous avez été désinscrit avec succès.');
        } else {
            $this->addFlash('error', 'Vous n\'êtes pas inscrit.');
        }

        return $this->redirectToRoute('llan');
    }

    private function checkAndRemoveEmptyTeam(Team $team, EntityManagerInterface $entityManager): void
    {
        if ($team->getMembers()->isEmpty()) {
            $entityManager->remove($team);
            $entityManager->flush();
        }
    }
}

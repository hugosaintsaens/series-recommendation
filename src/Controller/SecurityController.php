<?php

/**
 * Controller de sécurité
 * 
 * Ce controller contient uniquement les routes concernant l'inscription, la connexion et la déconnexion d'un utilisateur
 * 
 * @copyright 2021 BLHL
 */

namespace App\Controller;

use App\Entity\Likes;
use App\Entity\Users;
use App\Form\RegistrationType;
use App\Repository\LikesRepository;
use App\Repository\SeriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/signup", name="signup")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, SeriesRepository $seriesRepository): Response
    {
        // Si l'utilisateur est connecté, on le redirige vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }

        // On crée un nouvel utilisateur et le formulaire se basant sur les champs de ce dernier
        $user = new Users();
        $form = $this->createForm(RegistrationType::class, $user);

        // Si le formulaire d'inscription a été soumis et si les inputs sont valides
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // On hash le mot de passe
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            // On crée l'utilisateur
            $manager->persist($user);
            $manager->flush();

            // On récupère toutes les séries
            $series = $seriesRepository->findAll();

            // On crée les tuples likes mettant en relation le nouvel utilisateur et toutes les séries
            foreach ($series as $serie) {
                $like = new Likes();
                $like->setFavorite(false);
                $like->setCounter(NULL);
                $like->setUsersId($user);
                $like->setSeriesId($serie);
                $manager->persist($like);
            }
            $manager->flush();

            // On le redirige vers le formulaire de connexion
            return $this->redirectToRoute('signin');
        }

        // On retourne la vue signup.html.twig
        return $this->render('security/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/signin", name="signin")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est connecté, on le redirige vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }

        // On obtient l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // On obtient le dernier nom entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        // On retourne la vue signin.html.twig
        return $this->render('security/signin.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): Response
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

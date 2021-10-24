<?php

/**
 * Controller principal
 * 
 * Ce controller contient les routes principales du site comme l'accès à la page d'accueil, suite à une recherche et aux pages descriptives d'une série
 * 
 * @copyright 2021 BLHL
 */

namespace App\Controller;

use Doctrine\ORM\Mapping\Id;
use App\Repository\LikesRepository;
use App\Repository\SeriesRepository;
use App\Repository\ContainsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ColumbiaController extends AbstractController
{

    // Constante caractérisant le nombre de séries que l'on souhaite afficher par page
    const LIMIT = 10;

    /**
     * @Route("/", name="index")
     */
    public function home(Request $request, SeriesRepository $seriesRepository, LikesRepository $likesRepository): Response
    {
        // On récupère la variable page, pour savoir a quelle page nous sommes, sinon elle n'existe pas on l'initialise à 1
        $page = (int) $request->query->get("page", 1);
        // On récupère le nombre total de séries
        $total = (int) $seriesRepository->findTotalSeries();
        // On récupère l'offset
        $offset = ($page * self::LIMIT) - self::LIMIT;

        // On test si la page demandée est correcte en fonction du total de série et de la limite
        if (($page < 1) || ($page > ceil($total / self::LIMIT))) {
            return $this->redirectToRoute('error404');
        }

        // On test si l'utilisateur est connecté pour retourner les séries avec leur likes, sinon on retourne les séries seules
        if ($this->getUser()) {
            $tuples = $likesRepository->findPaginatedSeriesAndLikes(self::LIMIT, $offset, $this->getUser()->getId());
        } else {
            $tuples = $seriesRepository->findPaginatedSeries(self::LIMIT, $offset);
        }

        // Création du formulaire de recherche via mot-clé
        $form = $this->createFormBuilder()
            ->add('mot', TextType::class)
            ->add('recherche', SubmitType::class)
            ->getForm();

        // Si le formulaire de recherche a été soumis et si les inputs sont valides, on redirige l'utilisateur sur la route search
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // On remplace les espaces par des +
            $replace = str_replace(" ", "+", $form->get('mot')->getData());
            // On convertit les lettres en minuscules
            $lower = strtolower($replace);
            // On enlève les accents
            $accent = str_replace(array('à', 'á', 'â', 'ã', 'ä', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ'), array('a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y'), $lower);
            return $this->redirectToRoute('search', array('content' => $accent));
        }

        // On retourne la vue index.html.twig
        return $this->render('columbia/index.html.twig', [
            'form' => $form->createView(),
            'tuples' => $tuples,
            'total' => $total,
            'limit' => self::LIMIT,
            'page' => $page
        ]);
    }

    /**
     * @Route("/search/{content}", name="search", requirements={"content"="^[a-z+]*$"})
     */
    public function search($content, Request $request, ContainsRepository $containsRepository, LikesRepository $likesRepository): Response
    {
        // On sépare le contenu de la recherche en un tableau de mot
        $words = explode("+", $content);
        // On récupère la variable page, pour savoir a quelle page nous sommes, sinon elle n'existe pas on l'initialise à 1
        $page = (int) $request->query->get("page", 1);
        // On récupère le nombre total de séries en fonction du mot-clé recherché
        $total = count($containsRepository->findTotalSeriesByWords($words));
        // On récupère l'offset
        $offset = ($page * self::LIMIT) - self::LIMIT;

        // On test si l'utilisateur est connecté pour retourner les séries avec leur likes, sinon on retourne les séries
        if ($this->getUser()) {
            $tuples = $likesRepository->findPaginatedSeriesAndLikesByWords($words, self::LIMIT, $offset, $this->getUser()->getId());
        } else {
            $tuples = $containsRepository->findPaginatedSeriesByWords($words, self::LIMIT, $offset);
        }

        // On test si la page demandée est correcte en fonction du total de série et de la limite
        if ($tuples && (($page < 1) || ($page > ceil($total / self::LIMIT)))) {
            return $this->redirectToRoute('error404');
        }

        // Création du formulaire de recherche via mot-clé
        $form = $this->createFormBuilder()
            ->add('mot', TextType::class)
            ->add('recherche', SubmitType::class)
            ->getForm();

        // Si le formulaire de recherche a été soumis et si les inputs sont valides, on redirige l'utilisateur sur la route search
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // On remplace les espaces par des +
            $replace = str_replace(" ", "+", $form->get('mot')->getData());
            // On convertit les lettres en minuscules
            $lower = strtolower($replace);
            // On enlève les accents
            $accent = str_replace(array('à', 'á', 'â', 'ã', 'ä', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ'), array('a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y'), $lower);
            return $this->redirectToRoute('search', array('content' => $accent));
        }

        // On retourne la vue search.html.twig
        return $this->render('columbia/search.html.twig', [
            'form' => $form->createView(),
            'tuples' => $tuples,
            'total' => $total,
            'limit' => self::LIMIT,
            'page' => $page,
            'content' => $content
        ]);
    }

    /**
     * @Route("/serie/{id}", name="serie", requirements={"id"="\d+"})
     */
    public function show($id, SeriesRepository $seriesRepository, ContainsRepository $containsRepository, LikesRepository $likesRepository): Response
    {
        // On récupère la série grace à l'id
        $serie = $seriesRepository->find($id);

        // On test si la série a été trouvé
        if ($serie == null) {
            return $this->redirectToRoute('error404');
        }

        // On cherche le top mots-clés, les séries similaires de la série courante et on initialise la variable likes à null
        $words = $containsRepository->findTopWords($id);
        $similarSeries = $containsRepository->findSimilarSeries($id);
        $likes = null;

        // On retourne le tuple likes si l'utilisateur est connecté
        if ($this->getUser()) {
            $likes = $likesRepository->findOneBy(['users' => $this->getUser()->getId(), 'series' => $id]);

            // On test si l'id de l'utilisateur connecté correspond à l'id du tuple retourné dans la requête
            if ($likes->getUsersId()->getId() != $this->getUser()->getId()) {
                return $this->redirectToRoute('error404');
            }
        }

        // On retourne la vue show.html.twig
        return $this->render('columbia/show.html.twig', [
            'serie' => $serie,
            'words' => $words,
            'similarSeries' => $similarSeries,
            'likes' => $likes
        ]);
    }

    /**
     * @Route("/likes", name="likes")
     */
    public function likes(Request $request, LikesRepository $likesRepository, SeriesRepository $seriesRepository): Response
    {
        // On crée les variables nécessaires pour la modification du likes
        $likes = $likesRepository->find($request->query->get("id"));
        $page = (int) $request->query->get("page");
        $total = (int) $seriesRepository->findTotalSeries();
        $previous = $request->query->get("previous");

        // On test si la page précédente est valide
        if (array_key_exists($previous, array('index', 'search', 'serie'))) {
            return $this->redirectToRoute('error404');
        }

        // On test si la requête contient un résultat
        if ($likes == null) {
            return $this->redirectToRoute('error404');
        }

        // On test si la page fournie est correcte, sauf si la page précédente provient de la route serie
        if ($previous != 'serie' && (($page == null) || ($page < 1) || ($page > ceil((int) $total / self::LIMIT)))) {
            return $this->redirectToRoute('error404');
        }

        // On test si l'id de l'utilisateur connecté correspond à l'id du tuple retourné dans la requête
        if ($likes->getUsersId()->getId() != $this->getUser()->getId()) {
            return $this->redirectToRoute('error404');
        }

        // On modifie le likes vers le statut demandé
        if ($likes->getFavorite()) {
            $likes->setFavorite(false);
        } else {
            $likes->setFavorite(true);
        }

        // On valide la transaction
        $this->getDoctrine()->getManager()->flush();

        // On retourne l'utilisateur sur sa page précédente
        if ($previous == 'index') {
            return $this->redirectToRoute('index', array('page' => $page));
        } else if ($previous == 'search') {
            return $this->redirectToRoute('search', array('page' => $page, 'content' => $request->query->get("content")));
        } else if ($previous == 'serie') {
            return $this->redirectToRoute('serie', array('id' => $likes->getSeriesId()->getId()));
        }
    }
}

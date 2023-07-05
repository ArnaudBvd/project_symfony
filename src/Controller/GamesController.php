<?php

namespace App\Controller;

use App\Entity\Games;
use App\Form\GameType;
use App\Repository\GamesRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamesController extends AbstractController
{
    #[Route('/', name: 'app_games')]
    public function index(): Response
    {
        return $this->render('games/index.html.twig', [
            'controller_name' => 'Epic Games Collection ',
        ]);
    }

    #[Route('/games-list', name: 'games-list')]
    public function allGames(GamesRepository $gamesRepository): Response
    {
        $games = $gamesRepository->findAll();

        return $this->render('games/games-list.html.twig', [
            'controller_name' => 'Games List',
            'games' => $games
        ]);
    }

    
    #[Route('/detail/{id}', name: 'game-detail',methods: ['GET'])]
    public function detail(Games $game): Response
    {
        return $this->render('games/detail.html.twig', [
            'controller_name' => 'Detail',
            'game' => $game
        ]);
    }

    #[Route('/new', name: 'game_new',methods: ['POST','GET'])]
    public function new(GamesRepository $gamesRepository, Request $request): Response
    {
        // Créer un objet
        $game = new Games();
        // Avoir le formulaire
        $form = $this->createForm(GameType::class, $game);

        //Valider le formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Enregistre les données
            $gamesRepository->save($game,true);
            //Redirige vers LIST
            return $this->redirectToRoute('games-list');
        }

        //Afficher formulaire
        return $this->render('games/new.html.twig',
            [
                'form' => $form
            ]);
    }

    #[Route('/confirm-delete/{id}', name: 'game-confirm-delete',methods: ['POST','GET'])]
    public function confirmDelete(Games $games): Response
    {
        return $this->render('games/delete.html.twig',[
            'game' => $games
        ]);
    }

    #[Route('/delete/{id}', name: 'game-delete',methods: ['POST','GET'])]
    public function delete(Games $games, GamesRepository $gamesRepository): Response
    {
        $gamesRepository->remove($games,true);

        return $this->redirectToRoute("games-list");
    }

}

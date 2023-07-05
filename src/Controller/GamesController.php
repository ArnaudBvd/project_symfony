<?php

namespace App\Controller;

use App\Entity\Games;
use App\Repository\GamesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

}

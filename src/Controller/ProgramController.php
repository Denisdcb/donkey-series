<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use App\Repository\EpisodesRepository;
use App\Repository\SeasonsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route ('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {

    $programs = $programRepository->findAll();

    return $this->render('program/index.html.twig', [
       'programs' => $programs
        ]);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], name: 'show', methods: ['GET'])]
    public function show(ProgramRepository $programRepository, int $id):Response
    {
        $program = $programRepository->find($id);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/{id}/seasons', name: 'seasons', methods: ['GET'])]
    public function showSeasons(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->find($id);
        if (!$program) {
            throw $this->createNotFoundException('The program does not exist');
        }

        return $this->render('program/seasons.html.twig', [
            'program' => $program,
            'seasons' => $program->getSeasons()
        ]);
    }

        #[Route('/{id}/seasons/{seasonId}', name: 'episodes', methods: ['GET'])]
    public function showEpisodes(
        int $seasonId,
        int $id,
        EpisodesRepository $episodesRepository,
        SeasonsRepository $seasonRepository,
        ProgramRepository $programRepository,
    ): Response {
        // Récupérer le programme
        $program = $programRepository->find($id);

        $season = $seasonRepository->findOneBy(
            ['number' => $seasonId, 'program_id' => $id]
        );

        $episodes = $episodesRepository->findBy(
            ['season' => $seasonId, 'program' => $id]
        );

        // Retourner la vue avec les données
        return $this->render('program/episodes.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes
        ]);
    }
}
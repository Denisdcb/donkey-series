<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EpisodesRepository;
use App\Repository\SeasonsRepository;
use App\Entity\Program;
use Doctrine\ORM\EntityManager;
use PhpParser\Node\Name;
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

    #[Route('/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Creer un nouvel objet Category
        $program = new Program();
        // Creer le formulaire associé
        $form = $this->createForm(ProgramType::class, $program);
        // Récupérer les données de la requête
        $form->handleRequest($request);
        // Si le formulaire est valide
        if ($form->isSubmitted()) {
            // Enregistrer la catégorie
            $entityManager->persist($program);
            // Insérer en base de données
            $entityManager->flush();
            // Rediriger vers la page de liste des catégories
            return $this->redirectToRoute('program_index');
        }
        // Retourner la vue avec le formulaire
        return $this->render('program/add.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], name: 'show', methods: ['GET'])]
    public function show(Program $program):Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/{id}/seasons', name: 'seasons', methods: ['GET'])]
    public function showSeasons(Program $program): Response
    {
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
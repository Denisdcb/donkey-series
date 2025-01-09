<?php

namespace App\Controller;

use App\Entity\Seasons;
use App\Form\SeasonsType;
use App\Repository\SeasonsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/seasons')]
final class SeasonsController extends AbstractController
{
    #[Route(name: 'app_seasons_index', methods: ['GET'])]
    public function index(SeasonsRepository $seasonsRepository): Response
    {
        return $this->render('seasons/index.html.twig', [
            'seasons' => $seasonsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_seasons_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $season = new Seasons();
        $form = $this->createForm(SeasonsType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($season);
            $entityManager->flush();

            return $this->redirectToRoute('app_seasons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seasons/new.html.twig', [
            'season' => $season,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_seasons_show', methods: ['GET'])]
    public function show(Seasons $season): Response
    {
        return $this->render('seasons/show.html.twig', [
            'season' => $season,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_seasons_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Seasons $season, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SeasonsType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_seasons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seasons/edit.html.twig', [
            'season' => $season,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_seasons_delete', methods: ['POST'])]
    public function delete(Request $request, Seasons $season, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$season->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($season);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_seasons_index', [], Response::HTTP_SEE_OTHER);
    }
}

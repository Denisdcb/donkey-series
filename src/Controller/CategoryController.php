<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        // Récupérer toutes les catégories
        $categories = $categoryRepository->findAll();

        // Retourner la vue avec les catégories
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        // Trouver la catégorie par son nom
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException("Aucune catégorie nommée $categoryName");
        }

        // Trouver les 3 dernières séries de la catégorie
        $series = $programRepository->findBy(
            ['category' => $category],
            ['id' => 'DESC'], // Trier par ID décroissant
            3                // Limiter à 3 résultats
        );

        // Retourner la vue avec la catégorie et ses séries
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'series' => $series,
        ]);
    }
}

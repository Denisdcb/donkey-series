<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
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

    //Controller pour ajouter une catégorie
    #[Route('/add', name: 'add')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Creer un nouvel objet Category
        $category = new Category();
        // Creer le formulaire associé
        $form = $this->createForm(CategoryType::class, $category);
        // Récupérer les données de la requête
        $form->handleRequest($request);
        // Si le formulaire est valide
        if ($form->isSubmitted()) {
            // Enregistrer la catégorie
            $entityManager->persist($category);
            // Insérer en base de données
            $entityManager->flush();
            // Rediriger vers la page de liste des catégories
            return $this->redirectToRoute('category_index');
        }
        // Retourner la vue avec le formulaire
        return $this->render('category/add.html.twig', [
            "form" => $form->createView(),
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

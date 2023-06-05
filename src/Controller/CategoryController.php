<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Repository\ProgramRepository;
use App\Form\CategoryType;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request): Response
    {
        //Creer l'objet Category
        $category = new Category;
        //Creer le formulaire lié à $category
        $form = $this->createForm(CategoryType::class, $category);
        //Chope les données entrées dans le formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
        }

        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{categoryName}', methods: ['GET'], name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository)
    {
        $category = $categoryRepository->findOneBy(['Name' => $categoryName]);
        //A gauche du => : nom du champ de la BDD tel qu'indiqué dans la classe de type entity + /!\ case sensitive


        $programs = $programRepository->findByCategory($category);

        // $programs = $programRepository->findBy(
        //     // ['category_id' => $this->$category->getId()],
        //     ['category_id' => $this->$category->getId()],
        //     ['id' => 'DESC'],
        //     3,
        //     0
        // );
        // findProgramsInCategory();
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs
        ]);
    }
}

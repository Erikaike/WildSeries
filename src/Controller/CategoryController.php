<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Repository\ProgramRepository;

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

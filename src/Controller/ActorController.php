<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Actor;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    #[Route('/actor', name: 'app_actor')]
    public function index(): Response
    {
        return $this->render('actor/index.html.twig', [
            'controller_name' => 'ActorController',
        ]);
    }

    #[Route('/actor/{id}', name: 'app_actor_program_list')]
    public function show(Actor $actor): Response
    {
        return $this->render('actor/index.html.twig', [
            'actor'  => $actor,
        ]);
    }
}

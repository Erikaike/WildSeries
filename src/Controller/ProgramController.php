<?php

namespace App\Controller;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Category;
use App\Form\ProgramType;
use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series',
            'programs' => $programs,
        ]);
    }
    #[Route('/show/{id<^[0-9]+$>}/', name: 'show')]
    public function show(Program $program): Response
    {
        // $program = $programRepository->findOneBy(['id' => $id]);


        if (!$program) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request): Response
    {
        //Creer l'objet program
        $program = new Program;
        //Creer le formulaire lié à $program
        $form = $this->createForm(ProgramType::class, $program);
        //Chope les données entrées dans le formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this->addFlash('success', 'la série a bien été ajoutée');
        }

        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{programId}/seasons/{seasonId}', name: "season_show")]
    #[Entity('Program', options: ['mapping' => ['programId' => 'id']])]
    #[Entity('Season', options: ['mapping' => ['seasonId' => 'id']])]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $programId]);

        $season = $seasonRepository->findOneBy(['id' => $seasonId]);

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }

    #[Route('/{program}/season/{season}/episode/{episode}', name: "episode_show")]
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }
}

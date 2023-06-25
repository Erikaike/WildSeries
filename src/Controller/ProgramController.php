<?php

namespace App\Controller;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Category;
use App\Form\ProgramType;
use App\Service\ProgramDuration;
use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
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
    #[Route('/show/{slug}/', name: 'show', requirements: ['page' => '\d+'])]
    #[Entity('Program', options: ['mapping' => ['slug' => 'slug']])]
    public function show(Program $program, ProgramDuration $programDuration): Response
    {

        if (!$program) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'programDuration' => $programDuration->calculate($program),
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, SluggerInterface $slug): Response
    {
        //Creer l'objet program
        $program = new Program;
        //Creer le formulaire lié à $program
        $form = $this->createForm(ProgramType::class, $program);
        //Sluggifie le titre
        $program->setSlug($this->slug->slug($program->getTitle()));
        //Chope les données entrées dans le formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this->addFlash('success', 'la série a bien été ajoutée');
        }

        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/seasons/{season}', name: "season_show")]
    #[Entity('Program', options: ['mapping' => ['slug' => 'slug']])]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $programId]);

        $season = $seasonRepository->findOneBy(['id' => $seasonId]);

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }

    #[Route('/{programSlug}/season/{season}/episode/{episodeSlug}', name: "episode_show")]
    #[Entity('Program', options: ['mapping' => ['programSlug' => 'slug']])]
    #[Entity('Episode', options: ['mapping' => ['episodeSlug' => 'slug']])]
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }
}

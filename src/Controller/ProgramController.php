<?php

namespace App\Controller;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Form\ProgramType;
use App\Service\ProgramDuration;
use Symfony\Component\Mime\Email;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
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
    #[Entity('Program')]
    public function show($slug, Program $program, ProgramDuration $programDuration): Response
    {

        if (!$program) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'programDuration' => $programDuration->calculate($program),
            'slug' => $slug,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository, SluggerInterface $slugger, MailerInterface $mailer): Response
    {
        //Creer l'objet program
        $program = new Program();
        //Creer le formulaire lié à $program
        $form = $this->createForm(ProgramType::class, $program);
        //Chope les données entrées dans le formulaire
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
             //Sluggifie le titre
             $program->setSlug($slugger->slug($program->getTitle()));
        
            $programRepository->save($program, true);
            $this->addFlash('success', 'la série a bien été ajoutée');

            //Envoie de mail à l'ajout d'une nvelle serie
            $email = (new Email())
                ->from($this->getParameter(('mailer_from')))
                ->to('erika.ike@outlook.fr')
                ->subject('salut meuf')
                ->html($this->renderView('program/newProgramEmail.html.twig', ['program' => $program]));
            
            
            $mailer->send($email);
                

            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/seasons/{season}', name: "season_show")]
    #[Entity('Program')]
    public function showSeason($slug, Program $program, Season $season): Response
    {
        if (!$season) {
            throw $this->createNotFoundException(
                'No episode with id : ' . $season->getId() . ' found in episode\'s table.'
            );
        }

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'slug' => $slug,
        ]);
    }

    #[Route('/{programSlug}/season/{season}/episode/{episodeSlug}', name: "episode_show")]
    #[Entity('Program', options: ['mapping' => ['programSlug' => 'slug']])]
    #[Entity('Episode', options: ['mapping' => ['episodeSlug' => 'slug']])]
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        if (!$episode) {
            throw $this->createNotFoundException(
                'No episode with id : ' . $episode->getId() . ' found in episode\'s table.'
            );
        }


        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }
}

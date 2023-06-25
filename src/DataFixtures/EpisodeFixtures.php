<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Episode;
use App\DataFixtures\SeasonFixtures;
use App\DataFixtures\ProgramFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slug;

    public function __construct(SluggerInterface $slug)
    {
        $this->slug = $slug;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        //Boucle Program
        for ($i = 0; $i < count(ProgramFixtures::PROGRAM); $i++) {
            //Boucle Season
            for ($j = 0; $j < 6; $j++) {
                //Boucle Episode

                for ($k = 0; $k < 10; $k++) {
                    $episode = new Episode();
                    $episode->setTitle($faker->word())
                        ->setNumber($k)
                        ->setSynopsis($faker->paragraphs(1, true))
                        ->setSeason($this->getReference('season' . $j . '_serie' . $i))
                        ->setDuration(rand(0, 60))
                        ->setSlug($this->slug->slug($episode->getTitle()));

                    $manager->persist($episode);
                }
                $manager->flush();
            }
        }
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}

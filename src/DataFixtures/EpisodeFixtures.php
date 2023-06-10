<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
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
                        ->setSeasonId($this->getReference('season' . $j . '_serie' . $i));

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

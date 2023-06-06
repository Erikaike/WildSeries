<?php

namespace App\DataFixtures;

use App\Entity\Season;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        //Boucle sur les program
        for ($i = 1; $i < count(ProgramFixtures::PROGRAM) + 1; $i++) {
            //Boucle pour la crétion des saisons
            for ($j = 1; $j < 6; $j++) {
                $season = new Season();
                $season->setNumber($j)
                    ->setYear($faker->year())
                    ->setDescription($faker->paragraphs(3, true))
                    ->setProgramId($this->getReference('program_' . $i));

                $manager->persist($season);
                $this->addReference(('season' . $j . '_serie' . $i), $season);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}

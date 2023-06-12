<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        //Creation de 10 acteurs grâce à Faker
        for ($i = 0; $i < 11; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name());

            //Boucle qui assigne 3 programmes à chaque acteur
            for ($j = 0; $j < 4; $j++) {
                $actor->addProgram($this->getReference('program_' . rand(0, count(ProgramFixtures::PROGRAM) - 1)));
            }

            $manager->persist($actor);
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

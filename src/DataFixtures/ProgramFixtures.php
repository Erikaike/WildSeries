<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $program = new Program();
        $program->setTitle('The 100');
        $program->setSynopsis('a bunch of youngsters trying to survive on an almost-deserted planet Earth');
        $program->setCategory($this->getReference('category_Suspens'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('24');
        $program->setSynopsis('Jack Bauer does a lot of stuff and save the world');
        $program->setCategory($this->getReference('category_Action'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('Sense 8');
        $program->setSynopsis('a group of 8 people from all around the world discover that they\'re link buy some spiritual force');
        $program->setCategory($this->getReference('category_Fantastique'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('American Horror Story');
        $program->setSynopsis('don\'t really know what happen there but it\'s horrific');
        $program->setCategory($this->getReference('category_Horreur'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('Banana Fish');
        $program->setSynopsis('A mix of BL and gang stories');
        $program->setCategory($this->getReference('category_Manga'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('Friends');
        $program->setSynopsis('A group of 6 new-yorkers having decent jobs but living in crazy appartments');
        $program->setCategory($this->getReference('category_Comedie'));
        $manager->persist($program);




        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}

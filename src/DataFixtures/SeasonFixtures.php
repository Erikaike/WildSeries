<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public const SEASON = [

        ['title' => 'Friends', 'seasonNumber' => 1, 'year' => 1994, 'description' => '1st season of Friends'],
        ['title' => 'Friends', 'seasonNumber' => 2, 'year' => 1995, 'description' => '2d season of Friends'],
    ];

    // public function load(ObjectManager $manager): void
    // {
    //     foreach (self::SEASON as $key => $value) {
    //         $season = new Season();
    //         $season->setNumber($value['seasonNumber'])
    //             ->setYear($value['year'])
    //             ->setDescription($value['description'])
    //             ->setProgramId($this->getReference('program_' . trim($value['title'])));

    //         $this->addReference(('season' . $value['seasonNumber'] . '_' . trim($value['title'])), $season);

    //         $manager->persist($season);
    //     }

    //     $manager->flush();
    // }
    public function load(ObjectManager $manager): void
    {

        $season = new Season();
        $season->setNumber(1)
            ->setYear(1994)
            ->setDescription('1st season of Friends')
            ->setProgramId($this->getReference('program_Friends'));

        $this->addReference('season1_Friends', $season);

        $manager->persist($season);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}

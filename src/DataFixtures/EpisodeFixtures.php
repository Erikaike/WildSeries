<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    // public const EPISODE = [
    //     ['title' => 'Friends', 'seasonNumber' => 1, 'episodeNumber' => 1,  'episodeTitle' => 'The One Where Monica Gets a Roommate', 'synopsis' => 'Monica and the gang introduce Rachel to the "real world" after she leaves her fiancé at the altar.'],
    //     ['title' => 'Friends', 'seasonNumber' => 1, 'episodeNumber' => 2,  'episodeTitle' => 'The One with the Sonogram at the End', 'synopsis' => 'Ross finds out his ex-wife is pregnant. Rachel returns her engagement ring to Barry. Monica becomes stressed when her and Ross\'s parents come to visit.'],
    //     ['title' => 'Friends', 'seasonNumber' => 1, 'episodeNumber' => 3,  'episodeTitle' => 'The One with the Thumb',               'synopsis' => 'Monica becomes irritated when everyone likes her new boyfriend more than she does. Chandler resumes his smoking habit. Phoebe is given $7000 when she finds a thumb in a can of soda.'],
    //     ['title' => 'Friends', 'seasonNumber' => 1, 'episodeNumber' => 4,  'episodeTitle' => 'The One with George Stephanopoulos',   'synopsis' => 'Joey and Chandler take Ross to a hockey game to take his mind off the anniversary of the first time he slept with Carol, while the girls become depressed when they realize they don\'t have a \'plan\'.'],
    // ];
    // public function load(ObjectManager $manager): void
    // {

    //     foreach (self::EPISODE as $key => $value) {
    //         $episode = new Episode();
    //         $episode->setTitle($value['title'])
    //             ->setNumber($value['episodeNumber'])
    //             ->setSynopsis($value['synopsis'])
    //             ->setSeasonId($this->getReference('season' . $value['seasonNumber'] . '_' . $value['title']));

    //         $manager->persist($episode);
    //     }
    //     $manager->flush();
    // }
    public function load(ObjectManager $manager): void
    {

        $episode = new Episode();
        $episode->setTitle('Friends')
            ->setNumber(1)
            ->setSynopsis('1st Episode of Friends')
            ->setSeasonId($this->getReference('season1_Friends'));

        $manager->persist($episode);
        $episode = new Episode();
        $episode->setTitle('Friends')
            ->setNumber(2)
            ->setSynopsis('2d Episode of Friends')
            ->setSeasonId($this->getReference('season1_Friends'));

        $manager->persist($episode);
        $episode = new Episode();
        $episode->setTitle('Friends')
            ->setNumber(3)
            ->setSynopsis('3d Episode of Friends')
            ->setSeasonId($this->getReference('season1_Friends'));

        $manager->persist($episode);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}

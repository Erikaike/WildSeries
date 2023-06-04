<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    // public const PROGRAM = [
    //     ['title' => 'The 100',               'category' => 'category_Suspens',     'synopsis' => 'a bunch of youngsters trying to survive on an almost-deserted planet Earth',                         'coutry' => 'USA'],
    //     ['title' => '24',                    'category' => 'category_Action',      'synopsis' => 'Jack Bauer does a lot of stuff and saves the world',                                                 'coutry' => 'USA'],
    //     ['title' => 'Sense 8',               'category' => 'category_Fantastique', 'synopsis' => 'a group of 8 people from all around the world discover that they\'re link buy some spiritual force', 'coutry' => 'USA'],
    //     ['title' => 'American Horror Story', 'category' => 'category_Horreur',     'synopsis' => 'don\'t really know what happen there but it\'s horrific',                                            'coutry' => 'USA'],
    //     ['title' => 'Banana Fish',           'category' => 'category_Manga',       'synopsis' => 'A mix of BL and gang stories',                                                                       'coutry' => 'Japan'],
    //     ['title' => 'Friends',               'category' => 'category_Comedie',     'synopsis' => 'A group of 6 new-yorkers having decent jobs but living in crazy appartments',                        'coutry' => 'USA'],
    // ];

    // public function load(ObjectManager $manager): void
    // foreach (self::PROGRAM as $key => $value) {
    //     $program = new Program();
    //     $program->setTitle($value['title'])
    //         ->setCategory($value['category'])
    //         ->setSynopsis($value['synopsis'])
    //         ->setCountry($value['coutry'])
    //         ->setYear($value['year']);
    //     $this->addReference('program_' . trim($value['title']), $program);

    //     $manager->persist($program);
    // }
    public function load(ObjectManager $manager): void
    {
        $program = new Program();
        $program->setTitle('friends')
            ->setCategory($this->getReference('category_Comedie'))
            ->setSynopsis('A group of 6 new-yorkers having decent jobs but living in crazy appartments')
            ->setCountry('USA')
            ->setYear(1994);
        $this->addReference('program_Friends', $program);

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

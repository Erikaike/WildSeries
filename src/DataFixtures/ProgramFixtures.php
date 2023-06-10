<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAM = [
        ['title' => 'The 100',               'category' => 'Suspens',     'synopsis' => 'a bunch of youngsters trying to survive on an almost-deserted planet Earth',                         'coutry' => 'USA', 'year' => 2015],
        ['title' => '24',                    'category' => 'Action',      'synopsis' => 'Jack Bauer does a lot of stuff and saves the world',                                                 'coutry' => 'USA', 'year' => 2001],
        ['title' => 'Sense 8',               'category' => 'Fantastique', 'synopsis' => 'a group of 8 people from all around the world discover that they\'re link buy some spiritual force', 'coutry' => 'USA', 'year' => 2018],
        ['title' => 'American Horror Story', 'category' => 'Horreur',     'synopsis' => 'don\'t really know what happen there but it\'s horrific',                                            'coutry' => 'USA', 'year' => 2017],
        ['title' => 'Banana Fish',           'category' => 'Manga',       'synopsis' => 'A mix of BL and gang stories',                                                                       'coutry' => 'Japan', 'year' => 2014],
        ['title' => 'Friends',               'category' => 'Comedie',     'synopsis' => 'A group of 6 new-yorkers having decent jobs but living in crazy appartments',                        'coutry' => 'USA', 'year' => 1994],
    ];

    public function load(ObjectManager $manager): void
    {

        foreach (self::PROGRAM as $key => $value) {
            $program = new Program();
            $program->setTitle($value['title'])
                ->setCategory($this->getReference('category_' . $value['category']))
                ->setSynopsis($value['synopsis'])
                ->setCountry($value['coutry'])
                ->setYear($value['year']);

            $this->addReference('program_' . $key, $program);
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public const PROGRAM = [
        ['title' => 'The 100',               'synopsis' => 'a bunch of youngsters trying to survive on an almost-deserted planet Earth',                         'category' => 'category_Suspens'],
        ['title' => '24',                    'synopsis' => 'Jack Bauer does a lot of stuff and saves the world',                                                 'category' => 'category_Action'],
        ['title' => 'Sense 8',               'synopsis' => 'a group of 8 people from all around the world discover that they\'re link buy some spiritual force', 'category' => 'category_Fantastique'],
        ['title' => 'American Horror Story', 'synopsis' => 'don\'t really know what happen there but it\'s horrific',                                            'category' => 'category_Horreur'],
        ['title' => 'Banana Fish',           'synopsis' => 'A mix of BL and gang stories',                                                                       'category' => 'category_Manga'],
        ['title' => 'Friends',               'synopsis' => 'A group of 6 new-yorkers having decent jobs but living in crazy appartments',                        'category' => 'category_Comedie'],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAM as $key => $value) {
            $program = new Program();
            $program->setTitle($value['title']);
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

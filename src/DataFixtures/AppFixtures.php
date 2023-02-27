<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
    )
    {}
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach(range(1,3) as $i){
            $category = new Category();
            $category
                ->setSlug($faker->slug(2))
                ->setName($faker->realText(20))
            ;
            $manager->persist($category);
        }

        $manager->flush();
    }
}

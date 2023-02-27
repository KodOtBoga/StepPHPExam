<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private EntityManagerInterface $em,
    )
    {}
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        foreach ($this->em->getRepository(Category::class)->findAll() as $category) {


            foreach(range(1,3) as $i){
                $product = new Product();
                $product
                    ->setTitle($faker->text(10))
                    ->setDescription($faker->text(100))
                    ->setPrice(rand(1000, 2000))
                    ->setAmount(rand(100, 200))
                    ->setCategory($category)
                ;
                $manager->persist($product);
            }
            
            }

        $manager->flush();
    }
}

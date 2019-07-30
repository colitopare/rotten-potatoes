<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    $faker = \Faker\Factory::create('fr_FR');


    for ($c = 0; $c < 10; $c++) {
      $category = new Category;
      $category->setTitle($faker->realText(20));
      $manager->persist($category);
    }


    $manager->flush();
  }
}

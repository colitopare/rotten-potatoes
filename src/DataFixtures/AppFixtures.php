<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Entity\People;
use App\Entity\Rating;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    $faker = \Faker\Factory::create('fr_FR');

    $categoryTitle = ["Comédie", "Film fantastique", "Dramatique", "Film d'action", "Film d'horreur", "Polar", "Thriller", "Romantique"];

    // pour pouvoir faire les relations ManyToMany
    $categories = [];
    $movies = [];

    for ($c = 0; $c < count($categoryTitle); $c++) {
      $category = new Category;
      $category->setTitle($categoryTitle[$c]);

      // pour récupérer les instances de Category
      $categories[] = $category;

      $manager->persist($category);
    }

    for ($m = 0; $m < 10; $m++) {
      $movie = new Movie;
      $movie->setTitle($faker->realText(20))
        ->setPoster($faker->imageUrl(400, 600))
        ->setReleasedAt($faker->dateTimeBetween('-10years', '-1month'))
        ->setSynopsis($faker->realText());

      $randomCategories = $faker->randomElements($categories, mt_rand(1, 4));

      foreach ($randomCategories as $category) {
        $movie->addCategory($category);
      }

      // pour récupérer les instances de Movie
      $movies[] = $movie;

      $manager->persist($movie);
    }

    for ($p = 0; $p < 20; $p++) {
      $people = new People;
      $people->setFirstName($faker->firstName)
        ->setlastName($faker->lastName)
        ->setDescription($faker->realText())
        ->setBirthday($faker->dateTimeBetween('-50years', '-10years'))
        ->setPicture($faker->imageUrl(200, 200, 'people'));

      // Director
      $randomMovie = $faker->randomElement($movies);
      $people->addDirected($randomMovie);

      // Actors dans les films
      $randomMovies = $faker->randomElements($movies, mt_rand(0, 5));
      foreach ($randomMovies as $movie) {
        $people->addActedIn($movie);
      }

      $manager->persist($people);
    }

    for ($r = 0; $r < 10; $r++) {
      $rating = new Rating;
      $rating->setComment($faker->realText())
        ->setNotation($faker->numberBetween(0, 5));


      $manager->persist($rating);
    }

    $manager->flush();
  }
}

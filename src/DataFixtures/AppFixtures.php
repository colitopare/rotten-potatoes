<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Movie;
use App\Entity\People;
use App\Entity\Rating;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

  /**
   * On aura besoin de l'encoder pour les passwords des utilisateurs
   * 
   * @var UserPasswordEncoderInterface
   */
  private $encoder;
  /**
   * On se fait injecter l'encodeur :-)
   *
   * @param UserPasswordEncoderInterface $encoder
   */
  public function __construct(UserPasswordEncoderInterface $encoder)
  {
    $this->encoder = $encoder;
  }

  public function load(ObjectManager $manager)
  {
    $faker = \Faker\Factory::create('fr_FR');


    /**
     * Category
     */
    $categoryTitle = ["Comédie", "Film fantastique", "Dramatique", "Film d'action", "Film d'horreur", "Polar", "Thriller", "Romantique"];

    // pour pouvoir faire les relations ManyToMany
    $categories = [];
    for ($c = 0; $c < count($categoryTitle); $c++) {
      $category = new Category;
      $category->setTitle($categoryTitle[$c]);

      // pour récupérer les instances de Category
      $categories[] = $category;

      $manager->persist($category);
    }


    /**
     * People
     */
    $people = [];
    for ($p = 0; $p < 20; $p++) {
      $person = new People;
      $person->setFirstName($faker->firstName)
        ->setlastName($faker->lastName)
        ->setDescription($faker->realText())
        ->setBirthday($faker->dateTimeBetween('-70 years', '-10 years'))
        ->setPicture($faker->imageUrl(200, 200, 'people'));

      $people[] = $person;

      $manager->persist($person);
    }

    /**
     * User
     */
    $users = [];
    for ($u = 0; $u < 10; $u++) {
      $user = new User;

      $user->setEmail('user' . $u . '@gmail.com')
        ->setName($faker->lastName)
        ->setAvatar($faker->imageUrl(63, 63, 'people'))
        ->setPassword($this->encoder->encodePassword($user, "pass"));

      $users[] = $user;

      $manager->persist($user);
    }

    /**
     * Movies
     */
    for ($m = 0; $m < mt_rand(40, 100); $m++) {
      $movie = new Movie;
      $movie->setTitle($faker->realText(20))
        ->setPoster($faker->imageUrl(400, 600))
        ->setReleasedAt($faker->dateTimeBetween('-10 years', '-1 month'))
        ->setSynopsis($faker->realText());

      // Je prend un people au hasard qui sera le réalisateur
      $director = $faker->randomElement($people);
      $movie->setDirector($director);

      // Je prend des peoples au hasard qui seront les acteurs
      $actors = $faker->randomElements($people, mt_rand(3, 8));
      foreach ($actors as $actor) {
        $movie->addActor($actor);
      }

      // Je prend des catégories au hasard qui seront les catégories du film
      $randomCategories = $faker->randomElements($categories, mt_rand(1, 4));
      foreach ($randomCategories as $category) {
        $movie->addCategory($category);
      }

      /**
       * Rating
       */
      for ($r = 0; $r < mt_rand(5, 10); $r++) {
        $rating = new Rating;
        $rating->setComment($faker->realText())
          ->setCreatedAt($faker->dateTimeBetween('-6 months'))
          ->setNotation($faker->numberBetween(0, 5))
          ->setMovie($movie)
          // Je prend un utilisateur au hasard qui aura posté ce commentaire
          ->setAuthor($faker->randomElement($users));

        $manager->persist($rating);
      }

      $manager->persist($movie);
    }



    $manager->flush();
  }
}

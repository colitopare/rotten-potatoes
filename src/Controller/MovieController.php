<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Rating;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\RatingType;
use App\Entity\People;
use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;

class MovieController extends AbstractController
{

  /**
   * @Route("/", name="home")
   */
  public function index(MovieRepository $repo)
  {
    $lastMovie = $repo->lastMovieReleasedAt(3);

    $bestMovie = $repo->bestMovie(3);
    // dd($bestMovie);
    $pireMovie = $repo->pireMovie(3);

    return $this->render('movie/index.html.twig', [
      'lastMovie' => $lastMovie,
      'bestMovie' => $bestMovie,
      'pireMovie' => $pireMovie,
    ]);
  }

  /**
   * @Route("/category/{slug}", name="show_category")
   */
  public function show_category(Category $category)
  {
    return $this->render('movie/show_category.html.twig', [
      'category' => $category,
    ]);
  }

  /**
   * @Route("/movie/{slug}", name="show_movie")
   */
  public function show_movie(Movie $movie, Request $request, ObjectManager $manager, ?UserInterface $user)
  {
    // formulaire pour noter le film affiché
    $rating = new Rating;

    $form = $this->createForm(RatingType::class, $rating);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $rating->setAuthor($user)
        ->setMovie($movie);

      $manager->persist($rating);
      $manager->flush();
    }

    return $this->render('movie/show_movie.html.twig', [
      'movie' => $movie,
      'formRating' => $form->createView(),
    ]);
  }

  /**
   * @Route("/people/{slug}", name="show_people")
   */
  public function show_people(People $people)
  {
    return $this->render('movie/show_people.html.twig', [
      'people' => $people,
    ]);
  }

  public function show_all_category(CategoryRepository $repo)
  {
    // 1 - public funtion pour afficher un twig qui contiendra les rubriques de chaque catégory
    // 2 - Twig qui bouclera sur les category
    // 3 - template de base appel la function du controller
    // https://symfony.com/doc/current/templating/embedding_controllers.html

    $category = $repo->findAll();

    return $this->render(
      'movie/category.html.twig',
      ['category' => $category]
    );
  }
}

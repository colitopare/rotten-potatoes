<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MovieRepository;
use App\Form\MovieType;
use App\Entity\Movie;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class AdminController extends AbstractController
{
  /**
   * @Route("/admin/movie", name="admin_movies")
   */
  public function movies(MovieRepository $repo)
  {
    $movies = $repo->findAll();
    return $this->render('admin/movie/index.html.twig', [
      'movies' => $movies,
    ]);
  }

  /**
   * @Route("/admin/movie/{id}/edit", name="admin_movie_edit")
   */
  public function editMovie(Movie $movie, Request $request, ObjectManager $manager)
  {
    $form = $this->createForm(MovieType::class, $movie);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $manager->flush();
      $this->addFlash('success', 'Le film a été modifié avec succès');
      return $this->redirectToRoute('admin_movies');
    }

    return $this->render('admin/movie/edit_movie.html.twig', [
      'movie' => $movie,
      'formMovie' => $form->createView(),
    ]);
  }


  /**
   * @Route("/admin/movie/{id}/delete", name="admin_movie_delete")
   */
  public function deleteMovie(Movie $movie, Request $request, ObjectManager $manager)
  {
    // Sécurité csrf du formulaire caché de delete
    if ($this->isCsrfTokenValid('delete' . $movie->getId(), $request->get('_token'))) {
      $manager->remove($movie);
      $manager->flush();

      $this->addFlash('success', 'Le film supprimé avec succès');
    }

    return $this->redirectToRoute('admin_movies');
  }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Movie;

class MovieController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('movie/index.html.twig', []);
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
    public function show_movie(Movie $movie)
    {
        return $this->render('movie/show_movie.html.twig', [
            'movie' => $movie,
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

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
    public function sho_category(Category $category)
    {
        return $this->render('movie/show_category.html.twig', [
            'category' => $category,
        ]);
    }
}

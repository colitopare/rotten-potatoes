<?php

namespace App\Controller;

use App\Entity\Rating;
use App\Repository\RatingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminRatingController extends AbstractController
{
    /**
     * @Route("/admin/rating", name="admin_ratings")
     */
    public function index(RatingRepository $repo)
    {
        $ratings = $repo->findAll();
        return $this->render('admin/rating/index.html.twig', [
            'ratings' => $ratings,
        ]);
    }

    /**
     * @Route("/admin/rating/{id}/delete", name="admin_rating_delete")
     */
    public function deleteRating(Rating $rating, Request $request, ObjectManager $manager)
    {
        // Sécurité csrf du formulaire caché de delete
        if ($this->isCsrfTokenValid('delete' . $rating->getId(), $request->get('_token'))) {
            $manager->remove($rating);
            $manager->flush();

            $this->addFlash('success', "L'avis a été supprimé avec succès");
        }

        return $this->redirectToRoute('admin_ratings');
    }
}

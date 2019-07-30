<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RegistrationController extends AbstractController
{
  /**
   * @Route("/register", name="account_register")
   */
  public function register(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager): Response
  {
    $user = new User;

    $form = $this->createForm(RegistrationFormType::class, $user);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // encode the plain password
      $user->setPassword(
        $encoder->encodePassword(
          $user,
          $user->getPassword()
        )
      );

      $manager->persist($user);
      $manager->flush();

      return $this->redirectToRoute('security_login');
    }

    return $this->render('registration/register.html.twig', [
      'registrationForm' => $form->createView(),
    ]);
  }
}

<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request): Response
    {
        // afficher le formulaire d'ajout d'un post dans la page d'accueil
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'ProfileController',
            // on récupère les infos de User
            'user' => $this->getUser(),
            'form' => $form
        ]);
    }
}

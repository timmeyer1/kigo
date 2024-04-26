<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{

    // vue pour mettre en favoris une projet
    #[Route('/like/post/{id}', name: 'likePost', methods: ['GET'])]
    public function likeRedirectHere(Posts $post, EntityManagerInterface $manager, Request $request): Response
    {
        // on récupère l'user actuel
        $user = $this->getUser();

        // conditions
        if($post->isLikedByUser($user)) {
            $post->removeLike($user);
            $manager->flush();

            // return $this->json(['message' => 'Enlevé de vos favoris'], 200);
            return $this->redirect($request->headers->get('referer'));
        } 

        $post->addLike($user);
        $manager->flush();

        // return $this->json(['message' => 'Ajouté à vos favoris'], 200);
        return $this->redirect($request->headers->get('referer'));
    }
}
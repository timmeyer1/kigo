<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Repository\AdsRepository;
use App\Repository\PostsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    // profile view
    #[Route('/profile', name: 'profile', methods: ['GET'])]
    public function profile()
    {
        return $this->render('account/profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    // my posts view
    #[Route('/profile/myposts', name: 'myPosts', methods: ['GET'])]
    public function myPosts(PostsRepository $postsRepository): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur actuel
    
        // si l'utilisateur n'est pas connecté on renvoie à l'accueil
        if (!$user) {
            return $this->redirectToRoute('accueil');
        }
        
        return $this->render('account/myPosts.html.twig', [
            'userId' => $postsRepository->findAllByUserId([$this->security->getUser()]),
        ]);
    }


    // fonction pour changer le role d'un utilisateur
    #[Route('/change-role/{id}', name: 'changeRole', methods: ['GET'])]
    public function changeRole(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {

        // récupérer l'id de l'utilisateur
        $user = $userRepository->find($id);

        // Vérifier si l'utilisateur est connecté sinon on renvoie "Utilisateur non trouvé
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        // Ajouter le rôle ROLE_HOTE à l'utilisateur
        $user->setRoles(['ROLE_HOTE']);

        // Enregistrer les modifications dans la base de données
        $entityManager->flush();

        // Rediriger vers une page appropriée
        return $this->redirectToRoute('accueil');
    }

    // page des favoris
    #[Route('/profile/favorites', name: 'myFavorites', methods: ['GET'])]
    public function myFavorites(PostsRepository $postsRepository)
    {
        $user = $this->getUser(); // Récupérer l'utilisateur actuel
    
        // si l'utilisateur n'est pas connecté on renvoie à l'accueil
        if (!$user) {
            return $this->redirectToRoute('accueil');
        }
    
        $likes = $postsRepository->findAllLikesByUser($user);
    
        return $this->render('account/favorites.html.twig', [
            'likes' => $likes,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\User;
use App\Form\PostsType;
use App\Repository\PostsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $em)
    {
    }


    // page d'accueil
    #[Route('/', name: 'accueil', methods: ['GET'])]
    public function index(PostsRepository $postsRepository): Response
    {

        // on vérifie si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }



        // on récupère toutes les projets avec leurs images
        $posts = $this->em->getRepository(Posts::class)->findAllWithImages();
        // dd($posts);
        return $this->render('home/home.html.twig', [
            'posts' => $posts
        ]);
    }

    // page des détails d'une projet
    #[Route('/detail/{id}', name: 'detail', methods: ['GET'])]
    public function detail(int $id, Posts $posts)
    {
        // on vérifie si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }


        // on récupère toutes les projets avec leurs images
        $posts = $this->em->getRepository(Posts::class)->findByIdWithInfos($id);
        // on récupère l'id de l'utilisateur
        $user = $this->em->getRepository(User::class)->find($posts->getUserId());
        return $this->render('home/detail.html.twig', [
            'posts' => $posts,
            'sections' => $posts->getSectionId(),
            'user' => $posts->getUserId(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Entity\Posts;
use App\Form\AdsType;
use App\Form\PostsType;
use App\Repository\AdsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/posts')]
class PostsController extends AbstractController
{
    // #[Route('/', name: 'app_posts_index', methods: ['GET'])]
    // public function index(AdsRepository $postsRepository): Response
    // {
    //     return $this->render('posts/index.html.twig', [
    //         'posts' => $postsRepository->findAll(),
    //     ]);
    // }

    // vue pour ajouter une annonce
    #[Route('/add-post/{id}', name: 'addPost', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, UserRepository $userRepository)
    {

        $post = new Posts();
        // récupérer l'id de l'utilisateur
        $post->setUserId($userRepository->find($id));
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        // on vérifie si le formulaire est correct
        if ($form->isSubmitted() && $form->isValid()) {
            //gestion de l'image uploadée
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                //si une image est uploadée, on récupère son nom d'origine
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                //on genere un nouveau nom unique pour éviter d'ecraser des images de même nom
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                try {
                    //on déplace l'image uploadée dans le dossier public/images
                    $imageFile->move(
                        //games_images_directory est configuré dans config/services.yaml
                        $this->getParameter('dossier_images'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Une erreur est survenue lors de l\'upload de l\'image');
                }

                //on donne le nouveau nom pour la bdd
                $post->setImagePath($newFilename);
                $entityManager->persist($post);
                $entityManager->flush();

                return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->render('posts/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    // #[Route('/show/{id}', name: 'showAd', methods: ['GET'])]
    // public function show(Ads $post): Response
    // {
    //     return $this->render('posts/show.html.twig', [
    //         'post' => $post,
    //     ]);
    // }

    // vue pour éditer une annonce
    #[Route('/{id}/edit', name: 'editPost', methods: ['GET', 'POST'])]
    public function edit(Request $request, Posts $post, EntityManagerInterface $entityManager): Response
    {
        // on vérifie si l'utilisateur est propriétaire
        if ($this->getUser() !== $post->getUserId()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas le droit d\'éditer ce projet.');
        }

        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    // vue pour supprimer une annonce
    #[Route('/{id}', name: 'deletePost', methods: ['POST', 'GET'])]
    public function delete(Request $request, Posts $post, EntityManagerInterface $entityManager): Response
    {
        // on vérifie si l'utilisateur est propriétaire
        if ($this->getUser() !== $post->getUserId()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas le droit de modifier ce projet.');
        }

        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {

            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('myPosts', [], Response::HTTP_SEE_OTHER);
    }
}

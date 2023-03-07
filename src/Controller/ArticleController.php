<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('article/list-article.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/add-article', name: 'add_article')]
    public function addArticle(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        $article = new Article();
        $date = new DateTime();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        $articleFileName = $form->get('cover')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            if ($articleFileName) {
                $originalFileName = pathinfo($articleFileName->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalFileName);
                $newFileName = $safeFileName . '-' . uniqid() . '.' . $articleFileName->guessExtension();

                try {
                    $articleFileName->move(
                        $this->getParameter('articleFileName_directory'),
                        $newFileName
                    );
                }

                catch (FileException $e) {}
                $article->setCover($newFileName);
            }

            $article->setUser($user);
            $article->setDateAdd($date);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('add_article');
        }

        return $this->render('article/add-article.html.twig', [
            'form_article' => $form->createView(),
        ]);
    }
}

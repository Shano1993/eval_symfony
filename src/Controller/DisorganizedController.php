<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisorganizedController extends AbstractController
{
    #[Route('/disorganized', name: 'app_disorganized')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $disorganized = $articleRepository->findAll();

        return $this->render('disorganized/list.html.twig', [
            'list_disorganized' => $disorganized,
        ]);
    }

    #[Route('/disorganized/edit/{id}', name: 'disorganized_edit')]
    public function edit(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('article/add-article.html.twig', [
            'form_article' => $form->createView(),
        ]);
    }
}

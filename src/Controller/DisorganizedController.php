<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}

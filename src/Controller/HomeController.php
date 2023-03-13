<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
    {
        $articles = $articleRepository->findBy([], ['id'=> 'DESC'], 5,0);
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}

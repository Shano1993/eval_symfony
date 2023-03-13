<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted("ROLE_SUPER_ADMIN")]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(UserCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Eval Symfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute("Home", 'fas fa-home', 'app_home');
        yield MenuItem::linkToCrud('User', 'fas fa-map-marker-alt', User::class);
        yield MenuItem::linkToCrud('Article', 'fas fa-map-marker-alt', Article::class);
        yield MenuItem::linkToCrud('Comments', 'fas fa-map-marker-alt', Comment::class);
    }
}

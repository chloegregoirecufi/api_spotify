<?php

namespace App\Controller\Admin;

use App\Entity\Song;
use App\Entity\Album;
use App\Entity\Genre;
use App\Entity\Artist;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    //dans un premier temps on créer le construct qui prend comme param une instance de AdminUrlGenerator
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    )
    {
    }
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //on donne l'entité que l'on veut afficher au point d'entrer de notre BO
        $url = $this->adminUrlGenerator
            ->setController(GenreCrudController::class)
            ->generateUrl();
        
        return $this->redirect($url);
        
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/images/logo.jpg" style="width:30px; height:30px"><span class="text-small"> Spotify</span>')
            ->setFavIconPath('/images/logo.jpg');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Gestion Discographie');
        //list des sous-menu
        yield MenuItem::subMenu('Gestion Catégories', 'fa fa-star')->setSubItems([
            MenuItem::linkToCrud('Ajouter une catégorie', 'fa fa-plus', Genre::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les catégories', 'fa fa-eye', Genre::class)
        ]);
        yield MenuItem::subMenu('Gestion Albums', 'fa fa-music')->setSubItems([
            MenuItem::linkToCrud('ajouter un album', 'fa fa-plus', Album::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les albums', 'fa fa-eye', Album::class)
        ]);
        yield MenuItem::subMenu('Gestion des chansons', 'fa fa-play')->setSubItems([
            MenuItem::linkToCrud('ajouter une chanson', 'fa fa-plus', Song::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les chansons', 'fa fa-eye', Song::class)
        ]);
        yield MenuItem::subMenu('Gestion des artistes', 'fa fa-user')->setSubItems([
            MenuItem::linkToCrud('ajouter un artiste', 'fa fa-plus', Artist::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les artistes', 'fa fa-eye', Artist::class)
        ]);
    }
}

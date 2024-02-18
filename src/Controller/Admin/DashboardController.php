<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;


class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ){

    }


    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //on donne l'entite que l'on veut afficher au point d'entree de notre BO
        $url = $this->adminUrlGenerator
            ->setController(GenreCrudController::class)
            ->generateUrl();
        
        return $this->redirect($url);
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/images/logo.jpg" style="width:30px; height:30px"><span class="text-small">Spotify</span>')
            ->setFaviconPath('/images/logo.jpg');
    }

    public function configureMenuItems(): iterable
    {
        //section principale
        yield MenuItem::section('Gestion Discographie');
        //liste des sous-menu
        yield MenuItem::subMenu('Gestion catégories', 'fa fa-star')->setSubItems([
            MenuItem::linkToCrud('Ajouter une catégorie', 'fa fa-plus', Genre::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les catégories', 'fa fa-eye', Genre::class)
        ]);
        yield MenuItem::subMenu('Gestion Album', 'fa fa-musique')->setSubItems([
            MenuItem::linkToCrud('Ajouter des albums', 'fa fa-plus', Genre::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les albums', 'fa fa-eye', Genre::class)
        ]);
        yield MenuItem::subMenu('Gestion Chansons', 'fa fa-play')->setSubItems([
            MenuItem::linkToCrud('Ajouter une chansons', 'fa fa-plus', Genre::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les chansons', 'fa fa-eye', Genre::class)
        ]);
        yield MenuItem::subMenu('Gestion des Artistes', 'fa fa-user')->setSubItems([
            MenuItem::linkToCrud('Ajouter un artiste', 'fa fa-plus', Genre::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les artistes', 'fa fa-eye', Genre::class)
        ]);
    }
    // public function configureActions(Action $actions): Actions
    // {
    //     //permet de configuere les defferentes actions
    //     return $actions
    //     //permet de configurer les champs de la page index
    //     ->update(Crud::PAGE_INDEX, Action::NEW,
    //         fn(Action $action) => $action->setIcon('fa fa-add')->setLabel('Ajouter')->setCssClass('btn btn-success'))
    //     ->update(Crud::PAGE_INDEX, Action::EDIT,
    //         fn(Action $action) => $action->setIcon('fa fa-pen')->setLabel('Modifier'))
    //     ->update(Crud::PAGE_INDEX, Action::DELETE,
    //         fn(Action $action) => $action->setIcon('fa fa-trash')->setLabel('Supprimé'))
    //     //Page edition 
    //     ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,
    //         fn(Action $action) => $action->setLabel('Enregistrer et quitter'))
    //     ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE,
    //         fn(Action $action) => $action->setLabel('Enregistrer et continuer'))
    //     //page création
    //     ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN,
    //         fn(Action $action) => $action->setLabel('Enregistrer'))
    //     ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER,
    //         fn(Action $action) => $action->setLabel('Enregistrer et ajouter un nouveau'));
    // }

}

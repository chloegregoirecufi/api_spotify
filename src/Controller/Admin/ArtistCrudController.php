<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\config\Crud;


class ArtistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Artist::class;
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

    public function configureCrud(Crud $crud): Crud
    {
        //permet de renommer les différentes pages
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Artistes')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un artiste')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un artiste');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nome de l\'artiste'),
            TextEditorField::new('biography', 'Biographie de  l\'artiste'),
        ];
    }

}

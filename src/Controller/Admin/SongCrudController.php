<?php

namespace App\Controller\Admin;

use App\Entity\Song;
use PhpParser\Node\Scalar\MagicConst\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SongCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Song::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'titre de la chanson'),
            TextEditorField::new('filePathFile', 'Choisir un fichier mp3')
                ->setFormType(VichFileType::class)
                ->hideOnDetail()
                ->hideOnIndex(),
            TextField::new('filePath', 'Nom du fichier mp3')
                ->hideOnForm()
                ->hideOnIndex(),
            ImageField::new('filePath', 'choisir un fichier mp3')
                ->setBasePath('/upload/files/music')
                ->hideOnForm()
                ->hideOnIndex()
                ->hideOnDetail()
            ->addHtmlContentsToBody('<p>hello</p>'),
            NumberField::new('duration', 'duréer de la chanson'),
            AssociationField::new('album', 'Album associé'),
        ];
    }

    public function configureActions(Actions $actions): Actions 
    {
        //permet de config les différentes actions
        return $actions
            //permet de custom les champs de la page index
            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn(Action $action) => $action->setIcon('fa fa-add')->setLabel('Ajouter')->setCssClass('btn btn-success'))
            ->update(Crud::PAGE_INDEX, Action::EDIT,
                fn(Action $action) => $action->setIcon('fa fa-pen')->setLabel('Modifier'))
            ->update(Crud::PAGE_INDEX, Action::DELETE,
                fn(Action $action) => $action->setIcon('fa fa-trash')->setLabel('Supprimer'))
            ->add(Crud::PAGE_INDEX, Action::DETAIL,
                fn(Action $action) => $action->setIcon('fa fa-info')->setLabel('Informations'))    
    
            //page edition
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,
                fn(Action $action) => $action->setLabel('Enregistrer et quitter'))
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE,
                fn(Action $action) => $action->setLabel('Enregistrer et continuer'))
            //page de création
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN,
                fn(Action $action) => $action->setLabel('Enregistrer'))
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER,
                fn(Action $action) => $action->setLabel('Enregistrer et ajouter un nouveau'));
    }

    
}

<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\config\Crud;


class AlbumCrudController extends AbstractCrudController
{
    //on créer nos constantes
    public const ALBUM_BASE_PATH = 'upload/images/albums';

    public const ALBUM_UPLOAD_DIR = 'public/upload/images/albums';
    public static function getEntityFqcn(): string
    {
        return Album::class;
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
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hidOnForm(),
            TextField::new('title', 'titre de l\'album'),
            TextEditorField::new('description', 'Descritpion de l\'album'),
            //Champs d'association avec une autre table
            AssociationField::new('genre', 'Catégorie de l\'album'),
            AssociationField::new('artiste', 'Nom de l\'artiste'),
            ImageField::new('imagePath', 'Choisir une image de couverture')
                ->setBasePath(self::ALBUM_BASE_PATH)
                ->setUploadDir(self::ALBUM_UPLOAD_DIR)
                ->setUploadFileNamePattern(
                    //on donne un nom de fichier unique pour éviter de venir ecraser une image en cas de même nom
                        fn(UploadFile $File): string => sprintf(
                            'upload_%d_%s_.%s',
                            random_int(1, 999),
                            $file->getFilename(),
                            $file->guessExtension()
                        )),
            DateField::new('releaseDate', 'Date de sortie'),
            //ici on cache creatAt et updateAt on passera les données grace au persister
            DateField::new('CreateAt')->hideOnForm(),
            DateField::new('UpdateAt')->hideOnForm(),

        ];
    }

}




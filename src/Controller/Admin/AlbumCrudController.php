<?php

namespace App\Controller\Admin;

use ORM\Entity;
use App\Entity\Album;
use App\Repository\AlbumRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class AlbumCrudController extends AbstractCrudController
{
    //on créer nos constances
    public const ALBUM_BASE_PATH = 'upload/images/albums';
    public const ALBUM_UPLOAD_DIR = 'public/upload/images/albums';

    public static function getEntityFqcn(): string
    {
        return Album::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre de l\'album'),
            //champs d'association avec une autre table
            AssociationField::new('genre', 'Catégorie de l\'album'),
            AssociationField::new('Artist', 'Nom de l\'artiste'),
            ImageField::new('imagePath', 'Choisir une imahe de couverture')
                ->setBasePath(self::ALBUM_BASE_PATH)
                ->setUploadDir(self::ALBUM_UPLOAD_DIR)
                ->setUploadedFileNamePattern(
                    //on donne un nom de fichir pour eviter de venir écraser une image en cas de m nom
                    fn(UploadedFile $file): string =>sprintf(
                        'upload_%d_%s.%s',
                        random_int(1, 999),
                        $file->getFilename(),
                        $file->guessExtension()
                    )),
            DateField::new('realaseDate', 'Date de sortie'),
            //ici on cahce CreateAt et UpdateAt on passera les données grace au persister
            DateField::new('createdAt')->hideOnForm(),
            DateField::new('updateAt')->hideOnForm(),
        ];
    }

    //persister lors de la creation d'un album, on génère la date
    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof Album) return;
        $entityInstance->setCreatedAt(new \DateTimeImmutable());
        $entityInstance->setUpdateAt($entityInstance->getCreatedAt());
        parent::persistEntity($em, $entityInstance);
    }

    //persister lors de la modification d'un album, on genere la date 
    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof Album) return;
        $entityInstance->setUpdateAt(new \DateTimeImmutable());
        parent::updateEntity($em, $entityInstance);
    }



    
}

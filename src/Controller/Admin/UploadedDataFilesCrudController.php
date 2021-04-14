<?php

namespace App\Controller\Admin;

use App\Entity\UploadedDataFiles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;


class UploadedDataFilesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UploadedDataFiles::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
        return [
            TextField::new('fileName')
                ->onlyOnIndex()
                ,

            AssociationField::new('user')
                ->onlyOnIndex()
                ,

            IntegerField::new('uploadedData')
                ->onlyOnIndex()
                ->addCssClass('font-weight-bold text-success')
                ,

            IntegerField::new('alreadyInDatabase')
                ->onlyOnIndex()
                ->addCssClass('font-weight-bold text-warning')
                ,

            ArrayField::new('errorData')
                ->onlyOnIndex()
                ->addCssClass('font-weight-bold text-danger')
                ,

            TextField::new('status')
                ->onlyOnIndex()
                ,

            DateTimeField::new('updatedAt')
                ->onlyOnIndex()
                ,
            TextareaField::new('uploadedFile', 'Excel File')
                ->setFormType(VichFileType::class)
                ->setFormTypeOptions(['allow_delete' => false])
                ->onlyOnForms()
                ,

        ];
    }
    public function createEntity(string $entityFqcn)
    {
        $product = new UploadedDataFiles();
        $product->setUser($this->getUser());

        return $product;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions;
    }
}

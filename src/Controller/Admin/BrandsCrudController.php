<?php

namespace App\Controller\Admin;

use App\Entity\Brands;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class BrandsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Brands::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('brand'),

            ImageField::new('brandImage')
                ->onlyOnIndex()
                ->setBasePath('/images/brands'),

            TextareaField::new('brandImgFile')
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions(['allow_delete' => false]) 
                ->onlyOnForms()
                ->setRequired(true),
        ];
    }
    
}

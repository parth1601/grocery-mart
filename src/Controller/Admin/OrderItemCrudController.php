<?php

namespace App\Controller\Admin;

use App\Entity\OrderItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderItem::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('productName'),
            NumberField::new('quantity'),
            AssociationField::new('orderRef')
        ];
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setDefaultSort(['orderRef'=>'DESC']);
    }
}

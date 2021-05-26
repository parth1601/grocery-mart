<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            AssociationField::new('userId')
                ->onlyOnIndex(),
            ChoiceField::new('status')
                ->setChoices(fn () => [
                    'placed' => 'placed',
                    'delivered' => 'delivered',
                    'confirmed' => 'confirmed', 
                    'packed'=> 'packed',
                    'cart'=>'cart',
                    'out of delivery' => 'out of delivery',
                    ]),
            DateTimeField::new('createdAt')
                ->onlyOnIndex(),
            NumberField::new('totalPrice')
                ->onlyOnIndex(),

        ];
    }
}

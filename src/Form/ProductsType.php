<?php

namespace App\Form;

use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productKey')
            ->add('productName')
            ->add('priceBefore')
            ->add('priceAfter')
            ->add('productImage')
            ->add('updatedAt')
            ->add('productStatus')
            ->add('productDescription')
            ->add('expiryDate')
            ->add('category')
            ->add('subCategory')
            ->add('tags')
            ->add('productBrand')
            ->add('countryOfOrigin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}

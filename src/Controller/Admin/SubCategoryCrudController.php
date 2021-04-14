<?php

namespace App\Controller\Admin;

use App\Entity\SubCategory;
use App\Repository\SubCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SubCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('Category')->setRequired(true),
            TextField::new('SubCategory'),
        ];
    }

    /**
     * @Route("/admin/get-subcategory", name="getsubcategories")
     * 
     * @return Response
     */
    public function getSubCategories()
    {
        $value=$_POST['categoryId'];
        $repository = $this->getDoctrine()->getRepository(SubCategory::class);
        $subCategories = $repository->findByCategoryField($value);

        $responseArray = array();
        foreach ($subCategories as $subCategory) {
            $responseArray[] = array(
                "id" => $subCategory->getId(),
                "name" => $subCategory->getSubCategory()
            );
        }
        return new JsonResponse($responseArray);
    }
}

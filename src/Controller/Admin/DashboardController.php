<?php

namespace App\Controller\Admin;

use App\Entity\Brands;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Country;
use App\Entity\Products;
use App\Entity\SubCategory;
use App\Entity\Tags;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\UploadedDataFiles;
use App\Repository\BrandsRepository;
use App\Repository\CategoryRepository;
use App\Repository\CountryRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\TagsRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\CrudUrlGenerator;

use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/admin/dashboard", name="admin")
     * 
     * @return Response
     */
    public function index(): Response
    {
        $user_id = 12;
        return $this->render('pages/dashboard.html.twig',['user_id'=>$user_id]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('GroceryMart')
            ;
    }

    public function configureMenuItems(): iterable
    {
		return [
            MenuItem::section('Home'),
                MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
                MenuItem::linkToUrl('Open Google', 'fab fa-google', 'https://google.com'),

            MenuItem::section('Users'),
                MenuItem::linkToCrud('User', 'fas fa-users', User::class),
            
            MenuItem::section('Products Primary'),
                MenuItem::linkToCrud('Country', 'fas fa-flag', Country::class),
                MenuItem::linkToCrud('Categories', 'fas fa-bars', Category::class),
                MenuItem::linkToCrud('SubCategories', 'fab fa-blackberry', SubCategory::class),
                MenuItem::linkToCrud('Tags', 'fas fa-tags', Tags::class),
                MenuItem::linkToCrud('Brands', 'fab fa-bandcamp', Brands::class),

            MenuItem::section('Product'),
                MenuItem::linkToCrud('Products', 'fa fa-leaf', Products::class),
                MenuItem::linkToCrud('Product Import', 'fa fa-leaf', UploadedDataFiles::class),
            
            MenuItem::section('Order'),
                MenuItem::linkToCrud('Order', 'fa fa-list', Order::class),
                MenuItem::linkToCrud('OrderItems', 'fa fa-list' , OrderItem::class),
                
		];
    }




    /**
     * @Route("/admin/dashboard/getContext", name="admin-context")
     * 
     * @return Response
     */
    public function getContext()
    {
        $str = "Parth";
        return new Response($str);
    }
}

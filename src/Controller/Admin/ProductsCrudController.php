<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Entity\Brands;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Country;
use App\Entity\SubCategory;
use App\Entity\Tags;
use App\Entity\Order;
use App\Repository\BrandsRepository;
use App\Repository\CategoryRepository;
use App\Repository\CountryRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\TagsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UploadedDataFilesType;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Symfony\Component\Form\Button;
use Symfony\Component\HttpFoundation\JsonResponse;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Twig\Node\IfNode;

class ProductsCrudController extends AbstractCrudController
{
    private $countOfInsertedRecords = 0;
    private $errorInRecordNoArray = array();
    private $recordsAlreadyInDatabase = 0;
    private $errorRecords = 0; 
    private $message="";
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager; //->getConnection()->getConfiguration()->setSQLLogger(null);
    }

    public function longTaskAction()
    {
        set_time_limit(0); // 0 = no limits
        // ..
    }

    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Product Initials'),
                TextField::new('productKey', 'Key'),
                TextField::new('productName', 'Name'),

            FormField::addPanel('Product Status'),
                BooleanField::new('productStatus', 'Active')
                    ->setRequired(true),

            FormField::addPanel('Product Attributes'),
                AssociationField::new('countryOfOrigin')
                    ->setRequired(true)
                    ->hideOnIndex(),
                AssociationField::new('productBrand', 'Brand')
                    ->setRequired(true),
                AssociationField::new('category')
                    ->setRequired(true),
                AssociationField::new('subCategory')
                    ->setRequired(true),
                AssociationField::new('tags')
                    ->setRequired(true)
                    ->hideOnIndex(),

            FormField::addPanel('Product Price'),
                MoneyField::new('priceBefore', 'Before')
                    ->setCurrency('INR'),
                MoneyField::new('priceAfter', 'After')
                    ->setCurrency('INR'),

            FormField::addPanel('Product Image'),
                ImageField::new('productImage', 'Image')
                    ->hideOnForm()
                    ->setBasePath('/images/product'),
                TextareaField::new('productImageFile', 'Product Image')
                    ->setFormType(VichImageType::class)
                    ->setFormTypeOptions(['allow_delete' => false])
                    ->onlyOnForms(),

            FormField::addPanel('Product Expiry Date'),
                DateField::new('expiryDate')
                    ->hideOnIndex(),

            FormField::addPanel('Product Description'),
                TextEditorField::new('productDescription', 'Description'),
        ];
    }


    

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ;
            
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->renderSidebarMinimized(false);
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addJsFile('js/productSubCategory.js');
    }


    /**
     * @Route("/admin/import", name="import")
     * 
     * @return Response
     */
    public function import(): Response
    {
        $uploadedFile=$_FILES["import_excel"];
        if($_FILES["import_excel"]["name"] != ''){

            $allowed_extension = array('xls','csv','xlsx');
            $file_array = explode(".", $_FILES["import_excel"]["name"]);
            // dump($file_array);
            $file_entention = end($file_array);

            if(in_array($file_entention, $allowed_extension)){

                $file_type = IOFactory::identify($_FILES["import_excel"]["name"]);
                $reader = IOFactory::createReader($file_type);

                $spreadsheet = $reader->load($_FILES["import_excel"]["tmp_name"]);
                $data = $spreadsheet->getActiveSheet()->toArray();
                
                // $str = $this->processData($data);

                $this->message = '<div class="alert alert-success">'. $this->countOfInsertedRecords.' Data Inserted Successfully...!!!</div>';
                if($this->recordsAlreadyInDatabase>0){
                    $this->message.= '<div class="alert alert-warning">' . $this->recordsAlreadyInDatabase . ' Data Are Alredy In DataBase...!!!</div>';
                }
                if($this->errorRecords>0){
                    $str=implode(", ", $this->errorInRecordNoArray);
                    $this->message .= '<div class="alert alert-danger">Error accoured while entering Record No ' .$str. ' ...!!!</div>';
                }
            }
            else{
                $this->message = '<div class="alert alert-danger">Only xls, csv and xlsx file allowed...!!!</div>';
            }
        }
        else{
            $this->message = '<div class="alert alert-danger">Please Select File</div>';
        }
        echo $this->message;
        return $this->render('pages/______temp.html.twig', ['message' => $this->message]);
    }

    public function processData($data)
    {
        $doctrine = $this->getDoctrine();

        $countryRepository = $doctrine->getRepository(Country::class);
        $brandsRepository = $doctrine->getRepository(Brands::class);
        $categoryRepository = $doctrine->getRepository(Category::class);
        $subCategoryRepository = $doctrine->getRepository(SubCategory::class);
        $tagsRepository = $doctrine->getRepository(Tags::class);
        $productRepository = $doctrine->getRepository(Products::class);

        $countryA= $this->convertToArray("country",$countryRepository->getOneField());
        $brandA= $this->convertToArray("brand", $brandsRepository->getOneField());
        $categoryA= $this->convertToArray("Category", $categoryRepository->getOneField());
        $subCategoryA= $this->convertToArray("SubCategory", $subCategoryRepository->getOneField());
        $tagsA= $this->convertToArray("tag", $tagsRepository->getOneField());
        $productA= $this->convertToArray("productKey", $productRepository->getOneField());

        $i=0;
        foreach ($data as $row) {
            if ($this->validateData($row)) {

                if (!in_array($row[0], $productA)) {
                    $this->countOfInsertedRecords++;
                    array_push($productA, $row[0]);
                } else {
                    $this->recordsAlreadyInDatabase++;
                }                
            } else {
                $errorInRecordNo = $this->errorRecords + $this->countOfInsertedRecords + $this->recordsAlreadyInDatabase + 1;
                array_push($this->errorInRecordNoArray, $errorInRecordNo);
                $this->errorRecords++;
            }
        }
        $i=1;
        $batchSize=20;
        // Category Inserting
        foreach ($data as $row) {
            if( (!in_array($i,$this->errorInRecordNoArray)) && (!in_array($row[6], $categoryA)) ){
                $category=new Category();
                $category -> setCategory($row[6]);
                $this->entityManager->persist($category);
                array_push($categoryA, $row[6]);
                if((($i)%($batchSize))==0){
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }
            }
            $i++;
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
        
        // SubCategory Inserting
        $i = 1;
        foreach ($data as $row) {
            if ((!in_array($i, $this->errorInRecordNoArray)) && (!in_array($row[7], $subCategoryA))) {
                $subCategory = new SubCategory();
                $subCategory->setSubCategory($row[7]);
                $subCategory->setCategory($categoryRepository->findOneBy(["Category" => $row[6]]));
                $this->entityManager->persist($subCategory);
                array_push($subCategoryA, $row[7]);
                if ((($i) % ($batchSize)) == 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }
            }
            $i++;
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
        
        //brand Inserting
        $i = 1;
        foreach ($data as $row) {
            if ((!in_array($i, $this->errorInRecordNoArray)) && (!in_array($row[8], $brandA))) {
                $brand = new Brands();
                $brand->setBrand($row[8]);
                $file_name_temp = $row[8] . '.png';
                $brand->setBrandImage($file_name_temp);
                $brand->setUpdatedAt(new \DateTime());
                array_push($brandA, $row[8]);
                $this->entityManager->persist($brand);
                if ((($i) % ($batchSize)) == 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }
            }
            $i++;
        }
        $this->entityManager->flush();
        $this->entityManager->clear();

        //country Inserting
        $i = 1;
        foreach ($data as $row) {
            if ((!in_array($i, $this->errorInRecordNoArray)) && (!in_array($row[5], $countryA))) {
                $country = new Country();
                $country->setCountry($row[5]);
                array_push($countryA, $row[5]);
                $this->entityManager->persist($country);
                if ((($i) % ($batchSize)) == 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }
            }
            $i++;
        }
        $this->entityManager->flush();
        $this->entityManager->clear();

        // Tag Inserting
        $i = 1;
        foreach ($data as $row) {
            $tagArray = explode(",", $row[9]);
            foreach ($tagArray as $tag) {
                if ((!in_array($i, $this->errorInRecordNoArray)) && (!in_array($tag, $tagsA))) {
                    $tags = new Tags();
                    $tags->setTag($tag);
                    array_push($tagsA, $tag);
                    $this->entityManager->persist($tags);
                }
            }
            if ((($i) % ($batchSize)) == 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
            $i++;
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
        
        // image Inserting
        // $i=1;
        // foreach ($data as $row) {
        //     if (!in_array($i, $this->errorInRecordNoArray)) {
        //         $urlOriginal = "D:/GroceryMart/public/images/product/$row[4]";
        //         $urlCompress1 = "D:/GroceryMart/public/images/product/compress1/$row[4]";
        //         $urlCompress2 = "D:/GroceryMart/public/images/product/compress2/$row[4]";

        //         copy($row[13], $urlOriginal);
                
        //         // $this->compressedImage($urlOriginal, $urlCompress1, 80);
        //         // $this->compressedImage($urlOriginal, $urlCompress2, 60);
        //     }
        //     $i++;
        // }
        
        //product Inserting
        $productA = $this->convertToArray("productKey", $productRepository->getOneField());
        $i=1;
        foreach ($data as $row) {
            if ((!in_array($i, $this->errorInRecordNoArray)) && (!in_array($row[0], $productA))) {
                $product = new Products();
                $product->setProductKey($row[0]);
                $product->setProductName($row[1]);
                $product->setPriceBefore($row[2]);
                $product->setPriceAfter($row[3]);
                $product->setProductImage($row[4]);
                $product->setCountryOfOrigin($countryRepository->findOneBy(["country" => $row[5]]));

                $product->setCategory($categoryRepository->findOneBy(["Category" => $row[6]]));
                $product->setSubCategory($subCategoryRepository->findOneBy(["SubCategory" => $row[7]]));
                $product->setProductBrand($brandsRepository->findOneBy(["brand" => $row[8]]));

                $tagArray = explode(",", $row[9]);
                foreach ($tagArray as $tag) {
                    $tags= $tagsRepository->findOneBy(["tag" => $tag]);
                    $product->addTag($tags);
                }

                $product->setProductStatus($row[10]);
                $product->setProductDescription($row[11]);

                $d = explode("/", $row[12]);
                $day = (int)$d[1];
                $month = (int)$d[0];
                $year = (int)$d[2];
                $date = new \DateTime();
                $date->setDate($year, $month, $day);

                $product->setExpiryDate($date);
                $product->setUpdatedAt(new \DateTime());
                
                array_push($productA, $row[0]);
                $this->entityManager->persist($product);
                if ((($i) % ($batchSize)) == 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }
            }
            $i++;
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
        $str = "all Valid";
        return $str;
    }

    public function sToObject($str){
        $category = new Category();
        $category->setCategory($str);
        return $category;
    }


    public function convertToArray($str,$AOA)
    {
        $newA = array();
        foreach ($AOA as $array) {
            array_push($newA, $array[$str]);
        }
        return $newA;
    }


    public function compressedImage($source, $path, $quality)
    {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

        imagejpeg($image, $path, $quality);
    }

    
    public function validateData($row)
    {
        // dump($row);
        $count=0;
        foreach($row as $sell){
            if($sell===null){
                $count++;
            }
        }
        if($count>1){
            return false;
        }
        if (!(gettype($row[2]) == "integer" && gettype($row[3]) == "integer")) {
            return false;
        }
        $url = trim($row[13]);
        if (!(filter_var($url, FILTER_VALIDATE_URL))) {
            return false;
        }
        $allowed_extension=array('png','jpg','jpeg','gif');
        $file= explode(".", $row[4]);
        $fileExtention=$file[1];
        if($file[0]==null || $file[0]=="" ){
            return false;
        }
        if(!(in_array($fileExtention, $allowed_extension))){
            return false;
        }
        // dump("valid");
        return true;
    }
}
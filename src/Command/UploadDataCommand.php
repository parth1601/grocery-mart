<?php

namespace App\Command;

use App\Entity\Products;
use App\Entity\Brands;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Country;
use App\Entity\SubCategory;
use App\Entity\Tags;
use App\Entity\UploadedDataFiles;
use App\Repository\BrandsRepository;
use App\Repository\CategoryRepository;
use App\Repository\CountryRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\TagsRepository;
use App\Repository\ProductsRepository;
use App\Repository\UploadedDataFilesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use PhpOffice\PhpSpreadsheet\IOFactory;


class UploadDataCommand extends Command
{
    /**
     * @var EntityManagerInterface 
     */
    private $entityManager;

    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @var BrandsRepository
     */
    private $brandsRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var SubCategoryRepository
     */
    private $subCategoryRepository;

    /**
     * @var TagsRepository
     */
    private $tagsRepository;

    /**
     * @var ProductsRepository
     */
    private $productRepository;

    /**
     * @var UploadedDataFilesRepository
     */
    private $uploadedDataFilesRepository;

    private $errorInRecordNoArray = array();

    public const FILE_PATH = "D:/GroceryMart/public/admin/files/";

    /**
     * @param EntityManagerInterface $entityManager
     * @param ProductsRepository $orderRepository
     * @param BrandsRepository $brandsRepository
     * @param CategoryRepository $categoryRepository
     * @param SubCategoryRepository $subCategoryRepository
     * @param TagsRepository $tagsRepository
     * @param CountryRepository $countryRepository
     * @param UploadedDataFilesRepository $uploadedDataFilesRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ProductsRepository $productsRepository,
        BrandsRepository $brandsRepository,
        CategoryRepository $categoryRepository,
        SubCategoryRepository $subCategoryRepository,
        TagsRepository $tagsRepository,
        CountryRepository $countryRepository,
        UploadedDataFilesRepository $uploadedDataFilesRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->productsRepository = $productsRepository;
        $this->brandsRepository = $brandsRepository;
        $this->categoryRepository = $categoryRepository;
        $this->subCategoryRepository = $subCategoryRepository;
        $this->tagsRepository = $tagsRepository;
        $this->countryRepository = $countryRepository;
        $this->uploadedDataFilesRepository = $uploadedDataFilesRepository;

    }

    protected static $defaultName = 'app:upload-data';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $file = $this->uploadedDataFilesRepository->findOneBy(['status' => UploadedDataFiles::UNDER_PROCESS]);
        if($file)
        {
            $status = "Done";
            $file->setStatus($status);
            $this->entityManager->persist($file);
            $this->entityManager->flush();
            $this->entityManager->clear();

            $this->errorInRecordNoArray = $file->getErrorData();
            // $io->success("File " . $file->getFileName() . ' Found...!!');
            
            $filesystem = new Filesystem();
            $filename = self::FILE_PATH . $file->getFileName();
            // $io->writeln($filename);
            if($filesystem->exists($filename))
            {
                $file_type = IOFactory::identify($filename);
                // $io->writeln("Type : ".$file_type);
                $reader = IOFactory::createReader($file_type);
                // $io->writeln("reader created");
                $spreadsheet = $reader->load($filename);
                // $io->writeln('Loaded successfully');
                $data = $spreadsheet->getActiveSheet()->toArray();
                // $io->writeln(print_r($data));


                $countryA = $this->convertToArray("country", $this->countryRepository->getOneField());
                $brandA = $this->convertToArray("brand", $this->brandsRepository->getOneField());
                $categoryA = $this->convertToArray("Category", $this->categoryRepository->getOneField());
                $subCategoryA = $this->convertToArray("SubCategory", $this->subCategoryRepository->getOneField());
                $tagsA = $this->convertToArray("tag", $this->tagsRepository->getOneField());
                $productA = $this->convertToArray("productKey", $this->productsRepository->getOneField());


                $i = 1;
                $batchSize = 20;
                // Category Inserting
                $io->writeln("Category insertion Started.....");
                $io->progressStart();
                foreach ($data as $row) {
                    if ((!in_array($i, $this->errorInRecordNoArray)) && (!in_array($row[6], $categoryA))) {
                        $category = new Category();
                        $category->setCategory($row[6]);
                        $this->entityManager->persist($category);
                        array_push($categoryA, $row[6]);
                        if ((($i) % ($batchSize)) == 0) {
                            $this->entityManager->flush();
                            $this->entityManager->clear();
                            
                        }
                        $io->progressAdvance();
                    }
                    
                    $i++;
                }
                $this->entityManager->flush();
                $this->entityManager->clear();
                $io->progressFinish();
                $io->writeln("Category insertion finished.....");

                // SubCategory Inserting
                $i = 1;
                $io->writeln("SubCategory insertion Started.....");
                $io->progressStart();
                foreach ($data as $row) {
                    if ((!in_array($i, $this->errorInRecordNoArray)) && (!in_array($row[7], $subCategoryA))) {
                        $subCategory = new SubCategory();
                        $subCategory->setSubCategory($row[7]);
                        $subCategory->setCategory($this->categoryRepository->findOneBy(["Category" => $row[6]]));
                        $this->entityManager->persist($subCategory);
                        array_push($subCategoryA, $row[7]);
                        if ((($i) % ($batchSize)) == 0) {
                            $this->entityManager->flush();
                            $this->entityManager->clear();
                            // $io->progressAdvance($i);
                        }
                        $io->progressAdvance();
                    }
                    $i++;
                }
                $this->entityManager->flush();
                $this->entityManager->clear();
                $io->progressFinish();
                $io->writeln("SubCategory insertion finished.....");

                //brand Inserting
                $i = 1;
                $io->writeln("Brands insertion Started.....");
                $io->progressStart();
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
                        $io->progressAdvance();
                    }
                    $i++;
                }
                $this->entityManager->flush();
                $this->entityManager->clear();
                $io->progressFinish();
                $io->writeln("Brands insertion finished.....");


                //country Inserting
                $i = 1;
                $io->writeln("Country insertion Started.....");
                $io->progressStart();
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
                        $io->progressAdvance();
                    }
                    $i++;
                }
                $this->entityManager->flush();
                $this->entityManager->clear();
                $io->progressFinish();
                $io->writeln("Country insertion finished.....");

                // Tag Inserting
                $i = 1;
                $io->writeln("Tags insertion Started.....");
                $io->progressStart();
                foreach ($data as $row) {
                    $tagArray = explode(",", $row[9]);
                    foreach ($tagArray as $tag) {
                        if ((!in_array($i, $this->errorInRecordNoArray)) && (!in_array($tag, $tagsA))) {
                            $tags = new Tags();
                            $tags->setTag($tag);
                            array_push($tagsA, $tag);
                            $this->entityManager->persist($tags);
                            $io->progressAdvance();
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
                $io->progressFinish();
                $io->writeln("Tags insertion finished.....");

                //product Inserting
                // $productA = $this->convertToArray("productKey", $productRepository->getOneField());
                $i = 1;
                $io->writeln("Products insertion Started.....");
                $io->progressStart();
                foreach ($data as $row) {
                    if ((!in_array($i, $this->errorInRecordNoArray)) && (!in_array($row[0], $productA))) {
                        $product = new Products();
                        $product->setProductKey($row[0]);
                        $product->setProductName($row[1]);
                        $product->setPriceBefore($row[2]);
                        $product->setPriceAfter($row[3]);
                        $product->setProductImage($row[4]);
                        $product->setCountryOfOrigin($this->countryRepository->findOneBy(["country" => $row[5]]));

                        $product->setCategory($this->categoryRepository->findOneBy(["Category" => $row[6]]));
                        $product->setSubCategory($this->subCategoryRepository->findOneBy(["SubCategory" => $row[7]]));
                        $product->setProductBrand($this->brandsRepository->findOneBy(["brand" => $row[8]]));

                        $tagArray = explode(",", $row[9]);
                        foreach ($tagArray as $tag) {
                            $tags = $this->tagsRepository->findOneBy(["tag" => $tag]);
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
                        $io->progressAdvance();
                    }
                    $i++;
                }
                $this->entityManager->flush();
                $this->entityManager->clear();
                $io->progressFinish();
                $io->writeln("Products insertion finished.....");

                // image Inserting
                // $i = 1;
                // $io->writeln("Images insertion Started.....");
                // $io->progressStart();
                // foreach ($data as $row) {
                //     if (!in_array($i, $this->errorInRecordNoArray)) {
                //         $urlOriginal = "D:/GroceryMart/public/images/product/$row[4]";
                //         $urlCompress1 = "D:/GroceryMart/public/images/product/compress1/$row[4]";
                //         $urlCompress2 = "D:/GroceryMart/public/images/product/compress2/$row[4]";

                //         $filesystem->copy($row[13], $urlOriginal);

                //         $this->compressedImage($urlOriginal,
                //             $urlCompress1,
                //             60
                //         );
                //         $this->compressedImage($urlOriginal,
                //             $urlCompress2,
                //             40
                //         );
                //         $io->progressAdvance();
                //     }
                //     $i++;
                // }
                // $io->progressFinish();
                // $io->writeln("Images insertion finished.....");
            }

            $io->success("" . $file->getUploadedData() . ' Records Uploaded SuccessFully ... :)');
            $io->warning("" . $file->getAlreadyInDatabase() . ' Records Already In Database ... :|');
            $io->error("Error In Data No " . implode("," , $file->getErrorData()) . ' ... :(');
            return Command::SUCCESS;
        }
        else
        {
            $io->info("No files Found");
            return Command::FAILURE;
        }

    }

    public function convertToArray($str, $AOA)
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
    // protected function execute(InputInterface $input, OutputInterface $output): int
    // {
    //     $io = new SymfonyStyle($input, $output);
    //     $arg1 = $input->getArgument('arg1');

    //     if ($arg1) {
    //         $io->note(sprintf('You passed an argument: %s', $arg1));
    //     }

    //     if ($input->getOption('option1')) {
    //         // ...
    //     }

    //     $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

    //     return Command::SUCCESS;
    // }
}

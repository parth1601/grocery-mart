<?php

namespace App\Form\EventListener;

use App\Entity\Order;
use App\Repository\ProductsRepository;
use App\Entity\UploadedDataFiles;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class BeforeUploadFile implements EventSubscriberInterface
{
    private $countOfInsertedRecords = 0;
    private $errorInRecordNoArray = array();
    private $recordsAlreadyInDatabase = 0;
    private $errorRecords = 0;
    private $message = "";
    private $productRepository;

    public function __construct(ProductsRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public static function getSubscribedEvents()
    {
        return [BeforeEntityPersistedEvent::class => ['setDataItems'],];
    }
    

    public function setDataItems(BeforeEntityPersistedEvent $event): void
    {
        $filesystem = new Filesystem();
        $entity = $event->getEntityInstance();

        if (!($entity instanceof UploadedDataFiles)) {
            return;
        }

        $filename = $_FILES["UploadedDataFiles"]['name']['uploadedFile']['file'];

        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $filename);
        $file_entention = end($file_array);

        if (in_array($file_entention, $allowed_extension)) {
            try {
                $tmp_name= $_FILES["UploadedDataFiles"]['tmp_name']['uploadedFile']['file'];
                if($filesystem->exists($tmp_name)){

                    $file_type = IOFactory::identify($filename);
                    $reader = IOFactory::createReader($file_type);

                    $spreadsheet = $reader->load($tmp_name);
                    $data = $spreadsheet->getActiveSheet()->toArray();

                    $str = $this->processData($data);

                    $this->message = '<div class="alert alert-success">' . $this->countOfInsertedRecords . ' Data Inserted Successfully...!!!</div>';
                    if($this->recordsAlreadyInDatabase>0){
                        $this->message.= '<div class="alert alert-warning">' . $this->recordsAlreadyInDatabase . ' Data Are Alredy In DataBase...!!!</div>';
                    }
                    if($this->errorRecords>0){
                        $str=implode(", ", $this->errorInRecordNoArray);
                        $this->message .= '<div class="alert alert-danger">Error accoured while entering Record No ' .$str. ' ...!!!</div>';
                    }
                }
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at " . $exception->getPath();
            }
        } else {
            $this->message = '<div class="alert alert-danger">Only xls, csv and xlsx file allowed...!!!</div>';
        }
        $entity->setErrorData($this->errorInRecordNoArray);
        $entity->setUploadedData($this->countOfInsertedRecords);
        $entity->setAlreadyInDatabase($this->recordsAlreadyInDatabase);
        
    }

    public function processData($data)
    {
        $productA= $this->convertToArray("productKey", $this->productRepository->getOneField());

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
        $str = "all Valid";
        return $str;
    }

    public function convertToArray($str,$AOA)
    {
        $newA = array();
        foreach ($AOA as $array) {
            array_push($newA, $array[$str]);
        }
        return $newA;
    }

    
    public function validateData($row)
    {
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
        return true;
    }
}

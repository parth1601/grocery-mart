<?php

namespace App\Entity;

use App\Repository\UploadedDataFilesRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UploadedDataFilesRepository::class)
 * @Vich\Uploadable
 */
class UploadedDataFiles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="uploadedDataFiles")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @Vich\UploadableField(mapping="fileNameMapping", fileNameProperty="fileName")
     * 
     * @var File
     */
    private $uploadedFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer" ,nullable=true)
     */
    private $uploadedData;

    /**
     * @ORM\Column(type="array")
     */
    private $errorData = [];

    /**
     * @ORM\Column(type="integer" ,nullable=true)
     */
    private $alreadyInDatabase;

    public const UNDER_PROCESS = "Under Process";
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status = self::UNDER_PROCESS;

    public function __construct()
    {
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUploadedData(): ?int
    {
        return $this->uploadedData;
    }

    public function setUploadedData(int $uploadedData): self
    {
        $this->uploadedData = $uploadedData;

        return $this;
    }

    public function getErrorData(): ?array
    {
        return $this->errorData;
    }

    public function setErrorData(array $errorData): self
    {
        $this->errorData = $errorData;

        return $this;
    }

    public function getAlreadyInDatabase(): ?int
    {
        return $this->alreadyInDatabase;
    }

    public function setAlreadyInDatabase(int $alreadyInDatabase): self
    {
        $this->alreadyInDatabase = $alreadyInDatabase;

        return $this;
    }


    /**
     * Get the value of uploadedFile
     *
     * @return  File
     */ 
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    /**
     * Set the value of uploadedFile
     *
     * @param  File  $uploadedFile
     *
     * @return  self
     */ 
    public function setUploadedFile(File $uploadedFile = null)
    {
        $this->uploadedFile = $uploadedFile;
        if ($uploadedFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}

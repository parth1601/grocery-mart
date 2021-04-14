<?php

namespace App\Entity;

use App\Repository\BrandsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ProxyManager\ProxyGenerator\ValueHolder\MethodGenerator\Constructor;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=BrandsRepository::class)
 * @UniqueEntity(fields={"brand"}, message="Brand Already Exist")
 * @Vich\Uploadable
 */
class Brands
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brandImage;

    /**
     * @Vich\UploadableField(mapping="brandImg", fileNameProperty="brandImage")
     * 
     * @var File
     */
    private $brandImgFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="productBrand")
     */
    private $products;
    
    public function __construct()
    {
        $this->updatedAt = new \DateTime();
        $this->products = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->brand;
    }

    public function getId(): ?int
    {
        return $this->id;
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


    
    /**
     * Get the value of brandImage
     */ 
    public function getBrandImage()
    {
        return $this->brandImage;
    }

    /**
     * Set the value of brandImage
     *
     * @return  self
     */ 
    public function setBrandImage($brandImage)
    {
        $this->brandImage = $brandImage;

        return $this;
    }

    /**
     * Get the value of brandImgFile
     *
     * @return  File
     */ 
    public function getBrandImgFile()
    {
        return $this->brandImgFile;
    }

    /**
     * Set the value of brandImgFile
     *
     * @param  File  $brandImgFile
     *
     * @return  self
     */ 
    public function setBrandImgFile(File $brandImgFile = null)
    {
        $this->brandImgFile = $brandImgFile;
        if ($brandImgFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     * Get the value of brand
     */ 
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set the value of brand
     *
     * @return  self
     */ 
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setProductBrand($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getProductBrand() === $this) {
                $product->setProductBrand(null);
            }
        }

        return $this;
    }
}

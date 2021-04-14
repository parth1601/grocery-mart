<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 * @UniqueEntity(fields={"productKey"})
 * @Vich\Uploadable
 */
class Products
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
    private $productKey;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productName;

    /**
     * @ORM\Column(type="bigint")
     */
    private $priceBefore;

    /**
     * @ORM\Column(type="bigint")
     */
    private $priceAfter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productImage;

    /**
     * @Vich\UploadableField(mapping="productImg", fileNameProperty="productImage")
     * 
     * @var File
     */
    private $productImageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $productStatus;

    /**
     * @ORM\Column(type="text")
     */
    private $productDescription;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=SubCategory::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subCategory;

    /**
     * @ORM\ManyToMany(targetEntity=Tags::class, inversedBy="products")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity=Brands::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productBrand;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $expiryDate;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $countryOfOrigin;

    /**
     * @ORM\OneToMany(targetEntity=OrderItem::class, mappedBy="product")
     */
    private $orderItems;

    public function __construct()
    {
        $this->updatedAt = new \DateTime();
        $this->tags = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductKey(): ?string
    {
        return $this->productKey;
    }

    public function setProductKey(string $productKey): self
    {
        $this->productKey = $productKey;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getPriceBefore(): ?string
    {
        return $this->priceBefore;
    }

    public function setPriceBefore(string $priceBefore): self
    {
        $this->priceBefore = $priceBefore;

        return $this;
    }

    public function getPriceAfter(): ?string
    {
        return $this->priceAfter;
    }

    public function setPriceAfter(string $priceAfter): self
    {
        $this->priceAfter = $priceAfter;

        return $this;
    }

    public function getProductImage(): ?string
    {
        return $this->productImage;
    }

    public function setProductImage($productImage): self
    {
        $this->productImage = $productImage;

        return $this;
    }

    
    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
        // return $this->category->getCategory();
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): self
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * @return Collection|Tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getProductBrand(): ?Brands
    {
        return $this->productBrand;
    }

    public function setProductBrand(?Brands $productBrand): self
    {
        $this->productBrand = $productBrand;

        return $this;
    }

    /**
     * Get the value of productImageFile
     */ 
    public function getProductImageFile()
    {
        return $this->productImageFile;
    }

    /**
     * Set the value of productImageFile
     *
     * @param  File  $productImageFile
     *
     * @return  self
     */ 
    public function setProductImageFile(File $productImageFile = null)
    {
        $this->productImageFile = $productImageFile;
        if ($productImageFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return  \DateTime
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param  \DateTime  $updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of productStatus
     */ 
    public function getProductStatus()
    {
        return $this->productStatus;
    }

    /**
     * Set the value of productStatus
     *
     * @return  self
     */ 
    public function setProductStatus($productStatus)
    {
        $this->productStatus = $productStatus;

        return $this;
    }

    public function getExpiryDate(): ?\DateTimeInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(?\DateTimeInterface $expiryDate): self
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function getCountryOfOrigin(): ?Country
    {
        return $this->countryOfOrigin;
    }

    public function setCountryOfOrigin(?Country $countryOfOrigin): self
    {
        $this->countryOfOrigin = $countryOfOrigin;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->setProduct($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getProduct() === $this) {
                $orderItem->setProduct(null);
            }
        }

        return $this;
    }
}

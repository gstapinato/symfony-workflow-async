<?php

namespace App\Entity;

use App\DTO\ProductDTO;
use Doctrine\DBAL\Types\Types;
use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID, unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    #[ORM\Column(length: 5000, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idProductSupplier;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $url;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $name;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $productCategoryTree;

    #[ORM\Column(type: Types::DECIMAL, nullable: true, precision: 10, scale: 2)]
    private ?float $retailPrice;

    #[ORM\Column(type: Types::DECIMAL, nullable: true, precision: 10, scale: 2)]
    private ?float $discountedPrice;

    #[ORM\Column(length: 3500, nullable: true)]
    private ?string $image;


    public static function createFromProductDTO(ProductDTO $productDTO): self
    {
        $product = new self();
        $product->description = $productDTO->description;
        $product->idProductSupplier = $productDTO->idProductSupplier;
        $product->url = $productDTO->url;
        $product->name = $productDTO->name;
        $product->productCategoryTree = $productDTO->productCategoryTree;
        $product->retailPrice = $productDTO->retailPrice;
        $product->discountedPrice = $productDTO->discountedPrice;
        $product->image = $productDTO->image;
        return $product;
    }

    /**
     * Get the value of id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the value of description
     *
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


    /**
     * Get the value of name
     *
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the value of productCategoryTree
     *
     * @return ?string
     */
    public function getProductCategoryTree(): ?string
    {
        return $this->productCategoryTree;
    }


    /**
     * Get the value of retailPrice
     *
     * @return ?float
     */
    public function getRetailPrice(): ?float
    {
        return $this->retailPrice;
    }

    /**
     * Get the value of discountedPrice
     *
     * @return ?float
     */
    public function getDiscountedPrice(): ?float
    {
        return $this->discountedPrice;
    }

    /**
     * Get the value of image
     *
     * @return ?string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }


    /**
     * Get the value of url
     *
     * @return ?string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Get the value of idProductSupplier
     *
     * @return ?string
     */
    public function getIdProductSupplier(): ?string
    {
        return $this->idProductSupplier;
    }
}

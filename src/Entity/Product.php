<?php

namespace App\Entity;

use App\Entity\Category;
use App\Entity\Image;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Entity]
#[ORM\Table('products')]
class Product
{

    #[ORM\Id()]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(type: 'string')]
    #[Regex('/[a-zA-Z]{3,180}/')]
    private ?string $title = null;

    #[ORM\Column(type: 'string', nullable: true)] 
    #[Regex('/^[[:ascii:]]+$/')]
    private ?string $description = null;


    #[ORM\OneToOne(targetEntity: Category::class)]
    private ?Category $category = null;
    
    #[ORM\OneToOne(targetEntity: Image::class)]
    #[Groups('product')]
    private ?Image $image = null;

    #[ORM\Column(unique: true)]
    #[Regex('/^[a-zA-Z\d\/]+$/')]
    private ?int $slug;

    #[ORM\Column] 
    private int $price;

    #[ORM\Column] 
    private int $amount;
	
	public function getId() {
		return $this->id;
	}

	public function getTitle(): ?string {
		return $this->title;
	}
	
	public function setTitle(?string $title): self {
		$this->title = $title;
		return $this;
	}

	public function getDescription(): ?string {
		return $this->description;
	}
	
	public function setDescription(?string $description): self {
		$this->description = $description;
		return $this;
	}

	public function getCategory(): ?Category {
		return $this->category;
	}
	
	public function setCategory(?Category $category): self {
		$this->category = $category;
		return $this;
	}

	public function getImage(): ?Image {
		return $this->image;
	}
	
	public function setImage(?Image $image): self {
		$this->image = $image;
		return $this;
	}

	public function getSlug(): ?int {
		return $this->slug;
	}
	
	public function setSlug(?int $slug): self {
		$this->slug = $slug;
		return $this;
	}

	public function getPrice(): int {
		return $this->price;
	}
	
	public function setPrice(int $price): self {
		$this->price = $price;
		return $this;
	}

	public function getAmount(): int {
		return $this->amount;
	}
	
	public function setAmount(int $amount): self {
		$this->amount = $amount;
		return $this;
	}
}
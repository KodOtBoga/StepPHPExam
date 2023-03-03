<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\Regex;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('categories')]
class Category{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    //#[Groups('category')]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Regex('/^[a-zA-Z\d\/]+$/')]
    private ?string $slug;

    #[ORM\Column(unique: true)]
    private ?string $name;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'categories')]
    //#[Groups('category')]
    private ?Category $category = null;

    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'category')]
    private Collection $categories;

    /**
     */
    public function __construct() {

    }

	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}

	/**
	 * @return string|null
	 */
	public function getSlug(): ?string {
		return $this->slug;
	}
	
	/**
	 * @param string|null $slug 
	 * @return self
	 */
	public function setSlug(?string $slug): self {
		$this->slug = $slug;
		return $this;
	}

	/**
	 * @return Category|null
	 */
	public function getCategory(): ?Category {
		return $this->category;
	}
	
	/**
	 * @param Category|null $category 
	 * @return self
	 */
	public function setCategory(?Category $category): self {
		$this->category = $category;
		return $this;
	}

	/**
	 * @return Collection
	 */
	public function getCategories(): Collection {
		return $this->categories;
	}
	
	/**
	 * @param Collection $categories 
	 * @return self
	 */
	public function setCategories(Collection $categories): self {
		$this->categories = $categories;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getName(): ?string {
		return $this->name;
	}
	
	/**
	 * @param string|null $name 
	 * @return self
	 */
	public function setName(?string $name): self {
		$this->name = $name;
		return $this;
	}

	public function __toString()
	{
		return $this->name;
	}
}
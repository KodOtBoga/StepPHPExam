<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Order;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Entity]
#[ORM\Table('payments')]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(targetEntity: User::class, inversedBy:'payments')]
    private User $user;

    // #[ORM\Column]
    // private ?int $amount = null;


    #[ORM\OneToOne(targetEntity: Order::class)]
    private Order $order;

	#[ORM\Column]
	private ?\DateTime $date = null;

	public function __construct() 
	{
		$this->date = new \DateTime();
    }

	public function getId(): ?int {
		return $this->id;
	}

	public function getUser(): User {
		return $this->user;
	}

	public function setUser(User $user): self {
		$this->user = $user;
		return $this;
	}

	// public function getAmount(): int {
	// 	return $this->amount;
	// }

	// public function setAmount(int $amount): self {
	// 	$this->amount = $amount;
	// 	return $this;
	// }

	public function getOrder(): Order {
		return $this->order;
	}

	public function setOrder(Order $order): self {
		$this->order = $order;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDate() {
		return $this->date;
	}
	
	/**
	 * @param mixed $date 
	 * @return self
	 */
	public function setDate($date): self {
		$this->date = $date;
		return $this;
	}
}
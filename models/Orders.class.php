<?php
class Orders
{
	private $id; 
	private $id_users;
	private $status;
	private $price;
	private $date;

	private $user;
	private $products;
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}
	public function getProducts()
	{
		if ($this->products === null)
		{
			$manager = new ProductsManager($this->db);
			$this->products = $manager->findByOrder($this);
		}
		return $this->products;
	}
	public function getProductNbr()
	{
		if ($this->products === null)
		{
			$manager = new ProductsManager($this->db);
			$this->products = $manager->findNbrByOrder($this);
		}
		return $this->products;
	}
	public function addProduct(Products $products)
	{
		if ($this->products === null)
		{
			$this->getProducts();
		}
		$this->products[] = $products;
		$this->price += $products->getPrice();
	}
	public function editProduct(Products $product, $quantity)
	{
		$quantity = intval($quantity);
		if ($quantity <= 0)
		{
			$this->removeProduct($product);
		}
		else
		{
			if ($this->products === null)
			{
				$this->getProducts();
			}
			$stock = 0;
			foreach ($this->products AS $product_in)
			{
				if ($product_in->getId() == $product->getId())
				{
					$stock++;
				}
			}
			if ($stock < $quantity)
			{
				while ($stock < $quantity)
				{
					$this->addProduct($product);
					$stock++;
				}
			}
			else if ($stock > $quantity)
			{
				while ($stock > $quantity)
				{
					$this->removeOneProduct($product);
					$stock--;
				}
			}
		}
	}
	public function removeOneProduct(Products $product)
	{
		if ($this->products === null)
		{
			$this->getProducts();
		}
		$already = false;
		$list = [];
		foreach ($this->products AS $product_in)
		{
			if ($product_in->getId() == $product->getId() && $already == false)
			{
				$this->price -= $product_in->getPrice();
				$already = true;
			}
			else
			{
				$list[] = $product_in;
			}
		}
		$this->products = $list;
	}
	public function removeProduct(Products $product)
	{
		if ($this->products === null)
		{
			$this->getProducts();
		}
		$list = [];
		foreach ($this->products AS $product_in)
		{
			if ($product_in->getId() == $product->getId())
			{
				// modifier le prix
				$this->price -= $product_in->getPrice();
				// modifier les stocks
				// $product_in->setQuantity($product_in->getQuantity() + 1);
			}
			else
			{
				$list[] = $product_in;
			}
		}
		$this->products = $list;
	}

	public function getId()
	{
		return $this->id; 
	}
	public function getUser()
	{
		$manager = new UserManager($this->db);
		$this->user = $manager->findById($this->id_users);
		return $this->user;
	}
	public function getStatus()
	{
		return $this->status; 
	}
	public function getPrice()
	{
		return $this->price; 
	}
	public function getDate()
	{
		return $this->date; 
	}
	
	// SETTER

	
	public function setUser(User $user)
	{
		$this->user = $user;
		$this->id_users = $user->getId();  
	}
	public function setStatus($status)
	{
		if (strlen($status) > 63)
		{
			return "Le statut est invalide";
		} 
		if (strlen($status) < 2)
		{
			return "Le statut est invalide";
		}
		else
		{
			$this->status = $status;
		}
	}
	public function setPrice($price)
	{
		if (strlen($price) < 0)
		{
			return "Le prix ne peut pas être inférieur à 0";
		}
		else
		{
			$this->price = $price;
		}
	}
	public function setDate($date)
	{
		if($date == '')
		{
			return "Date invalide";
		}
		$tab = explode('-', $date);
		if (isset($tab[0], $tab[1], $tab[2]))
		{
			$month = $tab[1];
			$day = $tab[2];
			$year = $tab[0];
			if (checkdate($month, $day, $year) == true)
			{
				$this->date = $date;
			}
			else
			{
				return "La date est invalide.";
			}
		}
		else
		{
			return "Le date est invalide";
		}
	}
}
?>
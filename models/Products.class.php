<?php
class Products
{
	private $id;
	private $id_category; 
	private $name; 
	private $picture; 
	private $description; 
	private $price; 
	private $quantity;

	private $db;
	private $category;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function getId()
	{
		return $this->id;
	} 
	public function getCategory()
	{
		$manager = new CategoryManager($this->db);
		$this->category = $manager->findById($this->id_category);
		return $this->category;
	}
	public function getName()
	{
		return $this->name;
	} 
	public function getPicture()
	{
		return $this->picture;
	} 
	public function getDescription()
	{
		return $this->description;
	} 
	public function getPrice()
	{
		return $this->price;
	} 
	public function getQuantity()
	{
		return $this->quantity;
	} 

	//SETTER

	public function setCategory(Category $category)
	{
		$this->category = $category;
		$this->id_category = $category->getId();
	}
	public function setName($name)
	{
		if (strlen($name)<3)
		{
			return "Le nom de la category est trop court (<3)";
		}
		else if (strlen($name)>63)
		{
			return "Le nom de la category est trop long (>63)";
		}
		else
		{
			$this->name = $name;
		}
	}
	public function setPicture($picture)
	{
		if (strlen($picture)<3)
		{
			return "L'url de l'image est trop court (<3)";
		}
		else if (strlen($picture)>511)
		{
			return "L'url de l'image est trop long (>511)";
		}
		else if (filter_var($picture, FILTER_VALIDATE_URL) == false) 
		{
			return "L'url n'est pas valide";
		}
		else
		{
			$this->picture = $picture;
		}
	}
	public function setDescription($description)
	{
		if (strlen($description)<3)
		{
			return "La description est trop court (<3)";
		}
		else if (strlen($description)>1023)
		{
			return "La description est trop long (>1023)";
		}
		else 
		{
			$this->description = $description;
		}
	}
	public function setPrice($price)
	{
		if ($price <= 0)
		{
			return "Le prix ne peut pas etre inférieur ou égal à 0";
		}
		else if ($price >= 10000)
		{
			return "Le prix est trop elevé";
		}
		else
		{
			$this->price = $price;
		}
	}
	public function setQuantity($quantity)
	{
		if ($quantity < 0)
		{
			return "Les quantités ne peuvent pas être négatives";
		}
		else
		{
			$this->quantity = $quantity;
		}
	}

}
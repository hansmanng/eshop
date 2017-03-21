<?php
class Comment
{
	// liste des propriétés stockées -> privées
	private $id;		//toujours exactement les mêmes noms des colonnes dans la DB
	private $content;
	private $date;
	private $id_author;
	private $id_product;
	private $rate;

	// Propriété Calculée:
	private $author; //class User
	private $product; //class Article

	// Propriété Transmise:
	private $db;
	public function __construct($db)
	{
		$this->db = $db;
	}
	
	// **************************getter*****************************

	public function getId()
	{
		return $this->id;
	}
	public function getContent()
	{
		return $this->content;
	}
	public function getDate()
	{
		return $this->date;
	}
	public function getAuthor() //composition
	{
		$manager = new UserManager($this->db);
		$this->author = $manager->findById($this->id_author);
		return $this->author;// null
	}
	public function getProduct() //composition
	{
		$manager = new ProductsManager($this->db);
		$this->product = $manager->findById($this->id_product);
		return $this->product;// null
	}
	public function getRate()
	{
		return $this->rate;
	}

	// **************************setter********************************

	public function setContent($content)
	{
		if (strlen($content) > 4095)
		{
			return "Contenu trop long (> 4095)";
		}
		else if (strlen($content) < 2)
		{
			return "Contenu trop court (< 2)";
		}
		else
		{
			$this->content = $content;
		}
	} 
	public function setAuthor(User $author)
	{
		$this->author = $author;
		$this->id_author = $author->getId();
	}
	public function setProduct(Products $product)
	{
		$this->product = $product;
		$this->id_product = $product->getId();
	}
	public function setRate($rate)
	{
		if (strlen($rate) > 4)
		{
			return "La note trop longue (> 4)";
		}
		else if (strlen($rate) < 1)
		{
			return "La note trop courte (< 1)";
		}
		else
		{
			$this->rate = $rate;
		}
	} 
}
?>
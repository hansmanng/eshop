<?php 

class Category
 {
	private $id ;
	private $name;
	private $description;
	
	public function __construct($db)
	{
		$this->db = $db;
	}
	
	// GETTER------------------------------------------------------------------
	public function getId()
	{
		return $this->id;
	}
	public function getName()
	{
		return $this->name;
	}
	public function getDescription()
	{
		return $this->description;
	}
	
	// SETTER------------------------------------------------------------------
	public function setName($name)
	{
		if (strlen($name) > 31)
		{
			return "Le nom est trop long(>31)";
		}
		else if (strlen($name) < 2)
		{
			return "Le nom est trop court (< 2)";
		}
		else
		{
			$this->name = $name;
		}
	}
	
	public function setDescription($description)
	{
		if (strlen($description) > 4095)
		{
			return "La descritpion est trop longue(> 4095)";
		}
		else if (strlen($description) < 2)
		{
			return "La descritpion est trop courte (< 2)";
		}
		else
		{
			$this->description = $description;
		}
	}
}

?>
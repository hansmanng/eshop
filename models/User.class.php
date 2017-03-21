<?php
class User
{
	private $id;
	private $email;
	private $password;
	private $name;
	private $address;
	private $city;
	private $birthdate;
	private $admin;
	private $db;

	private $cart;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function getCart()
	{
		$manager = new OrdersManager($this->db);
		$this->cart = $manager->findCartByUser($this);
		return $this->cart;
	}
	public function getId()
	{
		return $this->id;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function getPassword()
	{
		return $this->password;
	}
	public function getName()
	{
		return $this->name;
	}
	public function getAddress()
	{
		return $this->address;
	}
	public function getCity()
	{
		return $this->city;
	}
	public function getBirthdate()
	{
		return $this->birthdate;
	}
	public function isAdmin()
	{
		return $this->admin;
	}
	public function verifPassword($password)
	{
		return password_verify($password, $this->password);
	}

	public function setEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL) == true)
		{
			$this->email = $email;
		}
		else
		{
			return "L'adresse email est invalide.";
		}
	}
	public function updatePassword($password, $old_password)
	{
		if (strlen($password) > 63)
		{
			return "Mot de passe trop long (> 63)";
		}
		else if (strlen($password) < 6)
		{
			return "Mot de passe trop court (< 6)";
		}
		else if (!$this->verifPassword($old_password))
		{
			return "L'ancien mot de passe est invalide";
		}
		else
		{
			$this->password = password_hash($password, PASSWORD_BCRYPT, ["cost"=>11]);
		}
	}
	public function initPassword($password1, $password2)
	{
		if (strlen($password1) > 63)
		{
			return "Mot de passe trop long (> 63)";
		}
		else if (strlen($password1) < 6)
		{
			return "Mot de passe trop court (< 6)";
		}
		else if ($password1 != $password2)
		{
			return "Les mots de passe ne correspondent pas";
		}
		else if ($this->password != null)
		{
			return "Vous ne pouvez pas initialiser un mot de passe deja existant";
		}
		else
		{
			$this->password = password_hash($password1, PASSWORD_BCRYPT, ["cost"=>11]);
		}
	}
	public function setName($name)
	{
		if (strlen($name) > 31)
		{
			return "Le nom est trop long (> 31)";
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
	public function setAddress($address)
	{
		if (strlen($address) > 127)
		{
			return "L'adresse est trop longue (> 127)";
		}
		else if (strlen($address) < 2)
		{
			return "L'adresse est trop courte (< 2)";
		}
		else
		{
			$this->address = $address;
		}
	}
	public function setCity($city)
	{
		if (strlen($city) > 63)
		{
			return "Le nom de la ville est trop long (> 63)";
		}
		else if (strlen($city) < 2)
		{
			return "Le nom de la ville est trop court (< 2)";
		}
		else
		{
			$this->city = $city;
		}
	}
	public function setBirthdate($birthdate)
	{
		$birthdate = str_replace('/', '-', $birthdate);
		$birthdate = str_replace('.', '-', $birthdate);
		$birthdate = str_replace(' ', '-', $birthdate);
		if($birthdate == '')
		{
			return "Date invalide";
		}
		$tab = explode('-', $birthdate);
		if (isset($tab[0], $tab[1], $tab[2]))
		{
			$month = $tab[1];
			$day = $tab[2];
			$year = $tab[0];
			if (checkdate($month, $day, $year) == true)
			{
				$this->birthdate = $birthdate;
			}
			else
			{
				return "La date de naissance est invalide. Votre navigateur n'est pas à jour. Pour des raisons de sécurité, veuillez faire la dernière mise à jour.";
			}
		}
		else
		{
			return "La date de naissance est invalide.";
		}
	}
	public function setAdmin($admin)
	{
		$this->admin = $admin;
	}
}
?>
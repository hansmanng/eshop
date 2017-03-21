<?php
class ProductsManager
{
	private $db;

	public function __construct($db)
	{
		$this->db=$db;
	}
	public function search($search)
	{
		// $list = [];
		// $recherche = mysqli_real_escape_string($this->db, $search);
		// $res = mysqli_query($this->db, "SELECT * FROM products WHERE name LIKE '%".$recherche."%' OR description LIKE '%".$recherche."%'");
		$request = $this->db->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
		$request->execute(['%'.$search.'%', '%'.$search.'%']);
		// while($product = mysqli_fetch_object($res, "Products", [$this->db]))
		// {
		// 	$list[] = $product;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Products", [$this->db]);
		return $list;
	}
	public function findByOrder(Orders $order)
	{
		// $id = intval($order->getId());
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT products.* FROM products LEFT JOIN link_orders_products ON link_orders_products.id_products=products.id WHERE link_orders_products.id_orders='".$id."'");
		$request = $this->db->prepare("SELECT products.* FROM products LEFT JOIN link_orders_products ON link_orders_products.id_products=products.id WHERE link_orders_products.id_orders=?");
		$request->execute([$order->getId()]);
		// while($products = mysqli_fetch_object($res, "Products", [$this->db]))
		// {
		// 	$list[] = $products;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Products", [$this->db]);
		return $list;
	}
	public function findNbrByOrder(Orders $order)
	{
		// $id = intval($order->getId());
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT products.*, COUNT(products.id) AS nbr FROM products LEFT JOIN link_orders_products ON link_orders_products.id_products=products.id WHERE link_orders_products.id_orders='".$id."' GROUP BY products.id");
		$request = $this->db->prepare("SELECT products.*, COUNT(products.id) AS nbr FROM products LEFT JOIN link_orders_products ON link_orders_products.id_products=products.id WHERE link_orders_products.id_orders=? GROUP BY products.id");
		$request->execute([$order->getId()]);
		// while($products = mysqli_fetch_object($res, "Products", [$this->db]))
		// {
		// 	$list[] = $products;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Products", [$this->db]);
		return $list;
	}

	public function findByCategory(Category $category)
	{
		// $id_category = intval($category->getId());
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT * FROM products WHERE id_category='".$id_category."' ORDER BY name");
		$request = $this->db->prepare("SELECT * FROM products WHERE id_category=? ORDER BY name");
		$request->execute([$category->getId()]);
		// while($products = mysqli_fetch_object($res, "Products", [$this->db]))
		// {
		// 	$list[] = $products;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Products", [$this->db]);
		return $list;
	}
	public function findById($id)
	{
		// $id = intval($id);
		// $res = mysqli_query($this->db, "SELECT * FROM products WHERE id='".$id."'");
		$request = $this->db->prepare("SELECT * FROM products WHERE id=? ORDER BY name");
		$request->execute([$id]);
		// $products = mysqli_fetch_object($res, "Products", [$this->db]); 
		// $user = new User();
		$products = $request->fetchObject("Products", [$this->db]);
		return $products;
	}

	public function save(Products $products)
	{
		// $id = intval($products->getId());
		// $id_category = intval($products->getCategory()->getId());
		// $name = mysqli_real_escape_string($this->db, $products->getName());
		// $picture = mysqli_real_escape_string($this->db, $products->getPicture());
		// $description = mysqli_real_escape_string($this->db, $products->getDescription());
		// $price = floatval($products->getPrice());
		// $quantity = intval($products->getQuantity());
		// $res = mysqli_query($this->db, "UPDATE products SET id_category='".$id_category."', name='".$name."', picture='".$picture."', description= '".$description."', price='".$price."', quantity= '".$quantity."' WHERE id='".$id."' LIMIT 1");
		$request = $this->db->prepare("UPDATE products SET id_category=?, name=?, picture=?, description=?, price=?, quantity=? WHERE id=? LIMIT 1");
		$request->execute([$products->getId(), $products->getCategory()->getId(), $products->getName(), $products->getPicture(), $products->getDescription(), $products->getPrice(), $products->getQuantity()]);
		return $this->findById($products->getId());
	}
	public function remove(Products $products)
	{
		// $id = intval($products->getId());
		// mysqli_query($this->db, "DELETE from products WHERE id='".$id."' LIMIT 1");
		$request = $this->db->prepare("DELETE from products WHERE id=? LIMIT 1");
		$request->execute([$products->getId()]);
		return $products;
	}
	public function create(Category $category, $name, $picture, $description, $price, $quantity)
	{
		$errors = [];
		$products = new Products($this->db);
		$error = $products->setCategory($category);
		if($error)
			$errors[] = $error;
		$error = $products->setName($name);// throw
		if($error)
			$errors[] = $error;
		$error = $products->setPicture($picture);
		if($error)
			$errors[] = $error;
		$error = $products->setDescription($description);
		if($error)
			$errors[] = $error;
		$error = $products->setPrice($price);
		if($error)
			$errors[] = $error;
		$error = $products->setQuantity($quantity);
		if($error)
			$errors[] = $error;
		if (count($errors) != 0)
			throw new Exceptions($errors);
		// $id_category= intval($products->getCategory()->getId());
		// $name = mysqli_real_escape_string($this->db, $products->getName());
		// $picture = mysqli_real_escape_string($this->db, $products->getPicture());
		// $description = mysqli_real_escape_string($this->db, $products->getDescription());
		// $price = floatval($products->getPrice());
		// $quantity = intval($products->getQuantity());
		// $res = mysqli_query($this->db, "INSERT INTO products (id_category, name, picture, description, price, quantity) VALUES('".$id_category."', '".$name."', '".$picture."', '".$description."', '".$price."', '".$quantity."')");
		$request = $this->db->prepare("INSERT INTO products (id_category, name, picture, description, price, quantity) VALUES(?, ?, ?, ?, ?, ?)");
		$request->execute([$products->getCategory()->getId(), $products->getName(), $products->getPicture(), $products->getDescription(), $products->getPrice(), $products->getQuantity()]);
		// $id = mysqli_insert_id($this->db);// last_insert_id
		$id = $this->db->lastInsertId();
		return $this->findById($id);
	}
}
?>
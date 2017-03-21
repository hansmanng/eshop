<?php
class OrdersManager
{	

	private $db;
	public function __construct($db)
	{
		$this->db=$db;
	}
	// SELECT
	public function findAll()
	{	
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT * FROM orders ORDER BY date");
		$request = $this->db->query("SELECT * FROM orders ORDER BY date");
		// while ($orders = mysqli_fetch_object($res, "Orders", [$this->db]))
		// {
		// 	$list[] = $orders;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Orders", [$this->db]);
		return $list;
	}
	public function findById($id)
	{
		// $id = intval($id);
		// $res = mysqli_query($this->db, "SELECT * FROM orders WHERE id='".$id."'");
		// $orders = mysqli_fetch_object($res, "Orders", [$this->db]);
		$request = $this->db->prepare("SELECT * FROM orders WHERE id=? LIMIT 1");
		$request->execute([$id]);
		$orders = $request->fetchObject("Orders", [$this->db]);
		return $orders;
	}
	public function findByUsers(User $user)
	{
		// $id_users = intval($user->getId());
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT * FROM orders WHERE id_users='".$id_users."'");
		$request = $this->db->prepare("SELECT * FROM orders WHERE id_users=?");
		$request->execute([$user->getId()]);
		// while($order = mysqli_fetch_object($res, "Orders", [$this->db]))
		// {
		// 	$list[] = $order;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Orders", [$this->db]);
		return $list;
	}
	public function findByStatus($status)
	{
		// $list = [];
		// $status = mysqli_real_escape_string($this->db, $status);
		// $res = mysqli_query($this->db, "SELECT * FROM orders WHERE status='".$status."'");
		$request = $this->db->prepare("SELECT * FROM orders WHERE status=?");
		$request->execute([$status]);
		// while($order = mysqli_fetch_object($res, "Orders", [$this->db]))
		// {
		// 	$list[] = $order;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Orders", [$this->db]);
		return $list;
	}
	public function findCartByUser(User $user)
	{
		// $id_users = intval($user->getId());
		// $res = mysqli_query($this->db, "SELECT * FROM orders WHERE id_users='".$id_users."' AND status='panier' ORDER BY date LIMIT 1");
		$request = $this->db->prepare("SELECT * FROM orders WHERE id_users=? AND status='panier' ORDER BY date LIMIT 1");
		$request->execute([$user->getId()]);
		// $cart = mysqli_fetch_object($res, "Orders", [$this->db]);
		$cart = $request->fetchObject("Orders", [$this->db]);
		return $cart;
	}
	// UPDATE
	public function save(Orders $orders)
	{
		$id = intval($orders->getId());
		$products = $orders->getProducts();
		$productManager = new ProductsManager($this->db);
		$old_list = $productManager->findNbrByOrder($orders);
		foreach ($old_list AS $product)
		{
			$product->setQuantity($product->getQuantity() + $product->nbr);
			$productManager->save($product);
		}
		// mysqli_query($this->db, "DELETE FROM link_orders_products WHERE id_orders='".$id."'");
		$request = $this->db->prepare("DELETE FROM link_orders_products WHERE id_orders=?");
		$request->execute([$id]);
		$request = $this->db->prepare("INSERT INTO link_orders_products (id_orders, id_products) VALUES(?, ?)");
		$count = 0;
		while ($count < count($products))
		{
			$product = $products[$count];
			// mysqli_query($this->db, "INSERT INTO link_orders_products (id_orders, id_products) VALUES('".$id."', '".$product->getId()."')");
			$request->execute([$id, $product->getId()]);
			$product->setQuantity($product->getQuantity() - 1);
			$productManager->save($product);
			$count++;
		}
		// $id_users = intval($orders->getUser()->getId());
		// $status = mysqli_real_escape_string($this->db, $orders->getStatus());
		// $price = floatval($orders->getPrice());
		// $date = mysqli_real_escape_string($this->db, $orders->getDate());
		// mysqli_query($this->db, "UPDATE orders SET id_users='".$id_users."', status='".$status."', price='".$price."', date='".$date."' WHERE id='".$id."'");
		$request = $this->db->prepare("UPDATE orders SET id_users=?, status=?, price=?, date=? WHERE id=?");
		$request->execute([$orders->getUser()->getId(), $orders->getStatus(), $orders->getPrice(), $orders->getDate(), $id]);
		return $this->findById($id);
	}
	// DELETE
	public function remove(Orders $orders)
	{
		// $id = intval($orders->getId());
		// mysqli_query($this->db, "DELETE from orders WHERE id='".$id."' LIMIT 1");
		$request = $this->db->prepare("DELETE from orders WHERE id=? LIMIT 1");
		$request->execute([$orders->getId()]);
		return $orders;	
	}
	// INSERT
	public function create(User $user)
	{
		$errors = [];
		$orders = new Orders($this->db);
		$error = $orders->setUser($user);
		if ($error)
			$errors[] = $error;
		if (count($errors) != 0)
			throw new Exceptions($errors);
		// $id_users = intval($orders->getUser()->getId());
		// $res = mysqli_query($this->db, "INSERT INTO orders (id_users) VALUES('".$id_users."')");
		$request = $this->db->prepare("INSERT INTO orders (id_users) VALUES(?)");
		$res = $request->execute([$orders->getUser()->getId()]);
		if (!$res)
			throw new Exceptions(["Erreur interne"]);
		// $id = mysqli_insert_id($this->db);
		$id = $this->db->lastInsertId();
		return $this->findById($id);
	}
}

?>
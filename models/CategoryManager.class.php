<?php
class CategoryManager
{
	private $db;
	public function __construct($db)
	{
		$this->db = $db;
	}

	public function search($search)
	{
		// $list = [];
		// $recherche = mysqli_real_escape_string($this->db, $search);
		// $res = mysqli_query($this->db, "SELECT * FROM categories WHERE name LIKE '%".$recherche."%' OR description LIKE '%".$recherche."%'");
		$request = $this->db->prepare("SELECT * FROM categories WHERE name LIKE ? OR description LIKE ?");
		$request->execute(['%'.$search.'%', '%'.$search.'%']);
		// while($category = mysqli_fetch_object($res, "Category", [$this->db]))
		// {
		// 	$list[] = $category;
		// }
		// return $list;
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Category", [$this->db]);
		return $list;
	}
	// SELECT
	public function findAll()
	{
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT * FROM categories ORDER BY id");
		$res = $this->db->query("SELECT * FROM categories ORDER BY id");
		// while ($category = mysqli_fetch_object($res, "Category",[$this->db])) // $article = new article();
		// {
		// 	$list[] = $category;
		// }
		$list = $res->fetchAll(PDO::FETCH_CLASS, "Category", [$this->db]);
		return $list;
	}
	public function findById($id)
	{
		// $id = intval($id);
		// $res = mysqli_query($this->db, "SELECT * FROM categories WHERE id='".$id."' LIMIT 1");
		// $category = mysqli_fetch_object($res, "Category",[$this->db]); // $article = new article();
		$request = $this->db->prepare("SELECT * FROM categories WHERE id=? LIMIT 1");
		$request->execute([$id]);
		$category = $request->fetchObject("Category",[$this->db]);
		return $category;
	}
	// UPDATE
	public function save(Category $category)
	{
		// $id = intval($article->getId());
		// $name = mysqli_real_escape_string($this->db, $category->getName());
		// $description = mysqli_real_escape_string($this->db, $category->getDescription());
		// $res = mysqli_query($this->db, "UPDATE categories SET name='".$name."', description='".$description."' WHERE id='".$id."' LIMIT 1");
		$request = $this->db->prepare("UPDATE categories SET name=?, description=? WHERE id=? LIMIT 1");
		$res = $request->execute([$category->getName(), $category->getDescription(), $category->getId()]);
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		// return $this->findById($id);
		return $this->findById($category->getId());
	}
	// DELETE
	public function remove(Category $category)
	{
		// $id = intval($article->getId());
		// $res = mysqli_query($this->db, "DELETE from categories WHERE id='".$id."' LIMIT 1");
		$request = $this->db->prepare("DELETE from categories WHERE id=? LIMIT 1");
		$request->execute([$category->getId()]);
		return $category;
	}
	// INSERT
	public function create($name,$description)
	{
		$errors = [];
		$category = new Category($this->db);
		$error = $category->setName($name);
		if ($error)
			$errors[] = $error;
		$error = $category->setDescription($description);
		if ($error)
			$errors[] = $error;
		if (count($errors) != 0)
			throw new Exceptions($errors);
		// $name = mysqli_real_escape_string($this->db, $category->getName());
		// $description = mysqli_real_escape_string($this->db, $category->getDescription());
		// $res = mysqli_query($this->db, "INSERT INTO categories (name,description) VALUES('".$name."','".$description."')");
		$request = $this->db->prepare("INSERT INTO categories (name,description) VALUES(?, ?)");
		$res = $request->execute([$category->getName(), $category->getDescription()]);
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		// $id = mysqli_insert_id($this->db);
		$id = $this->db->lastInsertId();
		return $this->findById($id);
	}
}
?>
<?php 
class CommentManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function findByProducts(Products $product)
	{
		// $id_product = intval($product->getId());
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT * FROM comments WHERE id_product='".$id_product."' ORDER BY date DESC");
		$request = $this->db->prepare("SELECT * FROM comments WHERE id_product=? ORDER BY date DESC");
		$request->execute([$product->getId()]);
		// while ($comment = mysqli_fetch_object($res, "Comment", [$this->db]))
		// {
		// 	$list[] = $comment;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Comment", [$this->db]);
		return $list;
	}
	public function findById($id) //function obligatoire findBy()
	{
		// $id=intval($id); // /!\ hyper important pour la sécurité, ne pas l'oublier /!\
		// $res = mysqli_query($this->db, "SELECT * FROM comments WHERE id='".$id."' LIMIT 1");
		$request = $this->db->prepare("SELECT * FROM comments WHERE id=? LIMIT 1");
		$request->execute([$id]);
		// $comment = mysqli_fetch_object($res, "Comment", [$this->db]); // $comment = new Comment();
		$comment = $request->fetchObject("Comment", [$this->db]);
		return $comment;
	}
	// UPDATE
	public function save(Comment $comment) //type hinting:pour forcer la class Comment, avec la propriété $comment
	{
		// $id = intval($comment->getId());
		// $content = mysqli_real_escape_string($this->db, $comment->getContent());
		// $id_author = intval($comment->getAuthor()->getId());
		// $id_product = intval($comment->getProduct()->getId());
		// $res = mysqli_query($this->db, "UPDATE comments SET content='".$content."', id_author='".$id_author."', id_product='".$id_product."' WHERE id='".$id."' LIMIT 1");
		$request = $this->db->prepare("UPDATE comments SET content=?, id_author=?, id_product=? WHERE id=? LIMIT 1");
		$res = $request->execute([$comment->getContent(), $comment->getAuthor()->getId(), $comment->getProduct()->getId(), $comment->getId()]);
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		// return $this->findById($id);
		return $this->findById($comment->getId());
	}
	// DELETE
	public function remove(Comment $comment)
	{
		// $id = intval($comment->getId());
		// $res = mysqli_query($this->db, "DELETE from comments WHERE id='".$id."' LIMIT 1");
		$request = $this->db->prepare("DELETE from comments WHERE id=? LIMIT 1");
		$request->execute([$comments->getId()]);
		return $comment;
	}
	// INSERT INTO    dans le même ordre que dans traitementComments.php:$_POST['content'], $_POST['id_article'], $_SESSION['id']
	public function create($content, User $author, Products $product)
	{
		$errors = [];
		$comment = new Comment($this->db);
		$error = $comment->setContent($content);
		if($error)
			$errors[] = $error;
		$error = $comment->setAuthor($author);
		if($error)
			$errors[] = $error;
		$error = $comment->setProduct($product); //return
		if($error)
			$errors[] = $error;
		if(count($errors) != 0)
			throw new Exceptions($errors);
		// $content = mysqli_real_escape_string($this->db, $content);
		// $id_author = intval($comment->getAuthor()->getId());
		// $id_product = intval($comment->getProduct()->getId());
		// $res = mysqli_query($this->db, "INSERT INTO comments (content, id_author, id_product) VALUES('".$content."', '".$id_author."', '".$id_product."')");
		$request = $this->db->prepare("INSERT INTO  comments (content, id_author, id_product) VALUES(?, ?, ?)");
		$res = $request->execute([$comment->getContent(), $comment->getAuthor()->getId(), $comment->getProduct()->getId()]);
		if (!$res)
			throw new Exceptions(["Erreur interne"]);
		// $id = mysqli_insert_id($this->db);
		$id = $this->db->lastInsertId();
		return $this->findById($id);
	}
}
 ?>
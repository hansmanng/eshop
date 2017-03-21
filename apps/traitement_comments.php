<?php

if(isset($_POST["id_product"], $_POST["content"], $_POST["rate"], $_SESSION['id']))
{
	// Etape 2
	$userManager = new UserManager($db);
	$productManager = new ProductsManager($db);
	$author = $userManager->findById($_SESSION['id']);
	$product = $productManager->findById($_POST["id_product"]);
	$rate = intval($_POST['rate']);
	$manager = new CommentManager($db);
	try
	{	
		$comment = $manager->create($_POST['content'], $author, $product, $rate);
		if ($comment)
		{
			// Etape 4
			header('Location: index.php?page=product&id='.$comment->getProduct()->getId());
			exit;
		}
		else
		{
			$errors[] = "Erreur interne";
		}
	}
	catch (Exceptions $e)// ExceptionS
	{
		$errors = $e->getErrors();// ->getMessage() => ->getErrors()
	}
}
?>
<?php
if (isset($_POST["action"]))
{
	$action = $_POST["action"];
	if ($action == "create_product")
	{
		if(isset($_POST['id_category'], $_POST['name'], $_POST['picture'], $_POST['description'], $_POST['price'], $_POST['quantity'],$_SESSION['id']))
		{
			$manager = new ProductsManager($db);
			$categoryManager = new CategoryManager($db);
			$category = $categoryManager->findById($_POST['id_category']);
			

		try 
			{
				$products = $manager->create($category, $_POST['name'], $_POST['picture'], $_POST['description'], $_POST['price'], $_POST['quantity']);
				if ($products)
				{
					header('Location: index.php?page=product&id='.$products->getId());
					exit;
				}
				else
				{
					$errors[] = "Erreur interne";
				}
		   }
		   catch (Exception $e)
		   {
		   		$errors = $e->getErrors();
		   }
		}
	}
}
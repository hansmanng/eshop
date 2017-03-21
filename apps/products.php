<?php
if (isset($_GET['id_category']))
{
	$categoryManager = new CategoryManager($db);
	$category = $categoryManager->findById($_GET['id_category']);
	if ($category)
	{
		require('views/products.phtml');
	}
	else
	{
		$errors[] = "Ce produit n'existe pas";
		require('views/errors.phtml');
	}
}
else
{
	echo "erreur";
}
?>

<?php 
if (isset($_SESSION['id']))
{
	$userManager = new UserManager($db);
	$user = $userManager->findById($_SESSION['id']);
	$cart = $user->getCart();
	if ($cart) 
	{
		require("views/cart.phtml");
	}
	else
	{
		$errors[] = "Vous n'avez pas encore de panier en cours";
		require('views/errors.phtml');
	}
}
else
{
	$errors[] = "Vous devez être connecté pour afficher le panier";
	require('views/errors.phtml');
}
?>
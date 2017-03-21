<?php
if (isset($_SESSION['id']))
{
	$userManager = new UserManager($db);
	$user = $userManager->findById($_SESSION['id']);
	$manager = new OrdersManager($db);
	$list = $manager->findByUsers($user);
	if (count($list)==0) 
	{
		echo "Vous n'avez pas encore passer de commandes";
	}
	require("views/orders.phtml");
}
else {
	echo "Vous devez être connecté pour afficher l'historique des commandes";
}

?>
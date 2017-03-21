<?php

// if(isset($_SESSION['id']))
	$manager = new ProductsManager($db);
	// $userManager = new UserManager($db);
	// $user = $userManager->findById($_SESSION['id']);
	// $cart = $user->getCart();
	$list = $manager->findByCategory($category);

	$count = 0;
	while ($count < count($list))// list.length
	{
		$product = $list[$count];
		require ('views/product_elem.phtml');
		$count++;
	}

	 if(isset($_SESSION['id']))
	 {
	 	$userManager = new UserManager($db);
		$user = $userManager->findById($_SESSION['id']);
		$cart = $user->getCart();
	 }
// }

// else {
// 	$errors[] = "Vous n'avez pas encore de panier en cours";
// 	require('views/errors.phtml');
// }
?>
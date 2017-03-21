<?php
if (isset($_SESSION['id']))
{
	$manager = new UserManager($db);
	$user = $manager->findById($_SESSION['id']);
	if ($user)
	{
		require("views/user.phtml");
	}
	else
	{
		$errors[] = "Utilisateur invalide";
		require('views/errors.phtml');
	}
}
else
{
	$errors[] = "Erreur: il faut être connecté pour accéder à cette page.";
	require('views/errors.phtml');
}
?>
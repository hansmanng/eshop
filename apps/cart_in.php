<?php
if (isset($_SESSION['id']))
{
	require ('views/cart_in.phtml');
}
else
{
	$message = "ajouter un produit a votre panier";
	require('views/must_login.phtml');
}
?>
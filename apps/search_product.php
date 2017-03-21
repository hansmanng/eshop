<?php
$productManager = new ProductsManager($db);
$products = $productManager->search($_GET['search']);
// liste de product => products
foreach ($products AS $index => $product)
{
	require ("views/search_product.phtml");
}
?>
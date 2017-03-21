<?php
$categoryManager = new CategoryManager($db);
$categories = $categoryManager->search($_GET['search']);
// liste de category => categories
foreach ($categories AS $index => $category)
{
	require ("views/search_category.phtml");
}
?>
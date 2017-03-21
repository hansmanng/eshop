<?php
$page_cat = '';
$page_nllecat = '';
$page_nvprod = '';
$page_profile = '';
$page_logout = '';
$page_login = '';
$page_register = '';

if ($page == 'categories')
{
	$page_cat = "active";

}
if ($page == 'create_category')
{
	$page_nllecat = "active";

}
if ($page == 'create_product')
{
	$page_nvprod = "active";

}
if ($page == 'user')
{
	$page_profile = "active";

}
if ($page == 'logout')
{
	$page_logout = "";

}
if ($page == 'login')
{
	$page_login = "active";

}
if ($page == 'register')
{
	$page_register = "active";

}
$recherche = "";
if (isset($_GET['search']))
{
	$recherche = $_GET['search'];
}

if (isset($_SESSION['id']))
{
	if (isset($_SESSION['admin']) && $_SESSION['admin'] == true)
	{
		require('views/header_admin.phtml');
	}
	else
	{
		require('views/header_in.phtml');
	}
}
else
{
	require('views/header.phtml');
}
?>
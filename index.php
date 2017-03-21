<?php
// http://192.168.1.95/partage/index.php?page=search_category&search=chat&ajax
// http://192.168.1.95/partage/index.php?page=search_product&search=chat&ajax
$errors = [];
$page = "categories";
// Live test : http://192.168.1.95/partage
// $db = mysqli_connect("192.168.1.57","animaniax","animaniax","animaniax");
$db = new PDO('mysql:dbname=animaniax;host=192.168.1.57', "animaniax", "animaniax");
session_start();
$access = ["errors", "login", "register", "categories", "create_category", "cart", "orders", "user",
			"create_product", "contact", "search", "search_product", "search_category", "products","product"];
if (isset($_GET['page']) && in_array($_GET['page'], $access))
{
    $page = $_GET['page'];
}
function __autoload($classname)// http://php.net/manual/fr/function.autoload.php
{
	require('models/'.$classname.'.class.php');
}
$access_traitement = ["logout"=>"users", "login"=>"users", "register"=>"users", "create_category"=>"category", "cart"=>"orders",
						"user"=>"users", "create_product"=>"Products", "product"=>"orders", "comments"=>"comments"]; // comments
if (isset($_GET['page'], $access_traitement[$_GET['page']]))
{
	$traitement = $access_traitement[$_GET['page']];
	require('apps/traitement_'.$traitement.'.php');
}
if (isset($_GET['ajax']))
	require('apps/'.$page.'.php');
else
	require('apps/skel.php');
?>
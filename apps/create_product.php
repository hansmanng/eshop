<?php
$manager = new CategoryManager($db);
$list = $manager->findAll();
require('views/create_product.phtml');
?>
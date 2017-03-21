<?php
$list = $cart->getProductNbr();
$count = 0;
while ($count < count($list))// list.length
{
	$product = $list[$count];
	require ('views/cart_elem.phtml');
	$count++;
}

?>
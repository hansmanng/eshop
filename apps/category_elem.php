<?php

$count = 0;
while ($count < count($list))// list.length
{
	$category = $list[$count];
	require('views/category_elem.phtml');
	$count++;
}
?>
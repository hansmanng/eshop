<?php

if (isset($_GET['id']))
	$manager = new CommentManager($db);
	$managerProducts = new ProductsManager($db);
	$comment = $managerProducts ->findById($_GET['id']);
	$list = $manager->findByProducts($comment);

	$count = 0;
	while ($count < count($list))// list.length
	{
		$comment = $list[$count];
		require('views/comment.phtml');
		$count++;
	}
?>
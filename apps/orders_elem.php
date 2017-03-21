<?php
	$count = 0;
	while ($count < count($list))
	{
		$orders = $list[$count];
		require("views/orders_elem.phtml");
		$count++;
	}
?>
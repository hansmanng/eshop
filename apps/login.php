<?php
$ref = '';
if (isset($_SERVER['HTTP_REFERER']))
{
	$ref = '<input type="hidden" name="ref" value="'.$_SERVER['HTTP_REFERER'].'">';
}
require('views/login.phtml');
?>
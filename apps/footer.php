<?php
if (isset($_SESSION['id']))
{
	require('views/footer_in.phtml');
}
else
{
	require('views/footer.phtml');
}
?>
$(document).ready(function()// pour charger du JS "convenablement", le fichier est bien dans la balise head MAIS
{// il faut absolument mettre un code équivalent, dans tous les cas, l'événement à surveiller s'appelle DOMContentLoaded
	$(".navbar-toggle").click(function ()
	{
		$(this).toggleClass("active");
	});
	if ($('#search_product').length == 1 && $('#search_category').length == 1)
	{
		var def = $('#search_input').val();
		$('#search_input').val('');
		$('#search_input').focus();
		$('#search_input').val(def);
		$('#search_input').keyup(function()
		{
			var val = encodeURIComponent($(this).val());
			history.pushState({}, "Recherche "+val, "index.php?page=search&search="+val);
			/*
				var req = new XMLHttpRequest();
				req.open('GET', "index.php?page=search_product&ajax&search="+val, true);
				req.onreadystatechange = function (aEvt)
				{
				  if (req.readyState == 4)
				  {
				     if(req.status == 200)
				      $('#search_category').html(req.responseText);
				     else
				      alert("Erreur pendant le chargement de la page.\n");
				  }
				};
				req.send(null);
			*/
			// XMLHttpRequest -> permet les requêtes AJAX
			$('#search_product').load("index.php?page=search_product&ajax&search="+val);
			// $('#search_category').load("index.php?page=search_category&ajax&search="+val);
			$.get("index.php?page=search_category&ajax&search="+val, function(data)
			{
				alert(data);
				$('#search_category').html(data);
			});
		});
	}
	else
	{
		$('#search_input').keyup(function()
		{
			$(this).parents('form').submit();
		});
	}
});
<?php
//var_dump($_POST);

if (isset($_POST["action"]))
{
	$action = $_POST["action"];
	if ($action == "create_category")
	{
		if (isset($_POST['name'], $_POST['description']))
		{
			// Etape 2
			$manager = new CategoryManager($db);
			try
			{
				// Etape 3
				//           public function create($content, $id_author, $id_article) -> CommentManager.class.php ligne 59
				$category = $manager->create($_POST['name'],$_POST['description']);
				if ($category)
				{
					// Etape 4
					header('Location: index.php?page=categories');
					exit;
				}
				else
				{
					$errors[] = "Erreur interne";
				}
			}
			catch (Exceptions $e)
			{
				$errors = $e->getErrors();
			}
		}
	}
}
?>
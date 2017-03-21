<?php
if (isset($_GET["page"]) && $_GET["page"] == "logout")
{
	session_destroy();
	header("Location: index.php");
	exit;
}
if (isset($_POST["action"]))
{
	$action = $_POST["action"];
	if ($action == "register")
	{
		if(isset($_POST["email"], $_POST["password1"], $_POST["password2"], $_POST["name"], $_POST["address"], $_POST["city"], $_POST["birthdate"])) 
		{
			$manager = new UserManager($db);
			try
			{
				$user = $manager->create($_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['name'], $_POST["address"], $_POST["city"], $_POST['birthdate']);
				if ($user)
				{
					header('Location: index.php?page=login');
					exit;
				}
				else
				{
					$user1 = $manager->findByEmail($_POST['email']);
					$user2 = $manager->findByName($_POST['name']);
					if ($user1)
					{
						$errors[] = "Email deja existant";
					}
					else if ($user2)
					{
						$errors[] = "Nom deja existant";
					}
					else
					{
						$errors[] = "Erreur interne";
					}
				}
			}
			catch (Exceptions $e)
			{
				$errors = $e->getErrors();
			}
		}
	}
	else if ($action == "login")
	{
		if (isset($_POST["email"], $_POST["password"]))
		{
			$manager = new UserManager($db);
			try
			{
				$user = $manager->findByEmail($_POST['email']);
				if ($user)
				{
					if ($user->verifPassword($_POST['password']))
					{
						$_SESSION['id'] = $user->getId();
						$_SESSION['email'] = $user->getEmail();
						$_SESSION['admin'] = $user->isAdmin();
						if (isset($_POST['ref']))
							header('Location: '.$_POST['ref']);
						else
							header('Location: index.php?page=categories');
						exit;
					}
					else
					{
						$errors[] = "Mot de passe incorrect";
					}
				}
				else
				{
					$errors[] = "Email inconnu";
				}
			}
			catch (Exceptions $e)
			{
				$errors = $e->getErrors();
			}
		}
	}
	else if ($action == "update")
	{
		if (isset($_SESSION['id'], $_POST["email"], $_POST["password"], $_POST["name"], $_POST["address"], $_POST["city"], $_POST["old_password"]))
		{
			$manager = new UserManager($db);
			try
			{
				$user = $manager->findById($_SESSION['id']);
				if ($user)
				{
					if ($user->verifPassword($_POST['old_password']))
					{
						if (($error = $user->setEmail($_POST['email'])))
							$errors[] = $error;
						if (($error = $user->updatePassword($_POST['password'], $_POST['old_password'])))
							$errors[] = $error;
						if (($error = $user->setName($_POST['name'])))
							$errors[] = $error;
						if (($error = $user->setAddress($_POST['address'])))
							$errors[] = $error;
						if (($error = $user->setCity($_POST['city'])))
							$errors[] = $error;
						if (count($errors) == 0)
						{
							$manager->save($user);
							$_SESSION['email'] = $user->getEmail();
							header('Location: index.php?page=user');
							exit;
						}
					}
					else
					{
						$errors[] = "Mot de passe incorrect";
					}
				}
				else
				{
					$errors[] = "Utilisateur inconnu";
				}
			}
			catch (Exceptions $e)
			{
				$errors = $e->getErrors();
			}
		}
	}
}
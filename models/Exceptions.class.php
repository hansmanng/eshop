<?php
class Exceptions extends Exception
{
	private $errors;

	public function __construct($errors)
	{
		parent::__construct(implode(" - ", $errors));
		$this->errors = $errors;
	}
	public function getErrors()
	{
		return $this->errors;
	}
}
?>
<?php

declare(strict_types=1);

class HomeController
{
	public function index(): void
	{
		require_once('Views/Home/Home.php');
	}
}

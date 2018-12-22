<?php

namespace App;

class SimplePagination 
{
	public static function currentPage() 
	{
		$page = htmlspecialchars($_GET['page'] ?? 1);

		if ($page < 1 || $page > 46) {
			$page = 1;
		}

		return $page;
	}
}

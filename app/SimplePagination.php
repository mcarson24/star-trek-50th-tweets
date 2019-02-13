<?php

namespace App;

class SimplePagination 
{
	/**
	 * Determine the current page to display.
	 * 
	 * @return integer
	 */
	public static function currentPage() 
	{
		$page = htmlspecialchars($_GET['page'] ?? 1);

		return ($page < 1 || $page > 46) ? 1 : $page;
	}
}

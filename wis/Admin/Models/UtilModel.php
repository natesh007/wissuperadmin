<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;

class UtilModel extends Model {
	function build_pagelinks($actual_link, $previous_page, $next_page, $totalPages, $adjacents, $page, $second_last) {
		$pagelinks='<ul class="pagination"><li';

		if($page <=1) {
			$pagelinks.='  class="disabled";  ';
		}

		$pagelinks .="><a ";

		if(isset($_REQUEST['nor'])) {
			if($page > 1) {
				$pagelinks .="href='".$actual_link."page=".$previous_page."'&nor=".$_GET['nor'];
			}
		}

		else {
			if($page > 1) {
				$pagelinks .="href='".$actual_link."page=".$previous_page."'";
			}
		}


		$pagelinks .=">Previous</a></li>";

		if ($totalPages <=10) {
			for ($counter=1; $counter <=$totalPages; $counter++) {
				if ($counter==$page) {
					$pagelinks .="<li class='active'><a>$counter</a></li>";
				}

				elseif(isset($_REQUEST['nor'])) {
					$pagelinks .="<li><a href='".$actual_link."page=$counter&nor=".$_GET['nor']."'>$counter</a></li>";
				}

				else {
					$pagelinks .="<li><a href='".$actual_link."page=$counter'>$counter</a></li>";
				}
			}
		}

		elseif($totalPages > 10) {

			if($page <=4) {
				for ($counter=1; $counter < 8; $counter++) {
					if ($counter==$page) {
						$pagelinks .="<li class='active'><a>$counter</a></li>";
					}

					elseif(isset($_REQUEST['nor'])) {
						$pagelinks .="<li><a href='".$actual_link."page=$counter&nor=".$_GET['nor']."'>$counter</a></li>";
					}

					else {
						$pagelinks .="<li><a href='".$actual_link."page=$counter'>$counter</a></li>";
					}
				}

				$pagelinks .="<li><a>...</a></li>";
				$pagelinks .="<li><a href='".$actual_link."page=$second_last'>$second_last</a></li>";
				$pagelinks .="<li><a href='".$actual_link."page=$totalPages'>$totalPages</a></li>";
			}

			elseif($page > 4 && $page < $totalPages - 4) {
				$pagelinks .="<li><a href='".$actual_link."page=1'>1</a></li>";
				$pagelinks .="<li><a href='".$actual_link."page=2'>2</a></li>";
				$pagelinks .="<li><a>...</a></li>";

				for ($counter=$page - $adjacents; $counter <=$page + $adjacents; $counter++) {
					if ($counter==$page) {
						$pagelinks .="<li class='active'><a>$counter</a></li>";
					}

					elseif(isset($_REQUEST['nor'])) {
						$pagelinks .="<li><a href='".$actual_link."page=$counter&nor=".$_GET['nor']."'>$counter</a></li>";
					}

					else {
						$pagelinks .="<li><a href='".$actual_link."page=$counter'>$counter</a></li>";
					}
				}

				$pagelinks .="<li><a>...</a></li>";
				$pagelinks .="<li><a href='".$actual_link."page=$second_last'>$second_last</a></li>";
				$pagelinks .="<li><a href='".$actual_link."page=$totalPages'>$totalPages</a></li>";
			}

			else {
				$pagelinks .="<li><a href='".$actual_link."page=1'>1</a></li>";
				$pagelinks .="<li><a href='".$actual_link."page=2'>2</a></li>";
				$pagelinks .="<li><a>...</a></li>";

				for ($counter=$totalPages - 6; $counter <=$totalPages; $counter++) {
					if ($counter==$page) {
						$pagelinks .="<li class='active'><a>$counter</a></li>";
					}

					elseif(isset($_REQUEST['nor'])) {
						$pagelinks .="<li><a href='".$actual_link."page=$counter&nor=".$_GET['nor']."'>$counter</a></li>";
					}

					else {
						$pagelinks .="<li><a href='".$actual_link."page=$counter'>$counter</a></li>";
					}
				}
			}
		}

		$pagelinks .="<li";

		if($page >=$totalPages) {
			$pagelinks .="class='disabled'";
		}

		$pagelinks .="><a";

		if($page < $totalPages) {
			if(isset($_REQUEST['nor'])) {
				$pagelinks .=" href='".$actual_link."page=".$next_page."'&nor=".$_GET['nor'];
			}

			else {
				$pagelinks .=" href='".$actual_link."page=$next_page'";
			}
		}

		$pagelinks .=">Next</a></li>";


		if($page < $totalPages && isset($_REQUEST['nor'])) {
			$pagelinks .="<li><a href='".$actual_link."page=$totalPages&nor=".$_GET['nor']."'>Last &rsaquo;&rsaquo;</a></li>";
		}

		elseif($page < $totalPages) {
			$pagelinks .="<li><a href='".$actual_link."page=$totalPages'>Last &rsaquo;&rsaquo;</a></li>";
		}

		$pagelinks .="</ul>";

		return $pagelinks;

	}
}
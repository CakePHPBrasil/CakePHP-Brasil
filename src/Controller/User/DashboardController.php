<?php
namespace App\Controller\User;
use App\Controller\AppController;
/**
 * Likes Controller
 *
 * @property App\Model\Table\LikesTable $Likes
 */
class DashboardController extends AppController {
	public function home() {
		echo 'Dashboard';
		die();
	}
}
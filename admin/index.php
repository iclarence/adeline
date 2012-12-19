<?php
require_once '../config.php';
$page = isset($request['page']) ? $request['page'] : 'AdminHomepage';
$pageController = new $page;
$pageController->run($request, $session);
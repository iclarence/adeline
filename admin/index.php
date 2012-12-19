<?php
require_once '../config.php';
$page = isset($request['page']) ? $request['page'] : 'AdminHomepage';
$action = isset($request['action']) ? $request['action'] : 'run';
$pageController = new $page;
$pageController->$action($request, $session);
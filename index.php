<?php
require_once 'config.php';
$page = isset($request['page']) ? $request['page'] : 'Homepage';
$pageController = new $page;
$pageController->run($request, $session);
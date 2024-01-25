<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::post('login', 'SecurityController');
Routing::post('register', 'SecurityController');
Routing::get('logout', 'SecurityController');
Routing::get('search', 'DefaultController');
Routing::get('main', 'PostController');
Routing::post('addPost', 'PostController');
Routing::get('group', 'GroupController');
Routing::get('user', 'UserController');
Routing::get('search', 'SearchController');
Routing::get('addComment', 'CommentController');
Routing::get('likeComment', 'CommentController');
Routing::get('reportComment', 'CommentController');
Routing::get('likePost', 'PostController');
Routing::get('reportPost', 'PostController');

Routing::run($path);
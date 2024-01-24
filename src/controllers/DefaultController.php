<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index()
    {
        if (!isset($_SESSION['user_ID'])) {
            header('Location: /login');
            exit();
        }
        $this->render('main');
    }
}
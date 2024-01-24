<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/userProfile.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class UserController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function user()
    {
        if ($this->isGet()) {
            $user_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
            
            $user_profile = $this->userRepository->getUserProfile($user_id);
            return $this->render('user', ['user_profile' => $user_profile]);
        }
    }

}
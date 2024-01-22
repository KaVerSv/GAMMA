<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/PostRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/GroupRepository.php';

class SearchController extends AppController
{
    private $postRepository;
    private $userRepository;
    private $groupRepository;

    public function __construct()
    {
        parent::__construct();
        $this->postRepository = new PostRepository();
        $this->groupRepository = new GroupRepository();
        $this->userRepository = new UserRepository();
    }

    public function search()
    {
        if ($this->isGet()) {
            $search = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);

            $found_posts = $this->postRepository->search($search);
            $found_groups = $this->groupRepository->search($search);
            $found_users = $this->userRepository->search($search);
            return $this->render('search', ['found_posts' => $found_posts, 'found_groups' => $found_groups, 'found_users' => $found_users]);
        }
    }
}
<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Group.php';
require_once __DIR__ . '/../repository/GroupRepository.php';

class GroupController extends AppController
{
    private $groupRepository;

    public function __construct()
    {
        parent::__construct();
        $this->groupRepository = new GroupRepository();
    }

    public function group()
    {
        if ($this->isGet()) {
            $group_id = filter_input(INPUT_GET, 'group_id', FILTER_VALIDATE_INT);

            $group_profile = $this->groupRepository->getGroupProfil($group_id);
            return $this->render('group', ['group_profile' => $group_profile]);
        }
    }

}
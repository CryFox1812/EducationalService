<?php
require_once 'GroupServiceInterface.php';

class GroupService implements GroupServiceInterface
{
    private $repo;
    public function __construct(GroupRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function get_group_list()
    {
        $groups = $this->repo->get_groups();
        echo json_encode($groups);
    }
}

?>
<?php

interface GroupRepositoryInterface
{
    public function get_groups();

    public function get_professor_by_group($group_id, $date);
}

?>
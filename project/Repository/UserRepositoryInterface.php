<?php

interface UserRepositoryInterface
{
    public function get_role($token);

    public function get_authenticated_user($username, $password);

    public function set_token($token, $user_id);

    public function add_user($username, $password, $role);

    public function update_user($user_id, $username, $password, $role);

    public function delete_user($user_id);

    public function check_token_validity($token); 
    
    public function check_token_time($token);

    public function get_user_by_token($token);  

    public function get_student_by_user($user_id);

    public function get_group_by_user($user_id);
}

?>
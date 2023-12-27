<?php

interface UserServiceInterface
{
    public function authentification($data);
    
    public function get_role($token);

    public function add_user($data);

    public function update_user($data);

    public function delete_user($data);

    public function check_token($token);
}

?>
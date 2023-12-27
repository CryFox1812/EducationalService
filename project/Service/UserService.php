<?php
require_once 'UserServiceInterface.php';

class UserService implements UserServiceInterface
{
    private $repo;
    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function authentification($data)
    {
        // Проверка наличия обязательных данных
        if (!isset($data->username) || !isset($data->password)) 
        {
            echo json_encode(array("message" => "Invalid request. Username and password are required."));
            exit();
        }

        $authenticated_user = $this->repo->get_authenticated_user($data->username, $data->password);

        if ($authenticated_user) 
        {
            // Генерация и возврат JWT токена
            $jwt_token = JWTHandler::generateToken(array("role" => $authenticated_user['role']));

            $this->repo->set_token($jwt_token, $authenticated_user['user_id']);

            echo json_encode(array("token" => $jwt_token));
        } 
        else 
        {
            echo json_encode(array("message" => "Authentication failed"));
            exit();
        }
    }

    public function get_role($token)
    {
        return $this->repo->get_role($token);
    }

    public function add_user($data)
    {
        $this->repo->add_user($data->username, $data->password, $data->role);
    }

    public function update_user($data)
    {
        $this->repo->update_user($data->user_id, $data->username, $data->password, $data->role);
    }

    public function delete_user($data)
    {
        $this->repo->delete_user($data->user_id);
    }

    public function check_token($token)
    {
        return $this->repo->check_token_validity($token);
    }
}

?>
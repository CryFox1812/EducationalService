<?php
require_once '../includes/db.php';
require_once 'UserRepositoryInterface.php';

class UserRepository implements UserRepositoryInterface
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function get_role($token) {
        $stmt = $this->conn->prepare("SELECT user_role FROM users WHERE token = ?");
        $stmt->bind_param('s', $token);
        $stmt->execute();
        
        $role = null;
        $stmt->bind_result($role);
        $stmt->fetch();

        $stmt->close();
        return $role;
    }

    public function get_authenticated_user($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param('ss', $username, $password);
        if (!$stmt->execute()) {
            echo json_encode(array("message" => "First request crash!"));
            exit();
        }

        $result = $stmt->get_result();
        $authenticated_user = $result->fetch_assoc();

        $stmt->close();
        return $authenticated_user;
    }

    public function set_token($token, $user_id)
    {
        $stmt = $this->conn->prepare("UPDATE users SET token = ? WHERE user_id = ?");
        $stmt->bind_param('si', $token, $user_id);
        $stmt->execute();
        if (!$stmt->execute()) {
            echo json_encode(array("message" => "Second request crash!"));
        }

        $stmt->close();
    }

    public function add_user($username, $password, $role)
    {
        $sql = "INSERT INTO users (username, password, user_role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sss', $username, $password, $role);
        $stmt->execute();

        $stmt->close();
    }

    public function update_user($user_id, $username, $password, $role)
    {
        echo json_encode($user_id);
        echo json_encode($username);
        echo json_encode($password);
        echo json_encode($role);
        $sql = "UPDATE users SET username = ?, password = ?, user_role = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sssi', $username, $password, $role, $user_id);
        $stmt->execute();

        $stmt->close();
    }

    public function delete_user($user_id)
    {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        $stmt->close();
    }

    public function get_user_by_token($token)
    {
        $sql = "SELECT user_id FROM users WHERE token = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $token);
        $stmt->execute();
        
        $stmt->bind_result($user_id);
        $stmt->fetch();

        $stmt->close();
        return $user_id;
    }    
        
    public function check_token_validity($token)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE token = ?";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $token);
        $stmt->execute();
        
        $stmt->bind_result($count);
        $stmt->fetch();
        
        $stmt->close();
    
        // Если количество строк с указанным токеном больше 0, токен существует
        return $count > 0;
    }    
    
    public function check_token_time($token)
    {
        $sql = "SELECT end_time FROM users WHERE token = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $token);
        $stmt->execute();
        
        $token_end_time = null;
        $stmt->bind_result($token_end_time);
        $stmt->fetch();

        $stmt->close();
        return $token_end_time;
    }
    
    public function get_student_by_user($user_id)
    {
        $sql = "SELECT * FROM students WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $student_id = $row['student_id'];

        return $student_id;
    }

    public function get_group_by_user($user_id)
    {
        $sql = "
select group_id
  from students
 where user_id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        $group_id = null;
        $stmt->bind_result($group_id);
        $stmt->fetch();
        return $group_id;
    }
}

?>
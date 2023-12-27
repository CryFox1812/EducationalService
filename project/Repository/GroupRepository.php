<?php
require_once '../includes/db.php';
require_once 'GroupRepositoryInterface.php';

class GroupRepository implements GroupRepositoryInterface
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function get_groups()
    {
        $stmt = $this->conn->prepare("SELECT * FROM student_groups");
        $stmt->execute();

        $result = $stmt->get_result();
        $groups = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $groups;
    }

    public function get_professor_by_group($group_id, $date)
    {
        $sql = "
select professor
  from schedules
 where group_id = ?
   and date = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('is', $group_id, $date);
        $stmt->execute();

        $rofessor_id = null;
        $stmt->bind_result($rofessor_id);
        $stmt->fetch();
        return $rofessor_id;
    }
}

?>
<?php
require_once '../includes/db.php';
require_once 'ScheduleRepositoryInterface.php';

class ScheduleRepository implements ScheduleRepositoryInterface
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function get_disciplines_list($group_id)
    {
        $sql = "
select distinct discipline as name
from schedules sch
where sch.group_id = ?
        ";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("s", $group_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $disciplines = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $disciplines;
    }

    public function get_schedule_list($group_id, $discipline = null, $startDate = null, $endDate = null)
    {
        $sql = "
select sch.discipline
     , sch.date
     , sch.audience_code
  from schedules sch
 where group_id = ?
";

        if ($discipline) {
            $sql .= " AND discipline = ?";
        }
    
        if ($startDate && $endDate) {
            $sql .= " AND date BETWEEN ? AND ?";
        }

        $stmt = $this->conn->prepare($sql);
        
        if ($discipline && $startDate && $endDate) {
            $stmt->bind_param("ssss", $group_id, $discipline, $startDate, $endDate);
        }
        else if ($startDate && $endDate)
        {
            $stmt->bind_param("sss", $group_id, $startDate, $endDate);
        }
        else if ($discipline) 
        {
            $stmt->bind_param("ss", $group_id, $discipline);
        }
        else 
        {
            $stmt->bind_param("s", $group_id);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $list = [];

        while ($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
        $stmt->close();

        return $list;
    }

    public function get_schedule_code($schedule_id)
    {
        $sql = "
select secret_code
  from schedules
 where schedule_id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $schedule_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $code = $row['secret_code'];

        return $code;
    }

    public function get_schedule_by_professor($professor_id, $current_time)
    {
        $sql = "
select schedule_id 
  from schedules
 where professor = ?
   and date < ?
 order by date desc
 limit 1
        ";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ss", $professor_id, $current_time);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return null;
        }
    }

    public function get_schedule_by_group($group_id, $current_time)
    {
        $sql = "
select schedule_id 
  from schedules
 where group_id = ?
   and date < ?
 order by date desc
 limit 1
        ";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ss", $group_id, $current_time);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return null;
        }
    }
}

?>
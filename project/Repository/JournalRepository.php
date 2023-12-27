<?php
require_once '../includes/db.php';
require_once 'JournalRepositoryInterface.php';

class JournalRepository implements JournalRepositoryInterface
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function get_attendance_list($group_id, $discipline = null, $startDate = null, $endDate = null) 
    {
        $sql = "
select sch.schedule_id as schedule_id
     , sch.discipline as discipline
     , sch.date as date
     , st.student_id as student_id
     , st.first_name as first_name
     , st.last_name as last_name
     , st.patronymic as patronymic
     , jr.attendance as attendance
  from student_groups stg
  join schedules sch on sch.group_id = stg.group_id
  join journal jr on jr.schedule_id = sch.schedule_id
  join students st on st.student_id = jr.student_id
 where stg.group_id = ?
        ";

        if ($discipline) {
            $sql .= " and sch.discipline = ?";
        }
    
        if ($startDate && $endDate) {
            $sql .= " and sch.date BETWEEN ? AND ?";
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

    public function get_grades_list($group_id, $discipline = null, $startDate = null, $endDate = null) 
    {
        $sql = "
select sch.schedule_id as schedule_id
     , sch.discipline  as discipline
     , sch.date        as date
     , st.student_id   as student_id
     , st.first_name   as first_name
     , st.last_name    as last_name
     , st.patronymic   as patronymic
     , jr.grade as mark
  from student_groups stg
  join schedules sch on sch.group_id = stg.group_id
  join journal jr    on jr.schedule_id = sch.schedule_id
  join students st   on st.student_id = jr.student_id
 where stg.group_id = ?
        ";

        if ($discipline) {
            $sql .= " and sch.discipline = ?";
        }
    
        if ($startDate && $endDate) {
            $sql .= " and sch.date BETWEEN ? AND ?";
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

    public function set_grades_list($list)
    {
        $sql = "
update journal
   set grade = ?
 where schedule_id = ? 
   and student_id = ?
        ";

        $stmt = $this->conn->prepare($sql);

        foreach ($list as $item) {
            $grade = $item->grade;
            $scheduleId = $item->schedule_id;
            $studentId = $item->student_id;

            $stmt->bind_param("iii", $grade, $scheduleId, $studentId);
            $stmt->execute();
            $stmt->reset();
        }

        $stmt->close();

        return true;
    }

    public function set_attendance_list($list)
    {
        $sql = "
update journal
   set attendance = ?
 where schedule_id = ? 
   and student_id = ?
        ";

        $stmt = $this->conn->prepare($sql);

        foreach ($list as $item) {
            $attendance = $item->attendance;
            $scheduleId = $item->schedule_id;
            $studentId = $item->student_id;

            $stmt->bind_param("iii", $attendance, $scheduleId, $studentId);
            $stmt->execute();
            $stmt->reset();
        }

        $stmt->close();

        return true;
    }

    public function set_attendance($schedule_id, $student_id)
    {
        $sql = "
update journal
   set attendance = 1
 where schedule_id = ? 
   and student_id = ?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ii", $schedule_id, $student_id);
        $stmt->execute();

        $stmt->close();

        return true;
    }

    public function average_grade($student_id, $discipline)
    {
        $sql = "
select discipline, AVG(grade) AS average_grade
  from journal j
  join schedules sch on j.schedule_id = sch.schedule_id
 where 1
        ";

        if ($student_id) {
            $sql .= "   and j.student_id = ?";
        }
    
        if ($discipline) {
            $sql .= "   and sch.discipline = ?";
        }

        $sql .= " group by discipline";


        $stmt = $this->conn->prepare($sql);
        
        if ($student_id && $discipline) {
            $stmt->bind_param("ss", $student_id, $discipline);
        }
        else if ($student_id)
        {
            $stmt->bind_param("s", $student_id);
        }
        else if ($discipline) 
        {
            $stmt->bind_param("s", $discipline);
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

    public function total_attendance($student_id, $discipline)
    {
        $sql = "
select sch.discipline
     , j.student_id
     , SUM(CASE WHEN attendance = 1 THEN 1 ELSE 0 END) AS total_attendance
  from journal j
  join schedules sch on j.schedule_id = sch.schedule_id
 where 1
        ";

        if ($student_id) {
            $sql .= "   and j.student_id = ?";
        }
    
        if ($discipline) {
            $sql .= "   and sch.discipline = ?";
        }

        $sql .= " group by student_id, sch.discipline";


        $stmt = $this->conn->prepare($sql);
        
        if ($student_id && $discipline) {
            $stmt->bind_param("ss", $student_id, $discipline);
        }
        else if ($student_id)
        {
            $stmt->bind_param("s", $student_id);
        }
        else if ($discipline) 
        {
            $stmt->bind_param("s", $discipline);
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
}

?>
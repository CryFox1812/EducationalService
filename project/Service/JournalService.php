<?php
require_once 'JournalServiceInterface.php';

class JournalService implements JournalServiceInterface
{
    private $repo;
    public function __construct(JournalRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function get_grades_list($data)
    {
        $group_id = $data["group_id"];
        $discipline = isset($data["discipline"]) ? $data["discipline"] : null;
        $dateType = isset($data["date_type"]) ? $data["date_type"] : null;
        
        if ($discipline == 'all')  $discipline = null;

        $startDate = null;
        $endDate = null;

        switch ($dateType) {
            case 'today':
                $startDate = date('Y-m-d');
                $endDate = date('Y-m-d', strtotime('+1 day'));
                break;
            case 'tomorrow':
                $startDate = date('Y-m-d', strtotime('+1 day'));
                $endDate = date('Y-m-d', strtotime('+2 days'));
                break;
            case 'week':
                $startDate = date('Y-m-d');
                $endDate = date('Y-m-d', strtotime('+1 week'));
                break;
            case 'month':
                $startDate = date('Y-m-d');
                $endDate = date('Y-m-d', strtotime('+1 month'));
                break;
            case 'all':
                // Не устанавливаем даты, чтобы выбрать все расписание
                break;
            default:
                // Обработка некорректных значений $dateType
                break;
        }

        $list = $this->repo->get_grades_list($group_id, $discipline, $startDate, $endDate);
        echo json_encode(array("list" => $list));
    }

    public function get_attendance_list($data)
    {
        $group_id = $data["group_id"];
        $discipline = isset($data["discipline"]) ? $data["discipline"] : null;
        $dateType = isset($data["date_type"]) ? $data["date_type"] : null;
        
        if ($discipline == 'all')  $discipline = null;

        $startDate = null;
        $endDate = null;

        switch ($dateType) {
            case 'today':
                $startDate = date('Y-m-d');
                $endDate = date('Y-m-d', strtotime('+1 day'));
                break;
            case 'tomorrow':
                $startDate = date('Y-m-d', strtotime('+1 day'));
                $endDate = date('Y-m-d', strtotime('+2 days'));
                break;
            case 'week':
                $startDate = date('Y-m-d');
                $endDate = date('Y-m-d', strtotime('+1 week'));
                break;
            case 'month':
                $startDate = date('Y-m-d');
                $endDate = date('Y-m-d', strtotime('+1 month'));
                break;
            case 'all':
                // Не устанавливаем даты, чтобы выбрать все расписание
                break;
            default:
                // Обработка некорректных значений $dateType
                break;
        }

        $list = $this->repo->get_attendance_list($group_id, $discipline, $startDate, $endDate);
        echo json_encode(array("list" => $list));
    }

    public function set_grades_list($data)
    {
        $data = array_filter($data, function($entry) {
            return is_numeric($entry->grade);
        });
        $answer = $this->repo->set_grades_list($data);
        echo json_encode(array("answer" => $answer));
    }

    public function set_attendance_list($data)
    {
        $data = array_filter($data, function($entry) {
            return is_numeric($entry->attendance) && 
                             ($entry->attendance == "0" || $entry->attendance == "1");
        });
        $answer = $this->repo->set_attendance_list($data);
        echo json_encode(array("answer" => $answer));
    }

    public function average_grade($data)
    {
        $student_id = isset($data["student_id"]) ? $data["student_id"] : null;
        $discipline = isset($data["discipline"]) ? $data["discipline"] : null;

        $result = $this->repo->average_grade($student_id, $discipline);
        echo json_encode(array("list" => $result));
    }

    public function total_attendance($data)
    {
        $student_id = isset($data["student_id"]) ? $data["student_id"] : null;
        $discipline = isset($data["discipline"]) ? $data["discipline"] : null;

        $result = $this->repo->total_attendance($student_id, $discipline);
        echo json_encode(array("list" => $result));
    }
}

?>
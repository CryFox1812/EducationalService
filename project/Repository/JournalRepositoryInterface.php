<?php

interface JournalRepositoryInterface
{
    public function get_attendance_list($group_id, $discipline, $startDate, $endDate);

    public function get_grades_list($group_id, $discipline, $startDate, $endDate);

    public function set_grades_list($list);

    public function set_attendance_list($list);

    public function set_attendance($schedule_id, $student_id);

    public function average_grade($student_id, $discipline);

    public function total_attendance($student_id, $discipline);
}

?>
<?php
require_once 'ScheduleServiceInterface.php';

class ScheduleService implements ScheduleServiceInterface
{
    private $scheduleRepository;
    private $journalRepository;
    private $userRepository;
    public function __construct(ScheduleRepositoryInterface $scheduleRepository,
                                JournalRepositoryInterface $journalRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->journalRepository = $journalRepository;
        $this->userRepository = $userRepository;
    }

    public function get_discipline_list($token)
    {
        $user_id = $this->userRepository->get_user_by_token($token);

        if ($user_id) 
        {
            $group_id = $this->userRepository->get_group_by_user($user_id);
            $list = $this->scheduleRepository->get_disciplines_list($group_id);
            echo json_encode($list);
        }
    }

    public function get_schedule_list($data, $token)
    {
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

        $user_id = $this->userRepository->get_user_by_token($token);

        if ($user_id) 
        {
            $group_id = $this->userRepository->get_group_by_user($user_id);
            $list = $this->scheduleRepository->get_schedule_list($group_id, $discipline, $startDate, $endDate);
            echo json_encode(array("list" => $list));
        }
    }

    public function get_schedule_code($token)
    {
        $user_id = $this->userRepository->get_user_by_token($token);

        if ($user_id) 
        {
            $current_datetime  = date('Y-m-d H:i:s');
            echo json_encode($user_id);
            echo json_encode($current_datetime);
            $schedule_id = $this->scheduleRepository->get_schedule_by_professor($user_id, $current_datetime);
            echo json_encode($schedule_id);
            $code = $this->scheduleRepository->get_schedule_code($schedule_id);
            echo json_encode(array("secret_code" => $code));
        }
        else 
        {
            http_response_code(404);
            echo json_encode(array("message" => "User not found"));
        }
    }

    public function set_schedule_code($data, $token)
    {
        $user_id = $this->userRepository->get_user_by_token($token);

        if ($user_id) 
        {
            $group_id = $this->userRepository->get_group_by_user($user_id);
            
            $current_time = date('Y-m-d H:i:s');
            $schedule_id = $this->scheduleRepository->get_schedule_by_group($group_id, $current_time);
            $code = $this->scheduleRepository->get_schedule_code($schedule_id);
            if ($code == $data->code)
            {
                $student_id = $this->userRepository->get_student_by_user($user_id);
                $answer =  $this->journalRepository->set_attendance($schedule_id, $student_id);
                echo json_encode(array("answer" => $answer));
            }
            else
            {
                http_response_code(400);
                echo json_encode(array("message" => "Invalid code"));
            }
        }
    }
}

?>
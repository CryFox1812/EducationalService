<?php
require_once '../includes/config.php';
require_once '../includes/jwt.php';
require_once '../exceptions/MainExceptions.php';

require_once '../Service/GroupServiceInterface.php';
require_once '../Service/JournalServiceInterface.php';
require_once '../Service/ScheduleServiceInterface.php';
require_once '../Service/UserServiceInterface.php';

class MainController 
{
    private $groupService;
    private $journalService;
    private $scheduleService;
    private $userService;
    public function __construct(GroupServiceInterface $groupServiceInterface,
                                JournalServiceInterface $journalServiceInterface,
                                ScheduleServiceInterface $scheduleServiceInterface,
                                UserServiceInterface $userServiceInterface)
    {
        $this->groupService = $groupServiceInterface;
        $this->journalService = $journalServiceInterface;
        $this->scheduleService = $scheduleServiceInterface;
        $this->userService = $userServiceInterface;
    }

    public function handleRequest() 
    {
        try {
            $headers = getallheaders();
            if (isset($headers['Registration-Request']) && $headers['Registration-Request'] === 'true') {
                $this->authentification();
                exit();
            } else {
                $token = $this->validateToken();
            }

            //header('Content-Type: application/json');

            $role = $this->userService->get_role($token);

            $method = $_SERVER['REQUEST_METHOD'];

            $this->methodChoose($method, $token);
        } 
        catch (UnauthorizedException $e) 
        {
            //header('Location: ../home/authentification.html');
            echo json_encode(["error" => $e->getMessage()]);
            exit();
        } 
        catch (Exception $e) 
        {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

    private function authentification()
    {
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);

        if (json_last_error() !== JSON_ERROR_NONE) 
        {
            $this->respondWithMessage("Invalid JSON data", 400);
        }

        $this->userService->authentification($data);
    }


    private function validateToken() 
    {
        $headers = getallheaders();
        $token = $headers['Authorization'];

        if ((!$token) || (!$this->userService->check_token($token)))
        {
            throw new UnauthorizedException("Unauthorized");
        }

        // Декодирование токена
        // $decoded = JWTHandler::decodeToken($token);
        // Другие проверки токена...

        return $token;
    }
    private function methodChoose($method, $token)
    {
        // Определение конечной точки API
        $request_uri = explode('/', trim($_SERVER['HTTP_X_REQUEST_URI'], '/'));

        if ($request_uri[0] == 'api') 
        {
            $resource = $request_uri[1];
            switch ($method) 
            {
                case 'GET':
                    $this->handleGetRequest($resource, $token);
                    break;
    
                case 'POST':
                    $this->handlePostRequest($resource, $token);
                    break;
    
                case 'PUT':
                    $this->handlePutRequest($resource, $token);
                    break;
    
                case 'DELETE':
                    $this->handleDeleteRequest($resource, $token);
                    break;
    
                default:
                    $this->respondWithMessage("Invalid request", 400);
            }
        }
    }

    private function handleGetRequest($resource, $token)
    {
        $data = $_GET;
        switch ($resource) 
        {
            case 'groups':
                $this->groupService->get_group_list();
                break;
                
            case 'schedule_code':
                $this->scheduleService->get_schedule_code($token);
                break;

            case 'grades_list':
                $this->journalService->get_grades_list($data);
                break;
                
            case 'attendance_list':
                $this->journalService->get_attendance_list($data);
                break;
                
            case 'schedule_list':
                $this->scheduleService->get_schedule_list($data, $token);
                break;
            
            case 'disciplines':
                $this->scheduleService->get_discipline_list($token);
                break;
            
            case 'average_grade':
                $this->journalService->average_grade($data);
                break;
            
            case 'total_attendance':
                $this->journalService->total_attendance($data);
                break;

            default:
                $this->respondWithMessage("Invalid API route", 404);
        }
    }

    private function handlePostRequest($resource, $token)
    {
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);

        if (json_last_error() !== JSON_ERROR_NONE) 
        {
            $this->respondWithMessage("Invalid JSON data", 400);
        }

        switch ($resource) 
        {
            case 'grades_list':
                $this->journalService->set_grades_list($data);
                break;
                
            case 'attendance_list':
                $this->journalService->set_attendance_list($data);
                break;

            case 'schedule_code':
                $this->scheduleService->set_schedule_code($data, $token);
                break;
    
            case 'user':
                $this->userService->add_user($data);
                break;

            default:
                $this->respondWithMessage("Invalid API route", 404);
        }
    }

    private function handlePutRequest($resource, $token)
    {
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);

        if (json_last_error() !== JSON_ERROR_NONE) 
        {
            $this->respondWithMessage("Invalid JSON data", 400);
        }

        switch ($resource) 
        {
            case 'user':
                $this->userService->update_user($data);
                break;

            default:
                $this->respondWithMessage("Invalid API route", 404);
        }
    }

    private function handleDeleteRequest($resource, $token)
    {
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);

        if (json_last_error() !== JSON_ERROR_NONE) 
        {
            $this->respondWithMessage("Invalid JSON data", 400);
        }

        switch ($resource) 
        {
            case 'user':
                $this->userService->delete_user($data);
                break;

            default:
                $this->respondWithMessage("Invalid API route", 404);
        }
    }

    private function respondWithMessage($message, $status)
    {
        //http_response_code($status);
        echo json_encode(array("message" => $message));
        exit();
    }
}

?>
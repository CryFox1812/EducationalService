<?php

require_once '../Repository/GroupRepository.php';
require_once '../Repository/JournalRepository.php';
require_once '../Repository/ScheduleRepository.php';
require_once '../Repository/UserRepository.php';

require_once '../Service/GroupService.php';
require_once '../Service/JournalService.php';
require_once '../Service/ScheduleService.php';
require_once '../Service/UserService.php';

require_once '../Controller/MainController.php';

$groupRepository = new GroupRepository();
$journalRepository = new JournalRepository();
$scheduleRepository = new ScheduleRepository();
$userRepository = new UserRepository();

$groupService = new GroupService($groupRepository);
$journalService = new JournalService($journalRepository);
$scheduleService = new ScheduleService($scheduleRepository, $journalRepository, $userRepository);
$userService = new UserService($userRepository);

$controller = new MainController($groupService, $journalService, $scheduleService, $userService);

$controller->handleRequest();

?>
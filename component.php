<?
require_once "config/bootstrap.php";
$qb = $entityManager->createQueryBuilder();
$arParams = array();
$arParams['department'] = $_GET['department'];
$arParams['whomSay'] = $_GET['whom-say'];
$arParams['whoSay'] = $_GET['who-say'];
$arParams['date-thanks'] = $_GET['date-thanks'];
$arParams['send'] = $_GET['send'];
$arParams['page_size'] = 20;

$report = new \Report\Execute();
$department = new Department();

if($_GET['send'] == "Y"){
    $data = $report->run("Data", "MySql", "Thank", $entityManager, $arParams);
}

$arParams['current_page'] = $data['CUR_PAGE'];
$arDepartment = $department->getAll($entityManager->createQueryBuilder());


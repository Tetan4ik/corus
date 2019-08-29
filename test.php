<?php

require_once "config/bootstrap.php";


$qb = $entityManager->createQueryBuilder();


$qb->select('t')
    ->from('thank', 't')
    ->where('t.date = :datetime')
    ->orderBy('t.date', 'ASC');

$fromTime = new \DateTime('2019-08-28 16:17:10');
$qb->setParameter('datetime',$fromTime);

$result = $qb->getQuery()->execute();

echo "<pre>";
var_dump($result);
echo "</pre>";




















/*

$report = new \Report\Execute();

$data = $report->run("Html","MySql","Thank",$entityManager,array("interval"=>array("from"=>date("Y-m-d H:i:s")),"select"=>"userToId"));

*/
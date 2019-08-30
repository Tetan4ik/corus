<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


require_once  'vendor/autoload.php';

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array("src/"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'dbname' => 'dbName',
    'user' => 'User',
    'password' => 'Passw0rd',
    'host' => 'Host'
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);



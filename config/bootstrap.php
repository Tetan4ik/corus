<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


require_once  'vendor/autoload.php';

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array("src/"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'dbname' => 'tet',
    'user' => 'tet',
    'password' => 'TOYiPEnA',
    'host' => 'foe.su'
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);


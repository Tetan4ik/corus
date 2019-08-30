<?php

namespace Report\Connectors;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Report\IConnector;

Class MySql implements IConnector
{

    /**
     * @param $targetEntity
     * @param $entityManager EntityManager
     * @param $params
     * @return array
     */
    public function getData($targetEntity, $entityManager, $params)
    {

        $result = array();

        /**
        * @var $qb QueryBuilder
        */
        $qb = $entityManager->createQueryBuilder();

        $targetEntity = new $targetEntity;

        if (method_exists($targetEntity, "onBeforeGetData"))
            $targetEntity->onBeforeGetData($targetEntity, $qb);

        $targetEntity->setSqlFilter($params, $qb, $entityManager);

        if (method_exists($targetEntity, "onAfterGetData"))
            $result = $targetEntity->onAfterGetData($targetEntity, $qb, $params['page_size']);

        return $result;

    }



}
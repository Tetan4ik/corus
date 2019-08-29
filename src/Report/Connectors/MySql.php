<?php

namespace Report\Connectors;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Report\Filters\Filter;
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

        /**
        * @var $qb QueryBuilder
        */
        $qb = $entityManager->createQueryBuilder();

        $qb->from(strtolower($targetEntity),substr(strtolower($targetEntity),0,3));

        $filter = "\Report\Filters\\" . $targetEntity . 'Filter';

        /**
         * @var $filter Filter
         */
        $filter = new $filter;

        $targetEntity = new $targetEntity;

        $filter->setSqlFilter($params, $qb);

        if (method_exists($targetEntity, "onBeforeGetData"))
            $targetEntity->onBeforeGetData($targetEntity, $qb);

        $result = $qb->getQuery()->execute();

        if (method_exists($targetEntity, "onAfterGetData"))
            $targetEntity->onAfterGetData($targetEntity, $result);

        return $result;

    }


}
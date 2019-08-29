<?php

namespace Report\Filters;

use Doctrine\ORM\QueryBuilder;

abstract Class Filter{

    public function setSqlFilter($arParams,QueryBuilder &$qb){

        $qb->setMaxResults($arParams['count']);


    }

}
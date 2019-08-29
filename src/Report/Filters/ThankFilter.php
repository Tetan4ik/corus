<?php

namespace Report\Filters;

use Doctrine\ORM\QueryBuilder;

Class ThankFilter extends Filter {

    public function setSqlFilter($arParams,QueryBuilder &$qb){

        parent::setSqlFilter($arParams,$qb);

        if($arParams['interval']){

            if($arParams['interval']['from'])

                $qb->select('t')
                    ->from('thank','t')
                    ->where('t.id = 1"');


        }

        $qb->select($arParams['select']);

    }


}
<?php

namespace Report;

interface IConnector
{

    public function getData($targetEntity, $entityManager, $filter);

}
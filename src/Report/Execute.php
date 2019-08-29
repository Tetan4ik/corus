<?php

namespace Report;

use Doctrine\ORM\EntityManager;

Class Execute
{

    /**
     * @param $type IType
     * @param $connector IConnector
     * @param $entity
     * @param $entityManager EntityManager
     * @param $filter
     * @return mixed
     */
    public function run($type, $connector, $entity, $entityManager, $filter)
    {

        $connector = "\Report\Connectors\\".$connector;

        /**
         * @var $connector IConnector
         */
        $connector = new $connector;
        $data = $connector->getData($entity, $entityManager, $filter);


        /**
         * @var $type IType
         */
        $type = "\Report\Types\\" . $type;
        $type = new $type;

        return $type->reportData($data);

    }


}
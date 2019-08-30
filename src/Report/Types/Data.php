<?php

namespace Report\Types;

use Report\IType;

Class Data implements IType {

    public function reportData($data)
    {
       return $data;
    }


}
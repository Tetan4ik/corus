<?php

namespace Report\Types;

use Report\IType;

Class Html implements IType {

    public function reportData($data)
    {
       return $data;
    }


}
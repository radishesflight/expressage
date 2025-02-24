<?php

namespace RadishesFlight\ExpressAge;


class ExpressAgeFactory
{
    public $expressAgeInterFace;

    public function __construct(ExpressAgeInterFace $expressAgeInterFace)
    {
        $this->expressAgeInterFace = $expressAgeInterFace;
        return $this;
    }
}

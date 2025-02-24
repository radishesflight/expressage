<?php

namespace RadishesFlight\ExpressAge;

interface ExpressAgeInterFace
{
    public function takeNumber($data);
    public function signature($data);
    public function placeOrder($data);
    public function general($data);
}

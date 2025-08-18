<?php

namespace RadishesFlight\ExpressAge;

interface ExpressAgeInterFace
{
    public function signature(array $data): array;
    public function general(array $data): array;
}

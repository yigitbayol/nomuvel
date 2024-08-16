<?php

namespace Yigitbayol\Nomuvel\Services;

class Nomuvel
{
    public function __construct()
    {
        $this->emoney = new Emoney($this);
        $this->individual = new Individual($this);
    }
}

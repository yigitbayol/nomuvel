<?php

namespace Yigitbayol\Nomuvel\Services;

class Nomuvel
{
    public $emoney;
    public $individual;
    public $sharedPos;
    public function __construct()
    {
        $this->emoney = new Emoney($this);
        $this->individual = new Individual($this);
        $this->sharedPos = new SharedPos($this);
    }
}

<?php

namespace libs\DenonAvr;

require_once __DIR__ . '/../../libs/DenonAvr.php';

use \libs\DenonAvr;

class alexa_stereo
{
    protected $denon;
    protected $color;
    public $response;

    public function __construct()
    {
        $this->denon = new DenonAvr('192.168.178.42');
    }
}

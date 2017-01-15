<?php

require_once __DIR__ . '../../libs/Milight.php';

use libs\Milight;
use Skills\Skill;

class alexa_lights extends Skill
{
    protected $milight;

    public function __construct()
    {
        parent::__construct();
        $this->milight = new Milight('192.168.178.40');
    }

    public function intentToFunction(array $config, string $intentName)
    {
        echo $config['intents'][$intentName][0];
    }

}

$a = new alexa_lights();

$a->LightsOnIntent(4);

$a->LightsPartyIntent();

sleep(3);

$a->LightsOnIntent();

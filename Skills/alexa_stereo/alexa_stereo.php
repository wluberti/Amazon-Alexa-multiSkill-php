<?php

namespace libs\Milight;

require_once __DIR__ . '/../../libs/Milight.php';

use \libs\Milight;

class alexa_lights
{
    protected $milight;
    protected $color;
    public $response;

    public function __construct()
    {
        $this->milight = new Milight('192.168.178.40');
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location)
    {
        switch ($location) {
            case 'kitchen':
                $this->milight->setRgbwActiveGroup(4);
                break;
            case 'table':
                $this->milight->setRgbwActiveGroup(3);
                break;
            case 'livingroom':
                $this->milight->setRgbwActiveGroup(1);
                break;
            case 'diningroom':
                $this->milight->setRgbwActiveGroup(2);
                break;
            case 'office':
                $this->milight->setRgbwActiveGroup(4);
                break;
            case 'bedroom':
                $this->milight->setRgbwActiveGroup(4);
                break;
            default:
                $this->milight->setRgbwActiveGroup(0);
                break;
        }

        $this->response .= "Location set to $location.";
    }

    public function setColor(string $colorName) {
        switch ($colorName) {
            case 'Violet':
                $this->milight->rgbwSetColorToViolet();
            case 'RoyalBlue':
            case 'BabyBlue':
            case 'Aqua':
            case 'RoyalMint':
            case 'SeafoamGreen':
            case 'Green':
            case 'LimeGreen':
            case 'Yellow':
            case 'YellowOrange':
            case 'Orange':
            case 'Red':
            case 'Pink':
            case 'Fusia':
            case 'Lilac':
            case 'Lavendar':
            case 'Disco':
            case 'Party':
            case 'Smooth':
            case 'Evening':
                break;
            default:
                // do nothing
                break;
        }
    }


    public function lightsOn()
    {
        $this->milight->rgbwSendOnToActiveGroup();
    }

//        "LightsOffIntent": "lightsOff",
//        "LightsSoftIntent": "lightsDim",
//        "LightsColoursIntent": "lightsToColor",
//        "LightsPartyIntent": "lightsParty"

}
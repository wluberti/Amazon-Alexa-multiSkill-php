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
            case 'dining table':
                $this->milight->setRgbwActiveGroup(3);
                break;
            case 'living room':
                $this->milight->setRgbwActiveGroup(1);
                break;
            case 'upstairs':
                $this->milight->setRgbwActiveGroup(4);
                break;
            default:
                $this->milight->setRgbwActiveGroup(0);
                break;
        }

        return sprintf("Location set to %s. ", $location);
    }

    public function lightsToColor(string $colorName) {
        switch ($colorName) {
            case 'violet':
                $this->milight->rgbwSetColorToViolet();
                break;
            case 'royal blue':
                $this->milight->rgbwSetColorToRoyalBlue();
                break;
            case 'baby blue':
                $this->milight->rgbwSetColorToBabyBlue();
                break;
            case 'aqua':
                $this->milight->rgbwSetColorToAqua();
                break;
            case 'royal mint':
                $this->milight->rgbwSetColorToRoyalMint();
                break;
            case 'seafoam green':
                $this->milight->rgbwSetColorToSeafoamGreen();
                break;
            case 'green':
                $this->milight->rgbwSetColorToGreen();
                break;
            case 'lime green':
                $this->milight->rgbwSetColorToLimeGreen();
                break;
            case 'yellow':
                $this->milight->rgbwSetColorToYellow();
                break;
            case 'yellow orange':
                $this->milight->rgbwSetColorToYellowOrange();
                break;
            case 'orange':
                $this->milight->rgbwSetColorToOrange();
                break;
            case 'red':
                $this->milight->rgbwSetColorToRed();
                break;
            case 'pink':
                $this->milight->rgbwSetColorToPink();
                break;
            case 'fusia':
                $this->milight->rgbwSetColorToFusia();
                break;
            case 'lilac':
                $this->milight->rgbwSetColorToLilac();
                break;
            case 'lavendar':
                $this->milight->rgbwSetColorToLavendar();
                break;
            case 'disco':
            case 'party':
                $this->milight->rgbwDiscoMode();
                break;
            case 'smooth':
            case 'evening':
                $this->milight->rgbwSetColorToYellowOrange();
                break;
            default:
                // do nothing
                break;
        }

        return sprintf("Color set to %s. ", $colorName);
    }


    public function lightsOn() {
        //$this->milight->rgbwSendOnToGroup($this->milight->getRgbwActiveGroup());
        $this->milight->rgbwAllOn();
        $this->milight->rgbwAllSetToWhite();
        $this->milight->rgbwAllBrightnessMax();
    }
    public function lightsOff() {
        $this->milight->rgbwSendOffToGroup($this->milight->getRgbwActiveGroup());
    }
    public function lightsDim() {}
    public function lightsParty() {
        $this->milight->rgbwDiscoMode();
    }
}
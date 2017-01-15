<?php

namespace Skills;

class skillException extends \Exception {}
class skillNotDeterminedException extends skillException {}
class skillNotFoundException extends skillException {}

class Skill
{
    public $skillName;
    public $skillConfigArray;
    public $skillFile;

    public function __construct(string $skillName = null, string $locationOfConfigFiles = __DIR__)
    {
        if ($skillName) {
            $this->getConfigForSkill($skillName, $locationOfConfigFiles);
        } else {
            $url = array_keys($_GET);

            if ($url) {
                $url = rtrim($url[0], '/');
                $url = explode('/', $url);

                $this->getConfigForSkill($url[1], $locationOfConfigFiles);
            } else {
                throw new skillNotDeterminedException("The skill could not be detemined based on the endpoint");
            }
        }
    }

    private function getConfigForSkill($skillName, $locationOfConfigFiles)
    {
        $jsonFileName = $locationOfConfigFiles . "/" . $skillName . "/" . $skillName . ".json";
        $phpFileName = $locationOfConfigFiles . "/" . $skillName . "/" . $skillName . ".php";

        if ( ! file_exists($jsonFileName)) {
            throw new skillNotFoundException("There is no configurationfile at '$jsonFileName'.");
        }
        if ( ! file_exists($phpFileName)) {
            throw new skillNotFoundException("There is no configurationfile at '$phpFileName'.");
        }

        $jsonFile = file_get_contents($jsonFileName);
        $configArray = json_decode($jsonFile, true);

        $this->skillName = $skillName;
        $this->skillConfigArray = $configArray;
        $this->skillFile = $phpFileName;
    }

    public function run(string $intentName, $slots = [])
    {
        if ( ! $this->skillName) {
            throw new skillNotFoundException("Skill was not proparly set!");
        }

        require_once $this->skillName . "/" . $this->skillName . ".php";
        $app = new $this->skillName();

        if (in_array($intentName, array_keys($this->skillConfigArray['intentMapping']))) {
            $app->$intentName($slots);
        }
    }
}
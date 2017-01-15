<?php

namespace Skills;

class skillException extends \Exception {}
class skillNotDeterminedException extends skillException {}
class skillNotFoundException extends skillException {}

class Skill
{
    public $skillName;
    public $skillConfigArray;

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
        $fileName = $locationOfConfigFiles . "/" . $skillName . "/" . $skillName . ".json";

        if ( ! file_exists($fileName)) {
            throw new skillNotFoundException("There is no configurationfile at '$fileName'.");
        }

        $jsonFile = file_get_contents($fileName);
        $configArray = json_decode($jsonFile, true);

        $this->skillName = $skillName;
        $this->skillConfigArray = $configArray;
    }

}
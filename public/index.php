<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../libs/simpleLogger.php';
require_once __DIR__ . '/../Skills/Skill.php';

// todo: make dynamic!
require_once __DIR__ . '/../Skills/alexa_lights/alexa_lights.php';
//require_once __DIR__ . '/../Skills/alexa_stereo/alexa_stereo.php';

use libs\simpleLogger;
use Skills\Skill;

// todo: make dynamic!
use libs\Milight\alexa_lights;
//use libs\Milight\alexa_stereo;


// Catch all errors so that non-Alexa requests show a message in stead of a 500 server error
try {
    $log = new simpleLogger();
    $skill = new Skill();
    $responseString = "Okay. ";

    $applicationId = $skill->skillConfigArray['applicationId'];
    $rawRequest = file_get_contents('php://input');

    $alexa = new \Alexa\Request\Request($rawRequest, $applicationId);
    $alexaRequest = $alexa->fromData();

    // do some logging of the request and found/selected skill
    $log->write("Found skill: " . print_r($skill->skillName, true));
    $log->write("Skill config: " . print_r($skill->skillConfigArray, true));
    $log->write(print_r($alexaRequest->data['request'], true));

    // todo: make dynamic!
    //$s = 'alexa_lights()';
    $app = new alexa_lights();

    if ($alexaRequest->data['request']['type'] == 'LaunchRequest') {
        $app->lightsOn();
    } elseif ($alexaRequest->data['request']['type'] == 'IntentRequest') {
        $intent = $alexaRequest->data['request']['intent']['name'];
        $slots = $alexaRequest->data['request']['intent']['slots'];

//        if ($slots['location']['value']) {
//            $responseString .= $app->setLocation($slots['location']['value']);
//            $log->write("set location to: " . $slots['location']['value']);
//        }
        if ($slots['color']['value']) {
            $responseString .= $app->lightsToColor($slots['color']['value']);
            $log->write("set color to: " . $slots['color']['value']);
        }
    }


    // Create response
   // $responseString = "This test succeeded!";

    $response = new \Alexa\Response\Response;
    $response
        ->respond($responseString)
        ->withCard($responseString)
        ->endSession(true);

    header('Content-Type: application/json');
    echo json_encode($response->render());
    exit;
}

catch (\Exception $e) {
    // Webpage for 'normal' (non-Alexa) requests
    echo "<html><body><h1>Noting to see here...</h1></body></html>" . PHP_EOL;

    // Write errors to logfile
    $log->write($e->getMessage(), true);
    die();
}

<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../libs/simpleLogger.php';
require_once __DIR__ . '/../Skills/Skill.php';

use libs\simpleLogger;
use Skills\Skill;

// Catch all errors so that non-Alexa requests show a message in stead of a 500 server error
try {
    $log = new simpleLogger();
    $skill = new Skill();

    $applicationId = $skill->skillConfigArray['applicationId'];
    $rawRequest = file_get_contents('php://input');

    $alexa = new \Alexa\Request\Request($rawRequest, $applicationId);
    $alexaRequest = $alexa->fromData();

    // do some logging of the request and found/selected skill
    $log->write(print_r($alexaRequest, true));
    $log->write(print_r($skill->skillConfigArray, true));
}

catch (\Exception $e) {
    // Webpage for 'normal' (non-Alexa) requests
    echo "<html><body><h1>Noting to see here...</h1></body></html>" . PHP_EOL;

    // Write errors to logfile
    $log->write($e->getMessage(), true);
    die();
}


// Create response
$responseString = "This test succeeded!";

$response = new \Alexa\Response\Response;
$response
    ->respond($responseString)
    ->withCard($responseString)
    ->endSession(true);

header('Content-Type: application/json');
echo json_encode($response->render());
exit;

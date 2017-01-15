<?php

namespace libs;

class fileNotAccessibleException extends \Exception {}

class simpleLogger
{
    var $fileHandle;
    var $timeString;


    /**
     * simpleLogger constructor.
     * @param string $filename
     * @throws fileNotAccessibleException
     */
    public function __construct(string $filename = "../debug.log")
    {
        $format = '%Y-%m-%d %H:%M:%S';
        $this->timeString = strftime($format);
        $this->fileHandle = fopen($filename, "a");

        if (!$this->fileHandle) {
            throw new fileNotAccessibleException("$filename is not accessible for writing!" . PHP_EOL);
        }

        fwrite($this->fileHandle, "=============================> New Request @ " . $this->timeString . PHP_EOL);
    }


    /**
     * @param $msg
     * @param bool $error
     */
    public function write($msg, bool $error = false)
    {
        if ($error) { fwrite($this->fileHandle, "===> Begining of error message <===" . PHP_EOL); }

        if ( ! is_string($msg)) {
            fwrite($this->fileHandle, print_r(implode(", ", $msg), true) . PHP_EOL);
        } else {
            fwrite($this->fileHandle, print_r($msg, true) . PHP_EOL);
        }

        if ($error) { fwrite($this->fileHandle, "===> End of error message <===" . PHP_EOL); }
    }


    /**
     * simpleLogger destructor
     */
    public function __destruct()
    {
        fwrite($this->fileHandle, "=============================> Request ended @ " . $this->timeString . PHP_EOL);
        fclose($this->fileHandle);
    }
}
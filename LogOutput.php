<?php

class LogOutput
{
    public function writeToLog($exception, $log = "out/log.txt")
    {    
        
        file_put_contents($log, $exception, FILE_APPEND | LOCK_EX);
        
    }
}
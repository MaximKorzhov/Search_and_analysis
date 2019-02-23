<?php
require_once "IReading.php";

class ReadingTxt extends Reader implements IReading
{        
    public function __construct()
    {
        $this->ext = 'txt';      
    }

    public function read($filePath, $numDog) 
    {        
        $handle = fopen($filePath, "r+");
        $readResult = NULL;
        while (($buffer = fgets($handle, 4096)) !== false) 
        {            
            $arrayString = (explode("\t", $buffer));
            if (in_array($numDog, $arrayString)) 
            {         
                $readResult = $arrayString[15] !=='' ? $arrayString[15] : 'dataNotFound';
                break;                
            }            
        } 
         
        fclose($handle);
        
        return $readResult ?? 'numDogNotFound';
    }
}
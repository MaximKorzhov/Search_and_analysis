<?php
require_once "IReading.php";

class ReadingCache implements IReading
{
    public function read($pathToCache, $fileNames)
    {
        $handle = fopen($pathToCache, "r+");
        $filePaths = [];        
        $buffer = '';   
        
        while (($buffer = fgets($handle, 4096)) !== false) 
        {
            $filePath = trim($buffer);                        
            
            if(in_array(pathinfo($filePath, PATHINFO_FILENAME), $fileNames))
            {
                $filePaths[] = $filePath;            
            }
        } 
                        
        fclose($handle);
        return $filePaths;
    }
}

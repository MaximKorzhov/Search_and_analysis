<?php
require_once "IReading.php";

class PathDuplicate implements IReading
{
    public function read($pathToCache, $filePaths)
    {
        $handle = fopen($pathToCache, "r+");
        $pathFound = [];        
        
        while (($buffer = fgets($handle, 4096)) !== false) 
        {
            $filePath = trim($buffer);
                        
            if(in_array($filePath, $filePaths))
            {                   
                $pathFound[] = $filePath;                    
            }                                    
        }         
        $filePaths = array_diff($filePaths, $pathFound);
       
        fclose($handle);
        return $filePaths;
    }
}

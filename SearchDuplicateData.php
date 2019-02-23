<?php
require_once "IReading.php";

class SearchDuplicateData implements IReading
{
    public function read($path, $dataForComparison)
    {
        $handle = fopen($path, "r+");        
        
        while (($buffer = fgets($handle, 4096)) !== false) 
        {                       
            if(strcmp(trim($buffer), $dataForComparison) === 0)
            {        
                fclose($handle);
                return NULL;
            }
        }
        fclose($handle);
        return $dataForComparison;
    }
}

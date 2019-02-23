<?php
require_once "IReading.php";
require_once "writingToCSV.php";

class ReadingCSV extends Reader implements IReading
{        
    public function __construct()
    {
        $this->ext = 'csv';
    }
    public function read($filePath, $pathCSV) 
    {                        
        $handle = fopen("in/input.csv", "r+");     
        $fp = fopen("in/replase.csv", 'w');
                
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
        {   
            $modifiedString = preg_replace("/\\s/ui",'', $data);
            fputcsv($fp, $modifiedString);
        }        
//            $writingToCSV->writeToCSV($data, $pathCSV);
        fclose($fp);
        fclose($handle);
    }
}    
//$readingCSV = new ReadingCSV();
//$filePath = "in/input.csv";
//$pathCSV = "in/replase.csv";
//$numDog = '';
//$readingCSV->read($filePath, $pathCSV);
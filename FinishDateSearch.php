<?php
require_once "readingXml.php";
require_once "ReadingTxt.php";
require_once "readingCSV.php";
require_once "readingZip.php";
require_once "SearchDuplicateData.php";

class FinishDateSearch
{
    public function getFinishDate($arrayString, $filePaths, $buffer)
    {
        $readingTxt = new ReadingTxt();
        $readingXml = new ReadingXml();
        $readingZip = new ReadingZip();
        $readingCSV = new ReadingCSV(); 
        $numDog = $arrayString[2];
        $finish_date1 = "fileNotFound";
        $finish_date2 = "fileNotFound";
        
        foreach ($filePaths as $filePath)
        {                         
            $fileExt = (pathinfo($filePath, $options = PATHINFO_EXTENSION));       
            $readingTxt->setNext($readingXml);
            $readingXml->setNext($readingZip);
            $readingZip->setNext($readingCSV);                                               
            $classObj = $readingTxt->selectObject($fileExt, $object = NULL); 
            if(pathinfo($arrayString[9],  PATHINFO_FILENAME) == pathinfo($filePath, PATHINFO_FILENAME))  $finish_date1 = $classObj->read($filePath, $numDog);
            if(pathinfo($arrayString[10],  PATHINFO_FILENAME) == pathinfo($filePath, PATHINFO_FILENAME))  $finish_date2 = $classObj->read($filePath, $numDog);            
        }                              
                
        if (!file_exists('out'))
        {
            mkdir('out', 0777, true);
        }

        if (isset($finish_date1) && isset($finish_date2) && !($finish_date1 == $arrayString[4] && $finish_date2 == $arrayString[5]))
        {    
            $dataString = rtrim($buffer, "\r\n") . "\t". $finish_date1 . "\t" . $finish_date2 . PHP_EOL;
            $LinesForWrite = (new SearchDuplicateData())->read("out/incorrect.txt", $dataString);              
            $LinesForWrite ?? (new Reader())->Save("out/incorrect.txt", $dataString);
            return $LinesForWrite;            
        }

        if (isset($finish_date1) && isset($finish_date2) && $finish_date1 == $arrayString[4] && $finish_date2 == $arrayString[5])
        {
            $dataString = rtrim($buffer, "\r\n") . "\t". $finish_date1 . "\t" . $finish_date2 . PHP_EOL;
            $LinesForWrite = (new SearchDuplicateData())->read("out/correct.txt", $dataString);                          
            $LinesForWrite ?? (new Reader())->Save("out/correct.txt", $dataString);
            return $LinesForWrite;            
        }  
    }
}
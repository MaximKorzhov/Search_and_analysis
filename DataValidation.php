<?php
require_once 'Reader.php';
require_once "readingCache.php";
require_once "Extensions.php";
require_once "SearchFileByMask.php";
require_once "LogOutput.php";
require_once "FinishDateSearch.php";

class   DataValidation 
{    
    public function readingInputFile ($inFile, $folders, $extensions, $readFromCache, $log)
    {
        $pathToCache = "out/cache.txt";        
        $currentPath = 'D:'.DIRECTORY_SEPARATOR;
        $parentDirectory = $currentPath;
        $cache = new ReadingCache();
        try
        {
            if (empty($inFile))
            {
                throw new Exception("file name inFile cannot be empty \r\n");
            }

            if (!file_exists($inFile))
            {
                throw new Exception("file not found {$inFile} \r\n");
            }
            $extentionsArray = $extensions->getArrayExtention();

            $handle = fopen($inFile, "r+");    
            while (($buffer = fgets($handle, 4096)) !== false)
            {
                $buffer = trim($buffer);//!
                $arrayString = explode("\t", $buffer);            
                $numDog = $arrayString[2];    
                $nameFile1 = pathinfo($arrayString[9], PATHINFO_FILENAME);
                $nameFile2 = pathinfo($arrayString[10], PATHINFO_FILENAME);
                $filePaths = [];

                $fileNames =
                [
                    $nameFile1,
                    $nameFile2,
                ];     

                if($readFromCache != NULL)
                {
                    $desiredPaths = $cache->read($pathToCache, $fileNames);
                }
                else 
                {
                    $desiredPaths = (new SearchByMask())->SearchFile($currentPath, $fileNames, $folders, $extentionsArray, $parentDirectory);
                }                        

                if(!empty($desiredPaths))
                {
                    $namesFound = [];

                    foreach ($desiredPaths as $cacheLine)
                    {
                        $filePaths[] = trim($cacheLine);
                        $namesFound[] = pathinfo(trim($cacheLine), PATHINFO_FILENAME);                        
                    }

                    $nameDifference = array_diff($fileNames, $namesFound);

                    if(!empty($nameDifference) && $readFromCache != NULL)        
                    {
                        $filePath = (new SearchByMask())->SearchFile($currentPath, $nameDifference, $folders, $extentionsArray, $parentDirectory);

                        if(!empty($filePath))
                        {                                
                            $filePaths = array_merge($filePaths, $filePath);               
                        }
                    }
                }    
                elseif($readFromCache != NULL) 
                {
                    $filePaths = (new SearchByMask())->SearchFile($currentPath, $fileNames, $folders, $extentionsArray, $parentDirectory);           
                }            

                $LinesForWrite = (new FinishDateSearch())->verificationProcess($arrayString, $filePaths, $buffer);
                echo $LinesForWrite;
            }
            fclose($handle);
        }
        catch (Exception $exception)
        {
            (new LogOutput())->writeToLog($exception->getMessage(), $log);
            echo $exception->getMessage(), "\n";
        }
    }
}
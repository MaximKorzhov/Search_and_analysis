<?php
require_once "IReading.php";

class ReadingXml extends Reader implements IReading
{
    public function __construct()
    {
        $this->ext = 'xml';
    }
    public function read($filePath, $numDog) 
    {
        $readResult = NULL;
        $reader = new XMLReader();
        $reader->open($filePath);
        
        while ($reader->read()) 
        {            
            if ($reader->name == 'docno' && $reader->readInnerXml() == $numDog) 
            {                                                        
               //$readResult[] = $reader->readInnerXml();  
               while ($reader->read()) 
               {
                   if ($reader->name == 'cred_enddate') 
                    {                
                       $readResult = ($reader->readInnerXml()) !== '' ? ($reader->readInnerXml()) :  'dataNotFound';
                       break;
                    }    
               }                                                              
            }                                            
        }
        
        $reader->close();
        return $readResult ?? 'numDogNotFound';
    }
}
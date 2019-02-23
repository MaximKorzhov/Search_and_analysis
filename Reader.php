<?php
require_once "readingXml.php";
require_once "ReadingTxt.php";
require_once "readingCache.php";
require_once "readingCSV.php";
require_once "readingZip.php";

class Reader 
{
    protected $successor;
    protected $ext;      
   
    public function setNext(Reader $account) : Reader
    {
        $this->successor = $account;
        return $account;
    }
    public function selectObject(string $ext, $object) //: object
    {       
        if ($this->canRead($ext))
        {
            $object = $this;           
        } 
        
        elseif ($this->successor)
        {
            $object = $this->successor->selectObject($ext, $object);
        }
        else
        {
            throw new Exception('None class for read');
        }
        return $object;
    }

    public function canRead($extention): bool
    {
        return ($this->ext === $extention);
    }
    
    public function Save($filename, $data, $opt = FILE_APPEND | LOCK_EX)
    {        
        file_put_contents($filename, $data, $opt);
        return $this;
    }
}

// $readingTxt = new ReadingTxt();
//        $readingXml = new ReadingXml();
//        $readingZip = new ReadingZip();
//        $readingCSV = new ReadingCSV();  
//$fileExt = "xml"; 
//$filePath
//$numDog
//                $readingTxt->setNext($readingXml);
//                $readingXml->setNext($readingZip);
//                $readingZip->setNext($readingCSV);                                               
//                $obj = $readingTxt->selectObject($fileExt, $filePath, $numDog);  
//                $obj1 = $readingTxt->getObj();
//                print_r($obj);
<?php

class CorrectFile 
{    
    public $correctFile = [];
    
    public function __construct($arrayString)
    {
        $numDog = $arrayString[2];
        $finishDate1 = $arrayString[4];
        $finishDate2 = $arrayString[5];           
        $nameFile1 = pathinfo($arrayString[9], PATHINFO_FILENAME);
        $nameFile2 = pathinfo($arrayString[10], PATHINFO_FILENAME);
        $this->correctFile = 
                [
                    $nameFile1=>
                    [
                       $numDog,
                       $finishDate1,            
                    ],
                    $nameFile2=>
                    [
                        $numDog,
                        $finishDate2,                
                    ],
                ];
    }
}

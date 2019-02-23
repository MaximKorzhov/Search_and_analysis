<?php
require_once "DataValidation.php";
require_once "Extensions.php";

//try
//{
    $inFile = "in/401.txt";
    $log = "out/log.txt";
    $readFromCache = NULL; //if no and any if yes

    $folders = 
    [
//        'opt',
//        '100MSDCF',
        'Develop', 
//      'NewFolderDevelop',
    ];
    $extensions = new Extensions([
                                    'txt', 
                                    'xml',
                                    'zip',
                                    'csv',
                                ]); 

    (new DataValidation())->readingInputFile($inFile, $folders, $extensions, $readFromCache, $log);
//}
//catch (Exception $e)
//{
//    Logger::Instance()->log($e->getMessage() . " (errcode: {$e->getCode()})");
//}
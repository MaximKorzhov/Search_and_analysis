<?php
require_once "pathDuplicate.php";
require_once "cacheInfo.php";
require_once "Extensions.php";

class SearchByMask
{    
    private $allFoundPath = [];
    private $pathsToTheDesiredFiles = [];        
    
    public function SearchFile($currentPath, array $fileNames, array $folders, array $extentionsArray, $parentDirectory)
    {        
        $pathsDuplicate = new PathDuplicate();
        $cache = new cacheData();
        $pathToCache = "out/cache.txt";
        $files = scandir($currentPath);    

        foreach($files as $file)
        {                            
            if(in_array($file, ['.', '..']))
            {
                continue;
            }

            $fullPath = $currentPath.DIRECTORY_SEPARATOR.$file;            

            if(!is_readable($fullPath))
            {
                continue;
            }

            if (is_dir($fullPath))
            {       
                foreach ($folders as $folder)
                {
                    $regexp = "/\b$folder\b/ui";
                    if(preg_match($regexp, $fullPath))
                    {
                        $tmp = $this->SearchFile($fullPath, $fileNames, $folders, $extentionsArray, $parentDirectory);
                    
                        if(!empty($tmp))
                        {
                            $this->pathsToTheDesiredFiles = $tmp;//array_merge($allFoundPath, $tmp);                            
                        }          
                    }
                }
                 continue;               
            }

             if (is_file($fullPath) && pathinfo($fullPath, $options = PATHINFO_DIRNAME) !== $parentDirectory)
            {
                $ext = pathinfo($fullPath, $options = PATHINFO_EXTENSION);
                $filename = pathinfo($fullPath, $options = PATHINFO_FILENAME);
                $this->allFoundPath[] = $fullPath;  
                if(in_array($ext, $extentionsArray) && in_array($filename, $fileNames))
                {                                                                       
                    $this->pathsToTheDesiredFiles[] = $fullPath; 
                }                               
            }    	    
        }  
        
      $pathsToWrite = $pathsDuplicate->read($pathToCache, $this->allFoundPath);
      $cache->writeToCache($pathsToWrite, $pathToCache);
      return $this->pathsToTheDesiredFiles;//$found;
    }
}

//    $folders = 
//    [
////        'NeWopt',
////        'opt',
////        '100MSDCF',
////        'Develop', 
////        
//        'NewFolderDevelop',
//    ];
//    $extensions = new Extensions
//    ([
//        'txt', 
//        'Xml',
////        'zip',
//    ]);     
//    
//$currentPath = 'D:'.DIRECTORY_SEPARATOR;
//$parentDirectory = $currentPath;
//$fileNames =
//    [
//        '0B5P7321',
//        '0B5P7431',
//    ]; 
//
//$pathWithoutParentDir = '';
//
//$obj = new SearchByMask();
//$show = $obj->SearchFile($currentPath, $fileNames, $folders, $extensions, $parentDirectory);     
//print_r($show);
<?php

class cacheData
{
    public function writeToCache($filePaths, $pathToCache)
    {
        foreach ($filePaths as $filePath)
        {            
            $resultSearch = $filePath."\n";
//            $arrayString = implode("", $resultSearch);
            file_put_contents($pathToCache, $resultSearch, FILE_APPEND | LOCK_EX);         
        }
        return 0;
    }
}
//$filePaths = ["fafaf", "uyru",];
//$pathToCache = "out/cache.txt";
//$e = new cacheData();
//$e->writeToCache($filePaths, $pathToCache);
<?php

class Extensions 
{
    protected $extensions;
    
    public function __construct(array $extensions) 
    {
        $this->extensions = $extensions;
    }
    
    public function getArrayExtention()
    {
        $this->ToLowerCase($this->extensions);
        return ($this->extensions);
    }

    protected function ToLowerCase(array &$extensions)
    {
        foreach ($extensions as $k => $m)
        {
            $extensions[$k] = strtolower($m);
        }        
    }    
}
//    public function getExtension($filename)
//    {
//        $normalizedExtensions = [];
//        $match = [];
//        foreach ($this->extensions as $extension)
//        {
//            if (preg_match("%\.{$extension}$%", strtolower($filename), $match))
//            {
////                $normalizedExtensions = array_merge($normalizedExtensions, $match);
//                return $extension;
//            }
       
//        }
//        return $normalizedExtensions;
//    }

//$ex = new Extensions([  'txt', 'Xml',  ]);
//$r = $ex->extensionNormalization();
//print_r($r);

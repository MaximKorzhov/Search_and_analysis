<?php
require_once "IReading.php";

class ReadingZip extends Reader implements IReading
{    
    public function __construct()
    {
        $this->ext = 'zip';
    }
    public function read($filePath, $numDog) 
    {
      $zip = new ZipArchive(); //Создаём объект для работы с ZIP-архивами
      //Открываем архив archive.zip и делаем проверку успешности открытия
      if ($zip->open($filePath) === true)
      {          
        $zip->extractTo("unpacked/"); //Извлекаем файлы в указанную директорию
        $zip->close(); //Завершаем работу с архивом
      }
      else
      echo "Архива не существует!"; //Выводим уведомление об ошибке
    }
}
//$readZip = new ReadingZip();
//$filePath = 'D:\Develop\testZip.zip';
//$numDog = '';
// $readZip->read($filePath, $numDog);
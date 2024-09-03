<?php 
/*
* CÓDIGO CONSULTADO Y TOMADO EN LA PÁGINA: 
* @author     Andres Hierro
* @link       http://ahierro.es/
*/
include('MySqlBackup.php');
include("../../../Php/conexion.php");
$arrayDbConf['host'] = $host;
$arrayDbConf['user'] = $us;
$arrayDbConf['pass'] = $pw;
$arrayDbConf['name'] = $bd;


try {
 
  $bck = new MySqlBackupLite($arrayDbConf);
  $bck->backUp();
  $bck->downloadFile();
 
}
catch(Exception $e) {
 
  echo $e;
 
}

try {
 
  $bck = new MySqlBackupLite($arrayDbConf);
  $bck->backUp();
  $bck->setFileDir('./backups/');
  $bck->setFileName('backupFileNae.sql');
  $bck->saveToFile();
 
}
catch(Exception $e) {
 
  echo $e;
 
}
?>
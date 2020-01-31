PwnLabs/FtpClient
=========

A simple wrapper client lbrary to connect to FTP Servers, and do simple operations.

Example usage
========

```angular2html
$ftpClient = new \PwnLabs\FtpClient\FtpClient(
    $host, 
    $username, 
    $password
);
 
$ftpClient->login(); 
$ftpClient->setPassiveMode(true); 
$ftpClient->changeDirectory('SOME_OTHER_DIRECTORY'); 
$listedFilenames = $ftpClient->listFilesInDirectory(); 

var_dump($listedFilenames); 

```

 

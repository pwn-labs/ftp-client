<?php

namespace PwnLabs\FtpClient;

/**
 * Class FtpClient
 * @package PwnLabs\FtpClient
 */
class FtpClient
{
    /**
     * @var string
     */
    private $serverUrl;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var resource
     */
    private $connectionId;

    /**
     * FtpClient constructor.
     * @param string $serverUrl
     * @param string $username
     * @param string $password
     */
    public function __construct(
        string $serverUrl,
        string $username,
        string $password
    ) {
        $this->serverUrl = $serverUrl;
        $this->username = $username;
        $this->password = $password;

        $this->connectionId =  $this->setSSLConnection();
    }

    /**
     * @return $this
     */
    public function login()
    {
        $login = ftp_login($this->connectionId, $this->username, $this->password);
        if ($login === false) {
            throw new \LogicException('Unable to login to FTP Server');
        }

        return $this;
    }

    /**
     * @param bool $passiveMode
     */
    public function setPassiveMode(bool $passiveMode)
    {
        ftp_pasv($this->connectionId, $passiveMode);
    }

    /**
     * @return string
     */
    public function showPresentWorkingDirectory()
    {
        return ftp_pwd($this->connectionId);
    }

    /**
     * @param string $newLocation
     * @return bool
     */
    public function changeDirectory(string $newLocation)
    {
        return ftp_chdir($this->connectionId, $newLocation);
    }

    /**
     * @return array
     */
    public function listFilesInDirectory()
    {
        return ftp_nlist($this->connectionId, '.');
    }

    /**
     * @param string $localFilename
     * @param string $remoteFilename
     * @return $this
     */
    public function downloadRemoteFileToLocalStorage(
        string $localFilename,
        string $remoteFilename
    ) {
        $localFileHandle = fopen($localFilename, 'w');

        ftp_fget($this->connectionId, $localFileHandle, $remoteFilename, FTP_ASCII, 0);

        return $this;
    }

    /**
     * @param $remoteFilename
     * @param $localFilePath
     * @return $this
     */
    public function putLocalFileOnRemoteStorage(string $remoteFilename, string $localFilePath)
    {
        ftp_put($this->connectionId, $remoteFilename, $localFilePath, FTP_ASCII);

        return $this;
    }

    /**
     * @return string
     */
    public function getServerUrl(): string
    {
        return $this->serverUrl;
    }

    /**
     * @param string $serverUrl
     */
    public function setServerUrl(string $serverUrl): void
    {
        $this->serverUrl = $serverUrl;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return resource
     */
    private function setSSLConnection()
    {
        return ftp_ssl_connect($this->serverUrl);
    }
}
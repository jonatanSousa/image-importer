<?php

namespace Console\App\Library\Image;


class FtpHandler
{
    private $connection;
    private $username;
    private $password;

    public function __construct()
    {
        $this->username = $_ENV['FTP_USERNAME'];
        $this->password =$_ENV['FTP_PASSWORD'];
    }

    /**
     * @param $local_file
     * @param $remote_file
     * @return bool
     * @throws \Exception
     */
    function uploadFTP($local_file, $remote_file): bool
    {
        try {
            $this->connection = ftp_connect($_ENV['FTP_HOST']) or die("Could not connect to " . $_ENV['HOST']);

            // login
            if ($connecT = ftp_login($this->connection, $this->username, $this->password)) {
                // successfully connected
            } else {
                throw new \Exception('FTP HANDLER : connection unsuccessful: ' . $this->username . ' passs: ' . $this->password);
            }

            $ftpPutResult = ftp_put($this->connection, $remote_file, 'images/' . $local_file, FTP_BINARY);
            ftp_close($this->connection);

            return true;
        } catch (\Exception $e) {
            throw new \Exception('UPLOADFTP error'.$e->getMessage());

        }

    }
}
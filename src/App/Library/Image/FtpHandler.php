<?php

namespace Console\App\Library\Image;


class FtpHandler
{

    private $connection;
    private $username;
    private $password;
    private $server;

    public function __construct()
    {


        $this->connection = ftp_connect($config->server);
        $this->username = $config->server;
        $this->password = $config->server;
        $this->server = $config->server;
    }

    function uploadFTP($local_file, $remote_file){
        // login
        if (@ftp_login($this->connection, $this->username, $this->password)){
            // successfully connected
        }else{
            return false;
        }

        ftp_put($this->connection, $remote_file, $local_file, FTP_BINARY);
        ftp_close($this->connection);
        return true;
    }
}
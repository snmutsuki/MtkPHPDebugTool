<?php

namespace mtk;

use Exception;

class MtkSftp{
    protected static $instance = null;
    protected $connection = null;
    protected $host = '';
    protected $port = '';
    protected $userName = '';
    protected $password = '';
    protected $remoteBaseDir = '';
    protected $localBaseDir = '';

    private function __construct(){
        $config = include ROOT_DIR."/app/Config/MtkSftpConfig.php";
        $this->host = $config['HOST'];
        $this->port = $config['PORT'];
        $this->userName = $config['USER_NAME'];
        $this->password = $config['PASSWORD'];
        $this->remoteBaseDir = $config['REMOTE_BASE_DIR'];
        $this->localBaseDir = $config['LOCAL_BASE_DIR'];
        $this->connection = ssh2_connect($this->host,$this->port);
        if(!ssh2_auth_password($this->connection,$this->userName,$this->password)) throw new Exception("sftp连接失败！");
    }

    public static function getConnection(){
        $instance = self::$instance ?? new MtkSftp;
        return $instance; 
    }

    public function uploadFile($localFile , $createMode = 0775){
        $remoteFile = self::parsePath($localFile);
        if(!ssh2_scp_send($this->connection,$localFile,$remoteFile,$createMode)) throw new Exception("上传".$localFile."失败！");
    }

    public function parsePath($path){
        return substr_replace($path,$this->remoteBaseDir,0,strlen($this->localBaseDir));
    }

}
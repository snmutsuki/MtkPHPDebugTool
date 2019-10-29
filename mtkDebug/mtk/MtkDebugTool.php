<?php
namespace mtk;

use ReflectionClass;
use Think\Exception;

class MtkDebugTool{
    protected static $configPath = '/app/Config/mdebugConfig.php';
    protected static $inited = false;
    protected static $debugRecord = [];
    protected static $mdebugPath = '';
    protected static $ignoreFileList = [];
    protected static $refreshVersionWhenRemove = false;
    protected static $baseDir = null;
    protected static $defaultDebugFileName = '';
    protected static $defaultVersionFileName = '';
    protected $debugFile = null;
    /**
     * @param string $filePath
     */
    private function __construct($filePath){
        try{
            $this->debugFile = fopen($filePath,'a+');
        }catch(\Throwable $e){
            $this->__destruct();
        }            
       
    }

    public function __destruct(){
        fclose($this->debugFile);
    }

    /**
     * 获取指定的日志记录实例，如果不填任何参数，将获取默认的debug日志记录
     * @param string $recordName debug日志记录的名字，不是文件名！
     * @param string $fileName 如果指定日志记录不存在，则需要进行初始化的日志文件路径
     * @return MtkDebugTool 
     */
    public static function getDebugRecord($recordName ='defaultRecord',$fileName = null){
        if(!self::$inited) self::init();
        if(isset(self::$debugRecord[$recordName])){          
        }else if($recordName == 'defaultRecord'){
            self::$debugRecord[$recordName] = new MtkDebugTool(self::$mdebugPath.self::$defaultDebugFileName);
        }else if(!empty($fileName) && !empty($recordName) && ($fileName != self::$defaultDebugFileName)){
            self::$debugRecord[$recordName] = new MtkDebugTool(self::$mdebugPath.$recordName);
        }else{
            throw new \Exception("argument exception");
        }
        return self::$debugRecord[$recordName];
    }

    public static function init(){      
        //$config = include self::$baseDir.self::$configPath;
        $config = include ROOT_DIR.self::$configPath;      
        if(empty($config)) throw new \Exception("配置文件为空");      
        self::$debugRecord = [];
        self::$baseDir = $config['DEBUG_BASE_DIR'];
        self::$mdebugPath = $config['MTK_DEBUG_FOLDER_PATH'];     
        self::$defaultDebugFileName = $config['DEFAULT_DEBUG_FILE_NAME'];
        self::$defaultVersionFileName = $config['MTK_VERSION_FILE_NAME'];
        self::$refreshVersionWhenRemove = $config['REFRESH_VERSION_WHEN_REMOVE'];
        self::$ignoreFileList = $config['IGNORE_FILE_LIST_RELATIVE_BY_BASE_DIR'];
        foreach(self::$ignoreFileList as &$file){
            $file = self::$baseDir.$file;
        }
        self::$inited = true;
        //self::initMtkDebugFolder();无文件写权限，无法使用       
    }

    /**
     * 打印当前执行的php文件
     */
    public function debugExecutePhpFile(){
        fwrite($this->debugFile,"<p>EPF:".print_r($_SERVER['PHP_SELF'],true)."-------------ET:".date("Y-m-d H:i:s")."</p><br>");
    }

    /**
     * 打印一个变量
     * @param mixed $args 需要打印的变量,最后一个参数可以为标识，不加也可以
     */
    public function debugVar($args){
        $args = func_get_args();
        $content = '<p><pre>';
        $count = 0;
        if(($count = count($args)) == 1){
            $content .= "****var-noname:\n";
        }else{
            $content .= (gettype($args[$count - 1]) == string) ? "****var-".array_pop($args).":\n" : "****var-nonameCollection:\n";
        }      
        foreach($args as $arg){
            $content .= print_r($arg,true)."\n"; 
        }
        $content .= "</pre></p>";
        fwrite($this->debugFile,$content);
    }

    /**
     * 打印一段debug_backtrace
     * @param boolean $needDetail 需不需要展现细节，即展开array和object
     */
    public function debugBackTrace($needDetail = false){
        fwrite($this->debugFile,"<p>mtk back trace------------------------------------<br><br>");
        $debugInfo = debug_backtrace();
        if(isset($debugInfo) && count($debugInfo) > 1){
            array_shift($debugInfo);
            if(!$needDetail){
                self::getSimpleArrInfo($debugInfo);
            }  
            fwrite($this->debugFile,print_r($debugInfo,true)."<br>**************************************mtk back trace<br><br></p>");//mtk TODO
            return ;
        }
        fwrite($this->debugFile,"无调用记录"."*mtk*<br>");//mtk TODO
    }
    
    /**
     * 转换一个object为它的名字
     * @param mixed &$object 需要转换的object
     */
    protected static function getSimpleObjectInfo(&$object){
        if(empty($object)) return false;
        $object = (new ReflectionClass($object))->getName();
    }
    
    /**
     * 转换一个array为它的简写模式
     * @param array &$args 需要转换的array
     */
    protected static function getSimpleArrInfo(&$args){
        if(empty($args)){return false;} 
        foreach($args as &$arg){
            if(is_object($arg)) self::getSimpleObjectInfo($arg);
            if(is_array($arg))  self::getSimpleArrInfo($arg);
        }
    }

    /**
     * 解析指定文件夹路径下所有指定后缀的文件，包括子目录下的文件
     * @param array $dir 需要解析的文件夹完整路径
     * @param string $ext 需要解析的文件的后缀，不加代表解析所有文件
     * @param array $ignore 需要忽略的文件夹或者文件的路径数组
     * @param array &$result 需要装载数据的数组，也可以不加，通过返回值会返回
     * @return array
     */
    protected static function getAllFile($dir,$ext = '',$ignore = [],&$result = []){
        $dir = str_replace("\\","/",$dir);
        $files = scandir($dir);
        $i = 0;
        foreach($files as $file){
            if(++$i<3) continue;
            if(is_dir($dirPath = $dir.$file."/")){
                if(in_array($dirPath , $ignore)) continue;
                self::getAllFile($dirPath,$ext,$ignore,$result);
            }else if(empty($ext)){
                $result[] = $dir.$file;
            }else if(pathinfo($file,PATHINFO_EXTENSION) == $ext){
                if(in_array($dir.$file , $ignore)) continue;
                $result[] = $dir.$file;
            }
        }
        return $result;
    }

    /**
     * 删除文件中指定的函数调用
     * 注意，为了逻辑简便，该指定函数的调用需要遵从以下原则：
     * 1、参数中不能有任何分号
     * 2、该函数名字不能出现在任何字符串中
     * 3、在定义该函数的地方使用会出现问题
     * 4、必须在一行
     * 5、一行只能调用一次
     * @param string $fileName 文件路径
     * @param string $functionName 函数名字
     */
    protected static function removeFunctionFromFile($fileName , $functionName= ''){
        if(empty($functionName)) return ;
        $oriFile = $modiFile = null;
        try{
            $oriFile = fopen($fileName,'r');
            $modFile = fopen($fileName.".mtk" , 'w');
            $str = '';
            while(!feof($oriFile)){
                $str = fgets($oriFile);
                $index = 0;
                if(($index = strpos($str , $functionName.'::')) === false){
                    fwrite($modFile , $str);
                    continue;
                }
                $semicolonIndex = 0;
                if(($semicolonIndex = strpos($str , ';' ,$index+strlen($functionName.'::')) ) === false ) throw new \Exception("该行中找不到结束标志，请查看函数的使用是否符合规则");
                $str = substr_replace($str , '' , 0, $semicolonIndex + 1);
                fwrite($modFile , $str);
            }
            fflush($modFile);   
            fclose($oriFile);
            fclose($modFile);
            unlink($fileName);
            rename($fileName.".mtk" , $fileName);
        }catch(\Throwable $e){
            fclose($oriFile);
            fclose($modFile);
            unlink($fileName.".mtk");
            throw $e;
        }

    }
    /**
     * 用于初始化mtk debug folder，里面包含的文件fileVersionList.php记录了一个指定目录下所有php文件的文件版本的map，php数组形式
     * @param string $rootDir 应用的根目录
     * @param string $dirPath 希望文件夹生成的位置
     */
    public static function initMtkDebugFolder(){
        if(!self::$inited) self::init();
        if(file_exists(self::$mdebugPath)) return;
        mkdir(self::$mdebugPath);
        try{
            self::refreshFileVersionList(self::$baseDir,self::$mdebugPath.self::$defaultVersionFileName,true);
        }catch(\Throwable $e){
            rmdir(self::$mdebugPath);
        }
    }

    /**
     * 用于更新fileVersionList.php文件
     * @param string $rootDir 应用根目录
     * @param string $filePath 记录文件的路径
     * @param boolean $isInit 是否是初始化阶段的调用
     * @param string $ext 需要记录的文件版本的文件类型
     */
    protected static function refreshFileVersionList($rootDir,$filePath,$isInit = false,$ext = 'php'){
        $modFile = null;
        try{
            $modFile = fopen($filePath.'mtk','w');
            $allFiles = self::getAllFile($rootDir,$ext,self::$ignoreFileList);
            $fileVersionList = array_flip($allFiles);
            fwrite($modFile , "<?php\nreturn array(\n\t'baseDir' => '".str_replace("\\","/",$rootDir)."',\n\t'ext' => '".$ext."'");
            foreach($fileVersionList as $key => &$value){
                $value = filemtime($key);
                fwrite($modFile,",\n\t'".str_replace("\\","/",$key)."' => ".$value);   
            }    
            fwrite($modFile,"\n);");   
            fflush($modFile);
            fclose($modFile);
            $isInit ?:unlink($filePath);
            rename($filePath.'mtk',$filePath);
            clearstatcache();
        }catch(\Throwable $e){
            fclose($modFile);
            clearstatcache();
            unlink($filePath.'mtk');
            throw $e;
        }
    }
    /**
     * 获取新增了的文件、修改、删除了的文件的文件名数组
     * @param string $filePath 记录文件的路径
     */
    public static function getChangedFileList($filePath = null){
        $filePath = $filePath ?? self::$mdebugPath.self::$defaultVersionFileName; 
        if(pathinfo($filePath , PATHINFO_EXTENSION) != 'php') throw new \Exception("记录文件格式错误");
        $oldFileVersionList = include $filePath;
        if(!is_array($oldFileVersionList)) throw new \Exception("记录内容格式错误");
        if(!isset($oldFileVersionList['baseDir'] , $oldFileVersionList['ext'])) throw \Exception("记录数组中不存在必需字段");
        $currentFileVersionList = array_flip(self::getAllFile($oldFileVersionList['baseDir'] , $oldFileVersionList['ext'],self::$ignoreFileList));
        array_shift($oldFileVersionList);array_shift($oldFileVersionList);
        foreach($currentFileVersionList as $key => &$value){
            $value = filemtime($key);
        }
        clearstatcache();
        $existedFileList = array_intersect_key($oldFileVersionList , $currentFileVersionList);//都存在的文件
        $noChangedFileList = array_intersect_assoc($oldFileVersionList , $currentFileVersionList);//未变更的文件
        $changedFileList = array_keys(array_diff_key($existedFileList , $noChangedFileList));//变更过的文件
        $newFileList = array_keys(array_diff_key($currentFileVersionList , $existedFileList));//新添加的文件
        $deletedFileList = array_keys(array_diff_key($oldFileVersionList , $existedFileList));//删除的文件
        return ['added' => $newFileList , 'modified' => $changedFileList , 'deleted' => $deletedFileList];
    }

    public static function removeAllDebugTag(){
        if(!self::$inited) self::init();
        $changedFileList = self::getChangedFileList(self::$mdebugPath.self::$defaultVersionFileName);
        self::getDebugRecord()->debugVar($changedFileList);
        foreach($changedFileList['added'] as $file){
            self::removeFunctionFromFile($file , 'MtkDebugTool');
            MtkSftp::getConnection()->uploadFile($file);
        }
        foreach($changedFileList['modified'] as $file){
            self::removeFunctionFromFile($file , 'MtkDebugTool');
            MtkSftp::getConnection()->uploadFile($file);
        }
        
        !self::$refreshVersionWhenRemove ?: self::refreshFileVersionList(self::$baseDir,self::$mdebugPath.self::$defaultVersionFileName);
    }
    
}
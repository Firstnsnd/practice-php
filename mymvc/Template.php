<?php
/**
 *a simple view class
 * @authors Your Name (you@example.org)
 * @date    2016-05-26 13:00:33
 * @version $Id$
 */

class Template{
	private $arrayConfig=array(
		'suffix'=>'.m',//设置模板文件的后缀
		'templateDir'=>'template/',//设置模板文件所在的文件夹
		'compiledir'=>'cache/',//设置编译后存放的目录
		'cache_htm'=>false,//是否需要编译成静态的HTML文件
		'suffix_cache'=>'.htm',//设置编译后的文件后缀
		'cache_time'=>2000,//多长时间自动更新，单位秒
		'php_turn'=>true,//是否支持php代码
		'cache_control'=>'control.dat',
		'debug'=>false
		);
	public $false;//模板文件名，不带路径
	private $value=array();//值栈
	private $compileTool;//编译器
	static private $instance=null;
	public $debug=array();
	private $controlData=array();

    function __construct($arrayConfig=array()){
    	$this->debug['begin']=microtime(true);//获取时间戳
    	$this->arrayConfig=$arrayConfig+$this->arrayConfig;
    	$this->getPath();
    	if (!is_dir($this->arrayConfig[templateDir])) {
    		exit('template dir not dound');
    	}
    	if (!is_dir($this->arrayConfig['compiledir'])) {
    		mkdir($this->arrayConfig['compiledir'],0770,true);
    	}
    	include('CompileClass.php');
    }
    /**
     * 路径处理为绝对路径
     * @return [type] [description]
     */
    public function getPath(){
    	$this->arrayConfig['templateDir']=strtr(realpath($this->arrayConfig['templateDir']),'\\', '/').'/';
    	$this->arrayConfig['compiledir']=strtr(realpath($this->arrayConfig['compiledir']),'\\', '/').'/';
    }
    /**
     * 取得模板引擎的实例
     * @return [type] [description]
     */
    public static function getInstance(){
    	if (is_null(self::$instance)) {
    	    self::$instance =new Template();
    	}
    	return self::$instance;
    }
    /**
     * 设置模板引擎的参数
     * @param [type] $key   [description]
     * @param [type] $value [description]
     */
    public function setConfig($key,$value=null){
    	if (is_array($key)) {
    		$this->arrayConfig=$key+$this->arrayConfig;
    	}else{
    		$this->arrayConfig[$key]=$value;
    	}
    }
    /**
     * 获取当前模板引擎的实例配置，仅供调试信息
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function getConfig($key=null)
    {
    	if ($key) {
    		return $this->arrayConfig[$key];
    	}else{
    		return $this->arrayConfig;
    	}
    }
    /**
     * 注入单个变量
     * @param   $key   模板变量名
     * @param  mixed $value 模板的变量值
     * @return [type]        [description]
     */
    public function assign($key,$value){
    	$this->value[$key]=$value;
    }
    /**
     * 注入数组变量
     * @return [type] [description]
     */
    public function assignArray(){
    	if(is_array($array)){
    		foreach($array as $k=>$v){
    			$this->value[$k]=$v;
    		}
    	}
    }

    public function path(){
    	return $this->arrayConfig['templateDir'].$this->file.$this->arrayConfig['suffix'];
    }
    /**
     * 判断是否开启了缓存
     * @return [type] [description]
     */
    public function needCache(){
    	return $this->arrayConfig['cache_htm'];
    }
    /**
     * 是否需要重新生成静态文件
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
     public function reCache($file){
     	$flag=false;
     	$cacheFile=$this->arrayConfig['compiledir'].md5($file).'.htm';
     	if ($this->arrayConfig['cache_htm']===true) {//是否需要缓存
     		$timeFlag=(time()-@filemtime($cacheFile))<$this->arrayConfig['cache_time']?true:false;
     		if (is_file($cacheFile)&&filesize($cacheFile)>1&&$timeFlag) {//缓存未过期
     			$flag=true;
     		}else{
     			$flag=false;
     		}
     	}
     }
     /**
      * 显示模板
      * @param  [type] $file [description]
      * @return [type]       [description]
      */
     public function show($file){
     	$this->file=$file;
     	if (!is_file($this->path())) {
     		exit('找不到对应的模板');
     	}
     	$compileFile=$this->arrayConfig['compiledir'].md5($file).'.php';
     	$cacheFile=$this->arrayConfig['compiledir'].md5($file).'.htm';
     	if ($this->reCache($file)===false) {
     		$this->debug['cache']='false';
     		$this->compileTool=new CompileClass($this->path(),$compileFile,$this->arrayConfig);
     		if ($this->needCache($file)===false) {
     			ob_start();
     		}
     		extract($this->value,EXTR_OVERWRITE);//返回输出缓冲区的内容
     		if(!is_file($compileFile)||filemtime($compileFile)<filemtime($this->path())){
     			$htis->compileTool->vars=$this->value;
     			$this->compileTool->compile();
     			include $compileFile;
     		}else{
     			include $compileFile;
     		}
     		if ($htis->needCache()) {
     			$message=ob_get_contents();
     			file_put_contents($cacheFile, $message);
     		}
     	}else{
     		readfile($cacheFile);
     		$this->debug['cache']='true';
     	}
     	$this->debug['spend']=microtime(true)-$this->debug['begin'];
     	$this->debug['count']=count($this->value);
     	$this->debug_info();
     }
     /**
      * 解析的信息
      * @return [type] [description]
      */
     public function debug_info(){
     	if ($this->arrayConfig['debug']===true) {
     		echo PHP_EOL,'---------debug info----------',PHP_EOL;
     		echo '程序运行日期:',date("Y-m-d h:i:s"),PHP_EOL;
     		echo '模板解析耗时:',$this->debug['spend'],'秒',PHP_EOL;
     		echo '模板含标签数目:'.$this->debug['count'],PHP_EOL;
     		echo '是否使用静态缓存',$this->deubg['cached'],PHP_EOL;
     		echo '模板引擎实例参数:',var_dump($htis->getConfig());
     	}
     }
     public function clean($path=null){
     	if ($path===null) {
     		$path=$this->arrayConfig['compiledir'];
     		$path=glob($path.'*'.$this->arrayConfig['suffix_cache']);
     	}else{
     		$path=$this->arrayConfig['compliedir'].md5($path).'.htm';
     	}
     	foreach((array)$oath as $v){
     		unlink($v);
     	}
     }
 }
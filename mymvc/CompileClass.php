<?php
/**
 * 模板编译工具类
 * @authors Your Name (you@example.org)
 * @date    2016-05-24 19:25:19
 * @version $Id$
 */

class CompileClass {
    private $template;//代编译的文件
    private $content;//需要替换的文本
    private $comfile;//编译后的文本
    private $lef='{';//左定界符
    private $right='}';// 右定界符
    private $value=array();//值栈
    private $phpTurn;
    private $T_p=array();
    private $T_R=array();
        function __construct($template,$compileFile,$config){
        	$this->template=$template;
        	$this->comfile=$compileFile;
        	$this->content=file_get_contents($template);
        	if ($config['php_turn']===false) {
        		$this->T_p[]="#<\? (=|php|)(.+?)\?>#is";
                $this->T_R[]="&LT;? \\1\\2? &gt;";
        	}
            $this->T_P[]="#\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}#";
            $this->T_p[]="#\{(loop|foresche) \\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)}#i";
            $this->T_P[]="#\{\/(loop|foreache|if)}#";
            $this->T_P[]="#\{([K|V])\}#";
            $this->T_P[]="#\{if(.*?)\}#i";
            $this->T_P[]="#\{(else if|elseif)(.*?)\}#i";
            $this->T_P[]="#\{else\}#i";
            $this->T_P[]="#\{(#\|\*)(.*?)(\#|\*)\}#";

            $this->T_R[]="<?php echo \$this->value['\\1'];?>";
            $this->T_R[]="<?php foreach((array) \$this->value['\\2'] as \$K=>\$V){?>";
            $this->T_R[]="<?php php?>";
            $this->T_R[]="<?php echo \$\\1;?>";
            $this->T_R[]='<?php if(\\1){?>';
            $this->T_R[]='<?php }else if(\\2){?>';
            $this->T_R[]='<?php }else{ ?>';
            $this->T_R[]='';
    }

    public function compile(){
        $this->c_var2();
        $this->c_staticFile();
    	file_put_contents($this->compile,$this->content);
    }
    /**
     * 加入对静态javascript文件的解析
     * @return [type] [description]
     */
    public function c_staticFile(){
        $this->content=preg_replace('#\{\!(.*?)\?\}#','<script src=\\1'.'?t='.time().'></script>', $this->content);
    }
    public function __set($name,$value){
        $this->name=$value;
    }
    public function __get(){
        return $this->$name;
    }

}
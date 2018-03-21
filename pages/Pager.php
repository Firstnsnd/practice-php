<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-21
 * Time: 上午11:13
 */

class Pager
{
    protected $total;    //数据集总数
    protected $listRows;    //每页展示的数量
    protected $currentPage;    //当前页
    protected $lastPage;    //最后一页
    protected $hasNext;    //是否有下一页
    protected $hasPre;    //是否有上一页
    protected $options = [    //操作配置
        'var_page' => 'page',
        'path'        => 'index.php',
        'query'        => [],
        'fragment'    =>'',
    ];


    public function __construct($total,$listRows,$currentPage = null,$options = [])
    {
        $this->options = array_merge($this->options,$options);
        $this->options['path'] = $this->options['path'] != '' ? rtrim($this->options['path'],'') : $this->getCurrentPath();        //当前脚本路径
        $this->listRows = $listRows;
        $this->total = $total;
        $this->lastPage = (int)ceil($total / $listRows);        //总数/每页展示数 = 最后一页的页数
        $this->currentPage = $this->getCurrentPage();    //获取当前页码
        $this->hasNext = ($this->currentPage < $this->lastPage);    //当前页小于下一页则表示有下一页
    }
    public function listRows()
    {
        return $this->listRows;
    }

    public function lastPage()
    {
        return $this->lastPage;
    }

    public static function getCurrentPath()
    {
        return $_SERVER['PHP_SELF'];    //返回当前脚本路径
    }
    public static function getCurrentPage($varPage='page',$default=1)
    {
        $page = isset($_GET[$varPage]) ? (int)$_GET[$varPage] : $default;    //通过$_GET从url中获取page页码，默认为1
        return $page;
    }

    protected function buildUrl($page)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $parameters = [$this->options['var_page'] => $page];        //构造url参数，如 page=1
        if (count($this->options['query']) > 0) {        //如果还有其他url参数，添加参数数组
            $parameters = array_merge($this->options['query'],$parameters);
        }
        $url = $this->options['path'];    //分页的url地址
        if (!empty($parameters)) {        //处理参数。拼接参数 ?xx=aa&yy=bb
            $url .= '?' . urldecode(http_build_query($parameters,null,'&'));
        }
        return $url . $this->buildFragment();        //拼接锚点 #
    }

    public function fragment($fragment)
    {
        $this->options['fragment'] = $fragment;
        return $this;
    }
    protected function buildFragment()
    {
        //是否存在锚点信息，若有则拼接，如：#top
        return $this->options['fragment'] ? '#' . $this->options['fragment'] : '' ;
    }

    public function getUrlRange($start,$end)
    {
        $urls = [];        //存储区间内urls
        for ($page=$start; $page <= $end; $page++) {
            $urls[$page] = $this->buildUrl($page);    //每个页码都生成url
        }
        return $urls;
    }
    public function getPageLinkWrapper($page,$url)
    {
        if ($page == $this->currentPage()) {        //当前页的页码按钮不可点击，是已激活按钮
            return $this->getActiveWrapper($page);    //提供页码，生成激活按钮
        }
        return $this->getAvaliablePageWrapper($page,$url);    //提供页码和链接其他可点击按钮
    }

    public function getActiveWrapper($text)
    {
        return '<li class="active"><span>'.$text.'</span></li>';
    }

    public function getAvaliablePageWrapper($text,$url)
    {
        return '<li><a href="'.htmlentities($url).'">'.$text.'</a></li>';
    }

    public function getDisabledTextWrapper($text)
    {
        return '<li class="disable"><span>'.$text.'</span></li>';
    }

    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');    //不可点击按钮
    }

    public function getPreviousButton($text='&laquo;')
    {
        if ($this->currentPage() <= 1) {    //根据当前页判断生成上一页按钮的样式
            return $this->getDisabledTextWrapper($text);    //第一页，上一页不可点击
        }
        $url = $this->buildUrl($this->currentPage() - 1);    //大于第一页，上一页=当前页-1，根据页码再生成url
        return $this->getPageLinkWrapper($text,$url); //将文字和url传入，生成按钮
    }

    public function getNextButton($text='&raquo;')
    {
        if (!$this->hasNext) {    //判断是否有下一页
            return $this->getDisabledTextWrapper($text);    //无下一页，生成禁用按钮样式
        }
        $url = $this->buildUrl($this->currentPage() + 1);    //有下一页，下一页=当前页+1，获取url
        return $this->getPageLinkWrapper($text,$url);    //传入文本和url，生成按钮
    }

    public function hasPages()
    {
        return !($this->currentPage == 1 && !$this->hasNext);
    }

    public function getUrlLinks($urls)
    {
        $html = '';
        foreach ($urls as $key => $value) {
            $html .= $this->getPageLinkWrapper($key, $value);        //将传入的urls批量生成普通页码按钮，并组装
        }
        return $html;
    }

    public function getLinks()
    {
        $block = [
            'first' => null,    //头部，最左边的部分
            'slider' => null,    //滑块部分，中间的部分，跟随页码变动
            'last'    => null,    //尾部，最右边的部分
        ];
        $side = 3;    //当前页码两边各有多少个页码 上图：当前第八页，左边567，右边9 10 11
        $window = $side * 2;    //头部和尾部的页码数，上图，当前第八页，头部12.. 尾部 ... 15 16

        if ($this->lastPage < $window + 6) {    //如果总页数小于12
            $block['first'] = $this->getUrlRange(1,$this->lastPage);    //头部页码 1---总页数
        } elseif ($this->currentPage <= $window) {    //如果当前页小于等于6，头部页码 1---8
            $block['first'] = $this->getUrlRange(1,$window + 2);
        } elseif ($this->currentPage > ($this->lastPage - $window)) { //如果当前页大于最后一页-$window
            $block['first'] = $this->getUrlRange(1,2);
            $block['last'] = $this->getUrlRange($this->lastPage - ($window + 2),$this->lastPage);
        } else {        //拥有头部，滑块，尾部
            $block['first'] = $this->getUrlRange(1,2);
            $block['slider'] = $this->getUrlRange($this->currentPage - $side,$this->currentPage + $side);
            $block['last'] = $this->getUrlRange($this->lastPage - 1,$this->lastPage);
        }
        $html = '';
        if (is_array($block['first'])) {        //将头部中的url地址转为按钮
            $html .= $this->getUrlLinks($block['first']);    //批量生成按钮获得html代码
        }
        if (is_array($block['slider'])) {        //滑块部分，包含省略号和滑块按钮
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['slider']);
        }
        if (is_array($block['last'])) {        //尾部部分，包含省略号和尾部按钮
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['last']);
        }
        return $html;
    }

    public function currentPage()
    {
        return $this->currentPage;
    }

    public function render()
    {
        if ($this->hasPages()) {
            return sprintf('<ul class="pagination">%s %s %s</ul>',
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            );
        }
    }


}
<?php 

/**
* 分页类
*/
class Pager
{
	protected $total;	//数据集总数
	protected $currentPage;	//当前页
	protected $lastPage;	//最后一页
	protected $listRows;	//每页展示的数量
	protected $hasNext;	//是否有下一页
	protected $hasPre;	//是否有上一页
	protected $options = [	//操作配置
		'var_page' => 'page',
		'path'		=> 'index.php',
		'query'		=> [],
		'fragment'	=>'',
	];

	public function __construct($total,$listRows,$currentPage = null,$options = [])
	{
		$this->options = array_merge($this->options,$options);
		$this->options['path'] = $this->options['path'] != '' ? rtrim($this->options['path'],'') : $this->getCurrentPath();
		$this->listRows = $listRows;
		$this->total = $total;
		$this->lastPage = (int)ceil($total / $listRows);
		$this->currentPage = $this->getCurrentPage();
		$this->hasNext = ($this->currentPage < $this->lastPage);
	}

	protected function buildUrl($page)
	{
		if ($page <= 0) {
			$page = 1;
		}
		$parameters = [$this->options['var_page'] => $page];
		if (count($this->options['query']) > 0) {
			$parameters = array_merge($this->options['query'],$parameters);
		}
		$url = $this->options['path'];
		if (!empty($parameters)) {
			$url .= '?' . urldecode(http_build_query($parameters,null,'&'));
		}
		return $url . $this->buildFragment();
	}

	public static function getCurrentPage($varPage='page',$default=1)
	{
		$page = isset($_GET[$varPage]) ? (int)$_GET[$varPage] : $default;
		return $page;
	}

	public static function getCurrentPath()
	{
		return $_SERVER['PHP_SELF'];
	}

	public function listRows()
	{
		return $this->listRows;
	}

	public function currentPage()
	{
		return $this->currentPage;
	}

	public function lastPage()
	{
		return $this->lastPage;
	}

	public function hasPages()
	{
		return !($this->currentPage == 1 && !$this->hasNext);
	}

	public function getUrlRange($start,$end)
	{
		$urls = [];
		for ($page=$start; $page <= $end; $page++) { 
			$urls[$page] = $this->buildUrl($page);
		}
		return $urls;
	}

	public function fragment($fragment)
	{
		$this->options['fragment'] = $fragment;
		return $this;
	}

	protected function buildFragment()
	{
		return $this->options['fragment'] ? '#' . $this->options['fragment'] : '' ; 
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

	public function getPreviousButton($text='&laquo;')
	{
		if ($this->currentPage() <= 1) {
				return $this->getDisabledTextWrapper($text);
		}
		$url = $this->buildUrl($this->currentPage() - 1);
		return $this->getPageLinkWrapper($text,$url);
	}

	public function getNextButton($text='&raquo;')
	{
		if (!$this->hasNext) {
			return $this->getDisabledTextWrapper($text);
		}
		$url = $this->buildUrl($this->currentPage() + 1);
		return $this->getPageLinkWrapper($text,$url);
	}

	public function getLinks()
	{
		$block = [
			'first' => null,	//
			'slider' => null,
			'last'	=> null,
		];
		$side = 3;
		$window = $side*2;

		if ($this->lastPage < $window + 6) {
			$block['first'] = $this->getUrlRange(1,$this->lastPage);
		} elseif ($this->currentPage <= $window) {
			$block['first'] = $this->getUrlRange(1,$window + 2);
		} elseif ($this->currentPage > ($this->lastPage - $window)) {
			$block['first'] = $this->getUrlRange(1,2);
			$block['last'] = $this->getUrlRange($this->lastPage - ($window + 2),$this->lastPage);
		} else {
			$block['first'] = $this->getUrlRange(1,2);
			$block['slider'] = $this->getUrlRange($this->currentPage - $side,$this->currentPage + $side);
			$block['last'] = $this->getUrlRange($this->lastPage - 1,$this->lastPage);
		}
		$html = '';
		if (is_array($block['first'])) {
			$html .= $this->getUrlLinks($block['first']);
		}
		if (is_array($block['slider'])) {
			$html .= $this->getDots();
			$html .= $this->getUrlLinks($block['slider']);
		}
		if (is_array($block['last'])) {
			$html .= $this->getDots();
			$html .= $this->getUrlLinks($block['last']);
		}
		return $html;
	}

	/**
	 * 批量生成url
	 * @param  [type] $urls [批量url]
	 * @return [type]       [array]
	 */
	public function getUrlLinks($urls)
	{
		$html = '';
		foreach ($urls as $key => $value) {
			$html .= $this->getPageLinkWrapper($key, $value);
		}
		return $html;
	}

	/**
	 * 生成省略号按钮
	 * @return [type] [description]
	 */
    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }

    /**
     * 生成普通页码按钮
     * @param  [type] $url  [description]
     * @param  [type] $page [description]
     * @return [type]       [description]
     */
    public function getPageLinkWrapper($page,$url)
    {
    	if ($page == $this->currentPage()) {
    		return $this->getActiveWrapper($page);
    	}
    	return $this->getAvaliablePageWrapper($page,$url);
    }

    /**
     * 激活按钮
     * @param  string $text [展示文字]
     * @return string       激活的标签
     */
    public function getActiveWrapper($text)
    {
    	return '<li class="active"><span>'.$text.'</span></li>';
    }

    /**
     * 禁用按钮
     * @param  string $text 展示文字
     * @return string       禁用的标签
     */
    public function getDisabledTextWrapper($text)
    {
    	return '<li class="disable"><span>'.$text.'</span></li>';
    }

    /**
     * 可激活的按钮
     * @param  页码或文字 $page 展示文字
     * @param  strin $url  标签的链接
     * @return string       可激活标签
     */
    public function getAvaliablePageWrapper($page,$url)
    {
    	return '<li><a href="'.htmlentities($url).'">'.$page.'</a></li>';
    }
}


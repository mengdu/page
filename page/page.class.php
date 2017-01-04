<?php
class Page{
	//当前页码
	private $page;
	//总数据长度
	private $total;
	//页数
	private $pages;
	//当前页查询字符串key
	private $queryPage = "page";
	//显示长度查询字符串key
	private $queryRows = "rows";
	//显示数据条数
	private $rows = 10;
	//当前url路径
	private $path;
	//当前查询字符串
	private $query = "";
	//分页显示长度
	private $len = 5;
	//分页类名
	private $classStr = "pagination";
	function __construct($total = 0 , $rows = 10){
		$this->total = $total;
		$this->rows = $rows;
		$this->setUri();
		$this->init();
	}
	//初始化
	private function init(){
		//设置当前页显示数据数量
		$this->rows = (!empty($_GET[$this->queryRows]) ? $_GET[$this->queryRows] : $this->rows);
		//设置当前页码
		$this->page = $_GET[$this->queryPage] ? $_GET[$this->queryPage] : 1;
		$this->resize();
	}
	//设置翻页查询字符串
	public function setPageQuery($val){
		$this->queryPage = $val;
		$this->init();
	}
	//设置数据量查询字符串
	public function setRowQuery($val){
		$this->queryRows = $val;
		$this->init();
	}
	//设置总数据长度
	public function setTotal($val){
		$this->total = $val > 0 ? $val : 0;
		$this->init();
	}
	//设置类名
	public function setClassName($str , $bool = false){
		if($bool){
			return $this->classStr = $str;
		}else{
			return $this->classStr = $this->classStr.' '.$str;
		}
	}
	//设置path
	public function setPath($path){
		return $this->path = $path;
	}
	//设置显示数量
	public function setRows($val){
		$this->rows = $val > 0 ? $val : 1;
		$this->resize();
	}
	//获取uri
	private function setUri(){
		//获取uri 以'?'分割成数组
		$uri = parse_url( $_SERVER["REQUEST_URI"] );
		$this->path = $uri['path'];
		/*if(isset($uri["query"])){
			//把提交部分转成索引数组
			parse_str($uri["query"],$params);
			//当前页查询字符串去掉
			unset($params[$this->queryPage]);
			//连接查询字符串
			$this->query = http_build_query($params);
		}*/
	}
	//获取总数据长度
	public function getTotal(){
		return $this->total;
	}
	//获取本页数据长度
	public function getCount(){
		$num = $this->page*$this->rows ;
		return $num > $this->total ? $num-$this->total : $this->rows;
	}
	//获取页数
	public function getPages(){
		return $this->pages;
	}
	//获取实际的当前页码
	public function getActivePage(){
		return $this->page;
	}
	
	//生成uri
	private function getUrl($key="", $val=""){
		if(empty($key)){
			return $this->path;
		}else{
			return $this->path.'?'.(empty($this->query) ? $key.'='.$val : $this->query.'&'.$key.'='.$val);
		}
		
	}
	//计算页数
	private function resize(){
		$this->pages = ceil($this->total/$this->rows);
		//防止页码超出范围
		if($this->page > $this->pages){
			$this->page = $this->pages;
		}
		if($this->page <= 0){
			$this->page = 1;
		}
	}
	//上一页
	private function lastPage(){
		$page = ($this->page - 1) > 0 ? $this->page : "";

		if($page){
			//$this->appends($this->queryPage, $page-1);
			return '<li><a href="'.$this->getUrl($this->queryPage, $page-1).'">&laquo;</a></li>';
		}else{
			return '<li class="disabled"><a href="#">&laquo;</a></li>';
		}
	}
	//数字页
	private function pageList(){
		
		$start = $this->page-ceil($this->len/2);
		$end = $this->page+ceil($this->len/2);

		$start = ($start <= 0) ? 1 : $start;
		$end = $end > $this->pages ? $this->pages : $end;
		
		$html = "";
		$i = $start;
		for(;$i <= $end ; $i++ ){
			if($this->page == $i){
				$html .= '<li class="active"><a href="#">'.$i.'</a></li>';
			}else{
				
				$html .= '<li><a href="'.$this->getUrl($this->queryPage, $i).'">'.$i.'</a></li>';
			}
		}

		return $html;
	}
	//下一页
	private function nextPage(){
		$page = ($this->page-$this->pages) > -1 ? "" : $this->page;
		if($page){
			//$this->appends($this->queryPage, $page+1);
			return '<li><a href="'.$this->getUrl($this->queryPage, $page+1).'">&raquo;</a></li>';
		}else{
			return '<li class="disabled"><a href="#">&raquo;</a></li>';
		}
	}
	//增加查询字符串
	public function appends($key, $val = ""){
		if(!is_array($key) && !is_string($key)){
			return false;
		}
		//如果第一个参数是个数组
		if(is_array($key)){
			foreach($key as $k => $v){
				if(is_string($k)){
					$this->query .= ($this->query == "") ? $k.'='.$v : '&'.$k.'='.$v;
				}
			}
		}else{
			$this->query .= ($this->query == "") ? $key.'='.$val : '&'.$key.'='.$val;
		}
		return true;
	}
	//获取分割参数
	public function limit(){
		$start = ($this->page - 1) * $this->rows;
		$end = ($this->page == $this->pages) ? $this->total - $start : $this->rows;

		return array($start, $end);
	}
	//输出sql字符串
	public function sql(){
		//$limit = ($this->page - 1) * $this->rows;
		//return ' limit '.$limit.','.$this->rows.' ';
		$limit = $this->limit();
		return ' limit '.$limit[0].','.$limit[1].' ';
	}
	//输出分页
	public function links(){
		$html = '<ul class="'.$this->classStr.'">';

		$html .= $this->lastPage();
		$html .= $this->pageList();
		$html .= $this->nextPage();

		$html .= '</ul>';
		return $html;
	}
	//简单分页
	public function simpleLinks(){
		$html = '<ul class="'.$this->classStr.'">';

		$html .= $this->lastPage();
		$html .= $this->nextPage();

		$html .= '</ul>';
		return $html;
	}
	//返回当前分页查询字符串
	public function query(){
		return array(
			$this->queryRows => $this->rows,
			$this->queryPage => $this->page,
			);
	}

}

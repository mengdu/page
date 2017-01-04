<?php
require_once('page/page.class.php');
echo "<pre>";

$page = new Page(50,8);


$page->appends('key','val');
$page->appends('rows',$_GET['rows']);

//$page->setTotal(70);
//$page->setClassName('page-style-btn');
//$page->setClassName('page-style-link');

//$page->setPath('custom/url');

echo "<div class='pre'>";
echo "sql:".$page->sql().'<br>';
echo "共:".$page->getPages().'页 <br>';
echo "第:".$page->getActivePage().'页 <br>';
echo "本页:".$page->getCount().'条 <br>';
echo "总:".$page->getTotal().'条 <br>';
echo "<br>";
echo "</div>";


//print_r($page);
echo "</pre>";

// echo '<link href="http://www.e.com/github%20pages/tpl/blog/css/bootstrap.min.css" rel="stylesheet">';
echo '<link href="page.css" rel="stylesheet">';
echo "<style>body{font-family:'微软雅黑';font-size:0.9em;}.pre{padding:10px;border: solid 1px #dcdcdc;
    border-radius: 3px;
    background: #f3f3f3;}</style>";

//第二个分页
$p = new Page();
$p->setTotal(123);
//如果同一页面存在多个分页必须重新定义查询字符串
$p->setPageQuery('p');
$p->setRowQuery('r');




//如果同一页面存在多个分页，需要这样设置
$p->appends($page->query());

$page->appends($p->query());

//输出第一个分页
echo $p->links().'<br>';
//输出第二个分页
echo $page->links().'<br>';

//简单分页
echo $p->simpleLinks().'<br>';
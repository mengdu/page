<link href="../css/pagination.css" rel="stylesheet">
<style>
  body {
    background: #f5f5f5;
    color: #43505a;
  }
  .demo-box {
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    margin-bottom: 20px;
  }
  .demo-box .title {
    margin: 10px 0;
    margin-bottom: 20px;
    font-size: 1rem;
  }
  .has-border.m-pagination .m-pagination-prev,
  .has-border.m-pagination .m-pagination-next,
  .has-border.m-pagination .m-pager-number {
    border: solid 1px #673ab7;
    background: #fff;
    color: #673ab7;
  }
  .has-border.m-pagination .m-pager-number.active {
    background: #673ab7;
    border: solid 1px #673ab7;
  }
</style>
<?php
include_once('../src/pagination.class.php');

$pageSize = abs($_GET['pageSize']);
$pageSize = $pageSize ? $pageSize : 10;

$page = new Pagination(2000, $pageSize);


$page->pagerCount = 8;
$page->prevText = '上一页';
$page->nextText = '下一页';

echo '<div class="demo-box">';
echo '<h3 class="title">完整例子</h3>';
echo $page->links();

echo '<h3 class="title">分页布局控制</h3>';
echo $page->links(['pager', 'prev', 'next', 'sizes']);

echo '<h3 class="title">简单分页</h3>';
echo $page->simpleLinks();

echo '</div>';

echo '<div class="demo-box">';
echo '<h3 class="title">自定义样式</h3>';

$page2 = new Pagination(500);

$page2->containerClassName = 'has-border';

// 多个分页同一个页面需要区分下分页参数
$page2->setQueryField([
  'page' => 'p',
  'size' => 's'
]);

$page2->setQueryParams([
  'test' => 123,
  'kw' => 'hello'
]);

echo $page2->links(['pager']);

echo '</div>';
// echo '<pre>';
// print_r($page2);

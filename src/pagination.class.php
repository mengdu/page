<?php
class Pagination {
  // 总数据量
  private $total = 0;
  // 当前页
  private $page = 3;
  // 分页大小
  private $pageSize = 0;
  // 页数
  private $pageCount = 0;
  // 显示页数
  private $pagerCount = 10;
  // 候选页码
  private $pageSizes = [5, 10, 20, 30, 40];
  
  public $prevText = 'Prve';
  public $nextText = 'Next';

  public $queryPageField = 'page';
  public $queryPageSizeField = 'pageSize';

  public $hasPrevMore = false;
  public $hasNextMore = false;

  function __construct ($total, $pageSize = 10) {
    $this->total = abs($total);
    $this->pageSize = $pageSize ? abs($pageSize) : 10;

    $this->resize();
  }

  private function resize () {
    $this->pageCount = intval(ceil($this->total / $this->pageSize));

    if ($this->page > $this->pageCount) {
      $this->page = $this->pageCount;
    }
  }

  public function setPageSizes ($sizes) {
    if (!is_array($sizes)) {
      throw new Exception('One param must be an Array.');
    }

    $this->pageSizes = $sizes;
  }

  private function pager () {
    $pagerCount = $this->pagerCount;
    $pageCount = $this->pageCount;
    $currentPage = $this->page;

    $halfPagerCount = floor(($pagerCount - 1) / 2);
  
    $showPrevMore = false;
    $showNextMore = false;
    

    if ($pageCount > $pagerCount) {
      if ($currentPage > $pagerCount - $halfPagerCount) {
        $showPrevMore = true;
      }
      if ($currentPage < $pageCount - $halfPagerCount) {
        $showNextMore = true;
      }
    }

    $pagers = [];
  
    if ($showPrevMore && !$showNextMore) {
      $startPage = $pageCount - ($pagerCount - 2);
      for ($i = $startPage; $i < $pageCount; $i++) {
        array_push($pagers, $i);
      }
    } else if (!$showPrevMore && $showNextMore) {
      for ($i = 2; $i < $pagerCount; $i++) {
        array_push($pagers, $i);
      }
    } else if ($showPrevMore && $showNextMore) {
      $offset = floor($pagerCount / 2) - 1;
      for ($i = $currentPage - $offset; $i <= $currentPage + $offset; $i++) {
        array_push($pagers, $i);
      }
    } else {
      for ($i = 2; $i < $pageCount; $i++) {
        array_push($pagers, $i);
      }
    }

    $this->hasPrevMore = $showPrevMore;
    $this->hasNextMore = $showNextMore;

    return $pagers;
  }

  function link ($text) {
    print_r($_SERVER["REQUEST_URI"]);

    return '<a href="#">'. $text .'</a>';
  }

  private function pagerHTML () {
    $pagers = $this->pager();
    $htmls = ['<ul class="m-pager">'];

    if ($this->pageCount > 0) {
      array_push($htmls, '<li class="m-pager-number'. ($this->page === 1 ? ' active' : '') .'">'. $this->link('1') .'</li>');
    }

    if ($this->hasPrevMore) {
      array_push($htmls, '<li class="m-pager-number">&laquo;</li>');
    }

    $len = count($pagers);

    for ($i = 0; $i < $len; $i++) {
      array_push($htmls, '<li class="m-pager-number '. ($this->page === $pagers[$i] ? ' active' : '') .'">'. $pagers[$i] .'</li>');
    }

    if ($this->hasNextMore) {
      array_push($htmls, '<li class="m-pager-number">&raquo;</li>');
    }

    if ($this->pageCount > 0) {
      array_push($htmls, '<li class="m-pager-number'. ($this->page === $this->pageCount ? ' active' : '') .'">'. $this->pageCount .'</li>');
    }

    array_push($htmls, '</ul>');
    return join('', $htmls);
  }

  private function sizesHTML () {
    $htmls = ['<select class="m-pagination-sizes">'];
    $len = count($this->pageSizes);

    for ($i = 0; $i < $len; $i++) {
      array_push($htmls, '<option value="'. $this->pageSizes[$i] .'">'. $this->pageSizes[$i] .' 条/页</option>');
    }

    array_push($htmls, '</select>');

    return join('', $htmls);
  }

  private function nextHTML () {
    return '<a href="#" class="m-pagination-next" '. ($this->page >= $this->pageCount ? 'disabled="disabled"' : '') .'>'. $this->nextText .'</a>';
  }

  private function prevHTML () {
    return '<a href="#" class="m-pagination-prev" '. ($this->page <= 1 ? 'disabled="disabled"' : '') .'>'. $this->prevText .'</a>';
  }

  // 输出分页
  function links ($layouts = ['total', 'sizes', 'prev', 'pager', 'next']) {
    $layoutMap = [
      'total' => '<span class="m-pagination-total">共'. $this->total .'条</span>',
      'sizes' => $this->sizesHTML(),
      'prev' => $this->prevHTML(),
      'pager' => $this->pagerHTML(),
      'next' => $this->nextHTML()
    ];

    $htmls = ['<div class="m-pagination is-background">'];

    if (!is_array($layouts)) {
      throw new Exception('One params must be an Array.');
    }

    $len = count($layouts);

    for ($i = 0; $i < $len; $i++) {
      array_push($htmls, ($layoutMap[$layouts[$i]] ? $layoutMap[$layouts[$i]] : $layouts[$i]));
    }

    array_push($htmls, '</div>');

    return join('', $htmls);
  }
  
  // 简单分页
  function simpleLinks () {}
}

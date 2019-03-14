<link href="../css/pagination.css" rel="stylesheet">
<?php
include_once('../src/pagination.class.php');

$page = new Pagination(100, 9);

print_r($page);
print_r($page->links());


## class
 `Page` 类是一个简单的分页类。
 
 **用法：**
 
 ```php
 $arr = [...];//数据数组
 $rows = 10;//每页显示数据量
 $page = new Page(count($arr), $rows);
 
 $page->links();
 //简单分页（只有‘上一页’，‘下一页’）
 //$page->simpleLinks();
 ```
 
 ## API
 
 `Page::setPageQuery($val)` 设置翻页查询字符串名字，默认`page`
 
 `Page::setRowQuery($val)` 设置显示长度查询字符串名字，默认`rows`
 
 `Page::setTotal($val)` 设置总数据长度
 
 `Page::setClassName($val [,$bool])` 增加分页类名，默认是`pagination`；
 `$bool` 参数可选，如果为true,则会替换
 
 `Page::setPath($path)` 设置分页链接的path字符串
 
 `Page::setRows($val)` 设置每页显示长度
 
 `Page::getTotal()` 获取总的数据长度
 
 `Page::getCount()` 获取获取本页数据长度(当然这个只是期望值，具体的还要数据库查询结果为准)
 
 `Page::getPages()` 获取总页数
 
 `Page::getActivePage()` 获取当前(真实)页码
 
 `Page::getUrl()` 获取url
 
 `Page::appends($key , $val)` 增加查询字符串到分页链接，$key可以是个索引数组
 
 `Page::limit()` 返回分页参数数组，第一个是开始数据，第二个是偏移数据
 
 `Page::sql()` 返回的构造的limit语句字符串
 
 `Page::query()` 返回分页查询字符串索引数组（同页存在多个分页时结合`Page::appends`有用）
 
 `Page::links()` 返回分页结果html字符串
 
 `Page::simpleLinks()` 返回简单分页结果html字符串
 
 
  
 

 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
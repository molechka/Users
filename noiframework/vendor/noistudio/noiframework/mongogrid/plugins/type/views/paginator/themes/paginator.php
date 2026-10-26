<?
use yii\data\Pagination;

use yii\web\Linkable;
use yii\widgets\LinkPager;
use NoiCore;
$count=  noicms\mongogrid\system_core\MGQuery::count($mg->collection, $mg->condition);
$pages=NoiCore::c("ppaginator")->show($count,$mg->page_item);
 
 
?>
<p><?php echo NoiCore::app()->lang('mongogrid_all');?>:<?php echo $count;?>&nbsp;</p>
<?
echo $pages;
?>



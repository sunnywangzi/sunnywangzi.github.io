<?php
include 'function.php';
$page=intval(@$_POST['page']);
$pagesize=load_config('pagesize');
$offset=($page-1)*$pagesize;
$res=$db->query("select count(id) from content where verify=1 and top<>1")->fetch();
$total=$res[0];
$pages=ceil($total/$pagesize);

$res=$db->query("select * from content where verify=1 and top<>1 order by top desc,addtime desc limit $offset,$pagesize")->fetchAll();
if(!$res) exit('<p class="mt-3 text-danger">没有数据</p>');
foreach($res as $r){
?>
<div class="card mb-3">
  <div class="card-header bg-info text-white"><?php echo date('Y-m-d H:i',$r['addtime']);?></div>
  <div class="card-body">
    <?php if($r['top']==1) echo '<span style="color:#F00;">[置顶]</span>';?>
    <?php echo $r['content'];?>
    <?php if($r['reply']!=''){?>
    <div class="card mt-3">
      <div class="card-header bg-warning text-black">管理员回复</div>
      <div class="card-body">
        <?php echo $r['reply'];?>
      </div>
    </div>
    <?php }?>
  </div>
</div>
<?php
}
?>
<nav aria-label="Page navigation ">
  <ul class="pagination" id="pager">
    <?php
if($page>1){
?>
    <li class="page-item">
      <a href="#<?php echo $page-1;?>" class="page-link" id="prev">上一页</a>
    </li>
    <?php
}
if($pages>$page){
?>
    <li class="page-item">
      <a href="#<?php echo $page+1;?>" class="page-link" id="next">下一页</a>
    </li>
    <?php
}
?>
  </ul>
</nav>
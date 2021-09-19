<?php
include 'function.php';
$res=$db->query("select * from content where verify=1 and top=1 order by top desc,addtime desc limit 0,10")->fetchAll();
if(!$res) exit;
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
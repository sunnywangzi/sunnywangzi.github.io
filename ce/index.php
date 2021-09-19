<?php
include 'function.php';
$name=load_config('name');
$verify=load_config('verify');
?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $name;?> - POWERED BY MATAWORK</title>
  <meta name="renderer" content="webkit">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
</head>
<body>
<div class="container-fluid">

<div class="col-lg-8 offset-lg-2 col-xs-12">
<h1 class="mt-3"><?php echo $name;?></h1>
<form id="myform" class="form">
<div class="form-group">
      <textarea class="form-control" rows="5" id="content" placeholder="留言内容" maxlength="100"></textarea>
</div>
<?php
if(load_config('scode')=='1'){
?>
<div class="form-group">
<input type="text" id="scode" class="form-control" placeholder="验证码">
</div>
<div class="form-group">
<img src="scode.php" alt="点击刷新" title="点击刷新" id="scode_img" style="vertical-align:middle;cursor:pointer;">
</div>
<?php } ?>
<div class="form-group"><button type="submit" class="btn btn-success btn-block">发布留言</button></div>
</form>
<div id="top">

</div>
<div id="list">
数据加载中
</div>
<footer class="mb-5">© 玛塔留言板 2018-2020 <a href="admin/login.php">管理登录</a></footer>
</div>

</div>
</div>

<!--对话框-->

<!-- 模态框 -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
 
      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">系统提示</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
 
      <!-- 模态框主体 -->
      <div class="modal-body" id="msg">
        模态框内容..
      </div>
 
      <!-- 模态框底部 -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
      </div>
 
    </div>
  </div>
</div>


<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
$(function(){

	

    $('#scode_img').bind('click',function(){this.src='scode.php?rand='+Math.random();});

    $('#myform').bind('submit',function(){
		if($('#content').val().trim()==''){
			$('#msg').html('请填写留言内容');
			$('#myModal').modal('show');
			return false;
		}
		if($('#scode').val()==''){
			$('#msg').html('请填写验证码');
			$('#myModal').modal('show');
			return false;
		}
		$.post('js_post.php',{'content':$('#content').val(),'scode':$('#scode').val(),'rand':Math.random()},function(data){
			
			if(data=='success'){
				$('#content').val('');
				$('#scode').val('');
				$('#scode_img').attr('src','scode.php?rand='+Math.random());
				offset=0;
				<?php if($verify==1){?>
				$('#msg').html('留言已经提交请等待管理员审核');
				$('#myModal').modal('show');
				<?php }?>
				load_content();
			}
			if(data=='scode'){
				$('#scode').val('');
				$('#msg').html('验证码有误');
				$('#myModal').modal('show');
			}
		});
		return false;
	});

	$(window).bind('hashchange',function(){
		load_content();
	});




	function load_content(){

		var page=window.location.hash;
		page=page.replace('#','');
		if(page=='') page=1;

		$('#list').html('数据加载中');
		
		$.post('js_content.php',{'page':page,'rand':Math.random()},function(data){
			$('#list').html(data);
		});
	}

	function load_top(){
		$.post('js_top.php',{},function(data){
			$('#top').html(data);
		});
	}

	
	load_top();
	load_content();
    

	

});
</script>
</body>
</html>
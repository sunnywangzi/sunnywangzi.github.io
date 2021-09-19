<?php
include '../function.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>系统登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-xs-12 pt-5">
                <h1>玛塔留言板</h1>
                <form method="post" class="form" id="myform">
                    <label for="name">账号:</label>
                    <input type="text" name="name" id="name" value="" class="form-control" required>
                    <br>
                    <label for="pass">密码:</label>
                    <input type="password" name="pass" id="pass" class="form-control" value="" required>
                    <br>

                    <input type="submit" name="" value="登 录" class="btn btn-primary btn-block">

                </form>
                <hr>
                <p>© 2018-2019 玛塔留言板</p>
            </div>
        </div>
    </div>

    <div class="modal fade" id="my-alert">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">系统提示</h4><button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                        账户或密码错误
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $('#myform').bind('submit', function () {
                var pass = $('#pass').val();
                var name = $('#name').val();
                $.post('js_login.php', { 'name': name, 'pass': pass, 'rand': Math.random() }, function (data) {
                    //alert(data);
                    if (data == 'success') {
                        window.location.href = 'index.php';
                    }
                    else {
                        $('#my-alert').modal();
                    }
                });
                return false;
            });
        });
    </script>
</body>

</html>
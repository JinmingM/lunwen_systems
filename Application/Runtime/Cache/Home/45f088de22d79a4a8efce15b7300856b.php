<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <div class="btn-group" role="group" aria-label="..." style="margin-left:1230px" navbar-static-top >
        <?php if(empty($username)): ?><button type="button" class="btn btn-default"><a href="/majinming/index.php/User/login"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><strong>登录</strong> </button>
            <button type="button" class="btn btn-default" ><a href="/majinming/index.php/User/regisiter"><strong>注册</strong> </button>
            <?php else: ?>
            <div style='float:left' ><strong>欢迎你：<?php echo ($username); ?>||<a href='/majinming/index.php/User/logout'>退出</strong></a></div><?php endif; ?>
    </div>
    <br><br>
    <ul class="nav nav-pills nav-justified navbar-static-top">
        <li role="presentation" class=""><a href="/majinming/index.php/Index/index2"><strong>首页</strong></a></li>
        <li role="presentation" class="active"><a href="/majinming/index.php/Lunwen/uploadLunwen"><strong>共享论文上传</strong></a></li>
        <li role="presentation" class="active"><a href="/majinming/index.php/Lunwen/download"><strong>共享论文下载</strong></a></li>

        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <strong> 用户中心</strong> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li role="presentation" ><a href="/majinming/index.php/User/changeupsw">账号管理<span class="glyphicon glyphicon-cog" aria-hidden="true"></a></li>
                <li role="presentation" ><a href="/majinming/index.php/User/grade">积分中心<span class="glyphicon glyphicon-usd" aria-hidden="true"></a></li>
                <li role="presentation" ><a href="/majinming/index.php/User/logout">用户注销<span class="glyphicon glyphicon-off" aria-hidden="true"></a></li>
            </ul>
        </li>
    </ul>

</head>
<body>
<br>
<br>
<br>
<div class="col-xs-4" style="margin-left:50px;width:800px">
    <h2>欢迎你，管理员，你可以选择以下操作：</h2>
    <br>
    <a href="/majinming/Admin.php/Index/index" ><h2>进入后台<span class="glyphicon glyphicon-home" aria-hidden="true"></span></h2></a>
    <br>
    <a href="/majinming/index.php/Index/index2" ><h2>进入论文系统<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></h2></a>
</div>
</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>管理员中心</title>
    <link rel="stylesheet" type="text/css" href="/majinming/Public/houtai/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/majinming/Public/houtai/css/main.css"/>
    <script type="text/javascript" src="_/majinming/Public/houtai/js/libs/modernizr.min.js"></script>
    <div style='float:left' ><strong>欢迎你：<?php echo ($username); ?></strong></a></div>
</head>
<body>
<div class="topbar-wrap white">
    <!--<div class="topbar-inner clearfix">-->
    <div class="topbar-logo-wrap clearfix">
        <h1 class="topbar-logo none"><a href="index.html" class="navbar-brand">管理员中心</a></h1>
    </div>
</div>
</div>
<div class="container clearfix">
    <div class="sidebar-wrap">
        <div class="sidebar-title">
            <h1>菜单</h1>
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-list">
                <li>
                    <a href="/majinming/index.php/Index/index2"><i class="icon-font">&#xe008;</i>首页</a>
                </li>
            </ul>
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-list">
                <li>
                    <a href="#"><i class="icon-font">&#xe008;</i>常用操作</a>
                    <ul class="sub-menu">
                        <li><a href="/majinming/Admin.php/Index/User"><i class="icon-font">&#xe003;</i>人员管理</a></li>
                        <li><a href="/majinming/Admin.php/Index/Lunwen"><i class="icon-font">&#xe005;</i>论文管理</a></li>
                        <li><a href="/majinming/Admin.php/Index/Pinglun"><i class="icon-font">&#xe006;</i>评论管理</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!--/main-->
</div>
</body>
</html>
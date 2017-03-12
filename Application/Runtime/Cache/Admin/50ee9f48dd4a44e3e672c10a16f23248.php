<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>管理员中心—论文</title>
    <link rel="stylesheet" type="text/css" href="/majinming/Public/houtai/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/majinming/Public/houtai/css/main.css"/>
    <link href="/majinming/Public/css/mypage.css" rel="stylesheet" type="text/css"/>
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
    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="index.html" color="#white">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">订单查询</span></div>
        </div>
        <div class="search-wrap">
            <div class="search-content">
                <form action="#" method="post">
                    <table class="search-tab">
                        <tr>
                            <th width="70">关键字:</th>
                            <td><input class="common-text" placeholder="关键字" name="key"  id="" type="text"></td>
                            <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th class="tc" width="5%"></th>
                            <th>论文ID</th>
                            <th>标题</th>
                            <th>用户ID</th>
                            <th>关键字</th>
                            <th>操作</th>
                        </tr>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                <td><h4><?php echo ($i); ?></h4></td>
                                <td><h4><?php echo ($vo["lid"]); ?></h4></td>
                                <td><h4><?php echo ($vo["title"]); ?></h4></td>
                                <td><h4><?php echo ($vo["uid"]); ?></h4></td>
                                <td><h4><?php echo ($vo["key"]); ?></h4></td>
                                <td><h4><a href='/majinming/Admin.php/Index/dellunwen/lid/<?php echo ($vo["lid"]); ?>'>删除</a></h4></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>
                    <div class="pages"><?php echo ($page); ?></div>
                </div>
            </form>
        </div>
    </div>
    <!--/main-->
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $page["title"][$lang]; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        html { 
            overflow-y: scroll; 
            font-size: 100%; 
            -webkit-text-size-adjust: 100%; 
            -ms-text-size-adjust: 100%;
        }
        
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
      
        .jumbotron {
            font-size: 54px;
            margin-bottom: 9px;
            font-weight: bold;
            letter-spacing: -1px;
            line-height: 1;
        }
        
        .input-flex { width: 100%; box-sizing: border-box; min-height: 28px; }
    </style>
    <link href="./css/bootstrap-responsive.css" rel="stylesheet">
    <link href="./css/bootstrap-datatables.css" rel="stylesheet">
    <link href="./css/bootstrap-cleditor.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href=".ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href=".ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href=".ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href=".ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href=".ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#"><?php echo $page["title"][$lang]; ?></a>
          <div class="nav-collapse">
            <ul class="nav">
              <?php foreach ($page["nav"][$lang] as $li): ?>
                <?php if ($li == $content["header"][$lang]): ?>
                <li class="active"><?php else: ?>
                <li><?php endif; ?><a href="#"><?php echo $li; ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container">
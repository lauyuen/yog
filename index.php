<?php

  include("yog.php");

  $yog = new yog();
  // $file = file_get_contents('./test.org');
  // $file = file_get_contents('./essentials.org');
  $file = file_get_contents('./May24.org');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>YOG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<meta http-equiv="refresh" content="30">  -->

    <!-- Le styles -->
    <link href="./fonts/stylesheet.css" rel="stylesheet">
    <link href="./css/bootstrap-journal.css" rel="stylesheet">
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
        
        .tags {
            margin-bottom: 24px;
            text-align: left;
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

    <!--<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">YOG</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="#">Blog</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>-->
    <div class="container">
        <div class="row-fluid">
            <div class="span2">
            </div>

            <div class="span8 offset2">
            <?php echo $yog->yogThis($file);?>
            </div>

            <div class="span2 offset10">
            </div>
        </div>
        <hr>

        <footer>
        <p>Footer Placement</p>
        </footer>
    </div> <!-- /container -->

    <!-- Le javascript
         ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/bootstrap-cleditor.js"></script>
    <script src="js/bootstrap-datatables.js"></script>
    
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <!--<script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>-->
        <script src="https://d3eoax9i5htok0.cloudfront.net/mathjax/latest/MathJax.js?config=default"></script>

    
    <script type="text/javascript">
        $(document).ready(function() {
            $(".collapse").collapse()
            MathJax.Hub.Config({
              tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
            });
            $("#input-en").cleditor();
            $("#input-fr").cleditor();
            $('#example').dataTable( {
                "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                                        "sLengthMenu": "_MENU_<span class=\"add-on\">records per page.</span>",
                                        "sSearch": ""
                }
            } );
            $('.dataTables_length label').attr("class", "input-append");
            $('.dataTables_filter input')
                .attr("placeholder", "Search");
                            $('.dataTables_filter label').attr({"class": "input-prepend", "style" : "margin-bottom: 10px;"})
                .prepend('<span class="add-on"><i class="icon-search"></i></span>');
        } );
    </script>
    
  </body>
</html>
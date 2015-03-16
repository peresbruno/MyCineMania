<?php
define("OBG", '<span style="color:red; font-size: 7px; text-align:top" class="glyphicon glyphicon-asterisk"></span>');
?>
<?php 
if (empty($_GET['pg'])) {
    $_GET['pg'] = "home";
}
?>
<!DOCTYPE html>
<html lang="en" ng-app="MyCineMania">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.13/angular.min.js"></script>
        <title>My Cine Mania</title>

        <!-- Bootstrap core CSS -->
        
        <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="/vendor/bootstrap/css/jumbotron.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/style.css" type="text/css" media="screen" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body ng-controller="mainController">
        <?php if($_GET['pg'] != 'voucher_view'){ ?>
        <?php require_once 'partes/topo.php'; ?>
        <!-- Main jumbotron for a primary marketing message or call to action -->

        <?php if (file_exists($_GET['pg'] . ".php")) { ?>
            <?php require_once $_GET['pg'] . ".php"; ?>
        <?php } else { ?>
            Pagina N&atilde;o Existe
        <?php } ?>
        
        <?php require_once 'partes/base.php'; ?>
        <?php }else{ ?>
            <?php require_once 'voucher_view.php'; ?>
        <?php } ?>
        <!-- Bootstrap core JavaScript
              ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
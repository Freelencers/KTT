<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>KTT | Blank Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <!-- Date Rang Picker -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/font-awesome/css/font-awesome.min.css');?>">
  <!-- Datepicker -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');?>">
  <!-- I Check -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/iCheck/all.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/Ionicons/css/ionicons.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/AdminLTE.min.css');?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/skins/_all-skins.min.css');?>">

  <script src="<?= base_url('assets/plugins/pace/pace.js');?>"></script>
  <link href="<?= base_url('assets/plugins/pace/pace.css');?>" rel="stylesheet" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    .template{
      display: none;
    }
    .pointer{
      cursor: pointer;
    }
  </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <a href="../../index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>KT</b>S</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>KTT</b>SYSTEM</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Lang -->
            <?php
              $lang = "";
              if($this->session->userdata("languaue") == "english"){
                
                $lang = "TH";
              }else{

                $lang = "EN";
              }
            ?>
            <li>
              <a href="#" id="switchLanguau" lang="<?=$lang?>">
                <span class="hidden-xs"><?=$lang?></span>
              </a>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?=base_url('assets/dist/img/avatar5.png');?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?=$fullName;?></span>
              </a>
            </li>
            <li>
              <a href="<?=base_url("index.php/Auth/Access/signOut");?>">
                <i class="fa fa-sign-out"></i>
              </a> 
            </li>
          </ul>
        </div>
      </nav>
    </header>

<!-- Template -->
<table class="template" id="noDataRow">
  <tr>
    <td colspan="{colspan}"><center><?=$this->lang->line("generalNoData")?></center></td>
  </tr>
</table>
<!-- Global variable -->
<script>
  var base_url = "<?=base_url()?>" + "index.php";
  var sessionAccId = "<?=$this->session->userdata("accId")?>";
  var language = "<?=$this->session->userdata("languaue")?>";


</script>
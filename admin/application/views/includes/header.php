<!DOCTYPE html>
<html>
  <head>

    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href='<?php echo base_url(); ?>/assets/dist/css/bootstrap-datetimepicker.min.css' rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/admin.css?<?=time()?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/table.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/neo.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/sscss/bootstrap-notify.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/sscss/styles/alert-bangtidy.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/sscss/styles/alert-blackgloss.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    <style>
      .error{
        color:red;
        font-weight: normal;
      }
      td,a,label,h1,h4,th,p,input{
        color: #000
      }
    </style>
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/head.js?<?=time()?>"></script>
    <script src='<?php echo base_url(); ?>/assets/js/bootstrap-datetimepicker.min.js'></script>
    <script src='<?php echo base_url(); ?>/assets/js/bootstrap-datetimepicker.kr.js'></script>
    <script src="<?php echo base_url(); ?>assets/js/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/ckeditor/sample.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/tooltipsy.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-notify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script src="<?php echo base_url(); ?>assets/select2/js/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/init.js?<?=time()?>"></script>
  </head>

  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>index" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">관리자 패널</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>관리자</b>패널</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

          <!-- <a  class="nav-link"  href="/admin/note" aria-expanded="true" style="padding: 15px 16px;float: left">
            <i class="fa fa-bell-o" style="color: #fff"></i>
          </a> -->
          <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li>
              <a href="<?=base_url()?>registerDeposit">충전관리&nbsp;&nbsp;(<?=getCoinState()?>)<span class="badge badge-danger badge-pill delivery"></span></a>
            </li>
            <li>
              <a href="<?=base_url()?>returnDeposit">환전관리&nbsp;&nbsp;(<?=getMoneyState()?>)<span class="badge badge-danger badge-pill pur"></span></a>
            </li>
            <li>
              <a href="<?=base_url()?>dashboard?order_part=3">1:1문의관리&nbsp;&nbsp;(<?=getPrivateState()?>)<span class="badge badge-danger badge-pill shopping"></span></a>
            </li>

          </ul>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>

                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo "관리자"; ?>
                      <small><?php echo "관리자"; ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url(); ?>loadChangePass" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Change Password</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <?php $board = get_board(); ?>
            <?php
            $m = "/board_settings/Bbs_SetUp_W/editboards/viewmessage/editboard/panel/bbs/viewreq/";
            if(!empty($board)){
              foreach($board as $v){
                $m .= "panel?id=".$v->id."/";
              }
            }
             ?>
            <li class="treeview <?php echo activate_menu($m);?>">
              <a href="<?php echo base_url(); ?>">
                <i class="fa fa-tasks"></i> <span>게시판관리</span></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url()."board_settings"  ?>"><i class="fa fa-circle-o"></i>게시판 설정</a></li>
                <li><a href="<?php echo base_url()."Bbs_SetUp_W"  ?>"><i class="fa fa-circle-o"></i>게시판 등록</a></li>

              <?php if(!empty($board)): ?>
                <?php foreach($board as $value): ?>
                <li  <?php if($this->input->get("board_type") == $value->name) echo "class='active';";  ?>><a href="<?php echo base_url()."panel?id=".$value->name  ?>" >
                  <i class="fa fa-circle-o"></i><?=$value->content?></a></li>
                <?php endforeach; ?>
              <?php endif; ?>
              </ul>
            </li>
            <li class="treeview <?php echo activate_menu("/addNew/registerDepoit/userListing/exitMember/memberLevel/registerDeposit/returnDeposit/deposithistory/editOld/editmemberL/charge/exchange/");?>">
              <a href="<?php echo base_url(); ?>">
                <i class="fa fa-users"></i>
                <span>회원관리</span>
              </a>
              <ul class="treeview-menu">
                <li class="<?=activate_menu("/addNew/userListing/editOld/");?>"><a href="<?php echo base_url()."userListing"  ?>">
                  <i class="fa fa-circle-o"></i>회원리스트</a>
                </li>
                <li class="<?=activate_menu("/registerDeposit/");?>"><a href="<?php echo base_url()."registerDeposit"  ?>">
                  <i class="fa fa-circle-o"></i>충전관리</a>
                </li>
                <li class="<?=activate_menu("/returnDeposit/");?>"><a href="<?php echo base_url()."returnDeposit"  ?>">
                  <i class="fa fa-circle-o"></i>환전관리</a>
                </li>
                <li><a href="<?php echo base_url()."exitMember"  ?>"><i class="fa fa-circle-o"></i>탈퇴회원</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="">
                <i class="fa fa-envelope"></i> <span>SMS관리</span></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="javascript:alert('SMS 서비스추가필요')"><i class="fa fa-circle-o"></i>SMS 전송</a></li>
                <li><a href="<?php echo base_url()."sms_history"  ?>"><i class="fa fa-circle-o"></i>SMS 전송내역</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>SMS 알림문자</a></li>
              </ul>
            </li>

          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

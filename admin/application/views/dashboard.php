<link href="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.css" rel="stylesheet" type="text/css" />
<script>
var vars = [0,0,0,0,0,0,0,0,0,0,0,0];
var vars1 = [0,0,0,0,0,0,0,0,0,0,0,0];
var vars2 = [0,0,0,0,0,0,0,0,0,0,0,0];
var vars3 = [0,0,0,0,0,0,0,0,0,0,0,0];
<?php if(!empty($register_members)): ?>
<?php foreach($register_members as $value):
    $d = $value->cdate;
 ?>
    <?php
        switch ($d) {
            case date("Y")."-01":
                    echo "vars[0]=".$value->c.";";
                break;
            case date("Y")."-02":
                echo "vars[1]=".$value->c.";";
                break;
            case date("Y")."-03":
                echo "vars[2]=".$value->c.";";
                break;
            case date("Y")."-04":
                echo "vars[3]=".$value->c.";";
                break;
            case date("Y")."-05":
                echo "vars[4]=".$value->c.";";
                break;
            case date("Y")."-06":
                echo "vars[5]=".$value->c.";";
                break;
            case date("Y")."-07":
                echo "vars[6]=".$value->c.";";
                break;
            case date("Y")."-08":
                echo "vars[7]=".$value->c.";";
                break;
            case date("Y")."-09":
                echo "vars[8]=".$value->c.";";
                break;
            case date("Y")."-10":
                echo "vars[9]=".$value->c.";";
                break;
            case date("Y")."-11":
                echo "vars[10]=".$value->c.";";
                break;
            case date("Y")."-12":
                echo "vars[11]=".$value->c.";";
                break;

            default:
                # code...
                break;
        }
    ?>
<?php endforeach; ?>
<?php endif; ?>
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        대행종합관리
      </h1>
    </section>
    <section class="content">
      <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div style="float: left;"><h4>1:1문의(미답변: <span class="text-danger text-bold"><?=getPrivateState()?>건</span>)</h4></div>
                        <div style="float: right;"><a href="<?=base_url()?>panel?id=private">더보기</a></div>
                    </div>
                    <div class="body table-responsive no-padding" style="clear: both;">
                        <table class="table table-hover">
                            <tr class="thead-dark">
                                <th>작성자</th>
                                <th>제목</th>
                                <th>일자</th>
                            </tr>
                            <?php if(!empty($private)): ?>
                            <?php foreach($private as $va): ?>
                                <tr>
                                    <td><?=$va->UserName?></td>
                                    <td><a href="viewReq/<?=$va->id?>"><?=$va->title?></a></td>
                                    <td><?=$va->updated_at?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div style="float: left;"><h4>충전관리</h4></div>
                        <div style="float: right;"><a href="<?=base_url()?>panel?id=private">더보기</a></div>
                    </div>
                    <div class="body table-responsive no-padding" style="clear: both;">
                        <table class="table table-hover">
                            <tr class="thead-dark">
                                <th>닉네임</th>
                                <th>충전코인</th>
                                <th>머니</th>
                                <th>일시</th>
                            </tr>
                            <?php if(!empty($private)): ?>
                            <?php foreach($putMoney as $va): ?>
                                <tr>
                                    <td><?=$va->nickname?></td>
                                    <td><?=$va->coin?></td>
                                    <td><?=$va->money?></td>
                                    <td><?=$va->created_at?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h3>회원가입 통계(월별)</h3>
                    </div>
                    <div class="body">
                        <div id="line_register" class="graph"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div style="float: left;"><h4>환전관리</h4></div>
                        <div style="float: right;"><a href="<?=base_url()?>panel?id=private">더보기</a></div>
                    </div>
                    <div class="body table-responsive no-padding" style="clear: both;">
                        <table class="table table-hover">
                            <tr class="thead-dark">
                                <th>닉네임</th>
                                <th>환전할 당근</th>
                                <th>예상금액</th>
                                <th>일시</th>
                            </tr>
                            <?php if(!empty($returnMoney)): ?>
                            <?php foreach($returnMoney as $va): ?>
                                <tr>
                                    <td><?=$va->nickname?></td>
                                    <td><?=$va->bullet?></td>
                                    <td><?=$va->bullet * 70?>(원)</td>
                                    <td><?=$va->created_at?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/chartjs.js"></script>
<script src="<?php echo base_url(); ?>assets/js/morris.js"></script>
<link href="<?php echo base_url(); ?>assets/dist/css/dashboard.css" rel="stylesheet" type="text/css" />


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>픽전적</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <section class="content">
       <div class="row">
          <div class="col-xs-12">
            <table class="table table-bordered table-striped">
              <colgroup>
                <col width="50%"/>
              </colgroup>
               <tr>
                  <td class="text-center">현재연승</td>
                  <td class="text-center"><?=$cur_win?>연승</td>
               </tr>
               <tr>
                  <td class="text-center">전체</td>
                  <td class="text-center">
                    <span class="win"><?=empty($win_room->total->win) ? 0 : $win_room->total->win?></span>승
                    <span class="lose"><?=empty($win_room->total->lose) ? 0 : $win_room->total->lose?></span>패
                  </td>
               </tr>
               <tr>
                  <td class="text-center">파워볼</td>
                  <td class="text-center">
                    <span class="win"><?=empty($win_room->pb->win) ? 0 : $win_room->pb->win?></span>승
                    <span class="lose"><?=empty($win_room->pb->lose) ? 0 : $win_room->pb->lose?></span>패
                  </td>
               </tr>
               <tr>
                  <td class="text-center">숫자합</td>
                  <td class="text-center">
                    <span class="win"><?=empty($win_room->nb->win) ? 0: $win_room->nb->win?></span>승
                    <span class="lose"><?=empty($win_room->nb->lose) ? 0 : $win_room->nb->lose?></span>패
                  </td>
               </tr>
               <tr>
                  <td class="text-center">추천수</td>
                  <td class="text-center">
                    <?=$recommend?>
                  </td>
               </tr>
               <tr>
                  <td class="text-center">누적당근수</td>
                  <td class="text-center">
                    <?=$bullet?>
                  </td>
               </tr>
             </table>
          </div>
      </div>
    </section>
  </body>
</html>

<style>
.win {
    color: red;
}
.lose {
    color: blue;
}
</style>

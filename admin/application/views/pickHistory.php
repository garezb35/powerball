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
                  <td class="text-center"><?=$pick["totalWinFix"]?>연승</td>
               </tr>
               <tr>
                  <td class="text-center">파워볼홀짝</td>
                  <td class="text-center">
                    <span class="<?=$pick["powerballOddEvenWinClass"]?>"><?=$pick["powerballOddEvenWinFix"]?></span>연승, <span class="win"><?=$pick["powerballOddEvenWin"]?></span>승<span class="lose"><?=$pick["powerballOddEvenLose"]?></span>패(<?=$pick["powerballOddEvenRate"]?>)
                  </td>
               </tr>
               <tr>
                  <td class="text-center">파워볼언더오버</td>
                  <td class="text-center">
                    <span class="<?=$pick["powerballUnderOverWinClass"]?>"><?=$pick["powerballUnderOverWinFix"]?></span>연승, <span class="win"><?=$pick["powerballUnderOverWin"]?></span>승<span class="lose"><?=$pick["powerballUnderOverLose"]?></span>패(<?=$pick["powerballUnderOverRate"]?>)
                  </td>
               </tr>
               <tr>
                  <td class="text-center">숫자합홀짝</td>
                  <td class="text-center">
                    <span class="<?=$pick["numberOddEvenWinClass"]?>"><?=$pick["numberOddEvenWinFix"]?></span>연승, <span class="win"><?=$pick["numberOddEvenWin"]?></span>승<span class="lose"><?=$pick["numberOddEvenLose"]?></span>패(<?=$pick["numberOddEvenRate"]?>)
                  </td>
               </tr>
               <tr>
                  <td class="text-center">숫자합언더오버</td>
                  <td class="text-center">
                    <span class="<?=$pick["numberUnderOverWinClass"]?>"><?=$pick["numberUnderOverWinFix"]?></span>연승, <span class="win"><?=$pick["numberUnderOverWin"]?></span>승<span class="lose"><?=$pick["numberUnderOverLose"]?></span>패(<?=$pick["numberUnderOverRate"]?>)
                  </td>
               </tr>
               <tr>
                  <td class="text-center">숫자합대중소</td>
                  <td class="text-center">
                    <span class="<?=$pick["numberPeriodWinClass"]?>"><?=$pick["numberPeriodWinFix"]?></span>연승, <span class="win"><?=$pick["numberPeriodWin"]?></span>승<span class="lose"><?=$pick["numberPeriodLose"]?></span>패(<?=$pick["numberPeriodRate"]?>)
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

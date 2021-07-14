<?php $ss= 0;
   if($pf==null) $ss = $uc;
   if($pf!=null) $ss = $uc-$pf; ?>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>채팅방리스트</h1>
   </section>
   <section class="content">
     <div class="row">
       <div class="col-xs-12 text-right">
         <a href="javascript:fnPopWinCT('<?=base_url()?>chatContent', 'MemNote', 643, 620, 'N');" class="btn btn-primary">모든 채팅글 보기</a>
       </div>
     </div>
      <div class="row my-4">
         <div class="col-xs-12">
            <form id="frmSearch">
                <table class="table table-bordered table-striped">
                   <tr class="thead-dark">
                      <th>번호</th>
                      <th>방제목</th>
                      <th>방장</th>
                      <th><span class="text-danger">최대인원수</span>/<span class="text-primary">현재인원수</span></th>
                      <th>누적당근(알)</th>
                      <th>현재 연승</th>
                      <th>추천수</th>
                      <th>창조일</th>
                      <th class="text-center">픽 전적보기</th>
                      <th class="text-center">채팅방내용보기</th>
                      <th class="text-center"></th>
                   </tr>
                   <?php
                      if(!empty($item))
                      {
                          foreach($item as $record)
                          {
                      ?>
                   <tr class="align-middle">
                      <td><?=$ss ?></td>
                      <td><?=$record->room_connect?></td>
                      <td><a data-toggle="tooltip" class="hastip"  data-uname="<?=$record->nickname?>" data-bullet = "<?=$record->bullet?>"
                         data-userid="<?=$record->userId?>"><?=$record->nickname?></a>
                      </td>
                      <td><span class="text-danger"><?=$record->max_connect?></span>/<span class="text-primary"><?=$record->members?></span></td>
                      <td><?=$record->bullet?></td>
                      <td><?=$record->cur_win?></td>
                      <td><?=$record->recommend?></td>
                      <td><?=$record->created_at?></td>
                      <td><a class="btn btn-block btn-warning" href="javascript:fnPopWinCT('<?=base_url()?>pickChatHistory?roomIdx=<?=$record->roomIdx?>', 'MemNote', 500, 300, 'N');">보기</a></td>
                      <td><a class="btn btn-block btn-warning" href="javascript:fnPopWinCT('<?=base_url()?>chatContent?roomIdx=<?=$record->roomIdx?>', 'MemNote', 643, 620, 'N');">보기</a></td>
                      <td class="text-center">
                         <a class="btn btn-sm btn-danger deleteRoom" href="#" data-id="<?php echo $record->roomIdx; ?>">
                           <i class="fa fa-trash"></i>
                         </a>
                      </td>
                   </tr>
                   <?php
                      $ss=$ss-1;
                      }
                    }
                    ?>
                </table>
            </form>
            <div>
                <?php echo $this->pagination->create_links(); ?>
             </div>
         </div>
      </div>
   </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
  var socketOption = {};
  socketOption['reconnect'] = true;
  socketOption['force new connection'] = true;
  socketOption['sync disconnect on unload'] = true;
  var is_manager = false;
  if('WebSocket' in window)
  {
      socketOption['transports'] = ['websocket'];
  }
  var socket =  null;
  var socket = io(node+"/prefix",socketOption);
   $(document).ready(function(){
     $('.hastip').tooltipsy({
      content: function ($el, $tip) {
         return '<table width="130" cellspacing="5" style="margin-left:10px;"><tbody><tr><td><span class="bold">'+$el.data("uname")+'</span></td></tr><tr><td>· <a href="/editOld/'+$el.data("userid")+'" target="_blank" class="popMem">회원정보보기</a></td></tr> <tr> <td>· <a href="javascript:fnPopWinCT(\'/pickHistory?userid='+$el.data("userid")+'\', \'MemNote\', 500, 300, \'N\');"  class="popMem">픽 전적 보기</a></td></tr></tbody></table>';
     },
     show: function (e, $el) {
         var cur_top = parseInt($el[0].style.top.replace(/[a-z]/g, ''))-20;
         $el.css({
             'top': cur_top + 'px',
             'display': 'block'
         })
     },
     offset: [0, 1],
     css: {
         'padding': '15px',
         'max-width': '200px',
         'color': '#303030',
         'background-color': '#f5f5b5',
         'border': '1px solid #deca7e',
         '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
         '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
         'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
         'text-shadow': 'none',
         'cursor':'pointer'
     }
     });
     $(".deleteRoom").click(function(){
       var confirmation = confirm("Are you sure to delete this room?");

   		if(confirmation)
   		{
        var currentRow = $(this);
         var id = $(this).data("id")
         jQuery.ajax({
       			type : "POST",
       			dataType : "json",
       			url : "/deleteRoom",
       			data : { roomIdx : id }
       			}).done(function(data){
              currentRow.parents('tr').remove();
              socket.emit('closeroom',id);
       		});
        }
     })
   })
</script>

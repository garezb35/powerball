<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>아이템목록</h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
           <table class="table table-bordered table-striped">
              <thead>
                  <tr class="thead-dark">
                   <th class="text-center align-middle">아이디</th>
                   <th class="text-center align-middle">아이템명</th>

                   <th class="text-center align-middle">보너스(경험치)</th>
                   <th class="text-center align-middle">이미지</th>
                   <th class="text-center align-middle">HOT 아이콘</th>
                   <th class="text-center align-middle">가격</th>
                   <th class="text-center align-middle">선물사용</th>
                   <th class="text-center align-middle">묶음단위</th>
                   <th class="text-center align-middle">사용기간</th>
                   <th class="text-center align-middle">상태</th>
                   <th class="text-center align-middle"></th>
                </tr>
              </thead>
              <?php if(!empty($items)): ?>
              <tbody class="wrap">
              <?php foreach($items as $item): ?>
                <tr class="wrap_tr" data-id="<?=$item->id?>">
                   <td class="text-center align-middle"><?=$item->id?></td>
                   <td class="text-center align-middle"><?=$item->name?></td>

                   <td class="text-center align-middle"><?=$item->bonus?></td>
                   <td class="text-center align-middle"><img src="<?=base_url_source().$item->image?>" width="50"/></td>
                   <td class="text-center align-middle">
                    <?php if($item->hot_icon == 1): ?>
                      <img src="<?=base_url_source()."assets/images/powerball/hot.png"?>" width="50"/>
                    <?php endif;?>
                    <?php if($item->hot_icon == 2): ?>
                      <img src="<?=base_url_source()."assets/images/powerball/new.png"?>" width="50"/>
                    <?php endif;?>
                   </td>
                   <td class="text-center align-middle"><?=number_format($item->price)?><?=$item->price_type == 1 ? "(코인)": "(도토리)"?></td>
                   <td class="text-center align-middle"><?=$item->gift_used == 1 ? " 선물가능":""?></td>
                   <td class="text-center align-middle"><?=$item->detail_count?></td>
                   <td class="text-center align-middle"><?=$item->period == 0 ? "일회용" : $item->period?></td>
                   <td class="text-center align-middle"><?=$item->state == 1 ? "사용가능" : ""?></td>
                   <td class="text-center align-middle">
                     <a class="btn btn-sm btn-info" href="<?php echo base_url().'editItem/'.$item->id; ?>">
                       <i class="fa fa-pencil"></i>
                     </a>
                     <?php if($item->state == 1): ?>
                       <a class="btn btn-sm btn-danger deleteItem" href="#" data-id="<?php echo $item->id; ?>" data-state="<?=$item->state?>?">
                         <i class="fa fa-trash"></i>
                       </a>
                     <?php endif;?>
                     <?php if($item->state == 0): ?>
                       <a class="btn btn-sm btn-success deleteItem" href="#" data-id="<?php echo $item->id; ?>" data-state="<?=$item->state?>">
                         복귀
                       </a>
                     <?php endif;?>
                   </td>
                </tr>
              <?php endforeach;?>
              </tbody>
              <?php endif;?>
            </table>
         </div>
       </div>
    </section>
</div>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<style>
.align-middle{
  vertical-align: middle !important;
}
</style>
<script>
	jQuery(document).on("click", ".deleteItem", function(){
    var id = $(this).data("id")
    var state = $(this).data("state")
    jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : "/unuse",
      data : { id : id,state:state}
      }).done(function(data){
        location.reload()
    }).fail(function(xhr){
      console.log(xhr)
    });
  })

</script>

<script type="text/javascript">
  var hitURL =  baseURL + "updateOrderItem";
  var art = new Array();
  $(".wrap").sortable({
  update: function(event, ui) {
    var wrap_tr = $(".wrap_tr");
    art = new Array();
     wrap_tr.each(function( index ) {
      art.push($(this).data("id"));
    }).promise().done( function(){ 
      jQuery.ajax({
      type : "POST",
      url : hitURL,
      data : { ids : art } 
      }).done(function(data){
        console.log(data);
      }).always(function(jqXHR, textStatus) {
        console.log(textStatus);
      });
    });
  }
});
</script>
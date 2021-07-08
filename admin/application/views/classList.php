<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>계급리스트</h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-6">
           <table class="table table-bordered table-striped">
              <tr class="thead-dark">
                 <th class="text-center">등급명</th>
                 <th class="text-center">표시할 등급명</th>
                 <th class="text-center">이미지</th>
                 <th class="text-center">기준경험치</th>
                 <th class="text-center">상태</th>
              </tr>
              <?php if(!empty($classes)): ?>
              <?php foreach($classes  as $v): ?>
                <tr>
                  <td class="text-center"><input type="text"  value="<?=$v->codename?>" onblur="changeClassInfo(<?=$v->id?>,'codename',$(this).val())"/></td>
                  <td class="text-center"><input type="text" value="<?=$v->description?>" onblur="changeClassInfo(<?=$v->id?>,'description',$(this).val())"/></td>
                  <td class="text-center"><img src="<?=base_url_source().$v->value3?>" /></td>
                  <td class="text-center"><input type="number" value="<?=$v->value1?>" onblur="changeClassInfo(<?=$v->id?>,'value1',$(this).val())"/></td>
                  <td class="text-center">
                    <select onchange="changeClassInfo(<?=$v->id?>,'status',$(this).val())">
                      <option <?=$v->status == "Y" ? "selected":""?> value="Y">사용함</option>
                      <option <?=$v->status == "N" ? "selected":""?> value="N">사용안함</option>
                    </select>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php endif;?>
            </talbe>
         </div>
      </div>
    </section>
</div>
<script>
  function changeClassInfo(id,item,value){
    var hitURL = baseURL + "updateClassInfo";
    jQuery.ajax({
    type : "POST",
    dataType : "json",
    url : hitURL,
    data : { id : id,item:item,value:value }
    }).done(function(data){
    });
  }
</script>

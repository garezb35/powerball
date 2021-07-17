<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>환경설정</h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <form name="frmList" id="frmList" method="post" action="<?=base_url()?>updateSet">
              <table class="table table-bordered">
                <colgroup>
                  <col width="230px" />
                </colgroup>
                <tbody class="thead-dark">
                  <tr>
                    <th class="align-middle text-center">
                      사이트 제목
                    </th>
                    <td class="align-middle">
                      <input type="text" name="site_alias" value="<?=$data->site_alias?>" required/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle text-center">
                      사이트 주소
                    </th>
                    <td class="align-middle">
                      <input type="text" name="site_address" value="<?=$data->site_address?>" required/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle text-center">
                      회사명
                    </th>
                    <td class="align-middle">
                      <input type="text" name="company_alias" value="<?=$data->company_alias?>" required/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle text-center">
                      대표
                    </th>
                    <td class="align-middle">
                      <input type="text" name="represent" value="<?=$data->represent?>" required/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle text-center">
                      사업자등록번호
                    </th>
                    <td class="align-middle">
                      <input type="text" name="business" value="<?=$data->business?>" required/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle text-center">
                      주소
                    </th>
                    <td class="align-middle">
                      <input type="text" name="company_address" value="<?=$data->company_address?>"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle text-center">
                      이메일
                    </th>
                    <td class="align-middle">
                      <input type="email" name="email" value="<?=$data->email?>"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle text-center">
                      통신판매업신고
                    </th>
                    <td class="align-middle">
                      <input type="text" name="company_phone" value="<?=$data->company_phone?>"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle text-center">
                      실시간 서버 주소
                    </th>
                    <td class="align-middle">
                      <input type="text" name="node_address" value="<?=$data->node_address?>" required/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle text-center">
                      실명인증 키
                    </th>
                    <td class="align-middle">
                      <input type="text" name="authen_key" value="<?=$data->authen_key?>" required/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-center">
                      금지어
                    </th>
                    <td class="align-middle">
                      <input class="form-control" type="text" name="prohited" value="<?=$data->prohited?>" data-role="tagsinput"/>
                    </td>
                  </tr>
                </tbody>
              </table>
              <a href="javascript:$('#frmList').submit()" class="btn btn-primary">확인</a>
            </form>
         </div>
       </div>
    </section>
  </div>

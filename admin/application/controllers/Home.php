  <?php if(!defined('BASEPATH')) exit('No direct script access allowed');

  require APPPATH . '/libraries/BaseController.php';
  /**
   * Class : Login (LoginController)
   * Login class to control to authenticate user credentials and starts user's session.
   * @author : Kishor Mali
   * @version : 1.1
   * @since : 15 November 2016
   */
  class Home extends BaseController
  {
      /**
       * This is default constructor of the class
       */
      public function __construct()
      {
        parent::__construct();
        $this->global['pageTitle'] = '몬스터파워볼 관리자';
        $this->load->model('base_model');
        $this->global['misses'] = $this->base_model->getSelect("pb_error_round");
        $this->load->helper('form');
        $this->isLoggedIn();
      }


      public function dashboard(){
        $data['private'] = $this->base_model->getReq("private",5,0);
        $data['register_members'] = $this->base_model->getRegsitesCountByM();
        $data["putMoney"] = $this->base_model->getPutMoney(5,0);
        $data["returnMoney"] = $this->base_model->getReturnMoney(5,0);
        $this->loadViews("dashboard", $this->global, $data , NULL);
      }

      public function getPP(){
          echo '<p>example</p>';
      }

    private function set_upload_options($path,$max_size=300000,$encrypt_name = true,$file_name=null)
    {
        $config = array();
        $config['upload_path'] = $path;
        $config['allowed_types'] = '*';
        $config['max_size']      = $max_size;
        $config['overwrite']     = true;
        $config['encrypt_name'] = $encrypt_name;
        if($file_name !=null) $config['file_name'] = $file_name;
        return $config;
    }


    public function privateMes(){
      $data['type']  = 1;
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getReq(1,0,0,$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input")));
      $returns = $this->paginationCompress ( "private/", $records_count,15);
      $data['content'] = $this->base_model->getReq(1,$returns['page'],$returns['segment'],$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input"));
      $this->loadViews("mailView",$this->global,$data,NULL);
    }

    public function after_use(){
      $data['type']  = 2;
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getReq(2,0,0,$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input")));
      $returns = $this->paginationCompress ( "after_use/", $records_count,15);
      $data['content'] = $this->base_model->getReq(2,$returns['page'],$returns['segment'],$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input"));
      $this->loadViews("mailView",$this->global,$data,NULL);
    }

    public function offque(){
      $data['type']  = 3;
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getReq(3,0,0,$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input")));
      $returns = $this->paginationCompress ( "offque/", $records_count,15);
      $data['content'] = $this->base_model->getReq(3,$returns['page'],$returns['segment'],$this->input->get("shCt"),$this->input->get("shCol"),$this->input->get("seach_input"));
      $this->loadViews("mailView",$this->global,$data,NULL);
    }

    public function publicreq(){
      $data['type']  = 4;
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getReq(4,0,0,null,$this->input->get("shCol"),$this->input->get("seach_input")));
      $returns = $this->paginationCompress ( "publicreq/", $records_count,15);
      $data['content'] = $this->base_model->getReq(4,$returns['page'],$returns['segment'],null,$this->input->get("shCol"),$this->input->get("seach_input"));
      $this->loadViews("mailView",$this->global,$data,NULL);
    }

    public function viewMessage($id){
      if(!is_numeric($id))
        return;
      $data['content'] = $this->base_model->getReqById($id);
      if(empty($data['content']))
        return;
      $data['comment'] = $this->base_model->getCommentsByPostId(5,0,$id);
      $data['size'] = sizeof($this->base_model->getSelect("pb_comment",array(array("record"=>"messageId","value"=>$id))));
      $reply_check = $this->base_model->getSelect("pb_message",array(array("record"=>"keys","value"=>$id),array("record"=>"reply","value"=>1)));
      $reply_check = sizeof($reply_check);
      $data["reply_check"] = $reply_check;
      $this->loadViews("viewMessage",$this->global,$data,NULL);
    }

    public function writeComment(){

      $comment = $this->input->post("sCONT");
      $postId= $this->input->post("postId");
      echo $this->base_model->insertArrayData("pb_comment",array(  "messageId"=>$postId,
                                                                    "userId"=>$this->session->userdata('userId'),
                                                                    "content"=>$comment));
    }

    public function writePost($id){
      $this->isLoggedIn();
      $data = $this->input->post();
      $data['fromId'] = 0;
      $data['type'] = $id;
      $data["content"] = $this->input->post("content",false);
      $data["content"] = str_replace("http://".$_SERVER['SERVER_NAME']."/assets/upload","/assets/upload",$data["content"]);
      $insert_id =  $this->base_model->insertArrayData("pb_message",$data);
      redirect("panel?id=".$id);
    }

    public function bbs(){
      $data['btype'] = $this->input->get("btype");
      $data['panel'] = $this->base_model->getSelect("pb_board",array(array("record"=>"name","value"=>$data['btype'])));
      $this->loadViews("bbs",$this->global,$data,NULL);
    }



    public function incomingBank(){
      $data['incomingBank'] = $this->base_model->getBank();
      $this->loadViews("incomingBank",$this->global,$data,NULL);
    }
    public function saveBank(){
      $count=$this->base_model->getBank();
      $data = array("name" =>$this->input->post("name"),
                    "bank" =>$this->input->post("bank"),
                    "number"=>$this->input->post("number"),
                    "updated_date"=>date("Y-m-d H:i"));
      if(sizeof($count) > 0){
        $this->base_model->updateBank($count[0]->id,$data);
      }else{
         $this->base_model->updateBank(0,$data);
      }
      redirect("incomingBank");
    }


    public function mail(){
      $this->load->library('pagination');
      $config['reuse_query_string'] = true;
      $this->pagination->initialize($config);
      $records_count = sizeof($this->base_model->getMail(0,0,0,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shType"),$this->input->get("content")));
      $returns = $this->paginationCompress ( "mail/", $records_count,15);
      $data['mail'] = $this->base_model->getMail(0,$returns['page'],$returns['segment'],$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shType"),$this->input->get("content"));
      $data["uc"] = $records_count;
      $data["pf"] = $returns["segment"];
      $this->loadViews("mail",$this->global,$data,NULL);
    }

    public function viewMail(){
      $id = $this->input->post("id");
      echo json_encode($this->base_model->getMessage($id));
    }

    public function editMail($id){
      $data['editMail'] = $this->base_model->getMessage($id);
      $this->loadViews("editMail",$this->global,$data,NULL);
    }

    public function SaveMail(){
      $data=$this->input->post();
      $id=$data["id"];
      unset($data["id"]);
      $this->base_model->updateDataById($id,$data,"tbl_mail","id");
      redirect("mail");
    }    

    public function updateDeposit(){
      $this->isLoggedIn();
      $sStat = $this->input->post("sStat");
      $userids = explode(",", $this->input->post("userids"));
      $chkReqSeq = $this->input->post("chkReqSeq");
      $js_result = array();
      foreach ($chkReqSeq as $key => $value) {
        if($sStat ==1){
          $this->base_model->updateDeposit($value,$sStat);
          $results  =$this->base_model->getAmountD($value);
          $temp = $this->base_model->increaseAmount($results);
          if(empty($temp[0]))
            continue;
          array_push($js_result,$temp);
        }
        else{
          $this->base_model->updateDeposit($value,$sStat);
        }
     }
     echo json_encode(array("status"=>1,"type"=>"request","result"=>$js_result));
    }


    public function homePage(){
      $data['mobile'] = $this->input->get("mobile")==1 ? 1:0;
      $data['banner'] = $this->base_model->getSelect("banner",array(array("record"=>"type","value"=>1),
                                                                    array("record"=>"mobile","value"=>$data['mobile'])));
      $data["type"] = "homePage";
      $data['banner_type'] = 1;
      $this->loadViews('homePage', $this->global, $data , NULL);
    }

    public function saveBanner(){
      $data= $this->input->post();
      $id = $data['id'];
      $redirect_url = $data['redirect_url'];
      unset($data['id']);
      unset($data['redirect_url']);
      if(empty($id) || $id <=0){
        $return  =  $this->base_model->insertArrayData("banner",$data);
      }
      if(!empty($id) || $id  >0 ){
        $this->base_model->updateDataById($id,$data,"banner","id");
        $return = $id;
      }
      if($return > 0){
        if($_FILES['image']['name'] !=""){
          if($this->input->post("mobile") ==1){
            $this->load->library('upload',$this->set_upload_options("../m/upload/homepage/banner"));
            $this->upload->initialize($this->set_upload_options("../m/upload/homepage/banner"));
          }
          else{
            $this->load->library('upload',$this->set_upload_options("../upload/homepage/banner"));
            $this->upload->initialize($this->set_upload_options("../upload/homepage/banner"));
          }
          if ( ! $this->upload->do_upload('image'))
          {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
            return;
          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($return,array("image"=>$img_data["file_name"]),"banner","id");
          }
        }
        if($_FILES['image1']['name'] !=""){
          $this->load->library('upload',$this->set_upload_options("../upload/homepage/banner"));
          $this->upload->initialize($this->set_upload_options("../upload/homepage/banner"));
          if ( ! $this->upload->do_upload('image1'))
          {
            $error = array('error' => $this->upload->display_errors());

          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($return,array("image1"=>$img_data["file_name"]),"banner","id");
          }
        }
      }
      redirect($redirect_url);
    }

    public function banner_s(){
      $type = $this->input->get("type");
      if(empty($type))
      {
        echo "오류";
        return;
      }
      $data['banner_s'] = $this->base_model->getSelect("banner",array(array("record"=>"type","value"=>$type)),
                                                                array(array("record"=>"order","value"=>"ASC")));
      $this->loadViews('banner_s', $this->global, $data , NULL);
    }

    public function saveBanner_S(){
      $data= $this->input->post();
      $id = $data['id'];
      unset($data['id']);
      if(!empty($id) && $id > 0 ){
        $this->base_model->updateDataById($id,$data,"pb_banner","id");
        $return = $id;
      }
      if(empty($id) || $id <=0){
        $return  =  $this->base_model->insertArrayData("pb_banner",$data);
      }
      if($return > 0){
        if($_FILES['image']['name'] !=""){
          $this->load->library('upload',$this->set_upload_options("D:/xampp/htdocs/powerball/public/assets/upload/banner"));
          $this->upload->initialize($this->set_upload_options("D:/xampp/htdocs/powerball/public/assets/upload/banner"));
          if ( ! $this->upload->do_upload('image'))
          {
            $error = array('error' => $this->upload->display_errors());
            var_dump($_SERVER['DOCUMENT_ROOT']);
            return;
          }
          else
          {
            $img_data = $this->upload->data();
            $this->base_model->updateDataById($return,array("image"=>$img_data["file_name"]),"pb_banner","id");
          }
        }
      }
      redirect("bannerList");
    }

    public function saveHeader(){
      if($_FILES['image']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../template/images",30000,false,"top_logo"));
        $this->upload->initialize($this->set_upload_options("../template/images",30000,false,"top_logo"));
        if ( ! $this->upload->do_upload('image'))
        {
          $error = array('error' => $this->upload->display_errors());

        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById(76,array("image"=>$img_data["file_name"],"type"=>20),"banner","id");
        }
      }
      if($_FILES['image1']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../template/images",30000,false,"top_logo_left"));
        $this->upload->initialize($this->set_upload_options("../template/images",30000,false,"top_logo_left"));
        if ( ! $this->upload->do_upload('image1'))
        {
          $error = array('error' => $this->upload->display_errors());

        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById(76,array("image1"=>$img_data["file_name"],"type"=>20),"banner","id");
        }
      }
       redirect("footer_management");
    }

    public function saveFooter(){
      $this->base_model->updateDataById(77,array("description"=>$this->input->post("content",false),"type"=>21),"banner","id");
      if($_FILES['image']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../template/images",30000,false,"footer_logo"));
        $this->upload->initialize($this->set_upload_options("../template/images",30000,false,"footer_logo"));
        if ( ! $this->upload->do_upload('image'))
        {
          $error = array('error' => $this->upload->display_errors());

        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById(77,array("image"=>$img_data["file_name"],"type"=>21),"banner","id");
        }
      }
      if($_FILES['image1']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../template/images",30000,false,"footer_logo_left"));
        $this->upload->initialize($this->set_upload_options("../template/images",30000,false,"footer_logo_left"));
        if ( ! $this->upload->do_upload('image1'))
        {
          $error = array('error' => $this->upload->display_errors());

        }
        else
        {
          $img_data = $this->upload->data();
          $this->base_model->updateDataById(77,array("image1"=>$img_data["file_name"],"type"=>21),"banner","id");
        }
      }
       redirect("footer_management");
    }

   

  public function popup(){
    $data['popup'] = $this->base_model->getPopup();
    $this->loadViews("popup",$this->global,$data,NULL);
  }

  public function savePopup(){
    $data = $this->input->post();
    $data["content"] = $this->input->post("content",false);
    $id= $data['id'];
    unset($data['id']);
    $terms = $data['terms1']."|".$data['terms2'];
    unset($data['terms1']);
    unset($data['terms2']);
    $data['terms'] = $terms;
    if(!empty($id) && $id > 0 ){
      $this->base_model->updateDataById($id,$data,"tbl_popup","id");
    }
    if(empty($id) || $id <=0){
      $this->base_model->insertArrayData("tbl_popup",$data);
    }
    redirect("/popup");
  }

  public function getHome(){
    $home = $this->input->post("home");
    $dt = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>$home)));
    echo json_encode($dt);
  }

  public function deleteHome(){
    $home = $this->input->post("home");
    $this->isLoggedIn();
    if(!empty($home)):
      $this->base_model->deleteRecordCustom("banner","id",$home);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($home)):
      echo json_encode(array("status"=>false));
    endif;
  }

  public function getBanner(){
    $banner = $this->input->post("banner");
    $dt = $this->base_model->getSelect("pb_banner",array(array("record"=>"id","value"=>$banner)));
    echo json_encode($dt);
  }

  public function deleteBanner(){
    $banner = $this->input->post("banner");
    $this->isLoggedIn();
    if(!empty($banner)):
      $this->base_model->deleteRecordCustom("pb_banner","id",$banner);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($banner)):
      echo json_encode(array("status"=>false));
    endif;
  }

 

  public function editPopup(){
    $popup = $this->input->post("popup");
    $dt = $this->base_model->getSelect("tbl_popup",array(array("record"=>"id","value"=>$popup)));
    echo json_encode($dt);
  }

  public function deletePopup(){
    $popup = $this->input->post("popup");
    $this->isLoggedIn();
    if(!empty($popup)):
      $this->base_model->deleteRecordCustom("tbl_popup","id",$popup);
      echo json_encode(array("status"=>true));
    endif;
    if(empty($popup)):
      echo json_encode(array("status"=>false));
    endif;
  }

  

    public function registerImage(){
      if($_FILES['FILE_NM']['name'] !=""){
        $this->load->library('upload',$this->set_upload_options("../upload/delivery"));
            $this->upload->initialize($this->set_upload_options("../upload/delivery"));
            if ( ! $this->upload->do_upload('FILE_NM'))
          {
             $error = array('error' => $this->upload->display_errors());
             echo json_encode(array("errorId"=>1));
          }
           else
          {
              $img_data = $this->upload->data();
              echo json_encode(array("errorId"=>0,'img'=>$img_data["file_name"]));
          }
      }
    }


  public function verifyDeposit(){
    $security = $this->input->post("security");
    $userId = $this->input->post("userId");
    $history = $this->base_model->getpayHistyBySecurity($security,1);
    $this->base_model->updateDataById($security,array("pending"=>0),"tbl_payhistory","security");
    foreach($history as $value) {
      if($value->type ==4){
        $this->base_model->updateDataById($value->delivery_id,array("add_check"=>0),"tbl_add_price","id");
      }
      else{
        $ins = array();
        if($value->type == 1) {$state = 15;$p="payed_send";$ins = array("state"=>$state,$p=>1,"pays"=>0);}
        if($value->type == 2) {$state = 6;$p="payed_checked";$ins = array("state"=>$state,$p=>1,"pays"=>0);}
        if($value->type == 3) {$state = 21;$p="return_check";$ins = array("state"=>$state,$p=>1,"pays"=>0);}
        if($value->type == 7)
        {
          $state = 6;$ins = array("state"=>$state,"payed_send"=>1,"payed_checked"=>1,"pays"=>0);
        }
        $this->base_model->updateDataById($value->delivery_id,$ins,"delivery","id");
      }
    }

    echo "true";
    return;
  }

  public function cancelDeposit(){
    $security = $this->input->post("security");
    $type = $this->input->post("type");
    $this->base_model->updateDataById($security,array("pending"=>2),"tbl_payhistory","security");
    $history = $this->base_model->getpayHistyBySecurity($security,1);
    if($type ==4) $pending=2;
    else $pending =1;
    if(!empty($history)){
      foreach($history as $value) {
        if(!empty($value->coupon_type)){
          $coupon_type = json_decode($value->coupon_type);
          if(!empty($coupon_type) && sizeof($coupon_type) > 0)
              foreach($coupon_type as $val_coupon){
                $temp = explode("|", $val_coupon);
                if(sizeof($temp) > 1)
                  $this->base_model->updateDataById($temp[1],array("used"=>0),"tbl_coupon_user","code");
            }
        }

        if($value->amount > 0)
        {
          $security = date("ymd").generateRandomString(10);
          $this->base_model->plusValue("tbl_users","deposit",$value->amount,array(array("userId",$value->userId)),"+");
          $this->base_model->insertArrayData("tbl_payhistory",array(
                              "all_amount"=>$value->amount,
                              "payed_date"=>date("Y-m-d H:i"),
                              "amount"=>$value->amount,
                              "payed_type"=>120,
                              "userId"=>$value->userId,
                              "pending"=>0,
                              "pamount"=>0,
                              "security"=>$security,
                              "by"=>1));
        }

        if($value->type!=4) {
          if($value->type ==1) $ss=array("state"=>40,"payed_send"=>0,"pays"=>0);
          if($value->type ==2){

            $ss=array("state"=>4,"payed_checked"=>0,"pays"=>0,"purchase_price" => 0);
            $temp = explode("|", $value->pur_fee);
            if(!empty($value->pur_fee) && !empty($temp[1]))
            {
              $temp[1] = 0;
              $ss["pur_fee"] = implode("|", $temp);
            }
          }
          if($value->type ==3) $ss=array("state"=>19,"return_check"=>0,"pays"=>0);
          if($value->type ==7) $ss=array("state"=>4,"payed_checked"=>0,"payed_send"=>0,"pays"=>0);
          $this->base_model->updateDataById($value->delivery_id,$ss,"delivery","id");
        }
        else
        {
          $this->base_model->updateDataById($value->delivery_id,array("add_check"=>3),"tbl_add_price","id");
          $this->base_model->updateDataById($value->delivery_id,array("pays"=>0),"delivery","id");
        }
      }
    }
    echo "true";
    return;
  }

  public function getDeliveryBySecurity(){
    $security = $this->input->post("security");
    $history = $this->base_model->getpayHistyBySecurity($security,1);
    $ordernum = array();
    foreach ($history as $key => $value) {
      array_push($ordernum,$value->ordernum);
    }
    echo implode(',', $ordernum);
  }

  public function sendMail(){
    $userId = $this->input->get("userid");
    $user = $this->base_model->getSelect("pb_users",array(array("record"=>"userId","value"=>$userId)));
    if(sizeof($user) ==0 ) return;
    $data['user'] = $user[0];
    $this->load->view("sendMail",$data);

  }

  function PopNote_I(){
    $this->base_model->insertArrayData("pb_inbox",$this->input->post());
    echo "<script>alert('발송되였습니다');self.close();</script>";
  }



  

  public function editBoard($id){
    $config['img_path'] = '/assets/upload'; // Relative to domain name
    $img_src = str_replace("/admin","",$_SERVER['DOCUMENT_ROOT']);

    $data['board'] = $this->base_model->getReqById($id);
    $this->loadViews("editBoard",$this->global,$data,NULL);
  }

  public function deleteBoard(){
    $id = $this->input->post("id");
    if(!empty($id))
    {
      $this->base_model->updateDataById($id,array("isDeleted"=>1),"pb_board","id",);
      echo 100;
      return;
    }
    else echo 101;
  }

  public function updateBoard(){
    $data = $this->input->post();

    $id = $data['id'];
    unset($data['id']);

    $data["content"] = $this->input->post("content",false);
    $data["content"] = str_replace("http://".$_SERVER['SERVER_NAME']."/assets/upload","/assets/upload",$data["content"]);
    $board_type = $data["board_type"];
    unset($data["board_type"]);
    $data['notice'] = !empty($this->input->post("notice")) ? $this->input->post("notice"):0;
    $updated_id=$this->base_model->updateDataById($id,$data,"pb_message","id");
    redirect("viewReq/".$id."?board_type=".$board_type);
  }

  public function deleteF(){
    echo delteFile($this->input->post("url"));
  }



  public function addBoard(){
    $id = $this->input->post("id");
    $data = $this->input->post();
    unset($data['id']);
    if($id ==0 )
    {
      $data['nid'] = generateRandomString(5);
      $d = $this->base_model->insertArrayData("pb_board",$data);
    }
    if($id > 0 )
      {
        $this->base_model->updateDataById($id,$data,"pb_board","id");
      }

    redirect("board_settings");
  }
  public function board_settings(){
    $data['board'] = $this->base_model->getSelect("pb_board",null);
    $this->loadViews("board_settings",$this->global,$data,NULL);
  }
  public function editboards($id){
    $data['board'] = $this->base_model->getSelect("pb_board",array(array("record"=>"id","value"=>$id)));
    $this->loadViews("Bbs_SetUp_W",$this->global,$data,NULL);
  }

  public function Bbs_SetUp_W(){
    // $data['role'] = $this->base_model->getSelect("tbl_roles");
    $this->loadViews("Bbs_SetUp_W",$this->global,NULL,NULL);
  }

  public function panel(){
    $id = $_GET['id'];
    $data['panel'] = $this->base_model->getSelect("pb_board",array(array("record"=>"name","value"=>$id)));
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $category = !empty($this->input->get("category")) ? $this->input->get("category"):"";
    $mode = !empty($this->input->get("mode")) ? $this->input->get("mode"):"";
    $shCol = !empty($this->input->get("shCol")) ? $this->input->get("shCol"):"";
    $seach_input = !empty($this->input->get("seach_input")) ? $this->input->get("seach_input"):"";
    $records_count = sizeof($this->base_model->getReq($id,100000,0,$category,$shCol,$seach_input,$mode));
    $returns = $this->paginationCompress ( "/panel", $records_count, 20);
    $data['content'] = $this->base_model->getReq($id,$returns['page'],$returns['segment'],$category,$shCol,$seach_input,$mode);
    $data["uc"] =$records_count;
    $data["pf"] = $returns["segment"];
    $this->loadViews("mailView",$this->global,$data,NULL);
  }

  public function actionUsers(){
    $sKind = $this->input->post("sKind");
    $chkMemCode = $this->input->post("chkMemCode");
    if($sKind =="E"){
      foreach($chkMemCode as $value){
        $this->base_model->deleteRecordCustom("pb_users","userId",$value);
        $this->base_model->deleteRecordCustom("tbl_auto_match","userId",$value);
        $this->base_model->deleteRecordCustom("pb_item_use","userId",$value);
        $this->base_model->deleteRecordCustom("pb_message","userId",array(array("fromId",$value),array("toId",$value)),false,true);
      }
      redirect("exitMember");
    }
    if($sKind =="C"){
      foreach($chkMemCode as $value){
        $this->base_model->updateDataById($value,array("isDeleted"=>0),"pb_users","userId");
        $this->base_model->addLog(2,$value,"",1);
      }
      redirect("exitMember");
    }
    if($sKind =="A"){
      $this->load->library('PHPExcel');
      $fileName = 'Exited User data-'.time().'.xlsx';
      $objPHPExcel = new PHPExcel();
      $objPHPExcel->setActiveSheetIndex(0);
      $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'userId');
      $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Email');
      $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
      $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mobile');
      $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'NickName');
      $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'loginId');
      $rowCount = 2;
      foreach ($chkMemCode as $key => $value) {
        $user = $this->base_model->getSelect("pb_users",array(array("record"=>"userId","value"=>$value)));
        if(!empty($user))
        {
          $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $user[0]->userId);
          $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $user[0]->email);
          $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $user[0]->name);
          $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $user[0]->phoneNumber);
          $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $user[0]->nickname);
          $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $user[0]->loginId);
        }
      }
      $filename = "ExitedUsers_". date("Y-m-d-H-i-s").".csv";
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
      $objWriter->save('php://output');
    }
  }


  public function pages(){
    $data['pages'] = $this->base_model->getSelect("banner", array(array("record"=>"type","value"=>3)),
                                                            array(array("record"=>"order","value"=>"ASC")));
    $this->loadViews("pages",$this->global,$data,NULL);
  }

  public function pages_edit($id){
    $this->load->helper('directory');

    $data['pages'] = $this->base_model->getSelect("banner",array(array("record"=>"type","value"=>3)));
    $data['content'] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>$id)));
    $data['map']= directory_map('../upload/banner/'.$id, FALSE, TRUE);
    $this->loadViews("pages",$this->global,$data,NULL);
  }

  public function addPage(){
    $data = $this->input->post();
    $data["content"] = $this->input->post("content",false);
    $data['header'] = (!isset($data['header']) || $data['header']=="")? 0: $data['header'];
    $data['my'] = (!isset($data['my']) || $data['my']=="") ? 0: $data['my'];
    $data['footer'] = (!isset($data['footer']) || $data['footer']=="") ? 0: $data['footer'];
    $id = $data['id'];
    if(!empty($id) && $id > 0)
    {
      unset($data['id']);
      $this->base_model->updateDataById($id,$data,"banner","id");
      $return = $id;
    }
    else{
      $data['type']=3;
      $return = $this->base_model->insertArrayData("banner",$data);
    }

   redirect("pages_edit/".$return);
  }

  public function NtDet_W(){
    $users = "";
    if(!empty($this->input->get("chkMemCode"))):
      $d = explode(",", $this->input->get("chkMemCode"));
      foreach ($d as $key => $value) {
        $recor = $this->base_model->getSelect("pb_users",array(array("record"=>"userId","value"=>$value)));
        if(!empty($recor))
          $users.=$recor[0]->name.",";
      }
    endif;
    $data['users'] = $users;
    $data['role'] = $this->base_model->getSelect("pb_codedetail",array(array("record"=>"class=","value"=>"0020")));
    $this->load->view("NtDet_W",$data);
  }

  public function multisend(){
    $receman = $this->input->post("receman");
    $title = $this->input->post("title");
    $content  = $this->input->post("content");
    $ids = $this->input->post("ids");
    if(empty($ids)){
      $users = $this->base_model->getSelect("pb_users",array(array("record"=>"isDeleted","value"=>0)));
      foreach($users as $value)
        $this->base_model->insertArrayData("pb_inbox",array(
                                                              "content"=>$content,
                                                              "fromId"=>1,
                                                              "toId"=>$value->userId));
    }
    else{
      $ids = explode(",", $ids);
      foreach ($ids as $key => $value) {
        $this->base_model->insertArrayData("pb_inbox",array(
                                                              "content"=>$content,
                                                              "fromId"=>1,
                                                              "toId"=>$value));
      }
    }
    echo "<script>window.close();</script>";
  }

  public function NtDet_D(){
    $chkNtSeq = $this->input->post("chkNtSeq");
    foreach($chkNtSeq as $value)
    {
      $this->base_model->deleteRecordCustom("tbl_mail","id",$value);
    }
    redirect("mail");
  }
  public function IdChk(){
    $this->isLoggedIn();
    $type = $this->input->get("type");
    if($type == "name")
      $loginId = sizeof($this->base_model->getSelect("pb_users",array(array("record"=>"loginId","value"=>$this->input->get("sMemId")))));
    else
      $loginId = sizeof($this->base_model->getSelect("pb_users",array(array("record"=>"nickname","value"=>$this->input->get("sMemId")))));
    if($loginId == 0) echo '0';
    else echo '1';
  }

  public function Mem_U(){
    $sKind = $this->input->post("sKind");
    $chkMemCode = $this->input->post("chkMemCode");
    $sMemLvlChk =  $this->input->post("level");
    if($sKind =="U"){
      // session_start();
      // $my_session_id = session_id();
      // session_write_close();
      $split_level = explode("-",$sMemLvlChk);
      $this->base_model->updateDataById($chkMemCode,array("level"=>$split_level[0],"exp"=>$split_level[1]+1),"pb_users","userId");
    }
    if($sKind =="D"){
      foreach($chkMemCode as $value){
        $this->base_model->updateDataById($value,array("isDeleted"=>1),"pb_users","userId");
      }
    }

    redirect("userListing");
  }

  public function Mem_X(){
    $this->load->library('PHPExcel');
    $fileName = 'Exited User data-'.time().'.xlsx';
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'userId');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Email');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mobile');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'NickName');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'loginId');
    $rowCount = 2;
    $user = $this->base_model->getSelect("tbl_users",array(array("record"=>"isDeleted","value"=>0)));
    foreach ($user as $key => $value) {
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->userId);
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->email);
      $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->name);
      $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->mobile);
      $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->nickname);
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value->loginId);
      $rowCount++;
    }
    $filename = "Users_". date("Y-m-d-H-i-s").".csv";
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
    $objWriter->save('php://output');
  }

  public function bbs_fl_D(){
    $sFL_SEQ = $this->input->post("sFL_SEQ");
    $id = $this->input->post("id");
    $file_name = "";
    $re = "file".$sFL_SEQ;
    $record = $this->base_model->getSelect("tbl_mail",array(array("record"=>"id","value"=>$id)));
    if(!empty($record)){
      $file_name = $record[0]->$re;
      if(!empty($file_name)){
        delteFile($_SERVER['DOCUMENT_ROOT']."/upload/mail/".$id."/".$file_name);
        $this->base_model->updateDataById($id,array($re=>""),"tbl_mail","id");
      }
    }
    redirect("editBoard/".$id);
  }



  public function getCommentMore(){
    $id = $this->input->post("id");
    $comment_id = $this->input->post("comment_id");
    echo json_encode($this->base_model->getCommentsByPostId(5,$comment_id,$id));
  }

  public function deleteComment(){
    $this->base_model->deleteRecordCustom("pb_comment","id",$this->input->post("id"));
    echo 1;
  }

  // public function ActingExcel_I(){
  //   $this->load->library('PHPExcel');
  //   $data = array();
  //   $this->load->library('upload',$this->set_upload_options("../upload/excel",30000,false));
  //   $this->upload->initialize($this->set_upload_options("../upload/excel",30000,false));
  //   if(isset($_FILES["Multi_FL"]["name"]) && $_FILES["Multi_FL"]["name"]!=""){
  //     if ( ! $this->upload->do_upload('Multi_FL'))
  //       {
  //          $error = array('error' => $this->upload->display_errors());
  //          echo json_encode(array("errorId"=>$this->upload->display_errors()));
  //       }
  //      else
  //     {
  //       $img_data = $this->upload->data();
  //       $inputFileType = PHPExcel_IOFactory::identify($img_data['full_path']);
  //       $objReader = PHPExcel_IOFactory::createReader($inputFileType);
  //       $objPHPExcel = $objReader->load($img_data['full_path']);
  //       $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
  //       if(sizeof($allDataInSheet) < 1 ) {echo "<script>alert('자료가 없습니다.');window.close();</script>";return;}
  //       $temp_id=0;
  //       foreach($allDataInSheet as $key=>$value)
  //       {
  //         $id   = $value['A'];
  //         $des  = $value['B'];
  //         if($id=="" || $des==""){
  //           continue;
  //         }
  //         $this->base_model->updateDataById($id,array("tracking_number"=>$des),"delivery","ordernum");
  //       }
  //     }
  //   }
  //   echo "<script>window.close();</script>";
  // }
   public function downloadI(){
    $this->load->helper('download');
    $sFL_SEQ = $this->input->post("sFL_SEQ");
    $id  = $this->input->post("id");
    $re= $this->base_model->getSelect("tbl_mail",array(array("record"=>"id","value"=>$id)));
    $record = "file".$sFL_SEQ;
    if(!empty($re)){
      $file_name = $re[0]->$record;
      if(!empty($file_name)){
      force_download("../upload/mail/".$id."/".$file_name,NULL);
      }
    }
  }

  public function changeLevel(){
    var_dump($this->base_model->getWillLevel());
  }



  public function updateOrderBanner(){
    $stack = array();
    $ids= $this->input->post("ids");
    foreach($ids as $key=>$value){
      $sql = "UPDATE pb_banner SET pb_banner.order = ".$key."  WHERE id =".$value.";";
      $stack[] = $sql;
    }
    $this->db->trans_start();
    foreach($stack as $value){
      $this->base_model->runSQL($value);
    }
    $this->db->trans_complete();
  }

  public function footer_management(){
    $data["p"] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>'76')));
    $data["p1"] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>'77')));
    $data["p2"] = $this->base_model->getSelect("banner",array(array("record"=>"id","value"=>'78')));
    $this->loadViews("footer_management",$this->global,$data,NULL);
  }

  public function saveMobileHeader(){
    if($_FILES['image']['name'] !=""){
      $this->load->library('upload',$this->set_upload_options(__DIR__."/../../../m/template/images",30000,false,"top_logo"));
      $this->upload->initialize($this->set_upload_options(__DIR__."/../../../m/template/images",30000,false,"top_logo"));
      if ( ! $this->upload->do_upload('image'))
      {
        $error = array('error' => $this->upload->display_errors());
        var_dump($error);

      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById(78,array("image"=>$img_data["file_name"],"type"=>22),"banner","id");
      }
    }
    if($_FILES['image1']['name'] !=""){
     $this->load->library('upload',$this->set_upload_options(__DIR__."/../../../m/template/images",30000,false,"kor_kor"));
      $this->upload->initialize($this->set_upload_options(__DIR__."/../../../m/template/images",30000,false,"kor_kor"));
      if ( ! $this->upload->do_upload('image1'))
      {
        $error = array('error' => $this->upload->display_errors());
         var_dump($error);
      }
      else
      {
        $img_data = $this->upload->data();
        $this->base_model->updateDataById(78,array("image1"=>$img_data["file_name"],"type"=>22),"banner","id");
      }
    }
    redirect("footer_management");
  }


  public function deletePost(){
    $id = $this->input->post("id");
    if(empty($id)) {echo 101;return;}
    $this->base_model->deleteRecordCustom("pb_message","id",$id);
    echo 100;
  }

  public function deleteCustomX(){
    $data = $this->input->post();
    $id = $data["id"];
    if($id > 0 ){
      $this->base_model->deleteRecordCustom("tbl_custom_exchange_rate","id",$id);
      echo 1;
      return;
    }
    echo 0;
  }


  public function changeGrade(){
    $grade = $this->input->post("grade");
    $id = $this->input->post("id");
    $this->base_model->updateDataById($id,array("grade"=>$grade),"tbl_board","id");
    echo 1;
  }


  public function deleteFooterImg(){
    $type = $this->input->post("type");
    $img = $this->input->post("img");
    delteFile($_SERVER['DOCUMENT_ROOT']."/template/images/".$img);
    $this->base_model->updateDataById("77",array($type=>""),"banner","id");
    echo 1;
  }



  public function shop_banner(){
    $data['mobile'] = $this->input->get("mobile")==1 ? 1:0;
    $data['banner_type'] = $this->input->get("type") > 0 ? $this->input->get("type") : 23;
    $data['banner'] = $this->base_model->getSelect("banner",array(array("record"=>"type","value"=>$data['banner_type']),
                                                                    array("record"=>"mobile","value"=>$data['mobile'])),
                                                            array(array("record"=>"order","value"=>"ASC")));
    $data["type"] = "shop_banner";
    $this->loadViews('homePage', $this->global, $data , NULL);
  }



  public function loginlog(){

    $year = empty($this->input->get("year")) ? date("Y") : $this->input->get("year");
    $month =  empty($this->input->get("month")) ? date("m") : $this->input->get("month");

    $data["year"] = $year;
    $data["month"] = $month;

    $data["result"] = $this->base_model->getDayAccess($year,$month);
    $this->loadViews("loginlog",$this->global,$data,NULL);
  }


  

  public function backup(){
    $this->load->dbutil();
    $prefs = array(
        'format'      => 'zip',
        'filename'    => 'buy.sql'
        );


    $backup =& $this->dbutil->backup($prefs);

    $db_name = date("YmdHi") .'.zip';
    $save = 'buy/'.$db_name;

    $this->load->helper('file');
    write_file($save, $backup);


    $this->load->helper('download');
    force_download($db_name, $backup);
  }

  public function pickHistory(){
        $history = array();
        $history["totalWinClass"] = "";
        $history["totalWinFix"] = 0;
        $history["powerballOddEvenWinClass"] = "";
        $history["powerballOddEvenWinFix"] = 0;
        $history["powerballOddEvenWin"] = 0;
        $history["powerballOddEvenLose"] = 0;
        $history["powerballOddEvenRate"] = 0;

        $history["powerballUnderOverWinClass"] = "";
        $history["powerballUnderOverWinFix"] = 0;
        $history["powerballUnderOverWin"] = 0;
        $history["powerballUnderOverLose"] = 0;
        $history["powerballUnderOverRate"] = 0;

        $history["numberOddEvenWinClass"] = "";
        $history["numberOddEvenWinFix"] = 0;
        $history["numberOddEvenWin"] = 0;
        $history["numberOddEvenLose"] = 0;
        $history["numberOddEvenRate"] = 0;

        $history["numberUnderOverWinClass"] = "";
        $history["numberUnderOverWinFix"] = 0;
        $history["numberUnderOverWin"] = 0;
        $history["numberUnderOverLose"] = 0;
        $history["numberUnderOverRate"] = 0;

        $history["numberPeriodWinClass"] = "";
        $history["numberPeriodWinFix"] = 0;
        $history["numberPeriodWin"] = 0;
        $history["numberPeriodLose"] = 0;
        $history["numberPeriodRate"] = 0;

    $userid = $this->input->get("userid");
    $current_user = $this->base_model->getSelect("pb_users",array(array("record"=>"userId","value"=>$userid)))[0];
    $user_win_history = $user_room = $room_history =  array();
    if(!empty($current_user->winning_history)){
      $data = json_decode($current_user->winning_history);
      $history["totalWinFix"] = $data->current_win->p;
            $history["powerballOddEvenWinFix"] = $data->pb_oe->current_win;
            $history["powerballOddEvenWin"] = $data->pb_oe->win;
            $history["powerballOddEvenLose"] = $data->pb_oe->lose;

            if($data->pb_oe->win ==0 && $data->pb_oe->lose ==0){
                $history["powerballOddEvenRate"] = 0;
            }
            else{
                $history["powerballOddEvenRate"] = number_format(100* ($data->pb_oe->win / ($data->pb_oe->win + $data->pb_oe->lose)))."%";
            }

            $history["powerballUnderOverWinFix"] = $data->pb_uo->current_win;
            $history["powerballUnderOverWin"] = $data->pb_uo->win;
            $history["powerballUnderOverLose"] = $data->pb_uo->lose;

            if($data->pb_uo->win ==0 && $data->pb_uo->lose ==0){
                $history["powerballUnderOverRate"] = 0;
            }
            else{
                $history["powerballUnderOverRate"] = number_format(100* ($data->pb_uo->win / ($data->pb_uo->win + $data->pb_uo->lose)))."%";
            }

            $history["numberOddEvenWinFix"] = $data->nb_oe->current_win;
            $history["numberOddEvenWin"] = $data->nb_oe->win;
            $history["numberOddEvenLose"] = $data->nb_oe->lose;

            if($data->nb_oe->win ==0 && $data->nb_oe->lose ==0){
                $history["numberOddEvenRate"] = 0;
            }
            else{
                $history["numberOddEvenRate"] = number_format(100* ($data->nb_oe->win / ($data->nb_oe->win + $data->nb_oe->lose)))."%";
            }

            $history["numberUnderOverWinFix"] = $data->nb_uo->current_win;
            $history["numberUnderOverWin"] = $data->nb_uo->win;
            $history["numberUnderOverLose"] = $data->nb_uo->lose;

            if($data->nb_uo->win ==0 && $data->nb_uo->lose ==0){
                $history["numberUnderOverRate"] = 0;
            }
            else{
                $history["numberUnderOverRate"] = number_format(100* ($data->nb_uo->win / ($data->nb_uo->win + $data->nb_uo->lose)))."%";
            }

            $history["numberPeriodWinFix"] = $data->nb_size->current_win;
            $history["numberPeriodWin"] = $data->nb_size->win;
            $history["numberPeriodLose"] = $data->nb_size->lose;

            if($data->nb_size->win ==0 && $data->nb_size->lose ==0){
                $history["numberPeriodRate"] = 0;
            }
            else{
                $history["numberPeriodRate"] = number_format(100* ($data->nb_size->win / ($data->nb_size->win + $data->nb_size->lose)))."%";
            }
    }

    $data = array("pick"=>$history,"user"=>$current_user);
    $this->load->view("pickHistory",$data);
  }

  public function pickChatHistory(){
    $roomIdx = $this->input->get("roomIdx");
    $room = $this->base_model->getSelect("pb_room",array(array("record"=>"roomIdx","value"=>$roomIdx)));
    $win_room = array();
    if(!empty($room[0]->winning_history))
        $win_room = json_decode($room[0]->winning_history);
    $data["win_room"] = $win_room;
    $data["cur_win"] = $room[0]->cur_win;
    $data["recommend"] = $room[0]->recommend;
    $data["bullet"] = $room[0]->bullet;
    $this->load->view("pickChatHistory",$data);
  }


  public function classList(){
    $classes = $this->base_model->getSelect("pb_codedetail",array(array("record"=>"class","value"=>"0020"),array("record"=>"code !=","value"=>"00")),array(array("record"=>"code","value"=>"ASC")));
    $data["classes"] = $classes;
    $this->loadViews("classList",$this->global,$data,NULL);
  }

  public function updateClassInfo(){
    $id = $this->input->post("id");
    $item = $this->input->post("item");
    $value = $this->input->post("value");
    $this->base_model->updateDataById($id,array($item=>$value),"pb_codedetail","id");
    echo 1;
  }

  public function listItem(){
    $item = $this->base_model->getSelect("pb_market",null,array(array("record"=>"order","value"=>"ASC")));
    $data["items"]  = $item;
    $this->loadViews("listItem",$this->global,$data,NULL);
  }

  public function editItem($id){
    $data["item"] = $this->base_model->getSelect("pb_market",array(array("record"=>"id","value"=>$id)));
    $this->loadViews("additem",$this->global,$data,NULL);
  }

  public function updateItem(){
    $data = $this->input->post();
    $id = $data["id"];
    unset($data["id"]);
    $this->base_model->updateDataById($id,$data,"pb_market","id");
    redirect("/listItem");
  }

  public function unuseItem(){
      $id = $this->input->post("id");
      $state = $this->input->post("state");
      $update_data = array("state"=>0);
      if($state == 0 )
        $update_data = array("state"=>1);
      $this->base_model->updateDataById($id,$update_data,"pb_market","id");
      echo 1;
  }

  public function purchasedUsr(){
    $this->load->library('pagination');
    $records_count = sizeof( $this->base_model->getPurchasedUser(10000,0));
    $returns = $this->paginationCompress ( "purchasedUsr/", $records_count, 20);
    $data["item"] = $this->base_model->getPurchasedUser($returns["page"], $returns["segment"]);
    $this->loadViews("purchasedUsr",$this->global,$data,NULL);
  }

  public function mondayGift(){
    $data["item"] = $this->base_model->getWinGift();
    $this->loadViews("mondayGift",$this->global,$data,NULL);
  }

  public function deleteGift(){
    $id = $this->input->post("id");
    $this->base_model->deleteRecordCustom("pb_win_gift","id",$id);
    echo 1;
  }

  public function addGift(){
    $data["item"] = $this->base_model->getSelect("pb_market",array(array("record"=>"state","value"=>1)),array(array("record"=>"order","value"=>"ASC")));
    $this->loadViews("addGift",$this->global,$data,NULL);
  }

  public function updateWinGift(){
    $this->base_model->insertArrayData("pb_win_gift",$this->input->post());
    redirect("/mondayGift");
  }


  public function chatManage(){
    $this->load->library('pagination');
    $records_count = sizeof($this->base_model->getChatRooms(10000,0));
    $returns = $this->paginationCompress ( "chatManage/", $records_count, 20);
    $data['item'] = $this->base_model->getChatRooms($returns["page"], $returns["segment"]);
    $data["uc"] = $records_count;
    $data["pf"] = $returns["segment"];
    $this->loadViews("chatlist",$this->global,$data,NULL);
  }

  public function chatContent(){
    $data["roomIdx"] = $this->input->get("roomIdx");
    $profile = array();
    $levels = $this->base_model->getSelect("pb_codedetail",array(array("record"=>"class","value"=>"0020"),array("record"=>"status","value"=>"Y")),array(array("record"=>"code","value"=>"ASC")));
    if(!empty($levels)){
        foreach($levels as $value){
          $profile[$value->code] = $value->value3;
        }
    }
    $data["profile"] = json_encode($profile);
    $this->load->view("chatContent",$data);
  }

  public function deleteRoom(){
    $roomIdx = $this->input->post("roomIdx");
    $this->base_model->deleteRecordCustom("pb_room","roomIdx",$roomIdx);
    echo 1;
  }

  public function usedItem(){
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $use = $this->input->get("use");
    $shType = $this->input->get("shType");
    $content = $this->input->get("content");
    $records_count = sizeof($this->base_model->getItem(2,10000,0,$use,$shType,$content));
    $returns = $this->paginationCompress ( "usedItem/", $records_count, 20);
    $data['item'] = $this->base_model->getItem(2,$returns["page"], $returns["segment"],$use,$shType,$content);
    $data["uc"] = $records_count;
    $data["pf"] = $returns["segment"];
    $this->loadViews("usedItem",$this->global,$data,NULL);
  }

  function process(){
    $in_par = $this->input->get();
    $this->base_model->insertArrayData("pb_error_round",array("day_round"=>$in_par["round"],"date"=>$in_par["date"]));
    echo 1;
  }

  function missRound(){
    $this->load->library('pagination');
    $records_count = sizeof($this->base_model->missItem(10000,0));
    $returns = $this->paginationCompress ( "missRound/", $records_count, 20);
    $data['item'] = $this->base_model->missItem($returns["page"], $returns["segment"]);
    $this->loadViews("missRound",$this->global,$data,NULL);
  }

  function insertMissRound(){
    $uniroun = $this->input->post("uniround");
    $pb=$this->input->post("pb");
    $nb=str_replace(" ","",$this->input->post("nb"));
    $round=$this->input->post("round");
    $date=$this->input->post("date");

    if(empty($pb) || empty($nb) || empty($round) || empty($date) || sizeof(explode(",",$nb)) !=5 || empty($uniroun)){
      echo 0;
      return;
    }
    $checked_result = $this->base_model->getPbResult($round,$date);
    if(sizeof($checked_result) > 0){
      echo -1;
      return;
    }

    $arr_five = explode(",",$nb);
    $arr_five[0] = intval($arr_five[0]);
    $arr_five[1] = intval($arr_five[1]);
    $arr_five[2] = intval($arr_five[2]);
    $arr_five[3] = intval($arr_five[3]);
    $arr_five[4] = intval($arr_five[4]);
    $pb = intval($pb);

    $pb_odd = $pb % 2;
    $sum = $arr_five[0] + $arr_five[1] + $arr_five[2] + $arr_five[3] + $arr_five[4];
    $nb_odd = $sum % 2;
    $pb_period = "A";
    $nb_period = "A";
    $pb_uo = 1;
    $nb_uo = 1;
    $nb_size = 1;
    if($pb >2 && $pb < 5)
      $pb_period = "B";
    if($pb ==5 && $pb == 6)
      $pb_period = "C";
    if($pb ==7 && $pb == 8 && $pb == 9)
      $pb_period = "D";

    if($sum >= 36 && $sum <= 49)
      $nb_period = "B";
    if($sum >= 50 && $sum <= 57)
      $nb_period = "C";
    if($sum >= 58 && $sum <= 65)
      $nb_period = "D";
    if($sum >= 66 && $sum <= 78)
      $nb_period = "E";
    if($sum > 78)
      $nb_period = "F";

    if($sum  >=65 && $sum <=80)
      $nb_size = 2;
    if($sum  >= 81)
      $nb_size = 3;
    if($pb >= 5)
      $pb_uo = 0;
    if($sum >= 73)
      $nb_uo = 0;
    $insert_id = $this->base_model->insertArrayData("pb_result_powerball",array(
      "round"=>$round,
      "day_round"=>$uniroun,
      "nb1"=>$arr_five[0],
      "nb2"=>$arr_five[1],
      "nb3"=>$arr_five[2],
      "nb4"=>$arr_five[3],
      "nb5"=>$arr_five[4],
      "pb"=>$pb,
      "pb_terms"=>$pb_period,
      "pb_oe"=>$pb_odd,
      "pb_uo"=>$pb_uo,
      "nb_terms"=>$nb_period,
      "nb_size"=>$nb_size,
      "nb_oe"=>$nb_odd,
      "nb_uo"=>$nb_uo,
      "nb"=>$sum,
    ));
    if($insert_id > 0){
      $this->base_model->runSP(array(
        "pb_round"=>$round,
        "day_round"=>$uniroun,
        "nb1"=>$arr_five[0],
        "nb2"=>$arr_five[1],
        "nb5"=>$arr_five[4],
        "pb"=>$pb,
        "nb3"=>$arr_five[2],
        "nb4"=>$arr_five[3],
        "pb_terms"=>$pb_period,
        "pb_oe"=>$pb_odd,
        "pb_uo"=>$pb_uo,
        "nb_terms"=>$nb_period,
        "nb_size"=>$nb_size,
        "nb_oe"=>$nb_odd,
        "nb_uo"=>$nb_uo,
        "nb"=>$sum,
      ));
    }
    $this->base_model->deleteMiss($round,date("Y-m-d",strtotime($date)));
    echo 1 ;

  }

  function deleteMiss(){
    $id = $this->input->post("id");
    $this->base_model->deleteRecordCustom("pb_error_round","id",$id);
    echo json_encode(array("status"=>1));
  }

  function setConfig(){
    $cmd = $this->input->post("cmd");
    $roomIdx = $this->input->post("roomIdx");
    $tuseridKey = $this->input->post("tuseridKey");
    $pb_user = $this->base_model->getSelect("pb_users",array(array("record"=>"userIdKey","value"=>$tuseridKey)));
    $bytime = 0;

    if($cmd == "foreverstop"){
      $userInfo = array('isDeleted'=>1, 'updated_at'=>date('Y-m-d H:i:s'));
      $this->load->model('user_model');
      $result = $this->user_model->deleteUser($pb_user[0]->userId, $userInfo);
      $this->user_model->addLog(1,$pb_user[0]->userId,"불법활동",1);
      if ($result > 0) { echo(json_encode(array('status'=>1,"bytime"=>0))); }
      else { echo(json_encode(array('status'=>0))); }
      return;
    }
    if($roomIdx == "channel1"){
      if(strpos($cmd,'mute') !== false){
        if($cmd == "muteOn")
          $bytime =  strtotime("+5 minutes");
        if($cmd == "muteOnTime1")
          $bytime =  strtotime("+1 hour");
        if($cmd == "muteOnTime")
          $bytime =  strtotime("+10000 hours");
        if($cmd == "muteOff")
          $bytime =  0;
        $this->base_model->updateDataById($tuseridKey,array("mutedTime"=>$bytime,"mutedType"=>1),"pb_users","userIdKey");
      }
      

      if($cmd == "banipOn"){
        $this->base_model->deleteRecordCustom("pb_ip_blocked","ip",$pb_user[0]->ip);
        $this->base_model->insertArrayData("pb_ip_blocked",array("ip"=>$pb_user[0]->ip));
        $this->load->model('user_model');
        $this->user_model->addLog(1,$pb_user[0]->userId,"불법활동",2);
      }

      if($cmd == "banipOff"){
        $this->base_model->deleteRecordCustom("pb_ip_blocked","ip",$pb_user[0]->ip);
      }
      echo json_encode(array("status"=>1,"bytime"=>$bytime));
    }
    else{
      $room = $this->base_model->getSelect("pb_room",array(array("record"=>"roomIdx","value"=>$roomIdx)));
      if(!empty($room)){
        $muted = explode(",",$room[0]->mute);
        if($cmd == "muteOn"){
          if(!in_array($tuseridKey,$muted))
          {
            array_push($muted,$tuseridKey);
            $this->base_model->updateDataById($room[0]->id,array("mute"=>implode(",",$muted)),"pb_room","id");
          }
        }
        if($cmd == "muteOff"){
          if (($key = array_search($tuseridKey,$muted)) !== false) {
              unset($muted[$key]);
          }
          $this->base_model->updateDataById($room[0]->id,array("mute"=>implode(",",$muted)),"pb_room","id");
        }
        if($cmd == "closeRoom"){
          $this->base_model->deleteRecordCustom("pb_room","id",$room[0]->id);
        }
        if($cmd == "kickOn"){
          if($tuseridKey == $room[0]->super){
            echo json_encode(array("status"=>0,"msg"=>"방장은 블록할수 없습니다"));
            return;
          }
          $blocked = explode(",",$room[0]->blocked);
          if(!in_array($tuseridKey,$blocked))
          {
            array_push($blocked,$tuseridKey);
            $this->base_model->updateDataById($room[0]->id,array("blocked"=>implode(",",$blocked)),"pb_room","id");
          }
        }
      }
      echo json_encode(array("status"=>1,"bytime"=>0));
    }
  }

  public function settings(){
    $data["data"] = $this->base_model->getSelect("pb_site_settings")[0];
    $this->loadViews("settings",$this->global,$data,NULL);
  }

  public function updateSet(){
    $updated_data = $this->input->post();
    $this->base_model->updateDataById(1,$updated_data,"pb_site_settings","id");
    redirect("/settings");
  }

  public function mailList(){
    $this->loadViews("mailList",$this->global,NULL,NULL);
  }

  public function mails(){
    $mail_list = array();
    $mails = $this->base_model->getMails();
    if(!empty($mails)){
      foreach($mails as $record){
        $temp = array();
        array_push($temp,$record->id);
        array_push($temp,$record->fnickname);
        array_push($temp,$record->tnickname);
        $report = "정상";
        if($record->report == 2){
          $report  = "신고됨";
        }
        if($record->report == 3){
          $report  = "신고수락";
        }
        if($record->report == 4){
          $report  = "신고신청거절";
        }
        $mail_type = "랜덤";
        if($record->mail_type == 2)
          $mail_type = "1:1";
        $state = "";
        if($record->state == 1)
          $state = "보관됨";
        array_push($temp,$report);
        array_push($temp,$mail_type);
        array_push($temp,$state);
        array_push($temp,$record->created_at);
        $view_date = "읽지 않음";
        if($record->view_date !="")
          $view_date = $record->view_date;
        array_push($temp,$view_date);
        array_push($mail_list,$temp);
      }
    }
    echo json_encode(array("data"=>$mail_list));
  }

  function contentMail(){
    $id = $this->input->post("id");
    $mails = $this->base_model->getMails($id);
    if(sizeof($mails) == 0)
    {
      echo json_decode(array("status"=>"false"));
      return;
    }
    echo json_encode(array("status"=>true,"data"=>$mails[0]));
  }

  function deleteMail(){
    $id = $this->input->post("id");
    $this->base_model->deleteRecordCustom("pb_inbox","id",$id);
    echo json_encode(array("status"=>true));
  }

  function views(){
    $data["page"] = $this->base_model->getSelect("pb_pages",array(array("record"=>"type","value"=>$this->input->get("type"))));
    $this->loadViews("views",$this->global,$data,NULL);
  }

  function updateViews(){
    $data = $this->input->post();
    $id = $data["id"];
    unset($data["id"]);
    if($id > 0)
      $this->base_model->updateDataById($id,$data,"pb_pages","id");
    else
      $this->base_model->insertArrayData("pb_pages",$data);
    redirect("views?type={$data["type"]}");
  }
  
  function getInvidual(){
    $id = $this->input->post("id");
    $data = $this->base_model->getSelect("pb_money_return",array(array("record"=>"id","value"=>$id)));
    if(!empty($data)){
      echo json_encode(array("status"=>1,"idc"=>$data[0]->idcard,"book"=>$data[0]->bankbook));
    }  
    else{
      echo json_encode(array("status"=>0));
    }
  }

  function DelMessage(){
    $chkMemCode = $this->input->post("chkMemCode");
    $sKind = $this->input->post("sKind");
    $this->db->where_in('id', $chkMemCode);
    $this->db->delete('pb_message');
    redirect($sKind);
  }

  function bannerList(){
    $data["banner"] = $this->base_model->getSelect("pb_banner",null,array(array("record"=>"updated_date","value"=>"DESC")));
    $this->loadViews("banner",$this->global,$data,NULL);
  }

  function logList(){
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $type = empty($this->input->get('type')) ? 1 : $this->input->get('type');
    $search = $this->input->get('search');
    $log_size = sizeof($this->base_model->getLogs(10000,0,$type,$search));
    $returns = $this->paginationCompress ( "logList/", $log_size, 20);
    $log = $this->base_model->getLogs($returns["page"], $returns["segment"],$type,$search);
    $data['log'] = $log;
    $this->loadViews("logs",$this->global,$data,NULL);
  }

  function ipblocked(){
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
     $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $content = trim($this->input->get('content'));
    $ips = sizeof($this->base_model->getips(10000,0,$content));
    $returns = $this->paginationCompress ( "ipblocked/", $ips, 20);
    $log = $this->base_model->getips($returns["page"], $returns["segment"],$content);
    $data['records'] = $log;
    $this->loadViews("iplist",$this->global,$data,NULL);
  }

  function updateOrderItem(){
    $ids = $this->input->post("ids");
      foreach($ids as $key=>$value)
        $this->base_model->updateDataById($value,array("order"=>$key+1),"pb_market","id");
  }

  public function returnDeposit(){
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $shPageSize =  empty($this->input->get("shPageSize")) ? 10: $this->input->get("shPageSize");
    $state = $this->input->get("state");
    $type   = empty($_GET['type']) ?    NULL : $_GET['type'];
    $start_date = empty($_GET['start_date']) ?  NULL : $_GET['start_date'];
    $end_date   = empty($_GET['end_date']) ?    NULL : $_GET['end_date'];
    $content   = empty($_GET['content']) ?    NULL : $_GET['content'];
    $records_count = sizeof($this->base_model->getReturnDeposits(null,0,$start_date,$end_date,$state,$type,$content));
    $returns = $this->paginationCompress ( "returnDeposit/", $records_count, $shPageSize);
    $data['deposit'] = $this->base_model->getReturnDeposits($returns["page"],$returns["segment"],$start_date,$end_date,$state,$type,$content);
    $data["uc"] =$records_count;
    $data["pf"] = $returns["segment"];
    $this->loadViews("returnDeposit", $this->global, $data , NULL);
  }
  public function updateReturnDeposit(){
    $chkReqSeq =  $this->input->post("chkReqSeq");
    $sStat = $this->input->post("sStat");
    $js_result = array();
    foreach ($chkReqSeq as $value) {
      $details = $this->base_model->getSelect("pb_money_return",array(array("record"=>"id","value"=>$value)))[0];
      $userId = $details->userId;
      $amount = $details->bullet;
      $pending = 0;
      if($sStat == 1){
       $this->base_model->plusValue("pb_users","bullet",$amount,array(array("userId",$userId)),"-");
       $user = $this->base_model->getSelect("pb_users",array(array("record"=>"userId","value"=>$userId)));
       if(empty($user))
        continue;
        array_push($js_result,array($user[0]->userIdKey,number_format($user[0]->bullet)));
      }
      $this->base_model->updateDataById($value,array("status"=>$sStat,'money'=>$amount * 70),"pb_money_return","id");
    }
    echo json_encode(array("status"=>1,"type"=>"request","result"=>$js_result));
  }

  public function registerDeposit(){
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $shPageSize =  empty($this->input->get("shPageSize")) ? 10: $this->input->get("shPageSize");
    $state = $this->input->get("updated");
    $type   = empty($_GET['type']) ?    NULL : $_GET['type'];
    $start_date = empty($_GET['start_date']) ?  NULL : $_GET['start_date'];
    $end_date   = empty($_GET['end_date']) ?    NULL : $_GET['end_date'];
    $content   = empty($_GET['content']) ?    NULL : $_GET['content'];
    $records_count = sizeof($this->base_model->getDepositByUserId(null,0,$start_date,$end_date,$state,$type,$content));
    $returns = $this->paginationCompress ( "registerDeposit/", $records_count, $shPageSize);
    $data['deposit'] = $this->base_model->getDepositByUserId($returns["page"],$returns["segment"],$start_date,$end_date,$state,$type,$content);
    $data["uc"] =$records_count;
    $data["pf"] = $returns["segment"];
    $this->loadViews("registerDeposit",$this->global,$data,NULL);
  }

  public function enableIP(){
    $ip = $this->input->post("ip");
    if(empty($ip)){
      echo json_encode(array("status"=>false));
      return;
    }
    $user = $this->base_model->getSelect("pb_users",array(array("record"=>"ip","value"=>trim($ip))));
    if(!empty($user)){
      $this->base_model->deleteRecordCustom("tbl_block_reason","userId",$user[0]->userId);
    }
     $this->base_model->deleteRecordCustom("pb_ip_blocked","ip",trim($ip));
     echo json_encode(array("status"=>true));
  }

  public function autogames(){
    $this->load->library('pagination');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);
    $start_date = empty($_GET['start_date']) ?  NULL : $_GET['start_date'];
    $end_date   = empty($_GET['end_date']) ?    NULL : $_GET['end_date'];
    $nickname   = empty($_GET['nickname']) ?    NULL : $_GET['nickname'];
    $bet_type   = empty($_GET['bet_type']) ?    NULL : $_GET['bet_type'];
    $state   = empty($_GET['state']) ?    NULL : $_GET['state'];
    $records_count = sizeof($this->base_model->getAutoGames(null,0,$start_date,$end_date,$nickname,$bet_type,$state));
    $returns = $this->paginationCompress ( "autogames/", $records_count, 20);
    $data['records'] = $this->base_model->getAutoGames($returns["page"],$returns["segment"],$start_date,$end_date,$nickname,$bet_type,$state);
    $this->loadViews("autogames",$this->global,$data,NULL);
  }

  public function deleteGame(){
    $id = $this->input->post("id");
    if(empty($id)){
      echo json_encode(array("status"=>false));
      return;
    }
    $this->base_model->deleteRecordCustom("pb_auto_setting","id",$id);
    echo json_encode(array("status"=>true));
  }

  public function alterGame(){
    $id = $this->input->post("id");
    $state = 0;
    $class = "badge-secondary";
    if($this->input->post("state") == 0 ) {$state = 1;$class = "badge-primary";}
    if(empty($id)){
      echo json_encode(array("status"=>false));
      return;
    }

    $this->base_model->updateDataById($id,array("state"=>$state),"pb_auto_setting","id");
    echo json_encode(array("status"=>true,"class"=>$class,"state"=>$state));
  }
}
?>

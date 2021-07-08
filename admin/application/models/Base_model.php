<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Base_model extends CI_Model
{


    function plusValue($database,$field,$value,$val_array,$type,$filter=true){
        $this->db->set($field, $field.$type.$value, FALSE);
        foreach($val_array as $v):
            if($filter ==true)
                $this->db->where($v[0],$v[1]);
            else
                $this->db->where_in($v[0],$v[1]);
        endforeach;
        $this->db->update($database);
    }

    function updateDataById($id,$data,$database,$record){
        if(is_array($id))
            $this->db->where_in($record, $id);
        else
            $this->db->where($record, $id);
        $this->db->update($database, $data);
        return $this->db->affected_rows();
    }

    function addLog($added,$userId,$reason,$type){
      if($added == 1){
        $this->db->select("id");
        $this->db->from("tbl_block_reason");
        $this->db->where("userId",$userId);
        $this->db->where("type",$type);
        $query = $this->db->get();
        $id = $query->result();
        if(sizeof($id) > 0){
          $this->db->where("id",$id[0]->id);
          $this->db->update("tbl_block_reason",array("reason"=>$reason));
        }
        else{
          $this->db->insert("tbl_block_reason",array("userId"=>$userId,"reason"=>$reason,"type"=>$type));
        }
      }
      else{
        $this->db->where("userId",$userId);
        $this->db->where("type",$type);
        $this->db->delete("tbl_block_reason");
      }
    }

    function deleteRecordCustom($database,$record,$id,$type = false,$or_where = false){
        if(!$or_where){
          if($type ==false)
              $this->db->where($record, $id);
          else
            $this->db->where_in($record, $id);
        }
        else{
          foreach($id as $v){
            $this->db->or_where($v[0],$v[1]);
          }
        }
        $this->db->delete($database);
    }

    function deleteMiss($round,$date){
      $this->db->where("day_round",$round);
      $this->db->LIKE("date",$date,"both");
      $this->db->delete("pb_error_round");
    }

    function getSelect($database,$array1=null,$array2=null,$array3=null,$array4=null,$array5=null,$array6=null){
        $this->db->select('*');
        $this->db->from($database);
        if($array1 !=null)
            foreach($array1 as $value){
                if(is_array($value["value"]))
                    $this->db->where_in($value['record'], $value['value'][0],"both");
                else
                    $this->db->where($value['record'], $value['value']);

            }
        if($array2 !=null)
            foreach($array2 as $value1){
                if($value1['record']!="") $this->db->order_by($value1['record'], $value1['value']);
            }
        if($array3 !=null)
            foreach($array3 as $value2){
                if($value2['record']!="") $this->db->group_by($value2['record']);
            }
        if($array4 !=null)
            foreach($array4 as $value3){
                if($value3['record']!="") $this->db->limit($value3['record'], $value3['value']);
            }
        if($array5 !=null)
            foreach($array5 as $value){
                $this->db->like($value['record'], $value['value'],"both");
            }
        if($array6 !=null)
            foreach($array6 as $value){
                $this->db->where_in($value['record'], $value['value'],"both");
            }
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function insertArrayData($database,$data){
        $this->db->insert($database,$data);
        return $this->db->insert_id();
    }

    public function getAll($database){
        $this->db->select('*');
        $this->db->from($database);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getPrivateCount(){
      $query = $this->db->query("SELECT COUNT(*) AS private_count FROM (SELECT
                                  COUNT(*) AS keys_count
                                FROM
                                  `pb_message`
                                WHERE `type` = 'private'
                                GROUP BY `keys`) a WHERE a.keys_count < 2 ");
      return $query->result();
    }

    public function getRegsitesCountByM(){
        $query = $this->db->query("SELECT  SUBSTRING_INDEX(created_at,\"-\",2) AS cdate,COUNT(*) AS c FROM pb_users  where isDeleted = 0 and user_type='01'  GROUP BY cdate order by cdate ASC");
        return $query->result();
    }
    public function getReq($id,$limit1=10,$limit2=0,$category=null,$item=null,$content=null,$mode=null){
        $this->db->select('BaseTbl.*,User.name as UserName,COUNT(Comment.id) as comment_count,User.userId,COUNT(View.id) as view_count');
        $this->db->from('pb_message as BaseTbl');
        $this->db->join("pb_users as User","User.userId=BaseTbl.fromId","left");
        $this->db->join("pb_comment as Comment","Comment.messageId=BaseTbl.id","left");
        $this->db->join("pb_view as View","View.postId=BaseTbl.id","left");
        $this->db->where('BaseTbl.type',$id);
        if($mode !=null && $mode !="" && $mode!="total") $this->db->where('BaseTbl.mode',$mode);
        if($category !=null && $category !="" && $category!="total") $this->db->where('BaseTbl.category',$category);
        if($content !=null && $content !=""){
            if($item == "username")
                $this->db->like('User.name',$content,"both");
            else
                $this->db->like('BaseTbl.'.$item,$content,"both");
        }

        $this->db->order_by('BaseTbl.keys','DESC');
        $this->db->order_by('BaseTbl.reply','ASC');
        if($limit1 ==null)  $this->db->limit(20,0);
        else $this->db->limit($limit1,$limit2);
        $this->db->group_by("BaseTbl.id");
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getPutMoney($limit1=10,$limit2=0){
      $this->db->select('BaseTbl.money,BaseTbl.coin,User.nickname,BaseTbl.created_at');
      $this->db->from("pb_deposit as BaseTbl");
      $this->db->join("pb_users as User","User.userId=BaseTbl.userId");
      $this->db->where("BaseTbl.accept",0);
      $this->db->where("User.isDeleted",0);
      $this->db->where("User.user_type","01");
      $this->db->order_by('BaseTbl.created_at','DESC');
      if($limit1 ==null)  $this->db->limit(20,0);
      else $this->db->limit($limit1,$limit2);
      $query = $this->db->get();
      $results = $query->result();
      return  $results;
    }

    public function getReturnMoney($limit1=10,$limit2=0){
      $this->db->select('BaseTbl.bullet,User.nickname,BaseTbl.created_at');
      $this->db->from("pb_money_return as BaseTbl");
      $this->db->join("pb_users as User","User.userId=BaseTbl.userId");
      $this->db->where("BaseTbl.status",0);
      $this->db->where("User.isDeleted",0);
      $this->db->where("User.user_type","01");
      $this->db->order_by('BaseTbl.created_at','DESC');
      if($limit1 ==null)  $this->db->limit(20,0);
      else $this->db->limit($limit1,$limit2);
      $query = $this->db->get();
      $results = $query->result();
      return  $results;
    }

    public function getReqById($id){
        $this->db->select(' BaseTbl.*,
                            User.name as UserName,
                            Board.category_use,
                            Board.category as bcategory,
                            Board.content as btitle,
                            Board.id as bid,
                            Board.name as bname,
                            Board.security as bsecurity,
                            COUNT(View.id) as view_count');
        $this->db->from('pb_message as BaseTbl');
        $this->db->join("pb_users as User","User.userId=BaseTbl.fromId","left");
        $this->db->join("pb_view as View","View.postId=BaseTbl.id","left");
        $this->db->join("pb_board as Board","Board.name=BaseTbl.type");
        $this->db->where('BaseTbl.id',$id);
        $this->db->order_by('BaseTbl.updated_at','DESC');
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function getCommentsByPostId($limit1=5,$limit2=0,$id =0){
        $this->db->select("BaseTbl.*,User.name");
        $this->db->from("pb_comment as BaseTbl");
        $this->db->join("pb_users as User","User.userId=BaseTbl.userId");
        $this->db->where("BaseTbl.messageId",$id);
        $this->db->order_by("BaseTbl.created_at","DESC");
        if($limit1 ==null)  $this->db->limit(20,0);
        $this->db->limit($limit1,$limit2);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getDepositByUserId($limit1=10,$limit2=0,$v1=null,$v2=null,$v3=null,$v4=null,$v5=null){
        $this->db->select(' BaseTbl.*,
                            User.name as Uname,
                            User.loginId,
                            User.nickname,
                            User.userId');
        $this->db->from('pb_deposit as BaseTbl');
        $this->db->join('pb_users as User','User.userId=BaseTbl.userId');
        if($v1!=null) $this->db->where("BaseTbl.updated_at >=",$v1);
        if($v2!=null) $this->db->where("BaseTbl.updated_at <=",$v2);
        if($v3!=null) $this->db->where("BaseTbl.accept",$v3);
        if($v5!=null && $v4!=null && $v4!="loginId1") $this->db->like("User.".$v4,$v5,"both");
        if($v5!=null && $v4!=null && $v4=="loginId") $this->db->where("User.".$v4,$v5);
        $this->db->order_by("BaseTbl.updated_at","DESC");
        if($limit1!=null) $this->db->limit($limit1,$limit2);
        $query = $this->db->get();
        $results = $query->result();
        return  $results;
    }

    public function updateDeposit($id,$state){
        $this->db->where("id", $id);
        $this->db->update("pb_deposit", array("accept"=>$state));
        return $this->db->affected_rows();
    }

    public function getAmountD($id){
        $this->db->select('*');
        $this->db->from('pb_deposit');
        $this->db->where('id',$id);
        $query = $this->db->get();
        $results = $query->result();
        return$results;
    }
    public function increaseAmount($results){
        $this->db->where('userId',$results[0]->userId);
        $this->db->set('coin', 'coin+'.$results[0]->coin, FALSE);
        $this->db->update('pb_users');
        $user = $this->getSelect("pb_users",array(array("record"=>"userId","value"=>$results[0]->userId)));
        if(!empty($user)){
          return array($user[0]->userIdKey,number_format($user[0]->coin));
        }
        return array("",0);
    }

    public function getReturnDeposits($limit1=10,$limit2=0,$v1=null,$v2=null,$v3=null,$v4=null,$v5=null){
        $this->db->select('BaseTbl.*,User.nickname as Uname,User.loginId,Bank.name as bname,User.bullet as cbullet');
        $this->db->from('pb_money_return as BaseTbl');
        $this->db->join("pb_users as User","User.userId=BaseTbl.userId");
        $this->db->join("pb_bank as Bank","Bank.id=BaseTbl.accountCode","left");
        if($v1!=null) $this->db->where("BaseTbl.updated_at >=",$v1);
        if($v2!=null) $this->db->where("BaseTbl.updated_at <=",$v2);
        if($v3!=null) $this->db->where("BaseTbl.status",$v3);
        if($v5!=null && $v4!=null && $v4!="loginId") $this->db->like("User.".$v4,$v5,"both");
        if($v5!=null && $v4!=null && $v4=="loginId") $this->db->where("User.".$v4,$v5);
        $this->db->order_by('BaseTbl.updated_at',"DESC");
        if($limit1!=null) $this->db->limit($limit1,$limit2);
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    public function getPurchasedUser($limit1=20,$limit2=0){
      $this->db->select('BaseTbl.*,Market.name as mname,Market.image as mimage,User.nickname');
      $this->db->from("pb_item_use as BaseTbl");
      $this->db->join("pb_market as Market","Market.code=BaseTbl.market_id");
      $this->db->join("pb_users as User","User.userId=BaseTbl.userId");
      $this->db->where("User.isDeleted",0);
      $this->db->where("User.user_type","01");
      $this->db->order_by('BaseTbl.created_date','DESC');
      if($limit1 ==null)  $this->db->limit(20,0);
      else $this->db->limit($limit1,$limit2);
      $query = $this->db->get();
      $results = $query->result();
      return  $results;
    }

    public function getWinGift(){
      $this->db->select('BaseTbl.*,Market.name as mname');
      $this->db->from("pb_win_gift as BaseTbl");
      $this->db->join("pb_market as Market","Market.code=BaseTbl.market_id");
      $this->db->order_by('BaseTbl.order','ASC');
      $query = $this->db->get();
      $results = $query->result();
      return  $results;
    }

    public function getChatRooms($limit1=20,$limit2=0){
      $this->db->select('BaseTbl.*,User.nickname,User.bullet');
      $this->db->from("pb_room as BaseTbl");
      $this->db->join("pb_users as User","User.userId=BaseTbl.userId");
      $this->db->order_by('BaseTbl.updated_at','DESC');
      if($limit1 ==null)  $this->db->limit(20,0);
      else $this->db->limit($limit1,$limit2);
      $query = $this->db->get();
      $results = $query->result();
      return  $results;
    }

    public function runSP($data){
      $stored_procedure = "CALL ProcessPowerball(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
      $a_result = $this->db->query( $stored_procedure, $data);
    }

    public function getItem($type,$limit1=20,$limit2=0,$use = null,$shType = null,$content = null){
      $this->db->select('BaseTbl.*,User.nickname');
      $this->db->from("pb_log as BaseTbl");
      $this->db->join("pb_users as User","User.userId=BaseTbl.userId");
      $this->db->where('BaseTbl.type','2');
      $this->db->where('User.isDeleted','0');
      $this->db->where('User.user_type','01');
      if(!empty($use)){
        $this->db->LIKE('BaseTbl.content',$use,"both");
      }
      if(!empty($shType) && !empty(trim($content))){
        if($shType == "A")
          $this->db->LIKE("User.loginId",trim($content),"both");
        if($shType == "B")
          $this->db->LIKE("User.name",trim($content),"both");
        if($shType == "F")
          $this->db->LIKE("User.email",trim($content),"both");
        if($shType == "D")
          $this->db->LIKE("User.nickname",trim($content),"both");
      }
      $this->db->order_by('Basetbl.created_at','DESC');
      if($limit1 ==null) {}
      else $this->db->limit($limit1,$limit2);
      $query = $this->db->get();
      $results = $query->result();
      return  $results;
    }

    public function missItem($limit1=20,$limit2=0){
      $this->db->select('BaseTbl.*');
      $this->db->from("pb_error_round as BaseTbl");
      $this->db->order_by('Basetbl.created_at','DESC');
      if($limit1 ==null) {}
      else $this->db->limit($limit1,$limit2);
      $query = $this->db->get();
      $results = $query->result();
      return  $results;
    }

    function getPbResult($round,$date){
      $this->db->select('BaseTbl.*');
      $this->db->from("pb_result_powerball as BaseTbl");
      $this->db->where('BaseTbl.round',$round);
      $this->db->LIKE('BaseTbl.created_date',$date,"both");
      $query = $this->db->get();
      $results = $query->result();
      return  $results;
    }

    public function processMiss($data)
    {
        $query = $this->db->query("SELECT game_code,pick,userId,id,TYPE FROM pb_betting WHERE pb_betting.`round` = ".$data["round"]." AND pb_betting.`changed` = 0 AND pb_betting.`is_win` = - 1 AND pb_betting.game_type = 1");
        $bet_list =  $query->result();
        if(!empty($bet_list)){
            foreach ($bet_list as $key => $value) {
              $isWin = 2;
              if($value->game_code == "pb_oe" && $value->pick == $data["pb_oe"])
              {
                $isWin = 1;
              }
              if($value->game_code == "pb_uo" && $value->pick == $data["pb_uo"])
              {
                $isWin = 1;
              }
              if($value->game_code == "nb_uo" && $value->pick == $data["nb_uo"])
              {
                $isWin = 1;
              }
              if($value->game_code == "nb_oe" && $value->pick == $data["nb_oe"])
              {
                $isWin = 1;
              }
              if($value->game_code == "nb_size" && $value->pick == $data["nb_size"])
              {
                $isWin = 1;
              }
              $this->db->query("UPDATE
                                 pb_users
                               SET
                                 pb_users.`exp` = pb_users.`exp` + 1
                               WHERE pb_users.`userId` = ".$value->userId." ");
              if($isWin == 1){

              }
              $this->db->query("UPDATE
                pb_betting
              SET
                pb_betting.`is_win` = ".$isWin."
              WHERE pb_betting.id = ".$value->id." ");
            }

            $qq = "SELECT CONCAT('{',GROUP_CONCAT(CONCAT('\"',game_code,'\"',':','{','\"pick\":',pick,',','\"is_win\":',is_win,'}') SEPARATOR ','),'}') AS result,
                      pb_betting.`userId`,
                      pb_betting.`round`,
                      pb_betting.`game_type`,
                      pb_betting.`type`,
                      pb_betting.`created_date`,
                      pb_betting.`roomIdx`
                    FROM
                      pb_betting
                    WHERE pb_betting.`round` = '{$data["round"]}'
                      AND pb_betting.`changed` = 0 AND pb_betting.`game_type`=1 AND pb_betting.`is_win` > -1
                    GROUP BY pb_betting.`userId`,pb_betting.`type`,pb_betting.`game_type` ORDER BY created_date ASC";

            $query  = $this->db->query($qq);
            $betted_list = $query->result();
            if(!empty($betted_list)){
              foreach($betted_list as $value){
                $this->db->query("INSERT pb_betting_ctl (
                                  content,
                                  userId,
                                  ROUND,
                                  game_type,
                                  TYPE,
                                  pick_date,
                                  roomIdx
                                )
                                VALUES
                                  ( '{$value->result}' , {$value->userId}, {$value->round}, 1, '{$value->type}','{$value->created_at}','{$value->roomIdx}')");
              }
            }
            $this->db->query("UPDATE pb_betting SET pb_betting.`changed`=1 WHERE pb_betting.`round`=".$data["round"]." AND pb_betting.`game_type`=1");
            $d = date("Y-m-d",strtotime($data["date"]));
            $this->db->query("DELETE FROM pb_error_round where round ={$data["round"]} and date LIKE '%{$d}%'");
            return 1;
        }
    }
}
?>

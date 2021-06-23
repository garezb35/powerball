<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText= '',$isDeleted=0,$st=null,$et=null,$level=null,$item=null,$content=null)
    {
        $this->db->select('BaseTbl.userId');
        $this->db->from('pb_users as BaseTbl');
        $this->db->where('BaseTbl.isDeleted', $isDeleted);
        $this->db->where('BaseTbl.user_type', "01");
        if($st !=null) $this->db->where("BaseTbl.created_at >=",$st);
        if($et !=null) $this->db->where("BaseTbl.created_at <=",$et);
        if($content !=null) {
            $content = trim($content);
            switch ($item) {
                case "B":
                    # code...
                    $this->db->like("BaseTbl.name",$content,'both');
                    break;
                case "A":
                    # code...
                    $this->db->like("BaseTbl.loginId",$content,'both');
                    break;
                case "D":
                    # code...
                    $this->db->like("BaseTbl.nickname",$content,"both");
                    break;
                case "F":
                    # code...
                    $this->db->like("BaseTbl.email",$content,'both');
                    break;
                case "E":
                    # code...
                    $this->db->where("BaseTbl.ip",$content);
                    break;
                default:
                    # code...
                    break;
            }
        }
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing($searchText = '', $page=0, $segment=0,$isDeleted=0,$st=null,$et=null,$level=null,$item=null,$content=null)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email,BaseTbl.coin, BaseTbl.name,BaseTbl.bullet,BaseTbl.ip, BaseTbl.phoneNumber,BaseTbl.loginId,BaseTbl.nickname,BaseTbl.created_at,BaseTbl.loginId,CodeDetail.codename,IpBlocked.ip as ip_block');
        $this->db->from('pb_users as BaseTbl');
        $this->db->join("pb_codedetail as CodeDetail","CodeDetail.code=BaseTbl.level","left");
        $this->db->join("pb_ip_blocked as IpBlocked","IpBlocked.ip=BaseTbl.ip","left");
        $this->db->where("CodeDetail.class","0020");
        $this->db->where('BaseTbl.user_type', "01");
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.nickname  LIKE '%".$searchText."%'
                            OR  BaseTbl.phoneNumber  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', $isDeleted);
        if($st !=null) $this->db->where("BaseTbl.creted_at >=",$st);
        if($et !=null) $this->db->where("BaseTbl.creted_at <=",$et);
        if($content !=null) {
            $content = trim($content);
            switch ($item) {
                case "B":
                    # code...
                    $this->db->like("BaseTbl.name",$content,'both');
                    break;
                case "A":
                    # code...
                    $this->db->like("BaseTbl.loginId",$content,'both');
                    break;
                case "D":
                    # code...
                    $this->db->like("BaseTbl.nickname",$content,"both");
                    break;

                case "F":
                    # code...
                    $this->db->like("BaseTbl.email",$content,'both');
                    break;
                case "E":
                    # code...
                    $this->db->where("BaseTbl.ip",$content);
                    break;
                default:
                    # code...
                    break;
            }
        }
        $this->db->limit($page, $segment);
        $this->db->group_by("BaseTbl.userId");
        $this->db->order_by("BaseTbl.created_at","DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function managerListing($limit1=0,$limit2=0,$st=null,$et=null,$level=null,$item=null,$content=null){
        $this->db->select('BaseTbl.*, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('Role.type =', 0);
        if($st !=null) $this->db->where("BaseTbl.createdDtm >=",$st);
        if($et !=null) $this->db->where("BaseTbl.createdDtm <=",$st);
        if($level !=null) $this->db->where("Role.roleId",$level);
        if($content !=null) $this->db->where("BaseTbl.".$item,$content);
        if($limit1 ==0 && $limit2==0){}
        else $this->db->limit($limit1,$limit2);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles($role=1,$type=1)
    {
        $this->db->select('roleId, role,level');
        $this->db->from('tbl_roles');
        if($type==1) $this->db->where('type', $role);
        else {$this->db->where('type >', $role);}
        $query = $this->db->get();
        return $query->result();
    }

    function getRoles(){
      $this->db->select('code, codename,value1');
      $this->db->from('pb_codedetail');
      $this->db->where('class', "0020");
      $this->db->order_by("code","ASC");
      $query = $this->db->get();
      return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("pb_users");
        $this->db->where("email", $email);
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }


    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('pb_users', $userInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId,$isDeleted=0)
    {
        $this->db->select('pb_users.*');
        $this->db->from('pb_users');
        $this->db->join('pb_codedetail as CodeDetail', 'CodeDetail.code = pb_users.level','left');
        $this->db->where('CodeDetail.class', "0020");
        $this->db->where('pb_users.isDeleted', $isDeleted);
		    $this->db->where('pb_users.user_type', "01");
        $this->db->where('pb_users.userId', $userId);
        $query = $this->db->get();
        return $query->result();
    }


    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('pb_users', $userInfo);
        return TRUE;
    }



    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('pb_users', $userInfo);
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');

        $user = $query->result();

        if(!empty($user)){
            if($this->encryption->decrypt($user[0]->password) ==$oldPassword)
                return $user;
             else {
                return array();
            }
        } else {
            return array();
        }
    }

    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);

        return $this->db->affected_rows();
    }

    public function deleteUserForever($id){
        $this->db->where('userId', $id);
        $this->db->delete('pb_users');

        $this->db->where('userId', $id);
        $this->db->delete('tbl_auto_match');

        $this->db->where('userId', $id);
        $this->db->delete('pb_pur_item');
    }
    public function insertArrayData($database,$data){
        $this->db->insert($database,$data);
        return $this->db->insert_id();
    }
    function deleteRecordCustom($database,$record,$id,$type = false){
        if($type ==false)
            $this->db->where($record, $id);
        else
          $this->db->where_in($record, $id);
        $this->db->delete($database);
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
}

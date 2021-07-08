<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('encryption');
        $this->encryption->initialize(cRYPT);
        $this->encryption->initialize(array('driver' => 'mycript'));
        $this->global['menu_list'] = array();
        $this->isLoggedIn();
    }

    public function managerList(){
       $this->load->model('user_model');
        $this->load->library('pagination');
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);
        $records_count= sizeof( $this->user_model->managerListing(0,0,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content")));
        $returns = $this->paginationCompress ( "managerList/", $records_count,$this->input->get("shPageSize"));
        $data['userRecords'] = $this->user_model->managerListing($returns["page"],$returns["segment"],$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content"));
        $data['managers'] = $this->user_model->getUserRoles(0,1);
        $this->global['pageTitle'] = '관리';
        $this->loadViews("manager", $this->global, $data, NULL);
    }

    function userListing()
    {

      $this->load->model('user_model');
      $searchText = $this->input->post('searchText');
      $data['searchText'] = $searchText;
      $this->load->library('pagination');
      $shPageSize = empty($this->input->get("shPageSize")) ? 10:$this->input->get("shPageSize");
      $count = $this->user_model->userListingCount($searchText,0,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content"));
      $returns = $this->paginationCompress ( "userListing/", $count, $shPageSize);
      $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"],0,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content"));
      $data["rolss"] =  $this->user_model->getRoles();
      $this->global['pageTitle'] = '회원리스트';
      $data["uc"] = $count;
      $data["pf"] = $returns["segment"];
      $this->loadViews("users", $this->global, $data, NULL);
    }

    public function exitMember(){
      $this->load->model('user_model');

      $searchText = $this->input->post('searchText');
      $data['searchText'] = $searchText;
      $data['levels'] = $this->user_model->getRoles();
     $this->load->library('pagination');

      $count = $this->user_model->userListingCount($searchText,1,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content"));

      $returns = $this->paginationCompress ( "userListing/", $count, $this->input->get("shPageSize"));

      $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"],1,$this->input->get("starts_date"),$this->input->get("ends_date"),$this->input->get("shMemLvl"),$this->input->get("shType"),$this->input->get("content"));
       $this->global['pageTitle'] = '탈퇴회원목록';
      $data["uc"] = $count;
      $data["pf"] = $returns["segment"];
      $this->loadViews("exitedusers", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
      $this->load->model('user_model');
      $data['roles'] = $this->user_model->getRoles();

      $this->global['pageTitle'] = 'CodeInsect : Add New User';

      $this->loadViews("addNew", $this->global, $data, NULL);
    }

    function addManger(){

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles(0);

            $this->global['pageTitle'] = 'CodeInsect : Add New User';

            $this->loadViews("addmanger", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    /**
     * This function is used to add new user to the system
     */

    function addNewUser()
    {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]|xss_clean');
      $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
      $this->form_validation->set_rules('password','Password','required|max_length[20]');
      $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');

      if($this->form_validation->run() == FALSE)
      {
          $this->addManger();
      }
      else
      {
          $data = $this->input->post();
          unset($data["IDCheck"]);
          unset($data["NickNameCheck"]);
          unset($data["cpassword"]);
          $data["userIdKey"] = generateRandomString(50);
          $data["password"] = $this->encryption->encrypt($data["password"]);
          $split_level = explode("-",$data["level"]);
          $data["level"] = $split_level[0];
          $data["exp"] = $split_level[1] +1;
          $this->user_model->addNewUser($data);
          redirect('addNew');
      }
    }

    function addProcessmanger(){

        if(!in_array("111", $this->global['menu_list']))
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');

                $userInfo = array('email'=>$email, 'password'=>$this->encryption->encrypt($password), 'roleId'=>$roleId, 'name'=> $name,
                                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));

                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);

                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }

                redirect('managerList');
            }
        }
    }

    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
      if($userId == null)
      {
          redirect('userListing');
      }

      if(!empty($this->input->get("isDeleted"))){

          $data['userInfo'] = $this->user_model->getUserInfo($userId,$this->input->get("isDeleted"));
      }

      else{

          $data['userInfo'] = $this->user_model->getUserInfo($userId);
      }

      $data['roles'] = $this->user_model->getRoles();
      $this->load->model('base_model');
      $this->global['pageTitle'] = 'CodeInsect : Edit User';
      $this->loadViews("editOld", $this->global, $data, NULL);
    }


    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        $this->load->library('form_validation');

        $userId = $this->input->post('userId');
        $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
        $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');

        if($this->form_validation->run() == FALSE)
        {
            $this->editOld($userId);
        }
        else
        {
            $data = $this->input->post();
            unset($data["userId"]);
            unset($data["cpassword"]);
            if(empty($data["password"]))
              unset($data["password"]);
            else {
              $data["password"] = $this->encryption->encrypt($data["password"]);
            }


            $result = $this->user_model->editUser($data, $userId);

            if($result == true)
            {
                if(!empty($this->input->post("settings"))){
                    $settings = json_encode($this->input->post("settings"));
                    $this->load->model('base_model');

                }
                $this->session->set_flashdata('success', 'User updated successfully');


            }
            else
            {
                $this->session->set_flashdata('error', 'User updation failed');
            }

            redirect('userListing');
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
      $userId = $this->input->post('userId');
      if(!empty($this->input->post("sure")) && $this->input->post("sure")==1){
          $this->user_model->deleteUserForever($userId);
          echo(json_encode(array('status'=>TRUE)));
      }
      else{
          $userInfo = array('isDeleted'=>1, 'updated_at'=>date('Y-m-d H:i:s'));
          $result = $this->user_model->deleteUser($userId, $userInfo);
          $this->user_model->addLog(1,$userId,$this->input->post("reason"),1);
          if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
          else { echo(json_encode(array('status'=>FALSE))); }
      }
    }

    function ipblock()
    {
      $userId = $this->input->post('userId');
      $mode = $this->input->post("mode");
      $ip = $this->input->post("ip");
      $result = array();
      $result["txt"] = "아이피차단해제";
      $result["mode"] = "enable";
      $result["status"] = true;
      if($mode == "enable"){
        $this->user_model->deleteRecordCustom("pb_ip_blocked","ip",$ip);
        $this->user_model->addLog(2,$userId,"",1);
        $result["txt"] = "아이피차단";
        $result["mode"] = "disable";
      }
      else{
        $checked_ip = $this->user_model->getSelect("pb_ip_blocked",array(array("record"=>"ip","value"=>$ip)));
        if(sizeof($checked_ip) == 0){
          $this->user_model->insertArrayData("pb_ip_blocked",array("ip"=>$ip));
          $this->user_model->addLog(1,$userId,$this->input->post("reason"),2);
        }
      }
      echo json_encode($result);
    }

    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'CodeInsect : Change Password';

        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }


    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');

        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);

            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('loadChangePass');
            }
            else
            {
                $usersData = array('password'=>$this->encryption->encrypt($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));

                $result = $this->user_model->changePassword($this->vendorId, $usersData);

                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }

                redirect('loadChangePass');
            }
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';

        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>

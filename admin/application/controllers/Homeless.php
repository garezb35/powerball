  <?php if(!defined('BASEPATH')) exit('No direct script access allowed');

  require APPPATH . '/libraries/BaseController.php';
  /**
   * Class : Login (LoginController)
   * Login class to control to authenticate user credentials and starts user's session.
   * @author : Kishor Mali
   * @version : 1.1
   * @since : 15 November 2016
   */
  class Homeless extends BaseController
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
      
    }

    function process(){
      $in_par = $this->input->get();
      $this->base_model->insertArrayData("pb_error_round",array("day_round"=>$in_par["round"],"date"=>$in_par["date"]));
      echo 1;
    }
  }
?>

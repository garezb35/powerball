<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "login";
$route['404_override'] = 'error';

/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'home/dashboard';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";

$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['ipblock'] = "user/ipblock";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";
$route['productListing'] = "home/productListing";
$route['activeProduct'] = "home/activeProduct";
$route['changeProduct'] ="home/changeProduct";
$route['changeOrder'] = 'home/changeOrder';







$route['offque'] ='home/offque';
$route['offque/(:num)'] ='home/offque/$1';
$route['publicreq'] ='home/publicreq';
$route['publicreq/(:num)'] ='home/publicreq/$1';
$route['viewReq/(:num)'] ='Home/viewMessage/$1';
$route['writeComment'] = "home/writeComment";
$route['writePost/(:any)'] = 'home/writePost/$1';
$route['bbs'] = 'home/bbs';
// $route['deliverAddress'] = 'home/deliverAddress';
// $route['updateDelA'] = 'home/updateDelA';
// $route['deleteDt'] = 'home/deleteDt';
//$route['getDelA'] = 'home/getDelA';
// $route['incomingBank'] = 'home/incomingBank';
// $route['saveBank'] ='home/saveBank';
// $route['saveCompany'] = 'home/saveCompany';
//$route['accuringRate'] = 'home/accuringRate';
//$route['saveAccurRate'] = 'home/saveAccurRate';
//$route['customexRate'] = 'home/customexRate';
//$route['saveCustomRate'] = 'home/saveCustomRate';
//$route['deliveryFee'] = 'home/deliveryFee';
//$route['saveFee'] = 'home/saveFee';
//$route['topcat'] = "home/topcat";
//$route['topcat/(:num)'] = "home/topcat/$1";
//$route['saveCategory'] = "home/saveCategory";
//$route['childCat'] = "home/childCat";
//$route['childCat/(:num)'] = "home/childCat/$1";
//$route['getCat'] = "home/getCat";
//$route['saveDeliveryTable'] = "home/saveDeliveryTable";
// $route['memberLevel'] = 'home/memberLevel';
// $route['saveMemberLevel'] = 'home/saveMemberLevel';
//$route['shoppingmal']  = 'home/shoppingmal';
//$route['saveShoppingMal'] = 'home/saveShoppingMal';
$route['mail'] = 'home/mail';
$route['mail/(:num)'] = 'home/mail/$1';
$route['viewMessage'] = 'home/viewMail';
$route['editMail/(:num)'] = 'home/editMail/$1';
$route['SaveMail'] = 'home/SaveMail';
//$route['pay_order'] = 'home/OrderHistory';
//$route['pay_order/(:num)'] = 'home/OrderHistory/$1';
//$route['memberpay'] = 'home/memberpay';
//$route['memberpay/(:num)'] = 'home/memberpay/$1';
$route['exitMember'] = 'user/exitMember';
// $route['registerPoint'] = 'home/registerPoint';
// $route['registerPoint/(:num)'] = 'home/registerPoint/$1';
// $route['savePointUsers'] = 'home/savePointUsers';
// $route['cancelPoint/(:num)'] = "home/cancelPoint/$1";
// $route['deletePoint'] = 'home/deletePoint';
$route['registerDeposit'] = 'home/registerDeposit';
$route['registerDeposit/(:num)'] = 'home/registerDeposit/$1';
$route['updateDeposit'] = 'home/updateDeposit';
// $route['ActDelivery'] = 'home/ActDelivery';
// $route['getProduct'] = 'home/getProduct';
// $route['UpdateDelivery'] = 'home/UpdateDelivery';
// $route['ShowDelivery'] = 'home/ShowDelivery';
// $route['setMemo'] = 'home/setMemo';
$route['homePage'] = 'home/homePage';
$route['saveBanner'] = 'home/saveBanner';
$route['banner_s'] = 'home/banner_s';
$route['saveBannerR'] = 'home/saveBanner_S';
$route['popup'] = 'home/popup';
$route['savePopup'] = 'home/savePopup';
$route['getHome'] = 'home/getHome';
$route['deleteHome'] = 'home/deleteHome';
$route['getBanner'] ='home/getBanner';
$route['deleteBanner'] = 'home/deleteBanner';
$route['editPopup'] = 'home/editPopup';
$route['deletePopup'] = 'home/deletePopup';
// $route['Comment_W'] = "home/Comment_W";
// $route['deliveryComment'] = "home/deliveryComment";
$route['verifyDeposit'] ='home/verifyDeposit';
$route['cancelDeposit'] ='home/cancelDeposit';
$route['sendMail'] ='home/sendMail';
$route['PopNote_I'] = 'home/PopNote_I';
// $route['deposithistory'] = 'home/deposithistory';
// $route['deposithistory/(:num)'] = 'home/deposithistory/$1';
// $route['saveDeposit'] = 'home/saveDeposit';
// $route['DpstUseDet_M']= 'home/DpstUseDet_M';
// $route['Box_Cnt_M'] = 'home/Box_Cnt_M';
// $route['getDelivery'] = 'home/getDelivery';


// $route['view-photo']="home/view_photo";
// $route['Acting_D'] = 'home/Acting_D';
// $route['ActingAdrs_W'] = 'home/ActingAdrs_W';
// $route['ActingAdrs_M'] ='home/ActingAdrs_M';
// $route['User_MemAddr_S'] = 'home/User_MemAddr_S';
// $route['Acting_Del'] = 'home/Acting_Del';
// $route['getOT'] = 'home/getOT';
// $route['trackPaper'] = 'home/trackPaper';
// $route['ActingExcel_W'] = 'home/ActingExcel_W';
$route['Bbs_SetUp_W'] = 'home/Bbs_SetUp_W';
$route['addBoard'] = 'home/addBoard';
$route['board_settings']= 'home/board_settings';
$route['editboards/(:num)'] = 'home/editboards/$1';
$route['panel'] = 'home/panel';
$route['panel/(:num)'] = 'home/panel/$1';
$route['actionUsers'] = 'home/actionUsers';
// $route['registered_mail']  ='home/registered_mail';
// $route['addRegisteredMail']='home/addRegisteredMail';
$route['pages'] = 'home/pages';
$route['pages_edit/(:num)'] = 'home/pages_edit/$1';
$route['addPage'] = 'home/addPage';
$route['NtDet_W'] = 'home/NtDet_W';
$route['multisend'] = 'home/multisend';
$route['NtDet_D'] = 'home/NtDet_D';
$route['IdChk'] = 'home/IdChk';
$route['Mem_U'] = 'home/Mem_U';
$route['Mem_X'] = 'home/Mem_X';
$route['bbs_fl_D'] = 'home/bbs_fl_D';
// $route['editmemberL/(:num)'] = 'home/editmemberL/$1';
// $route["seporders"] = "home/seporders";
// $route['Mem_Grade_S'] = 'home/Mem_Grade_S';
$route['getCommentMore'] = 'home/getCommentMore';
$route['deleteComment'] = 'home/deleteComment';
// $route['ActingExcel_I'] ='home/ActingExcel_I';
$route["downloadI"] = "home/downloadI";
// $route["changeLevel"] = "home/changeLevel";
// $route["addOption"] = "home/addOption";
// $route["addItem"] = "home/addItem";
// $route["deleteOption"] = "home/deleteOption";
// $route['editOption'] = "home/editOption";
// $route["deleteAcc"]='home/deleteAcc';
// $route["setting_point"]='home/setting_point';
// $route["savepointRegister"]='home/savepointRegister';
// $route["add_points"]='home/add_points';
// $route["savePointByRegister"]='home/savePointByRegister';
// $route["deletePointR"]='home/deletePointR';
// $route["eventPoint"]='home/eventPoint';
// $route["note"]='home/note';
// $route["note/(:num)"]='home/note/$1';
// $route["deleteNotes"]='home/deleteNotes';
// $route['saveEventHomepage'] = 'home/saveEventHomepage';
// $route['notsbyregister'] = 'home/notsbyregister';
// $route['saveregisternots'] = 'home/saveregisternots';

$route['footer_management'] = 'home/footer_management';
$route['saveHeader'] = 'home/saveHeader';
$route['saveFooter'] = 'home/saveFooter';
$route['saveMobileHeader'] = 'home/saveMobileHeader';
// $route['tackbae'] = 'home/tackbae';
// $route['addTackBae'] = 'home/addTackBae';
// $route['deleteTack'] = 'home/deleteTack';
// $route['send_management'] = 'home/send_management';
// $route['deleteSend'] = 'home/deleteSend';
// $route['addSends'] = 'home/addSends';
// $route['service_management'] = 'home/service_management';
// $route['service_type'] = 'home/service_type';
// $route['editServiceType'] = 'home/editServiceType';
// $route['deleteServiceType'] = 'home/deleteServiceType';
// $route['saveServiceType'] = 'home/saveServiceType';
// $route['editService'] = 'home/editService';
// $route['saveService'] = 'home/saveService';
// $route['getCateogory'] = 'home/getCateogory';
// $route['editAddress'] = 'home/editAddress';

// $route['deleteCustomX'] ="Home/deleteCustomX";
// $route['categoryProducts'] = "Home/categoryProducts";
// $route['categoryProducts/(:num)'] = "Home/categoryProducts/$1";
// $route['editCategory'] = "Home/editCategory";
// $route['editCategory/(:num)'] = "Home/edit_category/$1";
// $route['registerCategory'] = "Home/registerCategory";
// $route['del_cats'] = "Home/del_cats";
// $route['deleteProductImage'] = "Home/deleteProductImage";
$route['changeGrade'] = "Home/changeGrade";
// $route['viewNote'] = "Home/viewNote";

$route['deleteFooterImg'] = "Home/deleteFooterImg";

// $route['edtCoupon'] = "Home/edtCoupon";
// $route['delCoupon'] = "Home/delCoupon";

// $route['shopcategory'] = "Home/shopcategory";

// $route['category_pro'] = "Home/category_pro";

// $route['addShopCategory'] = "Home/addShopCategory";

// $route["getshopcategory"] = "Home/getshopcategory";

// $route["deleteShopBanner"] = "Home/deleteShopBanner";

// $route['ico'] = "Home/ico";

// $route['addIcon'] = "Home/addIcon";

// $route['CreateIcon'] = "Home/CreateIcon";

// $route['deleteIconImage'] = "Home/deleteIconImage";

// $route['product_wish'] = "Home/product_wish";

$route['shop_banner'] = "Home/shop_banner";

// $route['setCategoryShop'] = "Home/setCategoryShop";

// $route['product_option'] = "Home/product_option";

// $route["product_option_save"] = "Home/product_option_save";

// $route["saveOrderOptions"] = "Home/saveOrderOptions";

// $route["multi_categories"] = "Home/multi_categories";

// $route["deleteEval"] = "Home/deleteEval";

// $route["deleteRequestImage"] = "Home/deleteRequestImage";

// $route["updateProductTalk"] = "Home/updateProductTalk";

$route["loginlog"] = "Home/loginlog";

$route["backup"] = "Home/backup";

$route["pickHistory"] = "Home/pickHistory";

$route["pickChatHistory"] = "Home/pickChatHistory";

$route["classList"] = "Home/classList";

$route["updateClassInfo"] = "Home/updateClassInfo";

$route["listItem"] = "Home/listItem";

$route["editItem/(:num)"] = "Home/editItem/$1";

$route["updateItem"] = "Home/updateItem";

$route["unuse"] = "Home/unuseItem";

$route["purchasedUsr"] = "Home/purchasedUsr";

$route["purchasedUsr/(:num)"] = "Home/purchasedUsr/$1";

$route["mondayGift"] = "Home/mondayGift";

$route["deleteGift"] = "Home/deleteGift";

$route["addGift"] = "Home/addGift";

$route["updateWinGift"] = "Home/updateWinGift";

$route["chatManage"] = "Home/chatManage";

$route["chatManage/(:num)"] = "Home/chatManage/$1";

$route["chatContent"] = "Home/chatContent";

$route["deleteRoom"] = "Home/deleteRoom";

$route["usedItem"] = "Home/usedItem";

$route["usedItem/(:num)"] = "Home/usedItem/$1";

$route["set_err_round"]  = "Homeless/process";

$route["missRound"]  = "Home/missRound";

$route["missRound/(:num)"]  = "Home/missRound/$1";

$route["insertMissRound"] = "Home/insertMissRound";

$route["deleteMiss"] = "Home/deleteMiss";

$route["setConfig"] = "Home/setConfig";

$route["settings"]=  "Home/settings";

$route["updateSet"] = "Home/updateSet";

$route["mailList"] = "Home/mailList";

$route["mails"] = "Home/mails";

$route["contentMail"] = "Home/contentMail";

$route["deleteMail"] = "Home/deleteMail";

$route["views"] = "Home/views";

$route["updateViews"] = "Home/updateViews";

$route["getInvidual"] = "Home/getInvidual";

$route["DelMessage"] = "Home/DelMessage";

$route["bannerList"] = "Home/bannerList";

$route['logList'] = 'Home/logList';

$route["logList/(:num)"]  = "Home/logList/$1";

$route["ipblocked"] = "Home/ipblocked";

$route['updateOrderItem']=  "Home/updateOrderItem";

$route['returnDeposit'] = 'home/returnDeposit';
$route['returnDeposit/(:num)'] = 'home/returnDeposit/$1';
$route['updateReturnDeposit'] = 'home/updateReturnDeposit';

$route['editBoard/(:num)'] = 'home/editBoard/$1';
$route['deleteBoard']="home/deleteBoard";
$route['updateBoard']="home/updateBoard";
$route['deleteF']="home/deleteF";
$route['updateOrderBanner'] = 'home/updateOrderBanner';
$route['deletePost'] = 'Home/deletePost';
$route["enableIP"] = "Home/enableIP";
$route["autogames"] = "Home/autogames";
$route["deleteGame"] = "Home/deleteGame";
$route["alterGame"] = "Home/alterGame";
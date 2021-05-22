<?php
function getDiffTimes($date){
    $to_time = strtotime("now");
    $from_time = strtotime($date);
    $prefix = "분";
    $minute = round(abs($to_time - $from_time) / 60);
    $result_minute = 0;

    if($minute < 1) {
        $prefix = "초";
        $result_minute = round(abs($to_time - $from_time) % 60);
    }
    if($minute >= 1440) {
        $prefix = "일";
        $result_minute = round($minute / 1440);
    }
    if($minute >= 60 && $minute < 60*24) {
        $prefix = "시간";
        $result_minute = round($minute / 60);
    }

    if($result_minute ==0 )
        return "방금";
    else
        return $result_minute.$prefix;
}

function winningItem($count){
    $html = "";
    if($count >=5){
        $html  .= '<div style="position:absolute;top:0;right: 306px;z-index:96;" title="일주일 내에 5연승 기록이 있습니다"><img src="/assets/images/powerball/badge/badge5.png" width="46" height="68"></div>';
    }
    if($count >=10){
        $html  .= '<div style="position:absolute;top:0;right: 275px;z-index:97;" title="일주일 내에 10연승 기록이 있습니다"><img src="/assets/images/powerball/badge/badge10.png" width="46" height="68"></div>';
    }
    if($count >=15){
        $html  .= '<div style="position:absolute;top:0;right: 243px;z-index:97;" title="일주일 내에 15연승 기록이 있습니다"><img src="/assets/images/powerball/badge/badge15.png" width="46" height="68"></div>';
    }
    if($count >=20){
        $html  .= '<div style="position:absolute;top:0;right: 212px;z-index:97;" title="일주일 내에 20연승 기록이 있습니다"><img src="/assets/images/powerball/badge/badge20.png" width="46" height="68"></div>';
    }
    echo $html;
}

function getUserPrefix(){
    return array(
        array("alias"=>"전체","key"=>"all" ,"class"=>"none"),
        array("alias"=>"ㄱ","key"=>"ㄱ" ,"class"=>""),
        array("alias"=>"ㄴ","key"=>"ㄴ","class"=>""),
        array("alias"=>"ㄷ","key"=>"ㄷ","class"=>""),
        array("alias"=>"ㄹ","key"=>"ㄹ","class"=>""),
        array("alias"=>"ㅁ","key"=>"ㅁ","class"=>""),
        array("alias"=>"ㅂ","key"=>"ㅂ","class"=>""),
        array("alias"=>"ㅅ","key"=>"ㅅ","class"=>""),
        array("alias"=>"ㅇ","key"=>"ㅇ","class"=>""),
        array("alias"=>"ㅈ","key"=>"ㅈ","class"=>""),
        array("alias"=>"ㅊ","key"=>"ㅊ","class"=>""),
        array("alias"=>"ㅋ","key"=>"ㅋ","class"=>""),
        array("alias"=>"ㅌ","key"=>"ㅌ","class"=>""),
        array("alias"=>"ㅍ","key"=>"ㅍ","class"=>""),
        array("alias"=>"ㅎ","key"=>"ㅎ","class"=>""),
        array("alias"=>"A-Z","key"=>"A","class"=>"none"),
        array("alias"=>"0-9","key"=>"N","class"=>"none"),
        array("alias"=>"블랙리스트","key"=>"B","class"=>"black")
    );
}

function initConst($charact){
    switch ($charact){
        case "ㄱ":
            return array("가","깋");
        break;
        case "ㄴ":
            return array("나","닣");
            break;
        case "ㄷ":
            return array("다","딯");
            break;
        case "ㄹ":
            return array("라","맇");
            break;
        case "ㅁ":
            return array("마","밓");
            break;
        case "ㅂ":
            return array("바","빟");
            break;
        case "ㅅ":
            return array("사","싷");
            break;
        case "ㅇ":
            return array("아","잏");
            break;
        case "ㅈ":
            return array("자","짛");
            break;
        case "ㅊ":
            return array("차","칳");
            break;
        case "ㅋ":
            return array("카","킿");
            break;
        case "ㅌ":
            return array("타","팋");
            break;
        case "ㅍ":
            return array("파","핗");
            break;
        case "ㅎ":
            return array("하","힣");
            break;
        default:
            return array("","");
            break;
    }
}

function recursive_child_display($comments, $lookup_table, $root = 0, $deep = 0,$userId =0)
{
    $let = 30;
    if (isset($lookup_table[$root])) {
        foreach ($lookup_table[$root] as $comment_key => $comment_id) {
            // You can use $deep to test if you're in a comment of a comment
            $pro_img = "";
            $nickname = "";
            $reply_action = "<a href=\"#\" onclick=\"comment_box('".$comments[$comment_key]["id"]."', 'c'); return false;\">답변</a>";
            $level = "";
            $ml = '';
            $reply ="";
            if($userId == $comments[$comment_key]["userId"]){
                $reply_action = '  <li><a href="javascript:void(0)" onclick="comment_box(\''.$comments[$comment_key]["id"].'\', \'c\'); return false;">답변</a></li>
                            <li><a href="javascript:void(0)" onclick="comment_box(\''.$comments[$comment_key]["id"].'\', \'cu\'); return false;">수정</a></li>
                            <li><a href="javascript:void(0)" onclick="return comment_delete('.$comments[$comment_key]["id"].');">삭제</a></li>';
            }
            if(empty($comments[$comment_key]["suser"]))
            {
                $pro_img= "/assets/images/powerball/mine/profile.png";
                $nickname = "운영자";
                $level = "/assets/images/powerball/class/M30.gif";
            }
            else{
                $pro_img = $comments[$comment_key]["suser"]["image"];
                $nickname = $comments[$comment_key]["suser"]["nickname"];
                $level = $comments[$comment_key]["suser"]["get_level"]["value3"];

            }
            if($comments[$comment_key]["parent"] > 0){
                $reply = '<img src="/assets/images/powerball/icon_reply.png" class="icon_reply" alt="댓글의 댓글">';
                $ml = 'style="margin-left:'.(50+30*$deep).'px;border-top-color:#e0e0e0"';
            }
            echo '<article id="c_'.$comments[$comment_key]["id"].'" '.$ml.'>
                  <header style="z-index:5">
                      <div class="thumb">
                      <img src="'.$pro_img.'">
                      </div>
                      <div class="content">
                          <h1>'.$nickname.'님의 댓글</h1>
                          <img src="'.$level.'">
                          <span class="member">'.$nickname.'님</span>
                          '.$reply.'
                          <span class="bo_vc_hdinfo">
                          <time datetime="'.$comments[$comment_key]["created_at"].'">'.date("m-d H:i:s",strtotime($comments[$comment_key]["created_at"])).'</time>
                          </span>
                      </div>

                      <ul class="bo_vc_act">
                          '.$reply_action.'
                      </ul>
                  </header>
                  <!-- 댓글 출력 -->
                  <p>
                      '.$comments[$comment_key]["content"].'
                  </p>
                  <span id="edit_'.$comments[$comment_key]["id"].'"></span><!-- 수정 -->
                  <span id="reply_'.$comments[$comment_key]["id"].'" style="display: none;"></span><!-- 답변 -->
                  <input type="hidden" value="" id="secret_comment_'.$comments[$comment_key]["id"].'">
                  <textarea id="save_comment_'.$comments[$comment_key]["id"].'" style="display:none">'.$comments[$comment_key]["content"].'</textarea>';
            echo '</article>';
            recursive_child_display($comments, $lookup_table, $comment_id, $deep+1,$userId);

        }
    }
}
 function extractImage($html)
{
    preg_match_all('/<img[^>]+>/i',$html, $result);
    if(!empty($result[0][0]))
        return $result[0][0];
    else
        return "";
}

function checkImage($html)
{
    preg_match_all('/<img[^>]+>/i',$html, $result);
    if(!empty($result[0][0]))
        return "/assets/images/icon_picture.png";
    else
        return "/assets/images/icon_text.png";
}

function ballColorSel($num,$i)
{
    $ballColor = "";
    if($i == 5)
        return "pb";
    switch($num)
    {
        case '01':
        case '1':
        case '05':
        case '5':
        case '09':
        case '9':
        case '13':
        case '17':
        case '21':
        case '25':
           $ballColor = 'red';
            break;
        case '02':
        case '2':
        case '06':
        case '6':
        case '10':
        case '14':
        case '18':
        case '22':
        case '26':
            $ballColor = 'yellow';
            break;
        case '03':
        case '3':
        case '07':
        case '7':
        case '11':
        case '15':
        case '19':
        case '23':
        case '27':
            $ballColor = 'green';
            break;
        case '0':
        case '04':
        case '4':
        case '08':
        case '8':
        case '12':
        case '16':
        case '20':
        case '24':
        case '28':
            $ballColor = 'blue';
            break;
    }
    return $ballColor;
}


function sadariCheck($nb1){
    $result = "";
    if($nb1 % 2 == 1)
        $result = "left";
    else
        $result = "right";
    if($nb1 >=1 && $nb1 <=14)
        $result .= "_3";
    else
        $result .= "_4";
    return $result;
}

function sadariPath($type){
    $sType = array();
    switch ($type){
        case "left_3":
            array_push($sType,sadariObject(47,13,"h","66px","100","btl btr bbl"));
            array_push($sType,sadariObject(97,29,"w","204px","500","btr"));
            array_push($sType,sadariObject(113,217,"h","32px","50","bbr"));
            array_push($sType,sadariObject(128,13,"w","204px","500","btl"));
            array_push($sType,sadariObject(144,13,"h","32px","50","bbl"));
            array_push($sType,sadariObject(159,29,"w","204px","500","btr"));
            array_push($sType,sadariObject(175,217,"h","50px","70","bbl bbr"));

            break;
        case "left_4":
            array_push($sType,sadariObject(47,13,"h","49px","300","btl btr bbl"));
            array_push($sType,sadariObject(79,29,"w","204px","100","btr"));
            array_push($sType,sadariObject(95,217,"h","32px","250","bbr"));
            array_push($sType,sadariObject(111,28,"w","204px","100","btl","r"));
            array_push($sType,sadariObject(127,13,"h","32px","250","bbl"));
            array_push($sType,sadariObject(142,29,"w","204px","100","btr"));
            array_push($sType,sadariObject(158,217,"h","32px","250","bbr"));
            array_push($sType,sadariObject(173,28,"w","204px","100","btl","r"));
            array_push($sType,sadariObject(189,13,"h","36px","300","bbl bbr"));
            break;
        case "right_3":
            array_push($sType,sadariObject(47,217,"h","66px","100","btl btr bbr"));
            array_push($sType,sadariObject(97,28,"w","204px","100","btl","r"));
            array_push($sType,sadariObject(113,13,"h","32px","100","bbl"));
            array_push($sType,sadariObject(129,29,"w","204px","100","btr"));
            array_push($sType,sadariObject(144,217,"h","32px","100","bbr"));
            array_push($sType,sadariObject(160,28,"w","204px","100","btl","r"));
            array_push($sType,sadariObject(175,13,"h","50px","100","bbl bbr"));
            break;
        case "right_4":
            array_push($sType,sadariObject(47,217,"h","49px","100","btl btr bbr"));
            array_push($sType,sadariObject(79,28,"w","204px","100","btl","r"));
            array_push($sType,sadariObject(95,13,"h","32px","100","bbl"));
            array_push($sType,sadariObject(111,29,"w","204px","100","btr"));
            array_push($sType,sadariObject(127,217,"h","32px","100","bbr"));
            array_push($sType,sadariObject(142,28,"w","204px","100","bt1","r"));
            array_push($sType,sadariObject(158,13,"h","32px","100","bbl"));
            array_push($sType,sadariObject(173,29,"w","204px","100","btr"));
            array_push($sType,sadariObject(189,217,"h","36px","100","bbl bbr"));
            break;
    }

    return $sType;
}

function sadariObject($top,$left,$wh="w",$size,$spd,$class,$rl="l"){
    $temp = new \stdClass();
    $temp->pos = new \stdClass();
    $temp->size = new \stdClass();
    $temp->pos->top=$top;
    if($rl == "l")
        $temp->pos->left=$left;
    else
        $temp->pos->right=$left;
    if($wh == "w")
        $temp->size->width=$size;
    else
        $temp->size->height=$size;
    $temp->spd=$spd;
    $temp->class = $class;
    return $temp;
}


?>

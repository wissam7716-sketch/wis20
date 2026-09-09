<?php

// تم تصحيح اخطاء الملف بواسطه كيلوا@X_V_44 @ka7h_bot
$API_KEY = "8177219985:AAHii1xWe9tz3s-nHwfO5_7nUn8IgjnmfC4" ;

#حط ايديك سطر 7 وسطر 5119 بس 
$sudo = 7328300457; // ايدي الادمن
// ==========================================
// كود الحماية التلقائية للمجلدات الحساسة (إغلاق الثغرات)
// ==========================================
$protected_folders = ['Asiacell', 'RSHQ', 'data', 'Users', 'FCZR', 'onliner', 'AdsF', 'AdsInfo'];
foreach($protected_folders as $folder){
    if(!is_dir($folder)){ 
        @mkdir($folder, 0777, true); 
    }
    // إنشاء ملف .htaccess لمنع الوصول من المتصفح نهائياً
    if(!file_exists($folder.'/.htaccess')){
        @file_put_contents($folder.'/.htaccess', "<Files \"*.json\">\nOrder Deny,Allow\nDeny from all\n</Files>\nOptions -Indexes");
    }
    // إنشاء ملف index.php كطبقة حماية إضافية
    if(!file_exists($folder.'/index.php')){
        @file_put_contents($folder.'/index.php', "<?php http_response_code(403); die('Access Denied - تم حظر الوصول'); ?>");
    }
}
// ==========================================
define('API_KEY',$API_KEY);
define("IDBot", explode(":", $API_KEY)[0]);



echo file_get_contents("https://api.telegram.org/bot" . API_KEY . "/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']);

function replaceTextInJson($data, $search, $replace) {
    foreach ($data as $key => $value) {
        if (-($value) || is_object($value)) {
            $data->$key = replaceTextInJson($value, $search, $replace);
        } else if (is_string($value)) {
            $data->$key = str_replace($search, $replace, $value);
        }
    }
    return $data;
}

// تم تصحيح اخطاء الملف بواسطه كيلوا@X_V_44 @ka7h_bot

function bot($method, $datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // فحص إذا كان الطلب يحتوي على ملف لرفعه بطريقة صحيحة
    $has_file = false;
    foreach($datas as $key => $value){
        if($value instanceof CURLFile){ $has_file = true; break; }
    }
    if($has_file){
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: multipart/form-data"]);
    }
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    
    if(curl_error($ch)){
        var_dump(curl_error($ch));
        return false;
    }else{
        return json_decode($res);
    }
}

$usrbot = bot("getme")->result->username;
define("USR_BOT",$usrbot); #يابه لحد يلعب بهاذه
$emoji = 
"
" ;
$emoji = explode ("\n", $emoji) ;
$b = $emoji[rand(0,4)];
$NamesBACK = "رجوع ♾️" ;
$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT. "/rshq.json"),true);
$modes = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT. "/modes.json"),true);
include("Namero1.php") ;
mkdir("RSHQ/ALLS") ;
function SETJSON($INPUT){
    if ($INPUT !== null && $INPUT !== "") {
        $file_path = "RSHQ/ALLS/" . USR_BOT . "/rshq.json";
        
        // استخدام الطريقة المباشرة والناجحة (مثل SETJSON12)
        $encoded_input = json_encode($INPUT, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        
        file_put_contents($file_path, $encoded_input, LOCK_EX);
    }
}


function SETJSON1($INPUT){
    if ($INPUT != NULL || $INPUT != "") {
        $F = "RSHQ/ALLS/". USR_BOT. "/tmoil.json";
        $N = json_encode($INPUT, JSON_PRETTY_PRINT);   
        file_put_contents($F, $N, LOCK_EX);
    }
}

function SETJSON12($INPUT){
  if ($INPUT != NULL || $INPUT != "") {
      $F ="RSHQ/ALLS/". USR_BOT. "/modes.json";
      $N = json_encode($INPUT, JSON_PRETTY_PRINT);   
      file_put_contents($F, $N, LOCK_EX);
      
  }
}

function SETJSON15($INPUT){
  if ($INPUT != NULL || $INPUT != "") {
      $F = "RSHQ/ALLS/". USR_BOT. "/str_jo.json";
      $N = json_encode($INPUT, JSON_PRETTY_PRINT);   
      file_put_contents($F, $N, LOCK_EX);
      
  }
}

function SETJSON16($INPUT){
  if ($INPUT != NULL || $INPUT != "") {
      $F = "RSHQ/ALLS/". USR_BOT. "/pv.json";
      $N = json_encode($INPUT, JSON_PRETTY_PRINT);   
      file_put_contents($F, $N, LOCK_EX);
      
  }
}
mkdir("RSHQ") ;
mkdir("RSHQ/ALLS") ;
mkdir("RSHQ/ALLS/". USR_BOT) ;

$forwardM=json_decode(file_get_contents("forwardM.json"),1);
$Js=json_decode(file_get_contents("Js.json"),1);
$Ds=json_decode(file_get_contents("Ds.json"),1);
$Vs=json_decode(file_get_contents("Users/Vs.json"),1);

function Add($path, $content)
{
	$file = fopen("$path", "a") or die("Unable to open file!");
	fwrite($file, "$content");
	fclose($file);
}
function GetUpdates($offset = null, $limit = 1, $timeout = null, $allowed_updates = [])
{
	return bot('getUpdates', [
		'offset' => $offset,
		'limit' => $limit,
		'timeout' => $timeout,
		'allowed_updates' => $allowed_updates
	]);
}
function SetWebhook($url, $certificate = null, $max_connections = 1, $allowed_updates = [])
{
	return bot('setWebhook', [
		'url' => $url,
		'certificate' => $certificate,
		'max_connections' => $max_connections,
		'allowed_updates' => $allowed_updates,
	]);
}
function DeleteWebhook()
{
	return bot('deleteWebhook');
}
function GetWebhookInfo()
{
	return bot('getWebhookInfo');
}
function SendChatAction($chat_id, $action)
{
	bot('sendChatAction', [
		'chat_id' => $chat_id,
		'action' => $action
	]);
}
function SendMessage($chat_id, $text, $parse_mode = "MARKDOWN", $disable_web_page_preview = true, $reply_to_message_id = null, $reply_markup = null)
{
	return bot('sendMessage', [
		'chat_id' => $chat_id,
		'text' => $text,
		'parse_mode' => $parse_mode,
		'disable_web_page_preview' => $disable_web_page_preview,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function ForwardMessage($chat_id, $from_chat_id, $message_id)
{
	return bot('forwardMessage', [
		'chat_id' => $chat_id,
		'from_chat_id' => $from_chat_id,
		'disable_notification' => false,
		'message_id' => $message_id
	]);
}
function SendPhoto($chat_id, $photo, $caption = null, $parse_mode = "MARKDOWN", $reply_to_message_id = null, $reply_markup = null)
{
	return bot('sendPhoto', [
		'chat_id' => $chat_id,
		'photo' => $photo,
		'caption' => $caption,
		'parse_mode' => $parse_mode,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function SendAudio($chat_id, $audio, $caption = null, $parse_mode = "MARKDOWN", $duration = null, $performer = null, $title = null, $thumb = null, $reply_to_message_id = null, $reply_markup = null)
{
	return bot('sendAudio', [
		'chat_id' => $chat_id,
		'audio' => $audio,
		'caption' => $caption,
		'parse_mode' => $parse_mode,
		'duration' => $duration,
		'performer' => $performer,
		'title' => $title,
		'thumb' => $thumb,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function SendDocument($chat_id, $document, $thumb = null, $caption = null, $parse_mode = "MARKDOWN", $reply_to_message_id = null, $reply_markup = null)
{
	return bot('sendDocument', [
		'chat_id' => $chat_id,
		'document' => $document,
		'thumb' => $thumb,
		'caption' => $caption,
		'parse_mode' => $parse_mode,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function SendVideo($chat_id, $video, $duration = null, $width = null, $height = null, $thumb = null, $caption = null, $parse_mode = "MARKDOWN", $reply_to_message_id = null, $reply_markup = null, $supports_streaming = null)
{
	return bot('sendVideo', [
		'chat_id' => $chat_id,
		'video' => $video,
		'duration' => $duration,
		'width' => $width,
		'height' => $height,
		'thumb' => $thumb,
		'caption' => $caption,
		'parse_mode' => $parse_mode,
		'supports_streaming' => $supports_streaming,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function SendAnimation($chat_id, $animation, $duration = null, $width = null, $height = null, $thumb = null, $caption = null, $parse_mode = "MARKDOWN", $reply_to_message_id = null, $reply_markup = null)
{
	return bot('sendAnimation', [
		'chat_id' => $chat_id,
		'animation' => $animation,
		'duration' => $duration,
		'width' => $width,
		'height' => $height,
		'thumb' => $thumb,
		'caption' => $caption,
		'parse_mode' => $parse_mode,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function SendVoice($chat_id, $voice, $caption = null, $parse_mode = "MARKDOWN", $duration = null, $reply_to_message_id = null, $reply_markup = null)
{
	return bot('sendVoice', [
		'chat_id' => $chat_id,
		'voice' => $voice,
		'caption' => $caption,
		'parse_mode' => $parse_mode,
		'duration' => $duration,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function SendVideoNote($chat_id, $video_note, $duration = null, $length = null, $width = null, $height = null, $thumb = null, $caption = null, $parse_mode = "MARKDOWN", $reply_to_message_id = null, $reply_markup = null)
{
	return bot('sendVideoNote', [
		'chat_id' => $chat_id,
		'video_note' => $video_note,
		'duration' => $duration,
		'length' => $length,
		'thumb' => $thumb,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function SendMediaGroup($chat_id, $media, $reply_to_message_id = null)
{
	return bot('sendMediaGroup', [
		'chat_id' => $chat_id,
		'media' => $media,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id
	]);
}
function SendLocation($chat_id, $latitude, $longitude, $live_period = null, $reply_to_message_id = null, $reply_markup = null)
{
	return bot('sendLocation', [
		'chat_id' => $chat_id,
		'latitude' => $latitude,
		'longitude' => $longitude,
		'live_period' => $live_period,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function SendContact($chat_id, $phone_number, $first_name, $last_name = null, $reply_to_message_id = null, $reply_markup = null, $vcard = null)
{
	return bot('sendContact', [
		'chat_id' => $chat_id,
		'phone_number' => $phone_number,
		'first_name' => $first_name,
		'last_name' => $last_name,
		'vcard' => $vcard,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function SendPoll($chat_id, $question, $options, $reply_to_message_id = null, $reply_markup = null)
{
	return bot('sendPoll', [
		'chat_id' => $chat_id,
		'question' => $question,
		'options' => $options,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function GetUserProfilePhotos($user_id, $offset = null, $limit = null)
{
	return bot('getUserProfilePhotos', [
		'user_id' => $user_id,
		'offset' => $offset,
		'limit' => $limit
	]);
}
function GetFile($file_id)
{
	return bot('getFile', [
		'file_id' => $file_id
	]);
}
function File_path($file_path)
{
	$info = file_get_contents("https://api.telegram.org/file/bot" . API_KEY . "/" . $file_path);
	return $info;
}
function KickChatMember($chat_id, $user_id, $until_date = null)
{
	return bot('kickChatMember', [
		'chat_id' => $chat_id,
		'user_id' => $user_id,
		'until_date' => $until_date
	]);
}
function UnKickChatMember($chat_id, $user_id)
{
	return bot('promoteChatMember', [
		'chat_id' => $chat_id,
		'user_id' => $user_id,
		'can_send_messages' => true,
	]);
}
function PromoteChatMember($chat_id, $user_id)
{
	return bot('promoteChatMember', [
		'chat_id' => $chat_id,
		'user_id' => $user_id,
		'can_send_messages' => true,
		'can_delete_messages' => true,
		'can_invite_users' => true,
		'can_restrict_members' => true,
		'can_pin_messages' => true,
	]);
}
function RestrictChatMember($chat_id, $user_id)
{
	return bot('restrictChatMember', [
		'chat_id' => $chat_id,
		'user_id' => $user_id,
		'can_send_messages' => false,
		'can_send_media_messages' => false,
		'can_invite_users' => false,
		'can_send_other_messages' => false,
	]);
}
function UnRestrictChatMember($chat_id, $user_id)
{
	return bot('promoteChatMember', [
		'chat_id' => $chat_id,
		'user_id' => $user_id,
		'can_send_messages' => true,
		'can_send_media_messages' => true,
		'can_send_other_messages' => true,
	]);
}
function DemoteChatMember($chat_id, $user_id)
{
	return bot('promoteChatMember', [
		'chat_id' => $chat_id,
		'user_id' => $user_id,
		'can_change_info' => false,
		'can_post_messages' => false,
		'can_edit_messages' => false,
		'can_delete_messages' => false,
		'can_invite_users' => false,
		'can_restrict_members' => false,
		'can_pin_messages' => false,
		'can_promote_members' => false
	]);
}
function ExportChatInviteLink($chat_id)
{
	return bot('exportChatInviteLink', [
		'chat_id' => $chat_id
	]);
}
function SetChatPhoto($chat_id, $photo)
{
	return bot('setChatPhoto', [
		'chat_id' => $chat_id,
		'photo' => $photo
	]);
}
function DeleteChatPhoto($chat_id)
{
	return bot('deleteChatPhoto', [
		'chat_id' => $chat_id
	]);
}
function SetChatTitle($chat_id, $title)
{
	return bot('setChatTitle', [
		'chat_id' => $chat_id,
		'title' => $title
	]);
}
function SetChatDescription($chat_id, $description)
{
	return bot('setChatDescription', [
		'chat_id' => $chat_id,
		'description' => $description
	]);
}
function PinChatMessage($chat_id, $message_id)
{
	return bot('pinChatMessage', [
		'chat_id' => $chat_id,
		'message_id' => $message_id,
		'disable_notification' => false
	]);
}
function UnpinChatMessage($chat_id)
{
	return bot('unpinChatMessage', [
		'chat_id' => $chat_id,
	]);
}
function LeaveChat($chat_id)
{
	return bot('LeaveChat', [
		'chat_id' => $chat_id
	]);
}
function GetChat($chat_id)
{
	return bot('getChat', [
		'chat_id' => $chat_id
	]);
}
function GetChatAdministrators($chat_id)
{
	return bot('getChatAdministrators', [
		'chat_id' => $chat_id
	]);
}
function GetChatMembersCount($chat_id)
{
	return bot('getChatMembersCount', [
		'chat_id' => $chat_id
	]);
}
function GetChatMember($chat_id, $user_id)
{
	return bot('getChatMember', [
		'chat_id' => $chat_id,
		'user_id' => $user_id
	]);
}
function AnswerCallbackQuery($callback_query_id, $text, $show_alert = false, $url = null, $cache_time = 0)
{
	return bot('answerCallbackQuery', [
		'callback_query_id' => $callback_query_id,
		'text' => $text,
		'show_alert' => $show_alert,
		'url' => $url,
		'cache_time' => $cache_time
	]);
}
function EditMessageText($chat_id, $message_id, $text, $inline_message_id = null, $parse_mode = "MARKDOWN", $disable_web_page_preview = true, $reply_markup = null)
{
	return bot('editMessageText', [
		'chat_id' => $chat_id,
		'message_id' => $message_id,
		'inline_message_id' => $inline_message_id,
		'text' => $text,
		'parse_mode' => $parse_mode,
		'disable_web_page_preview' => $disable_web_page_preview,
		'reply_markup' => $reply_markup
	]);
}
function EditMessageCaption($chat_id, $message_id, $caption, $inline_message_id = null, $parse_mode = "MARKDOWN", $reply_markup = null)
{
	return bot('editMessageCaption', [
		'chat_id' => $chat_id,
		'message_id' => $message_id,
		'inline_message_id' => $inline_message_id,
		'caption' => $caption,
		'parse_mode' => $parse_mode,
		'reply_markup' => $reply_markup
	]);
}
function EditMessageMedia($chat_id, $message_id, $media, $inline_message_id = null, $parse_mode = "MARKDOWN", $reply_markup = null)
{
	return bot('editMessageMedia', [
		'chat_id' => $chat_id,
		'message_id' => $message_id,
		'inline_message_id' => $inline_message_id,
		'media' => $media,
		'reply_markup' => $reply_markup
	]);
}
function EditMessageReplyMarkup($chat_id, $message_id, $reply_markup, $inline_message_id = null)
{
	return bot('editMessageReplyMarkup', [
		'chat_id' => $chat_id,
		'message_id' => $message_id,
		'inline_message_id' => $inline_message_id,
		'reply_markup' => $reply_markup
	]);
}
function StopPoll($chat_id, $message_id, $reply_markup = null)
{
	return bot('stopPoll', [
		'chat_id' => $chat_id,
		'message_id' => $message_id,
		'reply_markup' => $reply_markup
	]);
}
function DeleteMessage($chat_id, $message_id)
{
	return bot('deletemessage', [
		'chat_id' => $chat_id,
		'message_id' => $message_id
	]);
}
function SendSticker($chat_id, $sticker, $reply_to_message_id = null, $reply_markup = null)
{
	return bot('sendSticker', [
		'chat_id' => $chat_id,
		'sticker' => $sticker,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function AnswerInlineQuery($inline_query_id, $results, $cache_time = 0, $is_personal = false, $next_offset = null, $switch_pm_text = null, $switch_pm_parameter = null)
{
	return bot('answerInlineQuery', [
		'inline_query_id' => $inline_query_id,
		'results' => $results,
		'cache_time' => $cache_time,
		'is_personal' => $is_personal,
		'next_offset' => $next_offset,
		'switch_pm_text' => $switch_pm_text,
		'switch_pm_parameter' => $switch_pm_parameter
	]);
}
function SendGame($chat_id, $game_short_name, $reply_to_message_id = null, $reply_markup = null)
{
	return bot('sendGame', [
		'chat_id' => $chat_id,
		'game_short_name' => $game_short_name,
		'disable_notification' => false,
		'reply_to_message_id' => $reply_to_message_id,
		'reply_markup' => $reply_markup
	]);
}
function InlineKeyBoard($inlinetext = [], $type, $contents = [], $standar = "column", $count = 1)
{
	for ($i = 0; $i < $count; $i++) {

		$text     = $inlinetext[$i];
		$content = $contents[$i];

		if ($standar == "column") {
			$keyboard['inline_keyboard'][] = [['text' => $text, $type => $content]];
		}
		if ($standar == "row") {
			$keyboard['inline_keyboard'][] = [['text' => $inlinetext[$i], $type => $contents[$i]], ['text' => $inlinetext[++$i], $type => $contents[$i]]];
		}
	}
	$inline = json_encode($keyboard);
	return $inline;
}
function KeyBoard($keytext = [], $standar = "column", $count = 1)
{
	for ($i = 0; $i < $count; $i++) {

		$text = $keytext[$i];

		if ($standar == "column") {
			$keyboard['keyboard'][] = [['text' => $text]];
		}
		if ($standar == "row") {
			$keyboard['keyboard'][] = [['text' => $keytext[$i]], ['text' => $keytext[++$i]]];
		}
	}
	$resize_keyboard = json_encode($keyboard);
	return $resize_keyboard;
}
function myZip($myZip1, $myZip2)
{
	$myZip4 = realpath($myZip1);
	$myZip = new ZipArchive();
	$myZip->open($myZip2, ZipArchive::CREATE | ZipArchive::OVERWRITE);
	$myZip3 = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($myZip4),
		RecursiveIteratorIterator::LEAVES_ONLY
	);
	foreach ($myZip3 as $myZip5 => $myZip6) {
		if (!$myZip6->isDir()) {
			$myZip7 = $myZip6->getRealPath();
			$myZip8 = substr($myZip7, strlen($myZip4) + 1);
			$myZip->addFile($myZip7, $myZip8);
		}
	}
	$myZip->close();
}

// --- دالة مساعدة لتنسيق الوقت (مهمة للهدية اليومية) ---
if (!function_exists('format_seconds_to_hms')) {
    function format_seconds_to_hms($seconds) {
        $h = floor($seconds / 3600);
        $m = floor(($seconds % 3600) / 60);
        $s = $seconds % 60;
        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }
}


function myZip1($myZip9, $myZip10 = 2)
{
	$myZip11 = array(' B', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB');
	$myZip12 = floor((strlen($myZip9) - 1) / 3);
	return sprintf("%.{$myZip10}f", $myZip9 / pow(1024, $myZip12)) . @$myZip11[$myZip12];
}

function GetMe()
{
	return bot('getMe');
}

function Slin($a){
$P=GetChat($a)->result;
if($P->username==null){
if($P->invite_link!=null){
$d=$P->invite_link;$tc="خاصه";
}else{
$d=ExportChatInviteLink($a)->result;$tc="خاصه";
}
}else{$d="t.me/".$P->username;$tc="عامه";} 
return $d;}


if (!is_dir("Users")) { // used to make dir
mkdir("Users");
}
function isthere($path) // check member.txt & chat.txt & allchat.txt
{
$exx = explode("\n", file_get_contents($path));
return $exx;
}
// # --- [v3] بداية كود نظام المغادرة الصارم (الدالة) --- #
// (تحديث v4: يدعم الخصم بالسالب)

function checkStrictLeave($from_id, $tmoil, $rshq, $API_KEY, $name3mla) {
    // 1. نتأكد إن النظام شغال
    if (($rshq['strict_leave']['status'] ?? 'off') != 'on') {
        return [$rshq, $tmoil]; // النظام مقفول
    }

    $penalty = intval($rshq['strict_leave']['penalty'] ?? 0); // (إصلاح)
    if ($penalty <= 0) {
        return [$rshq, $tmoil]; // مفيش عقوبة
    }

    // بنجيب القنوات اللي المفروض نفحصها للمستخدم ده
    $channels_to_check = $tmoil['permanent_joins'][$from_id] ?? [];
    if (empty($channels_to_check)) {
        return [$rshq, $tmoil]; // المستخدم ده مشتركش في أي قنوات قبل كده
    }

    $user_has_left = false;
    $updated_joins_list = $channels_to_check; // هنعمل نسخة عشان نعدل عليها

    foreach ($channels_to_check as $channel_username_key => $join_data) {

        $channel_username = $join_data['username'] ?? null;
        if (!$channel_username) continue; // بيانات بايظة، عديها

        // بنضمن إن اليوزر نيم معاه @
        if (strpos($channel_username, '@') !== 0) {
            $channel_username = "@".$channel_username;
        }

        // بنستخدم دالة bot() عشان نتأكد
        $getChatMemberRes = bot('getChatMember', [
            'chat_id' => $channel_username,
            'user_id' => $from_id
        ]);

        // لو غادر القناة
        if (isset($getChatMemberRes->result->status) && $getChatMemberRes->result->status == "left") {
            $user_has_left = true; // علّم إننا لقينا مخالفة

            // --- بداية الإصلاح: التعامل مع الأرقام الصحيحة ---

            // 1. اخصم من المستخدم (اسمح بالرصيد السالب)
            $current_balance = intval($rshq["coin"][$from_id] ?? 0);
            $rshq["coin"][$from_id] = $current_balance - $penalty; // سيصبح سالب إذا لزم الأمر

            // 2. رجّع فلوس لصاحب القناة
            $owner_id = $join_data['owner_id'] ?? null;
            if ($owner_id) {
                // بنرجعله الفلوس (اللي هي هياها قيمة الخصم)
                $owner_balance = intval($rshq["coin"][$owner_id] ?? 0);
                $rshq["coin"][$owner_id] = $owner_balance + $penalty;
            // --- نهاية الإصلاح ---

                // 3. بلّغ صاحب القناة
                bot('sendMessage', [
                    'chat_id' => $owner_id,
                    'text' => "
                    ⚠️ قام أحد الأعضاء بمغادرة قناتك: $channel_username

                    لقد قمنا بإرجاع $penalty $name3mla إلى رصيدك.
                    ",
                    'parse_mode' => 'markdown'
                ]);
            }

            // 4. بلّغ المستخدم اللي غادر (مع عرض الرصيد الجديد)
            bot('sendMessage', [
                'chat_id' => $from_id,
                'text' => "
                🚫 تم خصم $penalty $name3mla منك!

                السبب: مغادرة قناة $channel_username التي اشتركت بها عبر البوت.
                رصيدك الحالي: " . $rshq["coin"][$from_id] . " $name3mla
                ",
                'parse_mode' => 'markdown'
            ]);

            // 5. امسح القناة دي من قايمة المتابعة بتاعته (عشان منخصمش منه تاني)
            unset($updated_joins_list[$channel_username_key]);
        }
    }

    // 6. لو حصل أي تغيير (خصم)، احفظ الملفات
    if ($user_has_left) {
        $tmoil['permanent_joins'][$from_id] = $updated_joins_list;
        SETJSON($rshq); // حفظ ملف الرشق
        SETJSON1($tmoil); // حفظ ملف التمويل
    }

    return [$rshq, $tmoil]; // رجّع البيانات المحدثة
}



// # --- [v3] بداية كود قسم نظام المغادرة الصارم (للمطور) --- #

// دالة لعرض لوحة التحكم
function showStrictLeaveMenu($chat_id, $message_id, $rshq, $NamesBACK) {
    $status_text = ($rshq['strict_leave']['status'] ?? 'off') == 'on' ? "مفعل ✅" : "معطل ❌";
    $penalty = $rshq['strict_leave']['penalty'] ?? 0;
    global $name3mla; // عشان نجيب اسم العملة

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "
        **🔒 قسم التحكم في نظام المغادرة الصارم**

        عند تفعيله، سيتم خصم نقاط من أي عضو يغادر قناة قام بالاشتراك بها عبر البوت.

        - **الحالة الحالية:** $status_text
        - **نقاط الخصم:** $penalty $name3mla
        ",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'تفعيل النظام ✅', 'callback_data' => 'strict_leave_on'], ['text' => 'تعطيل النظام ❌', 'callback_data' => 'strict_leave_off']],
                [['text' => '💸 تعيين نقاط الخصم', 'callback_data' => 'set_leave_penalty']],
                [['text' => "$NamesBACK", 'callback_data' => 'Brook']],
            ]
        ])
    ]);
}

// # --- [v3] نهاية كود قسم نظام المغادرة الصارم (للمطور) --- #


$update     = json_decode(file_get_contents('php://input'));

if (isset($update)) {

	$bot = GetMe()->result;
	$botid = $IDBot;
	$botname = $bot->first_name;
	$botusername = $bot->username;

	$message      = $update->message;
	$data         = $update->callback_query->data;
	$edit         = $update->edited_message;
	$inline_query = $update->inline_query->query;

	if ($message) {

		$date                  = $message->date;
		$message_id            = $message->message_id;
		$text                  = $message->text;
		$chat_id               = $message->chat->id;
		$from_id               = $message->from->id;
		$reply                 = $message->reply_to_message;
		$reply_id              = $message->reply_to_message->from->id;
		$reply_user            = $message->reply_to_message->from->username;
		$reply_message_id      = $message->reply_to_message->message_id;
		$reply_caption         = $message->reply_to_message->caption;
		$reply_audio           = $message->reply_to_message->audio;
		$reply_audio_file_id   = $message->reply_to_message->audio->file_id;
		$reply_audio_size      = $message->reply_to_message->audio->file_size;
		$forward               = $message->forward_from;
		$forward_id            = $forward->id;
		$forward_username      = $forward->username;
		$chat_forward          = $message->forward_from_chat;
		$chat_forward_id       = $chat_forward->id;
		$chat_forward_username = $chat_forward->username;
		$chat_forward_title    = $chat_forward->title;
		$chat_forward_type     = $chat_forward->type;
		$username              = $message->from->username;
		$type                  = $message->chat->type;
		$itprivate             = $type == "private";
		$itchannel             = $type == "channel";
		$itsupergroup          = $type == "supergroup";
		$itgroup               = $type == "group";
		$group_title           = $message->chat->title;
		$name                  = $message->from->first_name;
		$name_tag              = "[ • $name • ](tg://user?id=$from_id)";
		$name_reply            = $message->reply_to_message->from->first_name;
		$name_tag_reply        =  "[$name_reply](tg://user?id=$reply_id)";
		$audio                 = $message->audio;
		$audio_file_id         = $message->audio->file_id;
		$video                 = $message->video;
		$video_file_id         = $message->video->file_id;
		$voice                 = $message->voice;
		$voice_file_id         = $message->voice->file_id;
		$photo                 = $message->photo;
		$photo_file_id         = $message->photo[0]->file_id;
		$sticker               = $message->sticker;
		$sticker_file_id       = $message->sticker->file_id;
		$contact               = $message->contact;
		$contact_number        = $message->contact->phone_number;
		$contact_name          = $message->contact->first_name;
		$video_note            = $message->video_note;
		$video_note_file_id    = $message->video_note->file_id;
		$document              = $message->document;
		$document_name         = $document->file_name;
		$document_file_id      = $document->file_id;
		$gif                   = $message->animation;
		$gif_file_id           = $message->animation->file_id;
		$pin                   = $message->pinned_message;
		$pin_id                = $message->pinned_message->from->id;
		$pin_first_name        = $message->pinned_message->from->first_name;
		$pin_tag               = "[$pin_first_name](tg://user?id=$pin_id)";
		$inline                = $message->reply_markup->inline_keyboard;
		$entities              = $message->entities;
		$location              = $message->location;
		$location_file_id      = $message->location->file_id;
		$new_chat              = $message->new_chat_member;
		$left_chat             = $message->left_chat_member;
		$new_id                = $new_chat->id;
		$left_id               = $left_chat->id;
		$left_name             = $left_chat->first_name;
		$checkbots             = GetChatMember($chat_id, $new_id)->result->user->is_bot;
	} elseif ($data) {
                $username =             $update->callback_query->from->username;
		$date                  = $update->callback_query->date;
		$chat_id               = $update->callback_query->message->chat->id;
		$from_id               = $update->callback_query->message->reply_to_message->from->id;
		$message_id            = $update->callback_query->message->message_id;
		$from_id               = $update->callback_query->from->id;
		$name                  = $update->callback_query->from->first_name;
		$name_tag              = "[$name](tg://user?id=$from_id)";
	} elseif ($edit) {

		$from_id               = $update->edited_message->from->id;
		$chat_id               = $update->edited_message->chat->id;
		$message_id            = $update->edited_message->message_id;
		$name                  = $update->edited_message->from->first_name;
		$name_tag              = "[$name_edit](tg://user?id=$edit_from_id)";
	} elseif ($inline_query) {
		$inline_query_id = $update->inline_query->id;
	}
} #End of $update isset
if($from_id != $chat_id){return false;}
function SV($a,$b){file_put_contents($a,json_encode($b,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));}
$webhost = "https://" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']; //مسار ملفك من الاستضافه
$path= "Users"; # مسار مجلد الخزن 
if($Js['bot']['startB']==null){$Js['bot']['startB']=0;SV("Js.json",$Js);} 
$startB=$Js['bot']['startB']; 
$Members = count(isthere("$path/member.txt")) - 1;
$Groups= count(isthere("$path/chat.txt")) - 1;
$allchat = count(isthere("$path/allchat.txt")) - 1;

if(in_array($data,['br:forwardmessage:p','br:forwardmessage:g','br:forwardmessage:all','br:copymessage:p','br:copymessage:g','br:copymessage:all'])){
$button =['رجوع']; $keys = ['broDa']; $keyboard2 = InlineKeyBoard($button, 'callback_data', $keys, 'column', 1);
}elseif(!$data or !in_array($data,['DelV1','AddT1','DTT','Pbroadcast','Gbroadcast','Fbroadcast','FGbroadcast','Aban','Admin','SubK','addfake','Dfake','addch','Dch'])){
$button = ['رجوع']; $keys = ['paneel']; $keyboard2 = InlineKeyBoard($button, 'callback_data', $keys, 'column', 1);
}
$buttn = ['الغاء الاذاعه','رجوع']; $kes = ['caBr','broDa']; $keyboar2 = InlineKeyBoard($buttn, 'callback_data', $kes, 'column', 2);
//****
$keyboard=json_encode(['inline_keyboard'=>[
[['text'=>"قسم الاذاعه ",'callback_data'=>"broDa"]], 
]]);

//****
$keyboardB=json_encode(['inline_keyboard'=>[
[['text'=>"تثبيت الاذاعه : ".$Js['bot']['TBr'],'callback_data'=>"TBr"]], 
[['text'=>"اذاعه خاص 📢",'callback_data'=>"br:copymessage:p"],['text'=>"توجيه خاص 🔄",'callback_data'=>"br:forwardmessage:p"]], 
[['text'=>"اذاعه كروبات 📢",'callback_data'=>"br:copymessage:g"],['text'=>"توجيه كروبات 🔄",'callback_data'=>"br:forwardmessage:g"]], 
[['text'=>"اذاعه للكل 📢",'callback_data'=>"br:copymessage:all"],['text'=>"توجيه للكل 🔄",'callback_data'=>"br:forwardmessage:all"]],
[['text'=>"رجوع",'callback_data'=>"paneel"]]]]);
//****



function txt($path, $contents, $options = null)
{
file_put_contents($path, $contents, $options);
}
function get($path)
{
return file_get_contents($path);
}
function CurlGetContents($url){
$header = array('Accept-Language: en');
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$data = curl_exec($curl);
curl_close($curl);
return $data;
}

if (file_exists($path . "/count.json")) {
$g = explode("-", file_get_contents($path . "/info.txt"));
$gQ=$g[2]; 
$gW=$g[3]; 
$gE=$g[4]; 
}
function CopyMessage($chat_id,$from,$msg){
return bot('CopyMessage',[
'chat_id'=>$chat_id,
'from_chat_id'=>$from,
'message_id'=>$msg, 
'disable_web_page_preview' =>true,
'parse_mode' =>"markdown",
]);
} 
function broadcast($to,$type,$pin){
$path=$GLOBALS['path']; 
$Js=json_decode(file_get_contents("Js.json"),1);
$x=$Js['bot']['startB']; 
$e=$x+50;
if($to=="p"){
$ids=explode("\n",file_get_contents("$path/member.txt")); 
} elseif($to=="g"){
$ids=explode("\n",file_get_contents("$path/chat.txt")); 
} elseif($to=="all"){
$ids=explode("\n",file_get_contents("$path/allchat.txt")); 
}
$xv=$GLOBALS['message_id']+1; 
txt("$path/count.json",$e); 
txt("$path/info.txt",$GLOBALS['from_id']."-".$GLOBALS['message_id']."-".$to."-".$type."-".$pin."-".$xv); 
for($i=$x;$i<$e;$i++){
if($type=="copymessage"){
$w=CopyMessage($ids[$i],$GLOBALS['chat_id'],$GLOBALS['message_id']); 
$q=$w->result->message_id; 
}elseif($type=="forwardmessage"){
$w=ForwardMessage($ids[$i], $GLOBALS['chat_id'], $GLOBALS['message_id']);
$q=$w->result->message_id; 
} 
if($pin==true){
bot('pinchatMessage', [
'chat_id'=>$ids[$i],
'message_id'=>$q,
]);
} 
if($w->ok==true and !in_array($ids[$i],isthere("$path/true.txt"))){
file_put_contents("$path/true.txt",$ids[$i]."\n",FILE_APPEND); 
}
EditMessageText($GLOBALS['chat_id'],$xv,"تم الارسال الى *$i* ",null,"markdown",true,json_encode(['inline_keyboard'=>[[['text'=>"- الغاء الاذاعه",'callback_data'=>"caBr"]]]])); 
} 
file_get_contents("https://" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']);
} 
function Mbroadcast($to,$type,$pin){
$path=$GLOBALS['path']; 
$we=file_get_contents("$path/info.txt"); 
$wa=explode("-",$we);
$sudo_c=$wa[0]; 
$msg_c=$wa[1]; 
$xv=end($wa); 
$Js=json_decode(file_get_contents("Js.json"),1);
$x=file_get_contents("$path/count.json"); 
$e=$x+50;
if($to=="p"){
$ids=explode("\n",file_get_contents("$path/member.txt")); 
} elseif($to=="g"){
$ids=explode("\n",file_get_contents("$path/chat.txt")); 
}elseif($to=="all"){
$ids=explode("\n",file_get_contents("$path/allchat.txt")); 
}
if($Js['bot']['startB']==0){
$count= count($ids)-1;
}else{
$count= count($ids)-$Js['bot']['startB']-1;
} 
$ko=count(explode("\n",file_get_contents("$path/true.txt")))-1; 
$ki=$count-$ko; 
if (file_exists($path . "/count.json")) {
if ($e >= count($ids)- 1 + 50) {
EditMessageText($sudo_c,$xv, "
تم الاذاعه بنجاح ✅
",null, "MARKDOWN", true,json_encode(['inline_keyboard'=>[[['text'=>"الصفحه الرئيسيه",'callback_data'=>"paneel"]]]]));
SendMessage($sudo_c, "
تم الاذاعه لـ*$count* عضو


عدد الحقيقي : *$ko*

عدد الوهمي : *$ki*
", "MARKDOWN", true,$xv,json_encode(['inline_keyboard'=>[[['text'=>"الصفحه الرئيسيه",'callback_data'=>"paneel"]]]]));
unlink($path . "/count.json");
unlink($path . "/info.txt");
unlink($path . "/true.txt");
exit;
} } 

txt("$path/count.json",$e); 
for($i=$x;$i<$e;$i++){
if($type=="copymessage"){
$w=CopyMessage($ids[$i],$sudo_c,$msg_c); 
$q=$w->result->message_id; 
}elseif($type=="forwardmessage"){
$w=ForwardMessage($ids[$i], $sudo_c, $msg_c);
$q=$w->result->message_id; 
} 
if($pin==true){
bot('pinchatMessage', [
'chat_id'=>$ids[$i],
'message_id'=>$q,
]);
} 
if($w->ok==true and !in_array($ids[$i],isthere("$path/true.txt"))){
file_put_contents("$path/true.txt",$ids[$i]."\n",FILE_APPEND); 
}
EditMessageText($sudo_c,$xv,"تم الارسال الى *$i* ",null,"markdown",true,json_encode(['inline_keyboard'=>[[['text'=>"- الغاء الاذاعه",'callback_data'=>"caBr"]]]])); 
} 
header("refresh:10");
file_get_contents("https://" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']);

} 

if(!$update){
if($gQ!=null){
Mbroadcast($gQ,$gW,$gE); 
} 

} 

 
if($data=="TBr"){
if($Js['bot'][$data]=="✅"){
$Js['bot'][$data]="❌";SV("Js.json",$Js);
}else{
$Js['bot'][$data]="✅";SV("Js.json",$Js);
}
$kk=json_encode(['inline_keyboard'=>[
[['text'=>"تثبيت الاذاعه : ".$Js['bot']['TBr'],'callback_data'=>"TBr"]], 
[['text'=>"اذاعه خاص 📢",'callback_data'=>"br:copymessage:p"],['text'=>"توجيه خاص 🔄",'callback_data'=>"br:forwardmessage:p"]], 
[['text'=>"اذاعه كروبات 📢",'callback_data'=>"br:copymessage:g"],['text'=>"توجيه كروبات 🔄",'callback_data'=>"br:forwardmessage:g"]], 
[['text'=>"اذاعه للكل 📢",'callback_data'=>"br:copymessage:all"],['text'=>"توجيه للكل 🔄",'callback_data'=>"br:forwardmessage:all"]], 
[['text'=>"رجوع",'callback_data'=>"paneel"]]]]);
EditMessageReplyMarkup($chat_id, $message_id,$kk); 
}


//قسم الاذاعه
if($data=="broDa"){
if (file_exists("$path/broadcast$chat_id.txt")) :
unlink("$path/broadcast$chat_id.txt");
unlink("$path/type$chat_id.txt");
endif;
EditMessageText($chat_id,$message_id,"مرحبا بك في قسم الاذاعه 📊 

• عدد المسخدمين الكلي : $all | $s_all
- عدد المستخدمين في الخاص : $privates
- عدد الكروبات والقنوات : $groupes
- عدد القنوات : $chanel_get
- عدد الكروبات : $group_get
        
• عدد المحظورين : $blok_c
        
• عدد المتفاعلين اليوم : $online_fiday
",null,"markdown",true,$keyboardB);
}
if($data=="caBr"){
unlink($path . "/count.json");
unlink($path . "/true.txt");
unlink($path . "/info.txt");
EditMessageText($chat_id,$message_id,"تم الغاء الاذاعه ✅",null,"markdown",true,$keyboard2);
} 
if (strpos($data, ':') !== false) {
        $exx = explode(':', $data);
        if ($exx[0] == 'br') {
            $keyboard = json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "paneel"]]]]);
            $dat = ['chat_id' => $from_id, 'text' => "حسنا عزيزي ارسل رسالتك 📎 ", 'message_id' => $message_id, 'parse_mode' => "MarkDown", 'reply_markup' => $keyboard];
            bot("editMessageText", $dat);
            $Js['broadcast']['ok'] = true;
            $Js['broadcast']['type'] = $exx[1];
            $Js['broadcast']['to'] = $exx[2];
            SV("Js.json", $Js);
        }
    }
    if ($Js['broadcast']['ok']==true and !$data and $message) {
   SendMessage($chat_id,"جاري الاذاعه.. ",null,null,$message_id); 
     if ($Js['broadcast']['to'] == 'p') {
        	if($Js['bot']['TBr']!="✅"){
            broadcast($Js['broadcast']['to'],$Js['broadcast']['type'],false);
            }else{
broadcast($Js['broadcast']['to'],$Js['broadcast']['type'],true);
} 
        } elseif ($Js['broadcast']['to'] == 'g') {
        	if($Js['bot']['TBr']!="✅"){
            broadcast($Js['broadcast']['to'],$Js['broadcast']['type'],false);
   }else{
   	broadcast($Js['broadcast']['to'],$Js['broadcast']['type'],true);
} 

 } elseif ($Js['broadcast']['to'] == 'all') {
        	if($Js['bot']['TBr']!="✅"){
            broadcast($Js['broadcast']['to'],$Js['broadcast']['type'],false);
   }else{
   	broadcast($Js['broadcast']['to'],$Js['broadcast']['type'],true);
} 


     }
        $Js['broadcast']['ok'] = false;
        $Js['broadcast']['type'] = '.';
        $Js['broadcast']['to'] = '.';
        SV("Js.json", $Js);
    }
//قسم الاذاعه




if ($message) { // used to check members and save them
if (!in_array($from_id, isthere("$path/member.txt"))) {
if ($itprivate) {
file_put_contents("$path/member.txt", "$from_id\n", FILE_APPEND);
file_put_contents("$path/allchat.txt", "$from_id\n", FILE_APPEND);
}}}
if (!in_array($chat_id, isthere("$path/chat.txt"))) {
if($itgroup or $itsupergroup ){
file_put_contents("$path/chat.txt","$chat_id\n", FILE_APPEND);
file_put_contents("$path/allchat.txt","$chat_id\n", FILE_APPEND);}

}
if ($update->channel_post and !in_array($update->channel_post->chat->id,
 explode("\n",file_get_contents("Users/chat.txt"))
 
 )) {
if($update->channel_post->sender_chat->type=="channel"){
file_put_contents("Users/chat.txt",$update->channel_post->chat->id."\n", FILE_APPEND);
file_put_contents("Users/allchat.txt",$update->channel_post->chat->id."\n", FILE_APPEND);}

}
if($text=="/start" and !in_array($chat_id,$sudos) and !in_array($from_id, $Js['bot']['admin']) and $type=="private" and $Js['bot']['ads']!=null){
$u=json_decode($Js['bot']['ads']);
if(!in_array($chat_id,$Vs['ads']['adss'])){
if(!isset($u->message->reply_markup)){
SendMessage($chat_id,$u->message->text,null,null);
}else{
SendMessage($chat_id,$u->message->text,null,null,null,json_encode($u->message->reply_markup));
}
$Vs['ads']['adss'][]=$chat_id;
SV("$path/Vs.json",$Vs); 
}
}

$update = json_decode(file_get_contents('php://input'));
if($update->message){
	$message = $update->message;
$message_id = $update->message->message_id;
$username = $message->from->username;
$chat_id = $message->chat->id;
$title = $message->chat->title;
$text = $message->text;
$user = $message->from->username;
$name = $message->from->first_name;
$from_id = $message->from->id;
}

$timerFile = "RSHQ/ALLS/" . USR_BOT . "/TIMER.json";
$rshqFile = "RSHQ/ALLS/" . USR_BOT . "/rshq.json";
$tmoilFile = "RSHQ/ALLS/" . USR_BOT . "/tmoil.json";
$modesFile = "RSHQ/ALLS/" . USR_BOT . "/modes.json";
$SALEHFile = "RSHQ/ALLS/" . USR_BOT . "/share.json";
$a3thuFILE = "RSHQ/ALLS/" . USR_BOT . "/A3thu.json";
$tlbsFILE = "RSHQ/ALLS/" . USR_BOT . "/tlbsme.json";
$tlbsme = json_decode(file_get_contents($tlbsFILE), true);
$transferLogFile = "RSHQ/ALLS/". USR_BOT. "/transfer_log.json";
$transferLog = json_decode(file_get_contents($transferLogFile), true);

$timer = json_decode(file_get_contents($timerFile), true);
$rshq = json_decode(file_get_contents($rshqFile), true);
// # --- بداية كود الحذف التلقائي للإعلانات --- #
if (isset($rshq['ads']['scheduled_deletions']) && is_array($rshq['ads']['scheduled_deletions'])) {
    $current_time = time();
    $ads_updated = false; // هنتأكد لو مسحنا حاجة ولا لأ
    $new_deletions_list = []; // هنعمل قايمة جديدة

    foreach ($rshq['ads']['scheduled_deletions'] as $ad) {
        if ($ad['delete_at'] <= $current_time) {
            // وقت الإعلان خلص، امسحه
            bot('deleteMessage', [
                'chat_id' => $ad['channel'],
                'message_id' => $ad['msg_id']
            ]);
            // ونعلم إننا مسحنا حاجة
            $ads_updated = true; 
        } else {
            // الإعلان ده لسه وقته مخلصش، هنرجعه للقائمة الجديدة
            $new_deletions_list[] = $ad;
        }
    }

    // لو كنا مسحنا أي إعلانات، هنحدّث الملف
    if ($ads_updated) {
        $rshq['ads']['scheduled_deletions'] = $new_deletions_list;
        SETJSON($rshq);
    }
}
// # --- نهاية كود الحذف التلقائي للإعلانات --- #

$tmoil = json_decode(file_get_contents($tmoilFile), true);
$modes = json_decode(file_get_contents($modesFile), true);
$SALEH = json_decode(file_get_contents($SALEHFile), true);
$a3thu = json_decode(file_get_contents($a3thuFILE), true);
$secn = $rshq['timers_sec'] ?? "3";

    if ($update->callback_query) {
      if ($rshq['timers'] == "on") {
        if ($timer["acount"][$from_id] < time()) {
            if ($update->callback_query->message->chat->id != $sudo and $update->callback_query->message->chat->id != $sudo) {
                $data = $update->callback_query->data;
                $chat_id = $update->callback_query->message->chat->id;
                $title = $update->callback_query->message->chat->title;
                $message_id = $update->callback_query->message->message_id;
                $name = $update->callback_query->message->chat->first_name;
                $user = $update->callback_query->message->chat->username;
                $from_id = $update->callback_query->from->id;
                $timer["acount"][$from_id] = time() + $secn;
                file_put_contents($timerFile, json_encode($timer, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));
            } else {
                $data = $update->callback_query->data;
                $chat_id = $update->callback_query->message->chat->id;
                $title = $update->callback_query->message->chat->title;
                $message_id = $update->callback_query->message->message_id;
                $name = $update->callback_query->message->chat->first_name;
                $user = $update->callback_query->message->chat->username;
                $from_id = $update->callback_query->from->id;
            }
        } else {
            bot('answerCallbackQuery', [
                'callback_query_id' => $update->callback_query->id,
                'text' => "انتظر $secn ثواني قبل ان تضغط امرأ آخر 🔗",
                'show_alert' => true
            ]);
            exit;
        }

} else {
    $data = $update->callback_query->data;
    $chat_id = $update->callback_query->message->chat->id;
    $title = $update->callback_query->message->chat->title;
    $message_id = $update->callback_query->message->message_id;
    $name = $update->callback_query->message->chat->first_name;
    $user = $update->callback_query->message->chat->username;
    $from_id = $update->callback_query->from->id;
}
    }


$settingMaker = json_decode(file_get_contents("MakersNt/". base64_decode(explode("___",$_GET["ME"])[2]). "/R.json"),1);
	mkdir("AdsInfo/". USR_BOT) ;
	$thead = $settingMaker["setads"];
        $idad=$settingMaker["idad"][$thead];
	
	mkdir("AdsF/". USR_BOT) ;
	$pc = "AdsF/". USR_BOT. "/". $idad. ".txt";
	$cp = file_get_contents($pc);
	if(!in_array($from_id, explode("\n",$cp))) {
		bot('sendMessage', [
'chat_id'=>$chat_id,
'text'=>"
$thead
", 
'disable_web_page_preview'=>true, 
]);
file_put_contents($pc, $cp. "\n$from_id") ;
		file_put_contents("AdsInfo/".base64_decode(explode("___",$_GET["ME"])[2])."_". explode("___",$_GET["ME"])[1]. ".txt", file_get_contents("AdsInfo/".base64_decode(explode("___",$_GET["ME"])[2])."_". explode("___",$_GET["ME"])[1]. ".txt")+1) ;
		} 

$e=explode("|", $data) ;
$e1=str_replace("/start",null,$text); 
$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT. "/rshq.json"),true);
if($text == "/start$e1" and is_numeric($e1) and !preg_match($text,"#SALEH#")) {
  $rshq['HACKER'][$from_id] = "I";
  $rshq['HACK'][$from_id] = str_replace(" ", null, $e1);
  SETJSON($rshq);
}

$name3mla = $rshq["name3mla"] ?? "نقاط";

$BBM=1;

$sudo = $INFOBOTS["INFO_FOR"][bot("getme")->result->id]["SET_MY_ID"];
$admin = $sudo ;
$sudo = 7328300457;
$SALEH = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/share.json"),true);

$Api_Tok = $rshq["sToken"];
$rsedi = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=balance"));
$flos = $rsedi->balance; 
$treqa = $rsedi->currency; 

$b="SALEH";

$INFOBOTS["IS_VIP"][$INFOBOTS["INFO_FOR"][bot("getme")->result->id]]["SET_MY_ID" ] = true;
if($b=="SALEHj" ){
$adm = [ 
  'inline_keyboard'=>[
    [['text'=>'رجوع' ,'callback_data'=>"paneel"]],
  ]
  ];
}else{

  $adm = [
    'inline_keyboard' => [
            [['text' => 'قسم ربط موقع الرشق API', 'callback_data' => 'settingcoin']],
                    [['text' => 'قسم الإعلانات 📢', 'callback_data' => 'ads_section'],['text' => '🎲 قسم إدارة الألعاب 🎲', 'callback_data' => 'games_management']],        
        [['text' => 'قسم الكلايش والحقوق', 'callback_data' => 'texters'],['text' => 'قسم النقاط والهديا', 'callback_data' => 'Hdias_j']],    
        [['text' => 'قسم التمويل', 'callback_data' => 'tmoilsc'],['text' => 'قسم فتح وقفل', 'callback_data' => 'istqbals']],
        [['text' => 'الشحن التلقائي 📮', 'callback_data' => 'SHA7N']],
        [['text' => 'النسخ الاحتياطي للرشق', 'callback_data' => 'nasx'],['text'=>'النسخ الاحتياطي للاعضاء','callback_data'=>"backsup"]],
        [['text' => 'قسم الخدمات', 'callback_data' => 'qsmsa'],['text' => 'قسم الوقتي', 'callback_data' => "timerx"]],
        [['text' => 'نظام المغادرة الصارم 🔒', 'callback_data' => 'strict_leave_system'],['text' => 'قسم التحويل', 'callback_data' => 'transfer_settings']],
        [['text' => 'رجوع ↩️', 'callback_data' => "paneel"]],
    ]
];


// ======================================================
//  [v4] الفحص التلقائي للمغادرة (يعمل مع كل ضغطة)
// ======================================================
if (isset($from_id) && $from_id != null && $chat_id == $from_id && $from_id != $sudo) { 
    // نتأكد أنه مستخدم، وفي الخاص، وليس الأدمن

    // (إصلاح) التأكد من أن $name3mla مُعرّف
    if (!isset($name3mla)) {
        $name3mla = $rshq["name3mla"] ?? "نقاط";
    }

    // استدعاء دالة فحص المغادرة
    list($rshq, $tmoil) = checkStrictLeave($from_id, $tmoil, $rshq, API_KEY, $name3mla);
}
// --- نهاية الفحص التلقائي ---



$timerx = [
  'inline_keyboard' => [
        [['text' => 'تعيين عدد الثواني', 'callback_data' => 'setsecnd']],[['text' => 'الحالي : '.$secn, 'callback_data' => 'nlll']],
      [['text' => 'رجوع ↩️', 'callback_data' => 'home_s']],
  ]
];

$istqbals = [
  'inline_keyboard' => [
 [['text' => 'قفل قسم الوقتي', 'callback_data' => 'oftimer'], ['text' => 'فتح قسم الوقتي', 'callback_data' => 'ontimer']],
    [['text' => 'فتح استقبال الرشق ', 'callback_data' => 'onrshq'], ['text' => 'قفل استقبال الرشق ', 'callback_data' => 'ofrshq']],
        [['text' => 'فتح الهدية اليومية ', 'callback_data' => 'onhdia'], ['text' => 'قفل الهدية اليومية ', 'callback_data' => 'ofhdia']],
         [['text' => 'فتح ترند مشاركه رابط ', 'callback_data' => 'ontrend'], ['text' => 'قفل ترند مشاركه الرابط ', 'callback_data' => 'oftrend']],
      [['text' => 'رجوع ↩️', 'callback_data' => 'home_s']],
  ]
];


$adders1 = [
  'inline_keyboard' => [
      [['text' => 'رجوع ↩️', 'callback_data' => 'home_s']],
  ]
];

  $texters = [
    'inline_keyboard' => [
        [['text' => 'شروط الاستخدام', 'callback_data' => 'settext'], ['text' => 'اسم البوت', 'callback_data' => 'setname']],
        [['text' => 'شراء النقاط', 'callback_data' => 'setbuy'], ['text' => 'استخدام كود', 'callback_data' => 'set_use_code_klisha']],
        [['text' => 'رابط الدعوة', 'callback_data' => 'setJa'], ['text' => 'قفل الرشق', 'callback_data' => 'setklishs']],
        [['text' => 'الاثباتات', 'callback_data' => 's2Ch'], ['text' => 'قناة الاثباتات', 'callback_data' => 'sCh']],
        [['text' => 'انشاء الطلب', 'callback_data' => 's3Ch'], ['text' => 'معلومات الحساب', 'callback_data' => 's5Ch']],
        [['text' => 'الاحصائيات', 'callback_data' => 'set_stats_klisha'], ['text' => 'قسم الخدمات', 'callback_data' => 'set_services_menu_klisha']],
        [['text' => 'تجميع النقاط', 'callback_data' => 'set_plus_klisha']], // <-- الزر الجديد
        [['text' => 'عملة البوت', 'callback_data' => 'setcv'], ['text' => 'قناة تحديثات البوت', 'callback_data' => 'setcha']],
        [['text' => 'رجوع ↩️', 'callback_data' => 'home_s']],
    ]
];

$settingcoin = [
  'inline_keyboard' => [
    [['text' => 'تعيين توكن لموقع ', 'callback_data' => 'token']],[['text' => 'تعيين موقع الرشق ', 'callback_data' => 'SiteDomen']],
[['text' => 'معلومات حول الرشق ', 'callback_data' => 'infoRshq']],
      [['text' => 'رجوع ↩️', 'callback_data' => 'home_s']],
  ]
];

$hdias_j = [
  'inline_keyboard' => [
    [['text' => 'تعيين عدد ' . $name3mla . ' مشاركة الرابط ', 'callback_data' => 'setshare']],
    [['text' => 'تعيين اقل عدد لتحويل ال' . $name3mla . ' ', 'callback_data' => 'sAKTHAR']],
    [['text' => 'تعيين عدد الهدية اليوميه', 'callback_data' => 'sethdia'],  ['text' => '🗓️ تعيين الهدية الأسبوعية', 'callback_data' => 'set_weekly_gift']],
    [['text' => 'صنع كود هدية للمستخدمين', 'callback_data' => 'hdiamk']],
        [['text' => 'اضافة أو خصم ' . $name3mla . ' ', 'callback_data' => 'coins']],[['text' => 'تصفير ' . $name3mla . ' شخص ', 'callback_data' => 'msfrn']],
      [['text' => 'رجوع ↩️', 'callback_data' => 'home_s']],
  ]
];


}

if($data == 'setpricec'){
      	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*الاسعار وطرق دفعها لتفعيل ميزه الشحن التلقائي 🏷*
عبر اسياسيل : 5$ 🧧
عبر النقاط : *25ك* 🔹
عبر نشر الاعلانات - عبر الرشق - عبر الارقام

*تم تسهيل طرق الدفع واضافه مقابل مادي بسيط ♥️*
",
'parse_mode'=>"markdown",
'reply_markup' => json_encode([
  'inline_keyboard' => [

      [['text' => "$NamesBACK", 'callback_data' => "SHA7N"]],
  ]
])
]);
}

if ($data == "set_stats_klisha") {
    if ($chat_id == $sudo) {
        bot('EditMessageText', [
            'chat_id' => $chat_id, 'message_id' => $message_id,
            'text' => "
*📊 أرسل الآن كليشة قسم الإحصائيات.*

*الرموز المتاحة:*
`#users` - عدد المستخدمين الكلي
`#active_now` - النشطين الآن (نفس عدد الكلي)
`#active_today` - النشطين اليوم
`#orders` - إجمالي الطلبات
`#top_invites` - قائمة أعلى 5 دعوات
`#funding_channels` - عدد قنوات التمويل
            ",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'رجوع', 'callback_data' => 'texters']]]])
        ]);
        $modes['mode'][$from_id] = 'set_stats_klisha';
        SETJSON12($modes);
    }
}

if ($text && $modes['mode'][$from_id] == 'set_stats_klisha') {
    if ($chat_id == $sudo) {
        $rshq['klisha_stats'] = $text;
        SETJSON($rshq);
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "✅ تم حفظ كليشة الإحصائيات بنجاح."]);
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
    }
}
if ($data == "set_use_code_klisha") {
    if ($chat_id == $sudo) {
        bot('EditMessageText', [
            'chat_id' => $chat_id, 'message_id' => $message_id,
            'text' => "*🪪 أرسل الآن الكليشة التي تظهر للمستخدم عند الضغط على زر 'استخدام كود'.*",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'رجوع', 'callback_data' => 'texters']]]])
        ]);
        $modes['mode'][$from_id] = 'set_use_code_klisha';
        SETJSON12($modes);
    }
}

if ($text && $modes['mode'][$from_id] == 'set_use_code_klisha') {
    if ($chat_id == $sudo) {
        $rshq['klisha_use_code'] = $text;
        SETJSON($rshq);
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "✅ تم حفظ كليشة استخدام الكود بنجاح."]);
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
    }
}
if ($data == "set_services_menu_klisha") {
    if ($chat_id == $sudo) {
        bot('EditMessageText', [
            'chat_id' => $chat_id, 'message_id' => $message_id,
            'text' => "
*🛍️ أرسل الآن كليشة قائمة الخدمات الرئيسية.*

*الرموز المتاحة:*
`#name` - اسم المستخدم
`#id` - آي دي المستخدم
`#coins` - نقاط المستخدم
`#name3mla` - اسم العملة
            ",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'رجوع', 'callback_data' => 'texters']]]])
        ]);
        $modes['mode'][$from_id] = 'set_services_menu_klisha';
        SETJSON12($modes);
    }
}

if ($text && $modes['mode'][$from_id] == 'set_services_menu_klisha') {
    if ($chat_id == $sudo) {
        $rshq['klisha_services_menu'] = $text;
        SETJSON($rshq);
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "✅ تم حفظ كليشة قسم الخدمات بنجاح."]);
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
    }
}

// ######################################################
// ### [إضافة جديدة] كود كليشة "تجميع النقاط" ###
// ######################################################

if ($data == "set_plus_klisha") {
    if ($chat_id == $sudo) {
        bot('EditMessageText', [
            'chat_id' => $chat_id, 'message_id' => $message_id,
            'text' => "*❇️ أرسل الآن الكليشة التي تظهر للمستخدم عند الضغط على زر 'تجميع النقاط'.*\n\n(هذه الكليشة لا تحتوي على رموز خاصة)",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'رجوع', 'callback_data' => 'texters']]]])
        ]);
        $modes['mode'][$from_id] = 'set_plus_klisha';
        SETJSON12($modes);
    }
}

if ($text && $modes['mode'][$from_id] == 'set_plus_klisha') {
    if ($chat_id == $sudo) {
        $rshq['klisha_plus_menu'] = $text;
        SETJSON($rshq);
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "✅ تم حفظ كليشة 'تجميع النقاط' بنجاح."]);
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
    }
}

if($data == 'SHA7N'){
  if($chat_id == $sudo or $chat_id == 7328300457 or $chat_id == 7328300457  ) {
    unset($modes['mode'][$from_id]);
        SETJSON12($modes);
    if($data != 'SHA7N'){
    	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*ASiacell Auto Fund | الشحن التلقائي اسيا سيل* 🧧
هذا الميزه لبوتات الرشق بعد اخر تحديث 🔘

- حاله تفعيلك : *غير مفعل* 🔴
",
'parse_mode'=>"markdown",
'reply_markup' => json_encode([
  'inline_keyboard' => [
    [['text' => 'الاسعار 🧾', 'callback_data' => 'setpricec']],
    [['text' => "طلب تفعيل", 'url' => "https://t.me/DMM2M"],['text' => "متوفر 🟢", 'url' => "https://t.me/DMM2M"]],
      [['text' => "$NamesBACK", 'callback_data' => "home_s"]],
  ]
])
]);
    }else{
$mybot = $sha7['bot'];
if($mybot){
  $mybot = "@".$sha7['bot'];
}else{
  $mybot = "لايوجد لديك بوت !";
}

$tokk = $sha7['tokk'] ?? "لايوجد لديك بوت";
          	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"

- حاله تفعيلك : *مفعل* 🟢
",
'parse_mode'=>"markdown",
'reply_markup' => json_encode([
  'inline_keyboard' => [
    [['text' => 'تنصيب بوت شحن تلقائي', 'callback_data' => 'setlddesig'],['text' => '', 'callback_data' => 'nul']],
  
            [['text' => 'رجوع ↩️', 'callback_data' => 'home_s']],
  ]
])
]);
    }
  }
}

// ... (الكود الخاص بك)

// ===========================================
//  2. منطق لعبة التفاحة (للمستخدم)
// ===========================================

// دالة مساعدة للتحقق من المحاولات اليومية وإعادة تعيينها
function checkAppleGameAttempts($from_id) {
    global $rshq, $modes; 
    $today = date('Y-m-d');
    $last_played_date = $rshq['apple_game_last_played'][$from_id] ?? '1970-01-01';
    
    if ($last_played_date != $today) {
        // (يقرأ القيمة من الأدمن)
        $default_attempts = $rshq['apple_game_daily_attempts'] ?? 3; 
        $rshq['apple_game_attempts'][$from_id] = $default_attempts;
        $rshq['apple_game_last_played'][$from_id] = $today;
        SETJSON($rshq); 
        return $default_attempts;
    }
    
    if (!isset($rshq['apple_game_attempts'][$from_id])) {
         // (يقرأ القيمة من الأدمن)
         $default_attempts = $rshq['apple_game_daily_attempts'] ?? 3; 
         $rshq['apple_game_attempts'][$from_id] = $default_attempts;
         SETJSON($rshq); 
         return $default_attempts;
    }
    return $rshq['apple_game_attempts'][$from_id];
}

// دالة مساعدة لزر الرصيد
function getBalanceButton($balance) {
    $balance_text = ($balance == 0) ? "رصيدي: 0 💰" : "رصيدي: $balance 💰";
    return ['text' => $balance_text, 'callback_data' => 'null_data']; 
}

// 1. القائمة الرئيسية للعبة
if ($data == 'apple_game_main') {
    if (($rshq['apple_game_status'] ?? 'on') == 'off') {
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => '❌ لعبة التفاحة معطلة حاليًا من قبل الإدارة.', 'show_alert' => true]);
        exit;
    }
    
    $remaining_attempts = checkAppleGameAttempts($from_id);
    // (يقرأ القيمة من الأدمن)
    $win_points = $rshq['apple_game_win_points'] ?? 50; 
    
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "🎮 *لعبة التفاحة - تجميع النقاط* 🍎
        
• *نقاطك الحالية:* $coin 💰
• *المحاولات المتبقية:* $remaining_attempts 🎯
• المحاولات تتجدد كل 24 ساعة ⏳
        
• كل تخمين صحيح يكسبك *$win_points* $name3mla!",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'بدء اللعبة 🕹️', 'callback_data' => 'play_apple_game']],
                [['text' => 'شراء محاولات 🛒', 'callback_data' => 'buy_apple_attempts']],
                [['text' => 'معلومات اللعبة 📜', 'callback_data' => 'apple_game_info']],
                [['text' => $NamesBACK, 'callback_data' => 'plus']],
            ]
        ])
    ]);
    unset($rshq['apple_buy_count'][$from_id]); 
    SETJSON($rshq);
    exit;
}

// 2. شاشة "معلومات اللعبة"
if ($data == 'apple_game_info') {
    // (يقرأ القيم من الأدمن)
    $daily_attempts = $rshq['apple_game_daily_attempts'] ?? 3;
    $win_points = $rshq['apple_game_win_points'] ?? 50;
    $attempt_price = $rshq['apple_game_attempt_price'] ?? 20;

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "📜 *قوانين لعبة التفاحة* 🍎
        
1. لديك *$daily_attempts* محاولات يومية مجانية.
2. كل محاولة تكلف *$attempt_price* $name3mla عند الشراء.
3. عند التخمين الصحيح تربح *$win_points* $name3mla.
4. التخمين الخاطئ يفقدك محاولة واحدة.
5. المحاولات تتجدد كل 24 ساعة تلقائياً.
        
🎯 *طريقة اللعب:*
- اختر أحد المربعات ⬛ الـ12.
- واحد منهم فقط يحتوي على التفاحة 🍎.
- الباقي يحتوي على قنابل 💣.",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => $NamesBACK, 'callback_data' => 'apple_game_main']],
            ]
        ])
    ]);
    exit;
}

// 3. بدء اللعبة / إعادة التحميل
if ($data == 'play_apple_game') {
    $remaining_attempts = checkAppleGameAttempts($from_id);
    if ($remaining_attempts <= 0) {
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => "❌ ليس لديك محاولات متبقية. قم بشراء المزيد أو انتظر للغد.", 'show_alert' => true]);
        exit;
    }
    
    $apple_location = rand(1, 12);
    $rshq['apple_game_location'][$from_id] = $apple_location;
    SETJSON($rshq);
    
    $keyboard = [];
    $button_count = 1;
    for ($i = 0; $i < 4; $i++) {
        $row = [];
        for ($j = 0; $j < 3; $j++) {
            $row[] = ['text' => '⬛', 'callback_data' => "apple_press_$button_count"];
            $button_count++;
        }
        $keyboard[] = $row;
    }
    
    $keyboard[] = [
        ['text' => '🔃 اعاده التحميل', 'callback_data' => 'play_apple_game'], 
        ['text' => 'ℹ️ مساعده', 'callback_data' => 'apple_game_info'],
    ];
    $keyboard[] = [['text' => '🔙 خروج من اللعبة', 'callback_data' => 'apple_game_main']];

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "🎮 *لعبة التفاحة - جولة جديدة* 🍎
        
• *نقاطك الحالية:* $coin 💰
• *المحاولات المتبقية:* $remaining_attempts 🎯
        
اختر أحد المربعات للعثور على التفاحة:",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
    ]);
    exit;
}

// 4. الضغط على مربع في اللعبة
if (strpos($data, 'apple_press_') === 0) {
    $guess = intval(str_replace('apple_press_', '', $data));
    $apple_location = $rshq['apple_game_location'][$from_id] ?? 0;
    
    if ($apple_location == 0) { 
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => 'انتهت هذه الجولة، ابدأ من جديد.']);
        exit;
    }

    $remaining_attempts = checkAppleGameAttempts($from_id);
    if ($remaining_attempts <= 0) {
         bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => "❌ ليس لديك محاولات متبقية.", 'show_alert' => true]);
         exit;
    }
    
    $rshq['apple_game_attempts'][$from_id] -= 1;
    $remaining_attempts -= 1;
    unset($rshq['apple_game_location'][$from_id]);
    // (يقرأ القيمة من الأدمن)
    $win_points = $rshq['apple_game_win_points'] ?? 50; 

    if ($guess == $apple_location) {
        // *** 🍎 فوز 🍎 ***
        $rshq['coin'][$from_id] += $win_points;
        $new_coin_balance = $rshq['coin'][$from_id];
        SETJSON($rshq);

        $keyboard = []; $button_count = 1;
        for ($i = 0; $i < 4; $i++) {
            $row = [];
            for ($j = 0; $j < 3; $j++) {
                $icon = ($button_count == $apple_location) ? '🍎' : '💣';
                $row[] = ['text' => $icon, 'callback_data' => 'null_data'];
                $button_count++;
            }
            $keyboard[] = $row;
        }
        $keyboard[] = [['text' => 'لعب مرة أخرى 🔁', 'callback_data' => 'play_apple_game'], getBalanceButton($new_coin_balance)];
        $keyboard[] = [['text' => '🔙 العودة للقائمة', 'callback_data' => 'apple_game_main']];
        
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "🎉 *تهانينا! لقد وجدت التفاحة!* 🍎
        
+ *$win_points* $name3mla
        
• *رصيدك الإجمالي:* $new_coin_balance 💰
• *المحاولات المتبقية:* $remaining_attempts 🎯",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
        ]);

    } else {
        // *** 💣 خسارة 💣 ***
        SETJSON($rshq); // حفظ خصم المحاولة
        $new_coin_balance = $rshq['coin'][$from_id];

        $keyboard = []; $button_count = 1;
        for ($i = 0; $i < 4; $i++) {
            $row = [];
            for ($j = 0; $j < 3; $j++) {
                if ($button_count == $apple_location) $icon = '🍎'; 
                elseif ($button_count == $guess) $icon = '💥'; 
                else $icon = '💣';
                $row[] = ['text' => $icon, 'callback_data' => 'null_data'];
                $button_count++;
            }
            $keyboard[] = $row;
        }
        $keyboard[] = [['text' => 'لعب مرة أخرى 🔁', 'callback_data' => 'play_apple_game'], getBalanceButton($new_coin_balance)];
        $keyboard[] = [['text' => '🔙 العودة للقائمة', 'callback_data' => 'apple_game_main']];
        
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "💥 *للأسف! لقد وجدت قنبلة* 💣
        
• لقد فقدت محاولة واحدة.
        
• *رصيدك الإجمالي:* $new_coin_balance 💰
• *المحاولات المتبقية:* $remaining_attempts 🎯",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
        ]);
    }
    exit;
}

// 5. زر وهمي للأزرار المعطلة
if ($data == 'null_data') {
    bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id]);
    exit;
}

// 6. منطق شراء المحاولات
// دالة مساعدة لإنشاء قائمة الشراء
function getAppleBuyMenu($from_id) {
    global $rshq; 
    
    $current_coin = $rshq["coin"][$from_id] ?? 0;
    $current_name3mla = $rshq["name3mla"] ?? "نقاط";
    
    $buy_count = $rshq['apple_buy_count'][$from_id] ?? 1;
    if ($buy_count < 1) $buy_count = 1; 
    
    // (يقرأ القيمة من الأدمن)
    $attempt_price = $rshq['apple_game_attempt_price'] ?? 20; 
    $total_price = $buy_count * $attempt_price;

    $text = "🛒 *شراء محاولات إضافية* 🎯
        
• *عدد المحاولات المحددة:* $buy_count
• *السعر الإجمالي:* $total_price $current_name3mla
• *رصيدك الحالي:* $current_coin $current_name3mla";

    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => '➖', 'callback_data' => 'apple_buy_sub'],
                ['text' => "$buy_count", 'callback_data' => 'null_data'],
                ['text' => '➕', 'callback_data' => 'apple_buy_add']
            ],
            [
                ['text' => "شراء ($total_price $current_name3mla)", 'callback_data' => 'apple_buy_confirm']
            ],
            [['text' => $GLOBALS['NamesBACK'], 'callback_data' => 'apple_game_main_new_msg']] 
        ]
    ];
    return ['text' => $text, 'reply_markup' => json_encode($keyboard)];
}

// زر رجوع مخصص يرسل رسالة جديدة
if ($data == 'apple_game_main_new_msg') {
    bot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $message_id]);
    
    $remaining_attempts = checkAppleGameAttempts($from_id);
    // (يقرأ القيمة من الأدمن)
    $win_points = $rshq['apple_game_win_points'] ?? 50; 
    $current_coin = $rshq["coin"][$from_id] ?? 0; 
    
    bot('sendMessage', [ 
        'chat_id' => $chat_id,
        'text' => "🎮 *لعبة التفاحة - تجميع النقاط* 🍎
        
• *نقاطك الحالية:* $current_coin 💰
• *المحاولات المتبقية:* $remaining_attempts 🎯
• المحاولات تتجدد كل 24 ساعة ⏳
        
• كل تخمين صحيح يكسبك *$win_points* $name3mla!",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'بدء اللعبة 🕹️', 'callback_data' => 'play_apple_game']],
                [['text' => 'شراء محاولات 🛒', 'callback_data' => 'buy_apple_attempts']],
                [['text' => 'معلومات اللعبة 📜', 'callback_data' => 'apple_game_info']],
                [['text' => $NamesBACK, 'callback_data' => 'plus']],
            ]
        ])
    ]);
    exit;
}


// 6.1: فتح قائمة الشراء (بإرسال رسالة جديدة)
if ($data == 'buy_apple_attempts') {
    if (!isset($from_id)) $from_id = $update->callback_query->from->id;

    bot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $message_id]);
    $menu = getAppleBuyMenu($from_id);
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $menu['text'], 
        'parse_mode' => 'markdown',
        'reply_markup' => $menu['reply_markup'] 
    ]);
    exit;
}

// 6.2: زر +
if ($data == 'apple_buy_add') {
    $rshq['apple_buy_count'][$from_id] = ($rshq['apple_buy_count'][$from_id] ?? 1) + 1;
    SETJSON($rshq); 
    $menu = getAppleBuyMenu($from_id);
    bot('EditMessageText', ['chat_id' => $chat_id, 'message_id' => $message_id, 'text' => $menu['text'], 'parse_mode' => 'markdown', 'reply_markup' => $menu['reply_markup']]);
    exit;
}

// 6.3: زر -
if ($data == 'apple_buy_sub') {
    $count = $rshq['apple_buy_count'][$from_id] ?? 1;
    if ($count > 1) { 
        $rshq['apple_buy_count'][$from_id] -= 1;
        SETJSON($rshq); 
        $menu = getAppleBuyMenu($from_id);
        bot('EditMessageText', ['chat_id' => $chat_id, 'message_id' => $message_id, 'text' => $menu['text'], 'parse_mode' => 'markdown', 'reply_markup' => $menu['reply_markup']]);
    } else {
         bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => 'الحد الأدنى للشراء هو 1']);
    }
    exit;
}

// 6.4: تأكيد الشراء
if ($data == 'apple_buy_confirm') {
    
    $current_coin = $rshq["coin"][$from_id] ?? 0;
    
    $buy_count = $rshq['apple_buy_count'][$from_id] ?? 1;
    // (يقرأ القيمة من الأدمن)
    $attempt_price = $rshq['apple_game_attempt_price'] ?? 20; 
    $total_price = $buy_count * $attempt_price;

    if ($current_coin >= $total_price) {
        
        $rshq['coin'][$from_id] -= $total_price;
        $rshq['apple_game_attempts'][$from_id] = (checkAppleGameAttempts($from_id)) + $buy_count;
        unset($rshq['apple_buy_count'][$from_id]); 
        SETJSON($rshq);
        
        bot('answerCallbackQuery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "✅ تم شراء $buy_count محاولات بنجاح.",
            'show_alert' => true
        ]);
        
        $coin = $rshq['coin'][$from_id];
        
        $data = 'apple_game_main_new_msg'; 
        // (سيتم استدعاء كود apple_game_main_new_msg بعد هذا)
        
    } else {
        bot('answerCallbackQuery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "❌ ليس لديك نقاط كافية لإتمام عملية الشراء. (تحتاج: $total_price)",
            'show_alert' => true
        ]);
        exit;
    }
}
// ===========================================
//  1. قسم إدارة الألعاب (للأدمن) - (إصلاح نهائي)
// ===========================================
// 1. القائمة الرئيسية لإدارة الألعاب
if ($data == "games_management") {
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "🎲 *قسم إدارة الألعاب* 🎲

اختر اللعبة التي تريد تعديل إعداداتها:",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => '🍎 لعبة التفاحة', 'callback_data' => 'admin_apple_game']],
                // --- (هذا هو الزر الجديد) ---
                [['text' => '🎡 لعبة عجلة الحظ', 'callback_data' => 'admin_wheel_game']],
                // --- (انتهى الزر الجديد) ---
                [['text' => $NamesBACK, 'callback_data' => 'Brook']],
            ]
        ])
    ]);
    exit;
}

// ===========================================
//  2. قسم إدارة عجلة الحظ (للأدمن)
// ===========================================

// 2.1: قائمة إعدادات عجلة الحظ
if ($data == "admin_wheel_game") {
    $status = $rshq['wheel_game']['status'] ?? 'on';
    $status_text = ($status == 'on') ? "مفعلة ✅" : "معطلة ❌";
    $min_win = $rshq['wheel_game']['min'] ?? 10;
    $max_win = $rshq['wheel_game']['max'] ?? 100;
    $cooldown = $rshq['wheel_game']['cooldown_hours'] ?? 24;

    bot('EditMessageText', [
        'chat_id' => $chat_id, 'message_id' => $message_id,
        'text' => "🎡 *إدارة لعبة عجلة الحظ*

- *الحالة الحالية:* $status_text
- *الحد الأدنى للربح:* $min_win $name3mla
- *الحد الأقصى للربح:* $max_win $name3mla
- *مدة الانتظار (بالساعات):* $cooldown ساعة",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'تفعيل اللعبة ✅', 'callback_data' => 'set_wheel_on'], ['text' => 'تعطيل اللعبة ❌', 'callback_data' => 'set_wheel_off']],
                [['text' => 'تعيين الحد الأدنى للربح', 'callback_data' => 'set_wheel_min']],
                [['text' => 'تعيين الحد الأقصى للربح', 'callback_data' => 'set_wheel_max']],
                [['text' => 'تعيين مدة الانتظار (ساعات)', 'callback_data' => 'set_wheel_cooldown']],
                [['text' => $NamesBACK, 'callback_data' => 'games_management']],
            ]
        ])
    ]);
    exit;
}

// 2.2: أزرار الفتح والقفل
if ($data == 'set_wheel_on' || $data == 'set_wheel_off') {
    $rshq['wheel_game']['status'] = ($data == 'set_wheel_on') ? 'on' : 'off';
    SETJSON($rshq);
    bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => ($data == 'set_wheel_on') ? '✅ تم تفعيل اللعبة.' : '❌ تم تعطيل اللعبة.']);
    $data = 'admin_wheel_game'; // لإعادة تحميل القائمة
}

// 2.3: مصفوفات الربط
$wheel_modes_text = [
    'set_wheel_min' => '🎡 أرسل الآن *الحد الأدنى* للربح (رقم فقط):',
    'set_wheel_max' => '🎡 أرسل الآن *الحد الأقصى* للربح (رقم فقط):',
    'set_wheel_cooldown' => '🎡 أرسل الآن *مدة الانتظار* بين كل محاولة (بالساعات، رقم فقط):',
];
$wheel_keys_map = [
    'set_wheel_min' => 'min',
    'set_wheel_max' => 'max',
    'set_wheel_cooldown' => 'cooldown_hours',
];

// 2.4: أوامر تعيين القيم (عند الضغط على الزر)
if (array_key_exists($data, $wheel_modes_text)) {
    bot('EditMessageText', [
        'chat_id' => $chat_id, 'message_id' => $message_id,
        'text' => $wheel_modes_text[$data], 'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'إلغاء الأمر ❌', 'callback_data' => 'cancel_game_mode_wheel']],
                [['text' => $NamesBACK, 'callback_data' => 'admin_wheel_game']]
            ]
        ])
    ]);
    $modes['mode'][$from_id] = $data;
    SETJSON12($modes);
    exit;
}

// 2.5: زر إلغاء وضع الإدخال
if ($data == 'cancel_game_mode_wheel') {
    unset($modes['mode'][$from_id]);
    SETJSON12($modes);
    $data = 'admin_wheel_game'; // رجوع لقائمة عجلة الحظ
}

// 2.6: استقبال القيم الرقمية من الأدمن
if ($text && is_numeric($text) && isset($modes['mode'][$from_id])) {
    $mode = $modes['mode'][$from_id];

    if (array_key_exists($mode, $wheel_keys_map)) {
        $rshq_key = $wheel_keys_map[$mode];

        // الحفظ داخل مصفوفة 'wheel_game'
        $rshq['wheel_game'][$rshq_key] = $text; 
        SETJSON($rshq); 

        bot('sendMessage', [
            'chat_id' => $chat_id, 'text' => "✅ *تم حفظ :* $text", 'parse_mode' => "markdown",
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => $NamesBACK, 'callback_data' => 'admin_wheel_game']]] ])
        ]);

        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
        exit; 
    }
}
// --- نهاية كود إدارة عجلة الحظ ---


// 2. قائمة إعدادات لعبة التفاحة
if ($data == "admin_apple_game") {
    $status = $rshq['apple_game_status'] ?? 'on'; 
    $status_text = ($status == 'on') ? "مفعلة ✅" : "معطلة ❌";
    $daily_attempts = $rshq['apple_game_daily_attempts'] ?? 3; 
    $win_points = $rshq['apple_game_win_points'] ?? 50; 
    $attempt_price = $rshq['apple_game_attempt_price'] ?? 20; 

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "🍎 *إدارة لعبة التفاحة*
        
- *الحالة الحالية:* $status_text
- *المحاولات اليومية المجانية:* $daily_attempts
- *نقاط الربح (للتخمين الصحيح):* $win_points
- *سعر شراء المحاولة الإضافية:* $attempt_price $name3mla",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'تفعيل اللعبة ✅', 'callback_data' => 'set_apple_on'], ['text' => 'تعطيل اللعبة ❌', 'callback_data' => 'set_apple_off']],
                [['text' => 'تعيين المحاولات اليومية', 'callback_data' => 'set_apple_daily_attempts']],
                [['text' => 'تعيين نقاط الربح', 'callback_data' => 'set_apple_win_points']],
                [['text' => 'تعيين سعر شراء المحاولة', 'callback_data' => 'set_apple_attempt_price']],
                [['text' => $NamesBACK, 'callback_data' => 'games_management']],
            ]
        ])
    ]);
    exit;
}

// 3. معالجات الفتح والقفل
if ($data == 'set_apple_on' || $data == 'set_apple_off') {
    $status = ($data == 'set_apple_on') ? 'on' : 'off';
    $rshq['apple_game_status'] = $status; 
    SETJSON($rshq);
    
    $text = ($status == 'on') ? '✅ تم تفعيل لعبة التفاحة.' : '❌ تم تعطيل لعبة التفاحة.';
    bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => $text]);
    
    $data = 'admin_apple_game'; // لإعادة تحميل القائمة
}

// 4. مصفوفة لربط الأوامر بالنصوص
$apple_game_modes_text = [
    'set_apple_daily_attempts' => '🍎 أرسل الآن *عدد المحاولات اليومية المجانية* (رقم فقط):',
    'set_apple_win_points' => '🍎 أرسل الآن *عدد نقاط الربح* عند إيجاد التفاحة (رقم فقط):',
    'set_apple_attempt_price' => '🍎 أرسل الآن *سعر شراء المحاولة الإضافية* (رقم فقط):',
];

// 4.1. مصفوفة لربط الأوامر بمفاتيح الحفظ (هذا هو الإصلاح)
$apple_game_keys_map = [
    'set_apple_daily_attempts' => 'apple_game_daily_attempts',
    'set_apple_win_points' => 'apple_game_win_points',
    'set_apple_attempt_price' => 'apple_game_attempt_price',
];

// 5. أوامر تعيين القيم (عند الضغط على الزر)
if (array_key_exists($data, $apple_game_modes_text)) {
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => $apple_game_modes_text[$data], // استخدام مصفوفة النصوص
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'إلغاء الأمر ❌', 'callback_data' => 'cancel_game_mode']],
                [['text' => $NamesBACK, 'callback_data' => 'admin_apple_game']]
            ]
        ])
    ]);
    $modes['mode'][$from_id] = $data;
    SETJSON12($modes);
    exit;
}

// 6. زر إلغاء وضع الإدخال
if ($data == 'cancel_game_mode') {
    unset($modes['mode'][$from_id]);
    SETJSON12($modes);
    // (ملاحظة: تم حذف إرسال رسالة "تم الإلغاء" لكي يتم الرجوع للقائمة مباشرة)
    $data = 'admin_apple_game'; 
}

// 7. استقبال القيم الرقمية من الأدمن (هذا هو الإصلاح الرئيسي)
if ($text && is_numeric($text) && isset($modes['mode'][$from_id])) {
    $mode = $modes['mode'][$from_id];
    
    // التحقق من مصفوفة الربط الجديدة
    if (array_key_exists($mode, $apple_game_keys_map)) {
        
        // جلب المفتاح الصحيح
        $rshq_key = $apple_game_keys_map[$mode]; // e.g., 'apple_game_win_points'
        
        // الحفظ في المفتاح الصحيح
        $rshq[$rshq_key] = $text; 
        SETJSON($rshq); 

        // إرسال رسالة الحفظ الموحدة + زر الرجوع
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "✅ *تم حفظ :* $text",
            'parse_mode' => "markdown",
             'reply_markup' => json_encode([ 
                'inline_keyboard' => [
                    [['text' => $NamesBACK, 'callback_data' => 'admin_apple_game']]
                ]
            ])
        ]);
        
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
        exit; 
    }
}




if($data == 'ssupport'){
  bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
- ارسل كليشه الدعم :
",
'parse_mode'=>"markdown",
'disable_web_page_preview'=>true,
'reply_markup' => json_encode([
  'inline_keyboard' => [
            [['text' => 'رجوع ↩️', 'callback_data' => 'SHA7N']],
  ]
])

]);
$modes['mode'][$from_id]  = $data;
        SETJSON12($modes);
}

if($text and $modes['mode'][$from_id] == 'ssupport'){
        bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
تم الحفظ .
",
'parse_mode'=>"markdown",
'disable_web_page_preview'=>true,
'reply_markup' => json_encode([
  'inline_keyboard' => [
            [['text' => 'رجوع ↩️', 'callback_data' => 'texters']],
  ]
])

]);
$rshq['support']= $text;
unset($modes['mode'][$from_id]);
SETJSON($rshq);
        SETJSON12($modes);
}

if($data == 'setlddesig'){
  bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
 لصنع بوت الشحن التلقائي الخاص بك ارسل توكن بوتك 

• يمكنك جلبه من هنا @BotFather 
",
'parse_mode'=>"markdown",
'disable_web_page_preview'=>true,
'reply_markup' => json_encode([
  'inline_keyboard' => [
            [['text' => 'رجوع ↩️', 'callback_data' => 'SHA7N']],
  ]
])

]);
$modes['mode'][$from_id]  = 'tnseb';
        SETJSON12($modes);
}

if($text and $modes['mode'][$from_id] == 'tnseb'){
  $n = json_decode(file_get_contents('https://api.telegram.org/bot'.$text.'/getme'));
  $use = $n->result->username;
  if($use){
    $URL_FILE = $_SERVER['SERVER_NAME']."".str_replace('Namero.php','Namero2.php',$_SERVER['SCRIPT_NAME']);
    file_get_contents("https://api.telegram.org/bot$text/setwebhook?url=$URL_FILE?ME=" . $text . "___" . $chat_id . "___" . USR_BOT);
      bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*تم صنع بوت الشحن التلقائي الخاص بك 📮️*
معرف البوت الخاص بك : [@$use]

*- تم ربط الشحن تلقائيا ببوتك *
",
'parse_mode'=>"markdown",
'disable_web_page_preview'=>true,
'reply_markup' => json_encode([
  'inline_keyboard' => [
            [['text' => 'رجوع ↩️', 'callback_data' => 'SHA7N']],
  ]
])

]);
$sha7['bot'] = $use;
$sha7['tokk'] = $text;
  file_put_contents('sha7n_'.USR_BOT,json_encode($sha7));
unset($modes['mode'][$from_id]);
        SETJSON12($modes);
  }else{
        bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
- التوكن خاطء حاول مره اخرى ؟
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($baac),
]);
unset($modes['mode'][$from_id]);
        SETJSON12($modes);
  }
}

if($data == "setsecnd") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo  ) {

	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
° ارسل الأن عدد الثواني للامر الوقتي الأن
- الارقام فقط 
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]], 
]
])
]);
$modes['mode'][$from_id]  = $data;
        SETJSON12($modes);
      }
    }

    if(is_numeric($text) and $modes['mode'][$from_id] == "setsecnd"){
      	bot('SendMessage',[
'chat_id'=>$chat_id,
'text'=>"
*
~ تم تعيين $text بنجاح للامر الوقتي
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]], 
]
])
]);
$rshq['timers_sec'] = $text;
SETJSON($rshq); SETJSON12($modes);
      }

if($data == "oftimer") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo  ) {

	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
تم قفل الوقتي بنجاح
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]], 
]
])
]);
unset($rshq['timers']);
SETJSON($rshq); SETJSON12($modes);
      }
    }

if($data == "ontimer") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo  ) {
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
تم فتح الوقتي بنجاح
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]], 
]
])
]);
$rshq['timers']  = "on";
SETJSON($rshq); SETJSON12($modes);
      }
    }

$admnb = [ 
  'inline_keyboard'=>[
    [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
  ]
  ];
  
  
  if($data == "s2Ch"){
    bot('EditMessageText',[
      'chat_id'=>$chat_id,
      'message_id'=>$message_id,
      'text'=>"
      *
• ارسال الان الكليشه .

- يمكنك وضع بعض الاضافات الى كليشه الاثباتات من خلال استخدام الاهاشتاكات التاليه :
*

1. `#name_user` : لوضع اسم شخص ووضع معرفه داخل اسمه 
2. `#username` : لوضع اسم مستخدم الشخص مع اضافه @ 
3. `#name` : لوضع اسم الشخص
4. `#id` : لوضع ايدي الشخص 
5. `#coins` لعرض عدد نقاط الشخص
6. `#tlbs` لعرض عدد طلبات البوت
7. `#shares` لعرض عدد مشاركات الرابط
8. `#xtlb` لعرض عدد طلبات الشخص
9. `#idorder` لعرض ايدي الطلب
10. `#type` لعرض نوع الطلب
11. `#count` لعرض عدد الرشق المطلوب
12. `#price` لعرض سعر الطلب
13. `#linker` لعرض رابط الطلب
*
يمكنك تعين نص ماركداون في البوت , عند كتابه معرف قناتك او معرفك قم بوضع [] بين المعرف .
      *
      ",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode($admnb)
      ]);
      $modes['mode'][$from_id] = "settext3";
SETJSON($rshq); SETJSON12($modes);
  }


  if($text and $modes['mode'][$from_id] == "settext3"){
    bot("sendmessage",[
      'chat_id' => $chat_id,
      'text' => "
• تم الحفظ بنجاح
      ",
      'parse_mode' => 'MaRKDOWN',
                      'reply_to_message_id' => $message_id,
                         
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
      [['text'=>'رجوع','callback_data'=>"startmsg"]],
]
])
  ]);
  unset($modes['mode'][$from_id]);
  $rshq["msgthbat"] = $text;
SETJSON($rshq); SETJSON12($modes);
  }

  if($data == "s5Ch"){
    bot('EditMessageText',[
      'chat_id'=>$chat_id,
      'message_id'=>$message_id,
      'text'=>"
      *
• ارسال الان الكليشه .

- يمكنك وضع بعض الاضافات الى كليشه زر معلومات حسابي من خلال استخدام الاهاشتاكات التاليه :
*

1. `#name_user` : لوضع اسم شخص ووضع معرفه داخل اسمه 
2. `#username` : لوضع اسم مستخدم الشخص مع اضافه @ 
3. `#name` : لوضع اسم الشخص
4. `#id` : لوضع ايدي الشخص 
5. `#coins` لعرض عدد نقاط الشخص
6. `#tlbs` لعرض عدد طلبات البوت
7. `#shares` لعرض عدد مشاركات الرابط
8. `#xtlb` لعرض عدد طلبات الشخص
9. `#coinsx` لعرض عدد النقاط المستخدمه
10. `#timehdia` لعرض الوقت المتبقي للهديه
*
يمكنك تعين نص ماركداون في البوت , عند كتابه معرف قناتك او معرفك قم بوضع [] بين المعرف .
      *
      ",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode($admnb)
      ]);
      $modes['mode'][$from_id] = "settext5";
SETJSON($rshq); SETJSON12($modes);
  }


  if($text and $modes['mode'][$from_id] == "settext5"){
    bot("sendmessage",[
      'chat_id' => $chat_id,
      'text' => "
• تم الحفظ بنجاح
      ",
      'parse_mode' => 'MaRKDOWN',
                      'reply_to_message_id' => $message_id,
                         
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
      [['text'=>'رجوع','callback_data'=>"startmsg"]],
]
])
  ]);
  unset($modes['mode'][$from_id]);
  $rshq["msgMYACC"] = $text;
SETJSON($rshq); SETJSON12($modes);
  }
        

  if($data == "s3Ch"){
    bot('EditMessageText',[
      'chat_id'=>$chat_id,
      'message_id'=>$message_id,
      'text'=>"
      *
• ارسال الان الكليشه .

- يمكنك وضع بعض الاضافات الى كليشه انشاء الطلب من خلال استخدام الاهاشتاكات التاليه :
*

1. `#name_user` : لوضع اسم شخص ووضع معرفه داخل اسمه 
2. `#username` : لوضع اسم مستخدم الشخص مع اضافه @ 
3. `#name` : لوضع اسم الشخص
4. `#id` : لوضع ايدي الشخص 
5. `#coins` لعرض عدد نقاط الشخص
6. `#tlbs` لعرض عدد طلبات البوت
7. `#shares` لعرض عدد مشاركات الرابط
8. `#xtlb` لعرض عدد طلبات الشخص
9. `#idorder` لعرض ايدي الطلب
10. `#type` لعرض نوع الطلب
11. `#count` لعرض عدد الرشق المطلوب
12. `#price` لعرض سعر الطلب
13. `#linker` لعرض رابط الطلب
*
يمكنك تعين نص ماركداون في البوت , عند كتابه معرف قناتك او معرفك قم بوضع [] بين المعرف .
      *
      ",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode($admnb)
      ]);
      $modes['mode'][$from_id] = "settext4";
SETJSON($rshq); SETJSON12($modes);
  }


  if($text and $modes['mode'][$from_id] == "settext4"){
    bot("sendmessage",[
      'chat_id' => $chat_id,
      'text' => "
• تم الحفظ بنجاح
      ",
      'parse_mode' => 'MaRKDOWN',
                      'reply_to_message_id' => $message_id,
                         
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
      [['text'=>'رجوع','callback_data'=>"startmsg"]],
]
])
  ]);
  unset($modes['mode'][$from_id]);
  $rshq["msgorde"] = $text;
SETJSON($rshq); SETJSON12($modes);
  }

        if($data == "resetm"){
          bot('EditMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"
            *
  -  تم تعيين العمله الافتراضيه ( نقاط )
            *
            ",
            'parse_mode'=>"markdown",
            'reply_markup'=>json_encode($admnb)
            ]);
            unset($modes['mode'][$from_id]);
            unset($rshq["name3mla"]);
  SETJSON($rshq); SETJSON12($modes);
        }
        
    
  if($data == "setcv"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      if(true){
        $admnb = [ 
          'inline_keyboard'=>[
            
            [['text'=>'تعين العمله الافتراضيه ( نقاط)' ,'callback_data'=>"resetm"]],
            [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
          ]
          ];
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
- ارسل اسم عمله البوت الأن
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          $modes['mode'][$from_id]  = $data;
SETJSON($rshq); SETJSON12($modes);
      }else{
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          هذا القسم للمشتركين المدفوعين فقط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
      }
    }
  }

  if($data == "nasx"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
        $admnb = [ 
          'inline_keyboard'=>[
            [['text'=>'رفع نسخه احتياطيه 💾' ,'callback_data'=>"as_up"]],
            [['text'=>'صنع نسخة احتياطية 📂' ,'callback_data'=>"make_up"]],
            [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
          ]
          ];
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *

مرحبًا بك في قسم النسخ الاحتياطية! 
يمكنك الآن رفع نسخة احتياطية لبوت الرشق الخاص بك وحفظها بسهولة. 
لديك التحكم الكامل في عملية النسخ الاحتياطي، حيث يمكنك تخصيص الإعدادات وتحديد الملفات والبيانات التي ترغب في تضمينها في النسخة الاحتياطية. 
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
        }
  }

  if($data == "as_up"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
        $admnb = [ 
          'inline_keyboard'=>[
            
            [['text'=>'رجوع' ,'callback_data'=>"nasx"]],
          ]
          ];
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
ارسل النسخه الان لرفعها في قاعده البيانات
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          $modes['mode'][$from_id]  = $data;
        SETJSON12($modes);
        }
      }

      if($modes['mode'][$from_id] == "as_up"){
      if($update->message->document){
        $file_id = "https://api.telegram.org/file/bot".API_KEY."/".bot("getfile",["file_id"=>$update->message->document->file_id])->result->file_path;
        if(pathinfo($file_id, PATHINFO_EXTENSION) == "bot"){
            bot("sendmessage",[
                "chat_id" => $chat_id,
                "text" => "تم رفع الملف بنجاح .",
                "parse_mode" => "marKdown",
          'reply_markup'=>json_encode([ 
            'inline_keyboard'=>[
              [['text'=>'رجوع','callback_data'=>"backsup"]],
            ]
            ])
            ]);

$decryptedMessage = base64_decode(explode("I_SALEH_",file_get_contents($file_id))[1]);
if(json_decode($decryptedMessage,1)){
  file_put_contents("RSHQ/ALLS/". USR_BOT. "/rshq.json",$decryptedMessage);

}


            unset($modes['mode'][$from_id]);
            SETJSON12($modes);
    
            }else{
          bot("sendmessage",[
            "chat_id" => $chat_id,
            "text" =>"- ركز عزيزي ارسل الملف بصيغه ( .bot )",
            "parse_mode" => "marKdown",
            'reply_markup'=>json_encode([ 
              'inline_keyboard'=>[
                [['text'=>'رجوع','callback_data'=>"backsup"]],
              ]
              ])
          ]);
          unset($modes[$from_id]);
        file_put_contents("$mode_name",json_encode($modes));
        }
    }
  }
  if($data == "make_up"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
        $admnb = [ 
          'inline_keyboard'=>[
            
            [['text'=>'رجوع' ,'callback_data'=>"nasx"]],
          ]
          ];
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
يتم العمل على صنع نسخة، يرجى الانتظار 🛠️
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);

$plaintext = file_get_contents("RSHQ/ALLS/". USR_BOT. "/rshq.json") ;

$encryptedMessage = base64_encode($plaintext);
file_put_contents('J_'.USR_BOT.'.bot',"DONT CHANGE ANYTHINK!! \n USer Bot : @".USR_BOT."; | In ".date('Y-m-d H:i:s')."; USER MAKER : @STrillion_bot ; \n BackUp : I_SALEH_$encryptedMessage");
bot("senddocument",[
  'chat_id' => $chat_id,
'document' => new CURLFile('J_'.USR_BOT.'.bot'),
  'caption' => "
- النسخه المشفره .
",
'parse_mode' => 'MaRKDOWN',
              'reply_to_message_id' => $message_id,

]);
unlick('J_'.USR_BOT.'.bot');
        }
  }

if($text and $modes['mode'][$from_id]== "setcv"){
    if(true){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
        *
- تم تعيين عمله البوت : $text
        *
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode($admnb)
        ]);
        $rshq["name3mla"] = $text;
        $modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
    }
  }


  $admnvip = [ 
  'inline_keyboard'=>[
    [['text'=>'تعين كليشه شروط الاستخدام' ,'callback_data'=>"settext"]],
    [['text'=>'تعين قناة لبوت' ,'callback_data'=>"setcha"],['text'=>'تعين اسم البوت' ,'callback_data'=>"setname"]],
    [['text'=>'تعين كليشه شراء ال$name3mla' ,'callback_data'=>"setbuy"]],
    [['text'=>'تعين كليشه الجوائز' ,'callback_data'=>"setJa"]],
    [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
  ]
  ];



if(is_numeric($text) and $modes['mode'][$from_id]== "s3rtmoil"){
    if(true){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
        *
        تم تعيين عدد ال$name3mla 
        *
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode($admnb)
        ]);

        $modes['mode'][$from_id]  = null;
        $tmoil['s3rtmoil' ]  = $text ;
            $rshq['s3rtmoil' ]  = $text ;
        SETJSON1($tmoil); 
SETJSON($rshq); SETJSON12($modes);
    }
  }
 
 if($data == "setklishs"){
    if($chat_id == $sudo or $chat_id==$sudo or in_array($from_id, $Js['admin'])  ) {
      if(true){
      	$admnb = [ 
  'inline_keyboard'=>[
    [['text'=>'الرجوع الاساسيه' ,'callback_data'=>"asases"]],
  ]
  ];
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          - ارسل الكليشه من فضلك
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          $modes['mode'][$from_id]  = $data;
SETJSON($rshq); SETJSON12($modes);
      }else{
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          هذا القسم للمشتركين المدفوعين فقط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
      }
    }
  }
 
 if($data == "asases"){
    if($chat_id == $sudo or $chat_id==$sudo or in_array($from_id, $Js['admin'])  ) {
      if(true){
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          تم رجوع الكليشه الاساسيه 
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          unset($modes['mode'][$from_id]) ;
          $rshq['setklishs' ]  = null;
          SETJSON($rshq);
SETJSON12($modes);
      }else{
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          هذا القسم للمشتركين المدفوعين فقط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
      }
    }
  }

if($text and $modes['mode'][$from_id]== "setklishs"){
    if(true){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
        *
        تم تعيين الكليشه بنجاح
        *
       مثال علي رسالتك :  `$text `
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode($admnb)
        ]);

        $modes['mode'][$from_id]  = null;
        $rshq['setklishs' ]  = $text ;
SETJSON($rshq); SETJSON12($modes);
    }
  }
 
  
  if($data == "settext"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      if(true){
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          ارسل الكليشه الان
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          $modes['mode'][$from_id]  = $data;
SETJSON($rshq); SETJSON12($modes);
      }else{
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          هذا القسم للمشتركين المدفوعين فقط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
      }
    }
  }
  
  if($data == "msfrn"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      if(true){
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          ارسل ايدي الشخص لتصفير ".$name3mla."ه
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          $modes['mode'][$from_id]  = $data;
SETJSON($rshq); SETJSON12($modes);
      }else{
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          هذا القسم للمشتركين المدفوعين فقط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
      }
    }
  }
  
  if($data == "xdmatsm"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      if(true){
      	$admnb = [ 
  'inline_keyboard'=>[
  [['text'=>'ارجاع الخزن ✅' ,'callback_data'=>"resetSALEHUUF"]],
    [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
  ]
  ];
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          - مرحبا بك عزيزي في هذا القسم يمكنك ارجاع الخزن 
          - يتم حفظ كل الخزونات في المخزن هذا ✅
          
          - تنبيه! لاتقم بارجاع الخزن اذا لم ينحذف 
          
          - للارجاع اضغط علي ارجاع الخزن لارجاع اخر خزن تم حفظه في بوتك
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          $modes['mode'][$from_id]  = $data;
SETJSON($rshq); SETJSON12($modes);
      }else{
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          هذا القسم للمشتركين المدفوعين فقط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
      }
    }
  }
  
  if($data == "resetSALEHUUF"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      if(true){
      	$admnb = [ 
  'inline_keyboard'=>[
  
    [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
  ]
  ];
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
انتضر بعد الوقت يتم الارجاع
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          $modes['mode'][$from_id]  = $data;
SETJSON($rshq); SETJSON12($modes);
$folderPath = 'RSHQ/BACKUP'; 
$files = scandir($folderPath);
$files = array_filter($files, function($file) {
    return !in_array($file, ['.', '..']);
});
$numericFiles = array_map(function($file) {
    return intval($file);
}, $files);

$maxFile = max($numericFiles);
$f2 = $maxFile ;
bot('sendmessage',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
- تم ارجاع اخر خزن ($f2) بنجاح لقاعده البيانات ✅
          *
          ",
          'parse_mode'=>"markdown",
          
          ]); 
          file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", file_get_contents("RSHQ/BACKUP/$f2" )) ;
      }else{
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          هذا القسم للمشتركين المدفوعين فقط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
      }
    }
  }

if($text and $modes['mode'][$from_id]== "msfrn"){
    if(true){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
        *
        تم تصفير $name3mla $text 
        *
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode($admnb)
        ]);
        $rshq["coin"][$text] = 0;
        $modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
    }
  }

  if($data == "setname"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      if(true){
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          ارسل اسم البوت الان .
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          $modes['mode'][$from_id]  = $data;
SETJSON($rshq); SETJSON12($modes);
      }else{
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          هذا القسم للمشتركين المدفوعين فقط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
      }
    }
  }

  if($data == "setcha"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      if(true){
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          ارسل يوزر القناة الان مع @
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          $modes['mode'][$from_id]  = $data;
SETJSON($rshq); SETJSON12($modes);
      }else{
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          هذا القسم للمشتركين المدفوعين فقط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
      }
    }
  }

  if($data == "setbuy"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      if(true){
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          ارسل كليشه شراء $name3mla الان
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          $modes['mode'][$from_id]  = $data;
SETJSON($rshq); SETJSON12($modes);
      }else{
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          هذا القسم للمشتركين المدفوعين فقط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
      }
    }
  }
  
  if($data == "setshare"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      if(true){
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          ارسل عدد ال$name3mla الان
          $name3mla مشاركه رابط لدعوه، 
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
          $modes['mode'][$from_id]  = $data;
SETJSON($rshq); SETJSON12($modes);
      }else{
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
          هذا القسم للمشتركين المدفوعين فقط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode($admnb)
          ]);
      }
    }
  }

if(is_numeric($text) and $modes['mode'][$from_id]== "setshare"){
    if(true){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
        *
        تم تعيين عدد ال$name3mla
        *
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode($admnb)
        ]);
        $rshq["coinshare"] = $text;
        $modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
    }
  }


  if($text and $modes['mode'][$from_id]== "setbuy"){
    if(true){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
        *
        تم تعيين الكليشه
        *
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode($admnb)
        ]);
        $rshq['buy']  = $text;
        $modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
    }
  }

  $chabot = $rshq['cha']; if ($chabot == null){$chabot = "ka7hbot";}


  if($text and $modes['mode'][$from_id]== "setname"){
    if(true){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
        *
        تم تعيين اسم البوت
        *
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode($admnb)
        ]);
        $rshq['namebot']  = $text;
        $modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
    }
  }

  $nambot = $rshq['namebot']; if($nambot == null){$nambot = "رشق العرب";}

  if($text and $modes['mode'][$from_id]== "settext"){
    if(true){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
        *
        تم تعيين الكليشه بنجاح
        *
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode($admnb)
        ]);
        $rshq['KLISHA']  = $text;
        $modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
    }
  }

  if($text and $modes['mode'][$from_id]== "setcha"){
    if(true){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"
        *
        تم تعيين القناة بنجاح
        *
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode($admnb)
        ]);
        $rshq['cha']  = str_replace("@","",$text);
        $modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
    }
  }

if($rshq['AKTHAR']==null){	
  $AKTHAR=20;
  }else{
$AKTHAR = $rshq['AKTHAR'];
  }

  if($rshq["HDIA"] == null or $rshq["HDIA"] == "on"){
  $HDIAS = "الهدية🎁";
  $mj = "✅";
  }else{
    $HDIAS = null;
    $mj = "❌";
  }
  if($treqa == null){
    $treqa = "لم يتم التعرف علي الطريقه او لم تقم بوضع معلومات الرشق";
  }


  

  if($data == "timerx") {
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('EditMessageText',[
  'chat_id'=>$chat_id,
  'message_id'=>$message_id,
  'text'=>"
اهلا بك عزيزي قسم الوقتي هو عباره عن يجعل المستخدم لا يستطيع الضغط علي الازرار الي كل 3 ثواني ♻
  ",
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($timerx)
  ]);
  
  $modes['mode'][$from_id]  = null;
  SETJSON($rshq); SETJSON12($modes);
  }
  }
  
  if($data == "istqbals") {
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('EditMessageText',[
  'chat_id'=>$chat_id,
  'message_id'=>$message_id,
  'text'=>"
- عزيزي المطور [$name](tg://user?id=$from_id)
~ يمكنك التحكم في الفتح والقفل 
  ",
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($istqbals)
  ]);
  
  $modes['mode'][$from_id]  = null;
  SETJSON($rshq); SETJSON12($modes);
  }
  }

  // ======================================================
//  (جديد) 14. قسم التمويل المطور بالكامل (للأدمن) - تحديث 3
// ======================================================

// 14.1: بناء لوحة التحكم الرئيسية للتمويل
if ($data == "tmoilsc") {
    if ($chat_id == $sudo) {
        
        // جلب الإعدادات الحالية
        $status = ($rshq['FREE'] == "TR") ? "مفتوح ✅" : "مغلق ❌";
        $status_callback = ($rshq['FREE'] == "TR") ? "tmoil_off" : "tmoil_on";
        $status_text = ($rshq['FREE'] == "TR") ? "قفل التمويل ❌" : "فتح التمويل ✅";
        
        $min_funding = $rshq['tmoil_min'] ?? 10;
        $max_funding = $rshq['tmoil_max'] ?? 10000;
        $cost_per_member = $rshq['s3rtmoil'] ?? 12;
        $join_points = $rshq['tmoil_join_points'] ?? 5;

        // بناء لوحة الأزرار
        $keyboard = [
            'inline_keyboard' => [
                [['text' => "الحالة: $status", 'callback_data' => 'null_data'], ['text' => $status_text, 'callback_data' => $status_callback]],
                [['text' => 'القنوات قيد التمويل 📊', 'callback_data' => 'admin_show_funding_page|1']],
                [['text' => "سعر العضو: $cost_per_member", 'callback_data' => 'set_tmoil_cost'], ['text' => "نقاط الانضمام: $join_points", 'callback_data' => 'set_tmoil_join_points']],
                [['text' => "الحد الأدنى: $min_funding", 'callback_data' => 'set_tmoil_min'], ['text' => "الحد الأقصى: $max_funding", 'callback_data' => 'set_tmoil_max']],
                [['text' => 'إضافة تمويل يدوي ➕', 'callback_data' => 'addtmoil']],
                [['text' => $NamesBACK, 'callback_data' => 'home_s']],
            ]
        ];

        bot('EditMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"
*👥 قسم إعدادات التمويل*

تحكم في جميع إعدادات تمويل الأعضاء من هنا.
            ",
            'parse_mode'=>"markdown",
            'reply_markup'=>json_encode($keyboard)
        ]);
        
        // (مهم) إلغاء أي وضع إدخال
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
        exit;
    }
}

// 14.2: مشغل أزرار الفتح والقفل
if ($data == "tmoil_on" || $data == "tmoil_off") {
    if ($chat_id == $sudo) {
        $rshq['FREE'] = ($data == "tmoil_on") ? "TR" : null;
        SETJSON($rshq);
        
        $alert_text = ($data == "tmoil_on") ? "✅ تم فتح قسم التمويل" : "❌ تم قفل قسم التمويل";
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => $alert_text]);
        
        $data = "tmoilsc"; // إعادة تحميل القائمة
    }
}

// 14.3: مشغل أزرار تعيين القيم (الأربعة)
$tmoil_set_buttons = [
    'set_tmoil_cost' => ['prompt' => '*💰 أرسل الآن سعر التمويل (سعر كل 1 عضو):*', 'key' => 's3rtmoil'],
    'set_tmoil_join_points' => ['prompt' => '*🎁 أرسل الآن نقاط الانضمام (التي يحصل عليها المستخدم):*', 'key' => 'tmoil_join_points'],
    'set_tmoil_min' => ['prompt' => '*📉 أرسل الآن الحد الأدنى لطلب التمويل:*', 'key' => 'tmoil_min'],
    'set_tmoil_max' => ['prompt' => '*📈 أرسل الآن الحد الأقصى لطلب التمويل:*', 'key' => 'tmoil_max']
];

if (array_key_exists($data, $tmoil_set_buttons)) {
    if ($chat_id == $sudo) {
        $prompt = $tmoil_set_buttons[$data]['prompt'];
        bot('EditMessageText', [
            'chat_id' => $chat_id, 'message_id' => $message_id,
            'text' => $prompt,
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => $NamesBACK, 'callback_data' => 'tmoilsc']]]])
        ]);
        
        $modes['mode'][$from_id] = $data; // (مثل: set_tmoil_cost)
        SETJSON12($modes);
        exit;
    }
}

// 14.4: مشغل استلام القيم (للأربعة)
if ($text && is_numeric($text) && $from_id == $sudo) {
    $mode = $modes['mode'][$from_id] ?? '';
    
    if (array_key_exists($mode, $tmoil_set_buttons)) {
            $key_to_save = $tmoil_set_buttons[$mode]['key']; // (مثل: s3rtmoil)
            
            // (حفظ)
            $rshq[$key_to_save] = $text;
            SETJSON($rshq);
            
            // (تحديث ملف tmoil.json أيضًا إذا لزم الأمر)
            if ($key_to_save == 's3rtmoil') $tmoil['s3rtmoil'] = $text;
            if ($key_to_save == 'tmoil_min') $tmoil["tmoils"] = $text; // (تأكد من أن هذا هو المفتاح الصحيح)
            SETJSON1($tmoil);

            bot('sendMessage', [
                'chat_id' => $chat_id, 'text' => "✅ *تم حفظ :* $text", 'parse_mode' => 'markdown',
                'reply_markup' => json_encode(['inline_keyboard' => [[['text' => $NamesBACK, 'callback_data' => 'tmoilsc']]]])
            ]);
            
            unset($modes['mode'][$from_id]);
            SETJSON12($modes);
            exit;
    }
}

// 14.5: مشغل زر "القنوات قيد التمويل"
if (explode("|", $data)[0] == "admin_show_funding_page") {
    if ($chat_id == $sudo) {
        $page = intval(explode("|", $data)[1]);
        if ($page < 1) $page = 1;

        $active_channels = $tmoil['db']["chs"] ?? [];
        if (!is_array($active_channels)) $active_channels = []; 
        
        $per_page = 5; 
        $total_channels = count($active_channels);
        $total_pages = ceil($total_channels / $per_page);
        
        if ($page > $total_pages && $total_pages > 0) $page = $total_pages;

        $channels_for_page = array_slice($active_channels, ($page - 1) * $per_page, $per_page);
        
        $keyboard = ['inline_keyboard' => []];
        
        if (empty($channels_for_page)) {
            $keyboard[] = [['text' => 'ℹ️ لا توجد قنوات قيد التمويل حاليًا', 'callback_data' => 'null_data']];
        } else {
            foreach ($channels_for_page as $channel_username) {
                if (is_string($channel_username)) { 
                    $keyboard[] = [['text' => "@$channel_username", 'callback_data' => "admin_view_funding|$channel_username|$page"]];
                }
            }
        }
        
        $pagination_buttons = [];
        if ($page > 1) {
            $pagination_buttons[] = ['text' => '◀️ السابق', 'callback_data' => "admin_show_funding_page|" . ($page - 1)];
        }
        if ($page < $total_pages) {
            $pagination_buttons[] = ['text' => 'التالي ▶️', 'callback_data' => "admin_show_funding_page|" . ($page + 1)];
        }
        
        if (!empty($pagination_buttons)) {
            $keyboard[] = $pagination_buttons;
        }
        
        $keyboard[] = [['text' => $NamesBACK, 'callback_data' => "tmoilsc"]];
        
        bot('EditMessageText', [
            'chat_id' => $chat_id, 'message_id' => $message_id,
            'text' => "*القنوات قيد التمويل حاليًا* (صفحة $page / $total_pages)\n\nاضغط على أي قناة لعرض تفاصيلها:",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode(['inline_keyboard' => $keyboard])
        ]);
        exit;
    }
}

// 14.6: مشغل زر "عرض تفاصيل القناة" (مع الأزرار الجديدة)
if (explode("|", $data)[0] == "admin_view_funding") {
    if ($chat_id == $sudo) {
        $channel_username = explode("|", $data)[1];
        $page_to_return = explode("|", $data)[2];
        
        $idM = $tmoil['chanels']["id_$channel_username"] ?? null;
        if (!$idM || !isset($tmoil['db']["$idM"])) {
            bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => '❌ خطأ: لم يتم العثور على بيانات هذا التمويل.', 'show_alert' => true]);
            exit;
        }
        
        $funding_data = $tmoil['db']["$idM"];
        
        $owner_id = $funding_data["owner"];
        $requested_count = $funding_data["count"];
        $price_paid = $funding_data["price"] ?? 'N/A';
        $created_date = $funding_data["create"];
        $delivered_count = $funding_data["startc"] ?? 0;
        $remaining_count = $requested_count - $delivered_count;
        
        $current_members_req = bot("getChatMembersCount", ['chat_id' => "@$channel_username"]);
        $current_members = $current_members_req->ok ? $current_members_req->result : 'N/A';
        
        $details_text = "
        *تفاصيل تمويل القناة: @$channel_username*
        
*صاحب الطلب:* [$owner_id](tg://user?id=$owner_id)
*تاريخ الطلب:* $created_date
        
--- *التفاصيل* ---
*الكمية المطلوبة:* $requested_count
*الكمية المسلمة:* $delivered_count
*المتبقي:* $remaining_count
        
*النقاط المدفوعة:* $price_paid $name3mla
*العدد الحالي للقناة:* $current_members
        ";
        
        // --- (جديد) إضافة أزرار التحكم ---
        $keyboard = [
            'inline_keyboard' => [
                [['text' => '🗑️ حذف التمويل', 'callback_data' => "funding_delete_confirm|$channel_username|$page_to_return"]],
                [['text' => '🚫 حظر العضو (من البوت)', 'callback_data' => "funding_ban_user|$owner_id|$page_to_return"]],
                [['text' => '⛔️ حظر القناة (من التمويل)', 'callback_data' => "funding_ban_channel|$channel_username|$page_to_return"]],
                [['text' => $NamesBACK, 'callback_data' => "admin_show_funding_page|$page_to_return"]]
            ]
        ];
        
        bot('EditMessageText', [
            'chat_id' => $chat_id, 'message_id' => $message_id,
            'text' => $details_text,
            'parse_mode' => 'markdown',
            'disable_web_page_preview' => true,
            'reply_markup' => json_encode($keyboard)
        ]);
        exit;
    }
}

// 14.7: (جديد) مشغلات أزرار التحكم (حذف وحظر)
if (explode("|", $data)[0] == "funding_delete_confirm") {
    if ($chat_id == $sudo) {
        $channel_username = explode("|", $data)[1];
        $page_to_return = explode("|", $data)[2];
        bot('EditMessageText', [
            'chat_id' => $chat_id, 'message_id' => $message_id,
            'text' => "⚠️ *هل أنت متأكد من حذف هذا التمويل؟*
سيؤدي هذا إلى إيقاف إرسال الأعضاء إلى @$channel_username نهائيًا. (لا يمكن التراجع)",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "✅ نعم، احذف الآن", 'callback_data' => "funding_delete_do|$channel_username|$page_to_return"]],
                    [['text' => "❌ إلغاء", 'callback_data' => "admin_view_funding|$channel_username|$page_to_return"]]
                ]
            ])
        ]);
    }
}

if (explode("|", $data)[0] == "funding_delete_do") {
    if ($chat_id == $sudo) {
        $channel_username = explode("|", $data)[1];
        $page_to_return = explode("|", $data)[2];
        
        // 1. إيجاد القناة في مصفوفة 'chs'
        $st = array_search($channel_username, $tmoil['db']["chs"]);
        if ($st !== false) {
            // 2. حذفها
            unset($tmoil['db']["chs"][$st]);
            // (إعادة ترتيب الفهرس)
            $tmoil['db']["chs"] = array_values($tmoil['db']["chs"]);
            SETJSON1($tmoil); 
            bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => '✅ تم حذف التمويل بنجاح.']);
            $data = "admin_show_funding_page|$page_to_return"; // العودة لقائمة القنوات
        } else {
            bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => '❌ خطأ: التمويل محذوف بالفعل.', 'show_alert' => true]);
            $data = "admin_show_funding_page|$page_to_return";
        }
    }
}

if (explode("|", $data)[0] == "funding_ban_user") {
    if ($chat_id == $sudo) {
        $user_to_ban = explode("|", $data)[1];
        $blockers[$user_to_ban] = true;
        file_put_contents($blockers_name, json_encode($blockers));
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => '🚫 تم حظر العضو من استخدام البوت.']);
        // (لا حاجة لإعادة تحميل الصفحة، فقط إشعار)
    }
}

if (explode("|", $data)[0] == "funding_ban_channel") {
    if ($chat_id == $sudo) {
        $channel_to_ban = explode("|", $data)[1];
        $tmoil["blocks"][] = $channel_to_ban; // إضافة لحظر التمويل
        SETJSON1($tmoil); 
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => '⛔️ تم حظر القناة من التمويل مستقبلًا.']);
        // (لا حاجة لإعادة تحميل الصفحة، فقط إشعار)
    }
}

  
  if($data == "adders1") {
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('EditMessageText',[
  'chat_id'=>$chat_id,
  'message_id'=>$message_id,
  'text'=>"
- عزيزي المطور [$name](tg://user?id=$from_id)
~ قسم الأضافه والتصفير للنقاط 
  ",
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($adders1)
  ]);
  
  $modes['mode'][$from_id]  = null;
  SETJSON($rshq); SETJSON12($modes);
  }
  }

  if($data == "settingcoin") {
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('EditMessageText',[
  'chat_id'=>$chat_id,
  'message_id'=>$message_id,
  'text'=>"
- عزيزي المطور [$name](tg://user?id=$from_id)
~ قسم تعيين النقاط للاعدادات
  ",
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($settingcoin)
  ]);
  
  $modes['mode'][$from_id]  = null;
  SETJSON($rshq); SETJSON12($modes);
  }
  }
  
  if($data == "Hdias_j") {
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('EditMessageText',[
  'chat_id'=>$chat_id,
  'message_id'=>$message_id,
  'text'=>"
- عزيزي المطور [$name](tg://user?id=$from_id)
~ قسم الهدايا والكودات
  ",
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($hdias_j)
  ]);
  
  $modes['mode'][$from_id]  = null;
  SETJSON($rshq); SETJSON12($modes);
  }
  }
  
  if($data == "texters") {
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('EditMessageText',[
  'chat_id'=>$chat_id,
  'message_id'=>$message_id,
  'text'=>"
- عزيزي المطور [$name](tg://user?id=$from_id)
~ قسم الكلايش والحقوق
  ",
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($texters)
  ]);
  
  $modes['mode'][$from_id]  = null;
  SETJSON($rshq); SETJSON12($modes);
  }
  }


function getServerSpeed() {
    $start_time = microtime(true);

    // Make a loopback request to the server itself
    $ch = curl_init('http://' . $_SERVER['SERVER_NAME']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $end_time = microtime(true);

    if ($response !== false) {
        $speed = $end_time - $start_time;
        return $speed;
    } else {
        return false; 
    }
}

$server_speed = getServerSpeed();

if ($server_speed !== false) {
    $good_speed_threshold = 0.1; 

    if ($server_speed < $good_speed_threshold) {
        $JP = "سرعه جيده " . round($server_speed, 4) . " في الثانيه";
    } else {
        $JP = "بطيئه " . round($server_speed, 4) . "في الثانيه ";
    }
} else {
    $JP = "Unable to fetch the loopback URL. Check your server configuration.";
}

  $nambot = $rshq['namebot']; if($nambot == null){$nambot = "رشق العرب";}
if($data == "Brook" or $data == "home_s") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
مرحبا بك في اعدادات بوت الرشق 🛍

💠 رصيدك في الموقع: $flos $treqa
♻️ أقل عدد لتحويل ال$name3mla: $AKTHAR
🎁 نقاط الهدية اليومية: `". ($rshq['hdias'] ?? "20") ."`
🔮 عدد الأقسام في البوت: *". count($rshq['qsm']) ."*
🔰️ عدد الخدمات داخل البوت: *". count($rshq['xdmaxs']) ."*
👩‍💻 اسم البوت الحالي: *$nambot *
🌀 سرعه البوت : $JP

",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($adm)
]);

$modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
}
}



if($data == "VIPME") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    if(true){
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
يمكنك الاستمتاع بمميزات مدفوعه هنا
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnvip)
]);
$modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
  }else{
    bot('EditMessageText',[
      'chat_id'=>$chat_id,
      'message_id'=>$message_id,
      'text'=>"
      *
      هذا القسم للمشتركين المدفوعين فقط
      *
      ",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode($admnb)
      ]);
  }
}
}

if ($data == "setJa") {
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('EditMessageText', [
      'chat_id' => $chat_id,
      'message_id' => $message_id,
      'text' => "
      *
    ارسل كليشه الجوائز الان ياحبيبي
      *
      ",
      'parse_mode' => "markdown",
      'reply_markup' => json_encode([
        'inline_keyboard' => [

          [['text' => 'رجوع', 'callback_data' => "Brook"]],
        ]
      ])
    ]);
    $modes['mode'][$from_id] = $data;
    $rshq = json_encode($rshq, 32 | 128 | 265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }
}

if($text and $modes['mode'][$from_id] == "setJa"){
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('sendmessage', [
      'chat_id' => $chat_id,
      'message_id' => $message_id,
      'text' => "
      *
   تم تعين الجوائز بنجاح 
      *
      ",
      'parse_mode' => "markdown",
      'reply_markup' => json_encode([
        'inline_keyboard' => [

          [['text' => 'رجوع', 'callback_data' => "Brook"]],
        ]
      ])
    ]);
    $rshq['JAWA'] = $text;
    $modes['mode'][$from_id] = null;
    $rshq = json_encode($rshq, 32 | 128 | 265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }
}


// ... (بداية الكود الخاص بك)

// ===========================================
//  قسم إدارة التحويلات (للأدمن) - إصلاح نهائي
// ===========================================

// 1. القائمة الرئيسية لإعدادات التحويل
if ($data == "transfer_settings") {
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "⚙️ *إعدادات قسم التحويل*
        
اختر القسم الذي تريد إدارته:",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'إعدادات التحويل بالرابط 🔗', 'callback_data' => 'link_transfer_settings']],
                [['text' => 'إعدادات التحويل بالآيدي 🆔', 'callback_data' => 'id_transfer_settings']],
                [['text' => $NamesBACK, 'callback_data' => 'Brook']], 
            ]
        ])
    ]);
    exit;
}

// 2. قائمة إعدادات التحويل بالرابط (الفرعية)
if ($data == "link_transfer_settings") {
    $status = $rshq['link_transfer_status'] ?? 'on';
    $status_text = ($status == 'on') ? "مفعل ✅" : "معطل ❌";
    // قراءة القيم الصحيحة
    $min = $rshq['link_transfer_min'] ?? "10";
    $max = $rshq['link_transfer_max'] ?? "10000";
    $commission = $rshq['link_transfer_commission'] ?? "0";

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "🔗 *إعدادات التحويل بالرابط*
        
- *الحالة الحالية:* $status_text
- *الحد الأدنى:* $min $name3mla
- *الحد الأقصى:* $max $name3mla
- *العمولة:* $commission%",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'فتح التحويل ✅', 'callback_data' => 'set_link_on'], ['text' => 'قفل التحويل ❌', 'callback_data' => 'set_link_off']],
                [['text' => 'تعيين الحد الأدنى', 'callback_data' => 'set_link_min']],
                [['text' => 'تعيين الحد الأقصى', 'callback_data' => 'set_link_max']],
                [['text' => 'تعيين العمولة (٪)', 'callback_data' => 'set_link_commission']],
                [['text' => $NamesBACK, 'callback_data' => 'transfer_settings']], 
            ]
        ])
    ]);
    exit;
}

// 3. قائمة إعدادات التحويل بالآيدي (الفرعية)
if ($data == "id_transfer_settings") {
    $status = $rshq['id_transfer_status'] ?? 'on';
    $status_text = ($status == 'on') ? "مفعل ✅" : "معطل ❌";
    // قراءة القيم الصحيحة
    $min = $rshq['id_transfer_min'] ?? "10";
    $max = $rshq['id_transfer_max'] ?? "10000";
    $commission = $rshq['id_transfer_commission'] ?? "0";

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "🆔 *إعدادات التحويل بالآيدي*
        
- *الحالة الحالية:* $status_text
- *الحد الأدنى:* $min $name3mla
- *الحد الأقصى:* $max $name3mla
- *العمولة:* $commission%",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'فتح التحويل ✅', 'callback_data' => 'set_id_on'], ['text' => 'قفل التحويل ❌', 'callback_data' => 'set_id_off']],
                [['text' => 'تعيين الحد الأدنى', 'callback_data' => 'set_id_min']],
                [['text' => 'تعيين الحد الأقصى', 'callback_data' => 'set_id_max']],
                [['text' => 'تعيين العمولة (٪)', 'callback_data' => 'set_id_commission']],
                [['text' => $NamesBACK, 'callback_data' => 'transfer_settings']],
            ]
        ])
    ]);
    exit;
}

// 4. معالجات أزرار الفتح والقفل المنفصلة
if (in_array($data, ['set_link_on', 'set_link_off', 'set_id_on', 'set_id_off'])) {
    $message_text = '';
    $redirect_to = '';

    if ($data == 'set_link_on') {
        $rshq['link_transfer_status'] = 'on';
        $message_text = '✅ تم فتح التحويل بالرابط.';
        $redirect_to = 'link_transfer_settings';
    } elseif ($data == 'set_link_off') {
        $rshq['link_transfer_status'] = 'off';
        $message_text = '❌ تم قفل التحويل بالرابط.';
        $redirect_to = 'link_transfer_settings';
    } elseif ($data == 'set_id_on') {
        $rshq['id_transfer_status'] = 'on';
        $message_text = '✅ تم فتح التحويل بالآيدي.';
        $redirect_to = 'id_transfer_settings';
    } elseif ($data == 'set_id_off') {
        $rshq['id_transfer_status'] = 'off';
        $message_text = '❌ تم قفل التحويل بالآيدي.';
        $redirect_to = 'id_transfer_settings';
    }

    SETJSON($rshq);
    bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => $message_text]);
    
    // إعادة تحميل القائمة الفرعية الصحيحة
    $data = $redirect_to;
    // (يجب أن يستمر الكود ليعالج $data = $redirect_to)
}

// 5. زر إلغاء العملية
if ($data == 'cancel_mode') {
    unset($modes['mode'][$from_id]);
    SETJSON12($modes);
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "❌ تم إلغاء العملية.",
    ]);
    // الرجوع لقائمة إعدادات التحويل الرئيسية
    $data = "transfer_settings"; 
}

// =============================================
//  ** (هذا هو الكود الذي تم إصلاحه) **
// =============================================

// 6. مصفوفات لربط الأوامر بالنصوص والمفاتيح
$transfer_modes_map = [
    'set_link_min' => 'link_transfer_min',
    'set_link_max' => 'link_transfer_max',
    'set_link_commission' => 'link_transfer_commission',
    'set_id_min' => 'id_transfer_min',
    'set_id_max' => 'id_transfer_max',
    'set_id_commission' => 'id_transfer_commission',
];

$transfer_modes_text = [
    'set_link_min' => "🔗 أرسل الآن *الحد الأدنى* للتحويل بالرابط:",
    'set_link_max' => "🔗 أرسل الآن *الحد الأقصى* للتحويل بالرابط:",
    'set_link_commission' => "🔗 أرسل الآن *العمولة* للتحويل بالرابط (رقم فقط، مثال: 5):",
    'set_id_min' => "🆔 أرسل الآن *الحد الأدنى* للتحويل بالآيدي:",
    'set_id_max' => "🆔 أرسل الآن *الحد الأقصى* للتحويل بالآيدي:",
    'set_id_commission' => "🆔 أرسل الآن *العمولة* للتحويل بالآيدي (رقم فقط، مثال: 5):",
];

// 7. أوامر تعيين القيم (عند الضغط على الزر)
if (array_key_exists($data, $transfer_modes_text)) {
    $back_callback = (strpos($data, 'link') !== false) ? 'link_transfer_settings' : 'id_transfer_settings';

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => $transfer_modes_text[$data], // استخدام مصفوفة النصوص
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'إلغاء الأمر ❌', 'callback_data' => 'cancel_mode']],
                [['text' => $NamesBACK, 'callback_data' => $back_callback]]
            ]
        ])
    ]);
    $modes['mode'][$from_id] = $data; // $data هو 'set_link_min'
    SETJSON12($modes);
    exit;
}

// 8. استقبال القيم الرقمية من الأدمن (عند إرسال الرقم)
if ($text && is_numeric($text) && isset($modes['mode'][$from_id])) {
    $mode = $modes['mode'][$from_id]; // $mode هو 'set_link_min'
    
    // التحقق إذا كان الوضع موجوداً في مصفوفة الربط
    if (array_key_exists($mode, $transfer_modes_map)) {
        
        // جلب المفتاح الصحيح لـ rshq.json
        $rshq_key = $transfer_modes_map[$mode]; // $rshq_key = 'link_transfer_min'
        
        $rshq[$rshq_key] = $text; // الحفظ بالمفتاح الصحيح
        SETJSON($rshq);
        
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "✅ تم الحفظ بنجاح. القيمة الجديدة هي: *$text*",
            'parse_mode' => "markdown",
        ]);
        
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
        
        // العودة إلى القائمة الفرعية الصحيحة
        $data = (strpos($mode, 'link') !== false) ? 'link_transfer_settings' : 'id_transfer_settings';
        // (يجب أن يستمر الكود ليعالج $data)
    }
}

// (الكود الحالي الخاص بك يستمر من هنا...)

if ($data == "offr") {
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('EditMessageText', [
      'chat_id' => $chat_id,
      'message_id' => $message_id,
      'text' => "
      *
     تم القفل
      *
      ",
      'parse_mode' => "markdown",
      'reply_markup' => json_encode([
        'inline_keyboard' => [

          [['text' => 'رجوع', 'callback_data' => "Brook"]],
        ]
      ])
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['FREE'] = null;
    $rshq = json_encode($rshq, 32 | 128 | 265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }
}

if ($data == "onfr") {
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('EditMessageText', [
      'chat_id' => $chat_id,
      'message_id' => $message_id,
      'text' => "
      *
     تم الفتح 
      *
      ",
      'parse_mode' => "markdown",
      'reply_markup' => json_encode([
        'inline_keyboard' => [

          [['text' => 'رجوع', 'callback_data' => "Brook"]],
        ]
      ])
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['FREE'] = "TR";
    $rshq = json_encode($rshq, 32 | 128 | 265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }
}


if ($data == "xdmat") {
    if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "
        *
🛠️ قسم الخدمات في البوت 🛠️
~ هذا القسم قسم اساسي يعتبر داخل اعدادات الرشق
~ فهو يقوم بأضافه اقسام وخدمات من هنا
        *
        ",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [["text" => "- الدخول الي الأقسام .","callback_data"=>"qsmsa"]],
            [['text' => 'رجوع', 'callback_data' => "Brook"]],
          ]
        ])
      ]);
      $modes['mode'][$from_id] = null;
      $rshq = json_encode($rshq, 32 | 128 | 265);
      file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
    }
  }


// ... (الكود الخاص بك)

$task_ex = explode("assasi_", $data)[1];
  
if ($task_ex) {
    $Y = $rshq['taskera'][$task_ex];

    if ($Y == "✅") {
        $t = "❌";
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => "• تم التعطيل", 'show_alert' => false]);
    } elseif ($Y == "❌" or $Y == null) {
        $t = "✅";
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => "• تم التفعيل", 'show_alert' => false]);

        if ($rshq['tasker_mns'][$task_ex] != true) {
            // (تحديد اسم القسم)
            switch ($task_ex) {
                // (هذا هو السطر الجديد)
                case "yearly_offers": $text = "عروض السنه 🎉"; break;
                
                case "sweat": $text = "واتساب 💚"; break;
                case "kwai": $text = "كواي 🧡"; break;
                case "insta": $text = "انستغرام 💜 "; break;
                case "tik": $text = "تيك توك 🖤"; break;
                case "telegram": $text = "تيليجرام 💙"; break;
                case "youtube": $text = "يوتيوب ❤️"; break;
                case "face": $text = "فيسبوك 💖"; break;
                case "twit": $text = "تويتر 🩵"; break;
                case "thread": $text = "ثريدز 🤍"; break;
                case "gem": $text = "شحن العاب 🤎"; break;
                case "offer": $text = "عروض اليوم 🩶"; break;
                case "jjll": $text = "ثريدز 🤍 "; break;
                default: $text = "";
            }

            $bSALEH = "SALEH" . rand(0, 999999999999999);
            $rshq['qsm'][] = $text . '-' . $bSALEH;
            $rshq['NAMES'][$bSALEH] = $text;
            $rshq['tasker_mns'][$task_ex] = true;
            $rshq['tasker_mcoide'][$task_ex] = $bSALEH;
        }
    }
    $rshq['taskera'][$task_ex] = $t;
    SETJSON($rshq);

    // (إعادة تحميل قائمة الأدمن - تم إضافة الزر الجديد هنا أيضًا)
    $key = ['inline_keyboard' => []];
    $key['inline_keyboard'][] = [
        ['text' => "عروض السنه 🎉" . ($rshq['taskera']["yearly_offers"] ?? "❌"), 'callback_data' => "assasi_yearly_offers"]
    ];
    $key['inline_keyboard'][] = [
        ['text' => "كواي 🧡" . ($rshq['taskera']["kwai"] ?? "❌"), 'callback_data' => "assasi_kwai"],          
        ['text' => "واتساب 💚" . ($rshq['taskera']["sweat"] ?? "❌"), 'callback_data' => "assasi_sweat"]
    ];
    $key['inline_keyboard'][] = [
        ['text' => "انستغرام 💜 " . ($rshq['taskera']["insta"] ?? "❌"), 'callback_data' => "assasi_insta"],
        ['text' => "تيك توك 🖤 " . ($rshq['taskera']["tik"] ?? "❌"), 'callback_data' => "assasi_tik"]
    ];
    $key['inline_keyboard'][] = [['text' => "تيليجرام 💙 " . ($rshq['taskera']["telegram"] ?? "❌"), 'callback_data' => "assasi_telegram"]];
    $key['inline_keyboard'][] = [
        ['text' => "يوتيوب ❤️ " . ($rshq['taskera']["youtube"] ?? "❌"), 'callback_data' => "assasi_youtube"],
        ['text' => "فيسبوك 💖 " . ($rshq['taskera']["face"] ?? "❌"), 'callback_data' => "assasi_face"]
    ];
    $key['inline_keyboard'][] = [
        ['text' => "تويتر 🩵 " . ($rshq['taskera']["twit"] ?? "❌"), 'callback_data' => "assasi_twit"],
        ['text' => "ثريدز 🤍 " . ($rshq['taskera']["thread"] ?? "❌"), 'callback_data' => "assasi_thread"]
    ];
    $key['inline_keyboard'][] = [
        ['text' => "شحن العاب 🤎" . ($rshq['taskera']["gem"] ?? "❌"), 'callback_data' => "assasi_gem"],
        ['text' => "عروض اليوم 🩶" . ($rshq['taskera']["offer"] ?? "❌"), 'callback_data' => "assasi_offer"]
    ];
    $key['inline_keyboard'][] = [['text' => "ثريدز 🤍 " . ($rshq['taskera']["jjll"] ?? "❌"), 'callback_data' => "assasi_jjll"]];
    $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "qsmsa"]];

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "*- الاقسام الاساسيات الجاهزه للأضافه . \n يمكنك تفعيلها وتعطيلها بأي وقت*",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode($key),
    ]);

    $modes['mode'][$from_id] = null;
    SETJSON12($modes);
    exit;
}



// ... (الكود الخاص بك)

if ($data == "asaiasis") {
    $key = ['inline_keyboard' => []];
    
    // (تم إضافة "عروض السنه" هنا)
    $key['inline_keyboard'][] = [
        ['text' => "عروض السنه 🎉" . ($rshq['taskera']["yearly_offers"] ?? "❌"), 'callback_data' => "assasi_yearly_offers"]
    ];
    $key['inline_keyboard'][] = [
        ['text' => "كواي 🧡" . ($rshq['taskera']["kwai"] ?? "❌"), 'callback_data' => "assasi_kwai"],          
        ['text' => "واتساب 💚" . ($rshq['taskera']["sweat"] ?? "❌"), 'callback_data' => "assasi_sweat"]
    ];
    $key['inline_keyboard'][] = [
        ['text' => "انستغرام 💜 " . ($rshq['taskera']["insta"] ?? "❌"), 'callback_data' => "assasi_insta"],
        ['text' => "تيك توك 🖤 " . ($rshq['taskera']["tik"] ?? "❌"), 'callback_data' => "assasi_tik"]
    ];
    $key['inline_keyboard'][] = [
        ['text' => "تيليجرام 💙 " . ($rshq['taskera']["telegram"] ?? "❌"), 'callback_data' => "assasi_telegram"]
    ];
    $key['inline_keyboard'][] = [
        ['text' => "يوتيوب ❤️ " . ($rshq['taskera']["youtube"] ?? "❌"), 'callback_data' => "assasi_youtube"],
        ['text' => "فيسبوك 💖 " . ($rshq['taskera']["face"] ?? "❌"), 'callback_data' => "assasi_face"]
    ];
    $key['inline_keyboard'][] = [
        ['text' => "تويتر 🩵 " . ($rshq['taskera']["twit"] ?? "❌"), 'callback_data' => "assasi_twit"],
        ['text' => "ثريدز 🤍 " . ($rshq['taskera']["thread"] ?? "❌"), 'callback_data' => "assasi_thread"]
    ];
    $key['inline_keyboard'][] = [
        ['text' => "شحن العاب 🤎" . ($rshq['taskera']["gem"] ?? "❌"), 'callback_data' => "assasi_gem"],
        ['text' => "عروض اليوم 🩶" . ($rshq['taskera']["offer"] ?? "❌"), 'callback_data' => "assasi_offer"]
    ];
    $key['inline_keyboard'][] = [
        ['text' => "ثريدز 🤍 " . ($rshq['taskera']["jjll"] ?? "❌"), 'callback_data' => "assasi_jjll"]
    ];
    $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "qsmsa"]];

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "*- الاقسام الاساسيات الجاهزه للأضافه . \n يمكنك تفعيلها وتعطيلها بأي وقت*",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode($key),
    ]);

    $modes['mode'][$from_id] = null;
    SETJSON($rshq);
    SETJSON12($modes);
    exit;
}



// ... (الكود الخاص بك)

// ===========================================
//  قسم إدارة الخدمات (للأدمن) - (بشكل 2x2)
// ===========================================

if ($data == "qsmsa") {
    $key = ['inline_keyboard' => []];
    $buttons_row = []; // مصفوفة لتخزين أزرار الأقسام
    
    $basic_service_codes = $rshq['tasker_mcoide'] ?? [];
    $qsm_list = $rshq['qsm'] ?? [];

    foreach ($qsm_list as $qsm_entry) {
        $nameq = explode("-", $qsm_entry)[0];
        $service_code = explode("-", $qsm_entry)[1];
        
        $is_basic = in_array($service_code, $basic_service_codes);
        $is_hidden = ($rshq['IFWORK>'][$service_code] == "NOT");
        
        $status_icon = $is_hidden ? "⚪️" : "🟢"; // أيقونة الحالة
        
        // إضافة زر القسم إلى مصفوفة الصف
        $buttons_row[] = ['text' => "$status_icon $nameq", 'callback_data' => "edits|$service_code"];
        
        // إذا اكتمل الصف (زرين)، أضفه للوحة المفاتيح وابدأ صف جديد
        if (count($buttons_row) == 2) {
            $key['inline_keyboard'][] = $buttons_row;
            $buttons_row = []; // أفرغ الصف
        }
    }
    
    // إذا تبقى زر واحد في النهاية، أضفه في صف لوحده
    if (count($buttons_row) > 0) {
        $key['inline_keyboard'][] = $buttons_row;
    }
    
    // إضافة أزرار التحكم السفلية
    $key['inline_keyboard'][] = [['text' => "+ اضافة قسم مخصص جديد", 'callback_data' => "addqsm"]];
    $key['inline_keyboard'][] = [['text' => "ألأقسام ألأساسيه (الجاهزة)", 'callback_data' => "asaiasis"]];
    $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "Brook"]];

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "*الأقسام الموجودة في البوت*
(اضغط على القسم لتعديله أو حذفه/إخفائه)
(🟢 ظاهر | ⚪️ مخفي)",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode($key),
    ]);

    $modes['mode'][$from_id] = null;
    SETJSON($rshq);
    SETJSON12($modes);
    exit;
}

// (مهم) يجب تعديل كود "edits" ليظهر أزرار الإخفاء/الحذف
if(explode("|",$data)[0]=="edits"){
    
    $service_code = explode("|",$data)[1];
    $service_name = $rshq['NAMES'][$service_code] ?? $service_code;

    // --- (أزرار تعديل الخدمات) ---
    $services_keyboard = [];
    if(isset($rshq['xdmaxs'][$service_code])) {
        foreach ( $rshq['xdmaxs'][$service_code] as $hjjj => $i) {
            $services_keyboard[] = [['text' => "$i", 'callback_data' => "editss|$service_code|$hjjj"], ['text' => "🗑", 'callback_data' => "delt|$service_code|$hjjj"]];
        }
    }
    
    $services_keyboard[] = [['text' => "+ أضافه خدمه يدويه", 'callback_data' => "add|$service_code"]];
    $services_keyboard[] = [['text' => "قسم الاضافه السريعه [ تلقائي ]", 'callback_data' => "addauto|$service_code"]];

    // --- (أزرار التحكم بالقسم نفسه) ---
    $is_basic = in_array($service_code, ($rshq['tasker_mcoide'] ?? []));
    $is_hidden = ($rshq['IFWORK>'][$service_code] == "NOT");

    if ($is_basic) {
        // قسم أساسي (إخفاء/إظهار فقط)
        $action_text = $is_hidden ? "إظهار ✅" : "إخفاء ❌";
        $services_keyboard[] = [['text' => $action_text, 'callback_data' => "toggle_visibility|$service_code"]];
    } else {
        // قسم مخصص (حذف نهائي)
        $services_keyboard[] = [['text' => "حذف القسم 🗑", 'callback_data' => "delete_custom_qsm|$service_code"]];
    }
    
    $services_keyboard[] = [['text' => "$NamesBACK", 'callback_data' => "qsmsa"]]; // رجوع لقائمة الأقسام

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "الخدمات الموجوده في قسم *$service_name*",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode(['inline_keyboard' => $services_keyboard]),
    ]);
    
    $modes['mode'][$from_id] = null;
    SETJSON($rshq); SETJSON12($modes);
    exit;
}


// 2. (جديد) معالج إخفاء/إظهار الأقسام (الأساسية والمخصصة)
// (هذا يحل محل الكود القديم 'delets')
if (explode("|", $data)[0] == "toggle_visibility") {
    $service_code = explode("|", $data)[1];
    
    // تبديل الحالة
    if ($rshq['IFWORK>'][$service_code] == "NOT") {
        $rshq['IFWORK>'][$service_code] = null; // أو "ok"
        $alert_text = "✅ تم إظهار القسم.";
    } else {
        $rshq['IFWORK>'][$service_code] = "NOT";
        $alert_text = "❌ تم إخفاء القسم.";
    }
    
    SETJSON($rshq);
    bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => $alert_text]);
    
    $data = 'qsmsa'; // إعادة تحميل القائمة
}

// 3. (جديد) معالج طلب حذف القسم (المخصص)
if (explode("|", $data)[0] == "delete_custom_qsm") {
    $service_code = explode("|", $data)[1];
    $service_name = $rshq['NAMES'][$service_code] ?? $service_code;

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "⚠️ *تأكيد الحذف*
        
هل أنت متأكد أنك تريد حذف القسم المخصص:
*$service_name*
        
هذا الإجراء سيحذف القسم وجميع الخدمات بداخله نهائيًا ولا يمكن التراجع عنه.",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'نعم، قم بالحذف الآن 🗑', 'callback_data' => "delete_custom_qsm_confirm|$service_code"]],
                [['text' => 'لا، إلغاء الأمر 🔙', 'callback_data' => 'qsmsa']],
            ]
        ])
    ]);
    exit;
}

// 4. (جديد) معالج تأكيد الحذف
if (explode("|", $data)[0] == "delete_custom_qsm_confirm") {
    $i_to_delete = explode("|", $data)[1];
    
    // 1. إزالة القسم من القائمة الرئيسية
    $new_qsm_list = [];
    foreach ($rshq['qsm'] as $qsm_entry) {
        if (explode("-", $qsm_entry)[1] != $i_to_delete) {
            $new_qsm_list[] = $qsm_entry;
        }
    }
    $rshq['qsm'] = $new_qsm_list;

    // 2. حذف بيانات القسم
    unset($rshq['NAMES'][$i_to_delete]);
    unset($rshq['xdmaxs'][$i_to_delete]); // حذف الخدمات
    unset($rshq['IFWORK>'][$i_to_delete]); // حذف حالة الإخفاء
    // (يجب أيضًا حذف أي بيانات أخرى مرتبطة بهذا القسم مثل 'Web', 'key', 'min'...)
    unset($rshq['Web'][$i_to_delete]);
    unset($rshq['key'][$i_to_delete]);
    unset($rshq['min'][$i_to_delete]);
    unset($rshq['mix'][$i_to_delete]);
    unset($rshq['IDSSS'][$i_to_delete]);
    unset($rshq['S3RS'][$i_to_delete]);
    unset($rshq['wsfer'][$i_to_delete]);
    unset($rshq['klishs'][$i_to_delete]);
    
    SETJSON($rshq);
    bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => '🗑 تم الحذف بنجاح.']);
    
    $data = 'qsmsa'; // إعادة تحميل القائمة
}

// 5. (تعديل) استبدال الكود القديم 'delets'
// تأكد من حذف الكود القديم الذي يبدأ بـ: if(explode("|",$data)[0] == "delets")
// لقد استبدلناه بـ "toggle_visibility"

// 6. كود تعديل الخدمات (يبقى كما هو غالبًا)
if(explode("|",$data)[0]=="edits"){
  // ... الكود الحالي الخاص بك لعرض الخدمات داخل القسم ...
  // لا يحتاج تعديل إلا إذا كنت تريد تغيير زر الرجوع
  
  $key = ['inline_keyboard' => []];
  $vv = rand(100,900);

  // (الكود الحالي لـ "edits" ... )
  foreach ( $rshq['xdmaxs'][explode("|",$data)[1]] as $hjjj => $i) {
    $key['inline_keyboard'][] = [['text' => "$i", 'callback_data' => "editss|".explode("|",$data)[1]."|$hjjj"], ['text' => "🗑", 'callback_data' => "delt|".explode("|",$data)[1]."|$hjjj"]];
  }
  $bSALEH = explode("|",$data)[1];
  $key['inline_keyboard'][] = [['text' => "+ أضافه خدمه يدويه", 'callback_data' => "add|$bSALEH"]];
  $key['inline_keyboard'][] = [['text' => "قسم الاضافه السريعه [ تلقائي ]", 'callback_data' => "addauto|$bSALEH"]];
  // $key['inline_keyboard'][] = [['text' => "مسح هذا القسم", 'callback_data' => "delets|$bSALEH"]]; // (تم نقل هذا الزر)
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "qsmsa"]]; // (تأكد أن الرجوع إلى "qsmsa")
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "الخدمات الموجوده في قسم *".$rshq['NAMES'][explode("|",$data)[1]]."*",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = null;
  $rshq['idTIMER'][$vv] = $rshq['NAMES'][explode("|",$data)[1]];
  SETJSON($rshq); SETJSON12($modes);
  exit;
}

// ...




if(explode("|",$data)[0] == "delets"){

  $rshq['IFWORK>'][explode("|",$data)[1]] = "NOT";
  $modes['mode'][$from_id] = null;
  SETJSON($rshq); SETJSON12($modes);


  $key = ['inline_keyboard' => []];
  foreach ($rshq['qsm'] as $i) {
    $nameq = explode("-",$i)[0];
    $i = explode("-",$i)[1];
    if($rshq['IFWORK>'][$i] != "NOT"){
    $key['inline_keyboard'][] = [['text' => "$nameq", 'callback_data' => "edits|$i"], ['text' => "", 'callback_data' => "delets|i"]];
  }
}
  $key['inline_keyboard'][] = [['text' => "+ اضافه قسم جديد", 'callback_data' => "addqsm"]];
  $key['inline_keyboard'][] = [['text' => "ألأقسام ألأساسيه", 'callback_data' => "qsmers"]];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "Brook"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
    *
    الاقسام الموجوده في البوت
    *
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
}

if($chat_id == $sudo){
  $tt = "قسم الاضافه السريعه [ تلقائي ]";
}
$UUS = explode("|", $data);
if(explode("|",$data)[0]=="edits"){
  $key = ['inline_keyboard' => []];
  $vv = rand(100,900);

  foreach ( $rshq['xdmaxs'][explode("|",$data)[1]] as $hjjj => $i) {

    $key['inline_keyboard'][] = [['text' => "$i", 'callback_data' => "editss|".explode("|",$data)[1]."|$hjjj"], ['text' => "🗑", 'callback_data' => "delt|".explode("|",$data)[1]."|$hjjj"]];
  }

  $bSALEH = explode("|",$data)[1];
  $key['inline_keyboard'][] = [['text' => "+ أضافه خدمه يدويه", 'callback_data' => "add|$bSALEH"]];
  $key['inline_keyboard'][] = [['text' => "قسم الاضافه السريعه [ تلقائي ]", 'callback_data' => "addauto|$bSALEH"]];
  $key['inline_keyboard'][] = [['text' => "مسح هذا القسم", 'callback_data' => "delets|$bSALEH"]];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "Brook"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
    *
    الخدمات الموجوده في قسم *".$rshq['NAMES'][explode("|",$data)[1]]."*
    *
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = null;
  $rshq['idTIMER'][$vv] = $rshq['NAMES'][explode("|",$data)[1]];
  SETJSON($rshq); SETJSON12($modes);
}

if($UUS[0]=="addauto"){
  if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('EditMessageText', [
      'chat_id' => $chat_id,
      'message_id' => $message_id,
      'text' => "
🌟
- أهلاً بك! خلال الفترة الأخيرة، تمت إضافة ميزة جديدة لتسهيل إضافة الخدمات للمستخدمين.
- يمكنك الآن إضافة خدمات مباشرة من خلال قسم الخدمات المتاحة في الموقع إلى بوتك.
- لاستخدام هذه الخدمة، يجب عليك وضع (موقع الرشق وتوكن الموقع) لبدء تشغيلها.
- بمجرد وضع هذه المعلومات، اضغط على الزر أدناه وابدأ استخدام الخدمة الجديدة!

👇

      ",
      'parse_mode' => "markdown",
      'reply_markup' => json_encode([
        'inline_keyboard' => [
          [['text' => 'تصفح الخدمات', 'callback_data' => "onlinerP|$UUS[1]"]],
          [['text' => 'رجوع', 'callback_data' => "edits|$UUS[1]"]],
        ]
      ])
    ]);
    $modes['mode'][$from_id] = "adders98"; 
    $rshq['idxs'][$from_id] = $UUS[1];
    $rshq = json_encode($rshq, 32 | 128 | 265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }
}

mkdir('time_back');
$tym = json_decode(file_get_contents('time_back/'.$chat_id.'_'.USR_BOT),1);

if($UUS[0]=="onlinerP"){
  if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    $keytr=[];
    $domen = "kd1s.com" ; //دومين موقع الرشق
$key = "999" ; //توكن لموقع
$api = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=services"));
for($i=0;$i <= 10;$i++){
$namem = $api[$i]->name ;
$id = $api[$i]->service ;
$s3r = $api[$i]->rate ;
$min = $api[$i]->min ;
$mix = $api[$i]->max ;
$category = $api[$i]->category ;
    if($namem) {
      $keytr[inline_keyboard][]=[['text'=>"$namem",'callback_data'=>"servicem|$id|$UUS[1]"]];
      $tym[$id]="$namem|$mix|$min|$id|$s3r";
      file_put_contents('time_back/'.$chat_id.'_'.USR_BOT,json_encode($tym));
    }
    }
    $keytr[inline_keyboard][]=[['text'=>"▶️ التالي",'callback_data'=>"cnc|2|$UUS[1]"]];
    $keytr[inline_keyboard][]=[['text'=>"رجوع",'callback_data'=>"addauto|$UUS[1]"]];

    bot('EditMessageText', [
      'chat_id' => $chat_id,
      'message_id' => $message_id,
      'text' => "
*🚀 التصفح السريع عزيزي المطور *[$name](tg://user?id=$chat_id) 🚀

~ اضغط على الخدمة المناسبة لإضافتها تلقائياً.

- يتم عرض (10) خدمات. يمكنك عرض المزيد من خلال النقر على الإيموجي أدناه.

*🔹 🔹 🔹 🔹 🔹 🔹 🔹 🔹 🔹 🔹*

      ",
      'parse_mode' => "markdown",
      'reply_markup' => json_encode($keytr)
    ]);
    $modes['mode'][$from_id] = "adders98"; 
    $rshq['idxs'][$from_id] = $UUS[1];
    $rshq = json_encode($rshq, 32 | 128 | 265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }
}

if(explode('|',$data)[0] == 'servicem'){
  $id = explode('|',$data)[1];
  $id_qsm = explode('|',$data)[2];
  $string = $tym[$id];
  list($namem, $mix, $min, $id, $s3r) = explode('|', $string);
  $nameqsm = $rshq['NAMES'][$id_qsm];
  $bop = bot('EditMessageText', [
      'chat_id' => $chat_id,
      'message_id' => $message_id,
      'text' => "
🚀 الإضافة السريعة (لقسم $nameqsm)

🔧 اسم الخدمة: [$namem]
🆔 ايدي الخدمة: `$id`
🔍 ايدي القسم: `$id_qsm`
💵 الحد الأدنى: `$min`
💰 الحد الأقصى: `$mix`
💲 سعر الخدمة في الموقع: `$s3r`

~ تمت الإضافة تلقائياً
      ",
      'parse_mode' => "markdown",
      'reply_markup'=>json_encode([
        'inline_keyboard'=>[
        [['text'=>"$NamesBACK",'callback_data'=>"onlinerP|".$id_qsm]],
          
         ]
       ])

    ]);
    $modes['mode'][$from_id] = null;
    $rshq['idxs'][$from_id] = null;
    $rshq['xdmaxs'][$id_qsm][] = $namem;
    $idser = array_search($namem,$rshq['xdmaxs'][$id_qsm]);

    bot('sendmessage', [
      'chat_id' => $chat_id,
      'message_id' => $message_id,
      'text' => "
للدخول إلى خدمة [$namem] تلقائياً 🚀

~ اضغط على أسم الخدمه ⬇️
      ",
      'parse_mode' => "markdown",
      'reply_to_message_id' => $bop->result->message_id,
      'reply_markup'=>json_encode([
        'inline_keyboard'=>[
        [['text'=>"$namem",'callback_data'=>"editss|".$id_qsm."|$idser" ]],
        [['text'=>"$NamesBACK",'callback_data'=>"onlinerP|".$id_qsm]],
          
         ]
       ])

    ]);

    $rshq['Web'][$id_qsm][$idser] = $rshq["sSite"]  ;
    $rshq['key'][$id_qsm][$idser] = $rshq["sToken"]  ;
    $rshq['min'][$id_qsm][$idser] = $min;
    $rshq['mix'][$id_qsm][$idser] = $mix;
    $rshq['IDSSS'][$id_qsm][$idser] = $id;

    $rshq= json_encode($rshq,32|128|265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
}

if(explode('|',$data)[0] == 'cnc'){
  if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    $num = explode('|', $data)[1];
    $vbn = $num + 1;
    $num = $num * 10;
    $keytrm = [];
    $domen = "kd1s.com"; // دومين موقع الرشق
    $key = "999"; // توكن لموقع
    $api = json_decode(file_get_contents("https://" . $rshq["sSite"] . "/api/v2?key=$Api_Tok&action=services"));
    
    for ($i = $num; $i < min($num + 10, count($api)); $i++) {
      $namem = $api[$i]->name ;
      $id = $api[$i]->service ;
      $s3r = $api[$i]->rate ;
      $min = $api[$i]->min ;
      $mix = $api[$i]->max ;
      $category = $api[$i]->category ;
        
        if ($namem) {
            $keytrm['inline_keyboard'][] = [['text' => "$namem", 'callback_data' => "servicem|$id|".explode('|',$data)[2]]];
            $tym[$id]="$namem|$mix|$min|$id|$s3r";
            file_put_contents('time_back/'.$chat_id.'_'.USR_BOT,json_encode($tym));
        }
    }
    
    $keytrm['inline_keyboard'][] = [['text' => "▶️ التالي", 'callback_data' => "cnc|$vbn|".explode('|',$data)[2]]];
    $keytrm['inline_keyboard'][] = [['text' => "رجوع", 'callback_data' => "addauto|".explode('|',$data)[2]]];
    

    bot('EditMessageText', [
      'chat_id' => $chat_id,
      'message_id' => $message_id,
      'text' => "
*🚀 التصفح السريع عزيزي المطور *[$name](tg://user?id=$chat_id) 🚀
- الصفحه : (". explode('|',$data)[1].") 

~ اضغط على الخدمة المناسبة لإضافتها تلقائياً.

- يتم عرض (10) خدمات. يمكنك عرض المزيد من خلال النقر على الإيموجي أدناه.

*🔹 🔹 🔹 🔹 🔹 🔹 🔹 🔹 🔹 🔹*
      ",
      
      'parse_mode' => "markdown",
      'reply_markup' => json_encode($keytrm)
    ]);
    $modes['mode'][$from_id] = "adders98"; 
    $rshq['idxs'][$from_id] = $UUS[1];
    $rshq = json_encode($rshq, 32 | 128 | 265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }
}

if (explode("|", $data)[0] == "editss") {
	$sitecon = $rshq['Web'][explode("|", $data)[1]][explode("|", $data)[2]] ?? $rshq["sSite"];
    $s3r = $rshq['S3RS'][explode("|", $data)[1]][explode("|", $data)[2]];
    $web = ($rshq['Web'][explode("|", $data)[1]][explode("|", $data)[2]] ?? $rshq["sSite"]);
    $s3r = ($s3r ?? "1");
    $key = ($rshq['key'][explode("|", $data)[1]][explode("|", $data)[2]] ?? $rshq["sToken"]);
    $mix = ($rshq['mix'][explode("|", $data)[1]][explode("|", $data)[2]] ?? "1000");
    $min = ($rshq['min'][explode("|", $data)[1]][explode("|", $data)[2]] ?? "100");
    $ifd = "$min - $mix";
    $idxdam = $rshq['IDSSS'][explode("|", $data)[1]][explode("|", $data)[2]] ?? "لا يوجد";
    $Apikey = $rshq['key'][explode("|", $data)[1]][explode("|", $data)[2]] ?? "لا يوجد";
   
   $rsedi = json_decode(file_get_contents("https://".$sitecon."/api/v2?key=$Apikey&action=balance"));
$flos = $rsedi->balance; 
$treqa = $rsedi->currency; 
    if ($rshq["sSite"] != null) {
        $dom = "ربط الخدمه على الموقع الأساسي (" . $rshq["sSite"] . ") ";
    }
    $key = ['inline_keyboard' => []];
    $key['inline_keyboard'][] = [['text' => "$dom", 'callback_data' => "setauto|" . explode("|", $data)[1] . "|" . explode("|", $data)[2]]];
    $key['inline_keyboard'][] = [['text' => "تعيين سعر الخدمه", 'callback_data' => "setprice|" . explode("|", $data)[1] . "|" . explode("|", $data)[2]]];
    $key['inline_keyboard'][] = [['text' => "تعيين ايدي الخدمه", 'callback_data' => "setid|" . explode("|", $data)[1] . "|" . explode("|", $data)[2]]];
    $key['inline_keyboard'][] = [['text' => "تعيين ادنى حد للخدمه", 'callback_data' => "setmin|" . explode("|", $data)[1] . "|" . explode("|", $data)[2]]];
    $key['inline_keyboard'][] = [['text' => "تعيين اقصى حد للخدمه", 'callback_data' => "setmix|" . explode("|", $data)[1] . "|" . explode("|", $data)[2]]];
    $key['inline_keyboard'][] = [['text' => "تعيين ربط الموقع", 'callback_data' => "setWeb|" . explode("|", $data)[1] . "|" . explode("|", $data)[2]]];
    $key['inline_keyboard'][] = [['text' => "تعيين وصف الخدمه", 'callback_data' => "setabb|" . explode("|", $data)[1] . "|" . explode("|", $data)[2]]];
    $key['inline_keyboard'][] = [['text' => "تعيين كليشه الارسال", 'callback_data' => "setklisja|" . explode("|", $data)[1] . "|" . explode("|", $data)[2]]];
    $key['inline_keyboard'][] = [['text' => "تعيين API KEY الموقع للخدمه", 'callback_data' => "setkey|" . explode("|", $data)[1] . "|" . explode("|", $data)[2]]];
    $key['inline_keyboard'][] = [['text' => "امسح الخدمه", 'callback_data' => "delt|" . explode("|", $data)[1] . "|" . explode("|", $data)[2]]];
    $key['inline_keyboard'][] = [['text' => "🔃 تحديث القائمه", 'callback_data' => "editss|" . explode("|", $data)[1] . "|" . explode("|", $data)[2]]];
    
    $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "edits|".explode("|", $data)[1]]];

    

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "*
    هنا خدمه " . $rshq['xdmaxs'][explode("|", $data)[1]][explode("|", $data)[2]] . " في قسم " . $rshq['NAMES'][explode("|", $data)[1]] . "
    يمكنك التحكم الكامل بلخدمات هنا ؟
    *
   
      - سعر الخدمه الحالي : *$s3r*
   - ايدي الخدمه الحالي : `$idxdam`
   - ادني حد - اقصي حد : *$ifd*
   - ربط الخدمه مربوط بموقع : ($sitecon)
   - مفتاح الموقع : `$Apikey`
   - رصيدك في الموقع : *$flos*
    ",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode($key),
    ]);
    $modes['mode'][$from_id] = null;
    SETJSON($rshq);
    SETJSON12($modes);
}

if(explode("|",$data)[0]=="delt"){
  unset($rshq['xdmaxs'][explode("|",$data)[1]][explode("|",$data)[2]]);
  $modes['mode'][$from_id] = null;
  $rshq['idTIMER'][$vv] = $rshq['NAMES'][explode("|",$data)[1]];
  SETJSON($rshq); SETJSON12($modes);

  $key = ['inline_keyboard' => []];
  $vv = rand(100,900);

  foreach ( $rshq['xdmaxs'][explode("|",$data)[1]] as $hjjj => $i) {

    $key['inline_keyboard'][] = [['text' => "$i", 'callback_data' => "editss|".explode("|",$data)[1]."|$hjjj"], ['text' => "🗑", 'callback_data' => "delt|".explode("|",$data)[1]."|$hjjj"]];
  }

  $bSALEH = explode("|",$data)[1];
  $key['inline_keyboard'][] = [['text' => "+ اضافه خدمات الي هذا القسم", 'callback_data' => "add|$bSALEH"]];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "Brook"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
    *
    
    الخدمات الموجوده في قسم *".$rshq['NAMES'][explode("|",$data)[1]]."*
    *
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);

}

$name_xadm = $rshq['xdmaxs'][explode("|",$data)[1]][explode("|",$data)[2]];
$name_qsm = $rshq['NAMES'][explode("|",$data)[1]];
$xcmp = "editss|".explode("|", $data)[1]."|".explode("|", $data)[2]."";
$jn[1] = explode("|",$rshq['MGS'][$from_id])[1];
$jn[2] = explode("|",$rshq['MGS'][$from_id])[2];
$xcdp = "editss|".$jn[1]."|".$jn[2]."";
$backers = ['inline_keyboard' => []];

$backers['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "$xcdp"]];
$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/rshq.json"),true);
if(explode("|",$data)[0]=="setprice"){
  $key = ['inline_keyboard' => []];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "$xcmp"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
- عزيزي المطور اهلا بك في خدمه *$name_xadm* داخل اقسام *$name_qsm*
~ في وضع ( سعر الخدمه ) 
~ أرسل الأن سعر الخدمه :
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = "setprice";
  $rshq['MGS'][$from_id] = "MGS|".explode("|",$data)[1]."|".explode("|",$data)[2];
  SETJSON($rshq); SETJSON12($modes);
}

if(explode("|",$data)[0]=="setauto"){

  $key = ['inline_keyboard' => []];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "$xcmp"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
- عزيزي المطور اهلا بك في خدمه *$name_xadm* داخل اقسام *$name_qsm*
~ تم ربط الخدمه بنجاح علي الموقع الأساسي .
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = null;
  $rshq['Web'][explode("|",$data)[1]][explode("|",$data)[2]] = $rshq["sSite"]  ;
  $rshq['key'][explode("|",$data)[1]][explode("|",$data)[2]] = $rshq["sToken"]  ;
  SETJSON($rshq); SETJSON12($modes);
}



if(explode("|",$data)[0]=="setmin"){
  $key = ['inline_keyboard' => []];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "$xcmp"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
- عزيزي المطور اهلا بك في خدمه *$name_xadm* داخل اقسام *$name_qsm*
~ في وضع ( أدني حد الخدمه ) 
~ أرسل الأن ادنى حد الخدمه :
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = "setmin";
  $rshq['MGS'][$from_id] = "MGS|".explode("|",$data)[1]."|".explode("|",$data)[2];
  SETJSON($rshq); SETJSON12($modes);
}

if(is_numeric($text) and $modes['mode'][$from_id] == "setmin"){
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    $bA = $text / 1000;
    bot("sendmessage",[
      "chat_id" => $chat_id,
      "text" => "
      تم تعيين ادني حد *". $rshq['xdmaxs'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]]."* في قسم *".$rshq['NAMES'][explode("|",$rshq['MGS'][$from_id])[1]]."*
      ",
      "parse_mode"=>"markdown",
      'reply_markup' => json_encode($backers),
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['min'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]] = $text ;
    $rshq['MGS'][$from_id] = null;
    SETJSON($rshq); SETJSON12($modes);
  }
}

if(explode("|",$data)[0]=="setabb"){
	$mix = ($rshq['mix'][explode("|",$data)[1]][explode("|",$data)[2]] ?? "1000");
        $min = ($rshq['min'][explode("|",$data)[1]][explode("|",$data)[2]] ?? "100");
	$abb1 = "
	👮🏽] اسم الخدمة : [".$rshq['xdmaxs'][explode("|",$data)[1]][explode("|",$data)[2]]."]

💰] السعر : ". $g ." نقطة لكل 1000

📊] الحد الادني للرشق : $min
🎟️] الحد الاقصي للرشق : $mix

🦾] ارسل الكمية التي تريد طلبها : 
	" ;

  if($rshq['wsfer'][explode("|",$data)[1]][explode("|",$data)[2]] == null){
    $abb = $abb1;
  }else{
    $abb = $rshq['wsfer'][explode("|",$data)[1]][explode("|",$data)[2]];
  }
	$abb = $rshq['wsfer'][explode("|",$data)[1]][explode("|",$data)[2]]?? $abb;
  $key = ['inline_keyboard' => []];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "$xcmp"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
- عزيزي المطور اهلا بك في خدمه *$name_xadm* داخل اقسام *$name_qsm*
~ في وضع ( وصف الخدمه ) 
~ أرسل الأن وصف الخدمه :

*الوصف الحالي :-*

$abb
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = "setabb";
  $rshq['MGS'][$from_id] = "MGS|".explode("|",$data)[1]."|".explode("|",$data)[2];
  SETJSON($rshq); SETJSON12($modes);
}

if($text and $modes['mode'][$from_id] == "setabb"){
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    $bA = $text / 1000;
    bot("sendmessage",[
      "chat_id" => $chat_id,
      "text" => "
      تم تعيين الوصف *". $rshq['xdmaxs'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]]."* في قسم *".$rshq['NAMES'][explode("|",$rshq['MGS'][$from_id])[1]]."*
      ",
      "parse_mode"=>"markdown",
      'reply_markup' => json_encode($backers),
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['wsfer'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]] = $text ;
    $rshq['MGS'][$from_id] = null;
    SETJSON($rshq); SETJSON12($modes);
  }
}

if(explode("|",$data)[0]=="setklisja"){
	$mix = ($rshq['mix'][explode("|",$data)[1]][explode("|",$data)[2]] ?? "1000");
        $min = ($rshq['min'][explode("|",$data)[1]][explode("|",$data)[2]] ?? "100");
      
	$abb = "
	• ارسل الرابط الخاص بك 📥 :
	" ;
  
	$abb = $rshq['klishs'][explode("|",$data)[1]][explode("|",$data)[2]]?? $abb;
  $key = ['inline_keyboard' => []];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "$xcmp"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
- عزيزي المطور اهلا بك في خدمه *$name_xadm* داخل اقسام *$name_qsm*
~ في وضع ( كليشه ألأرسال الخدمه ) 
~ أرسل الأن الكليشه الخدمه :

*الكليشه الحاليه :-*

$abb
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = "setklisja";
  $rshq['MGS'][$from_id] = "MGS|".explode("|",$data)[1]."|".explode("|",$data)[2];
  SETJSON($rshq); SETJSON12($modes);
}

if($text and $modes['mode'][$from_id] == "setklisja"){
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    $bA = $text / 1000;
    bot("sendmessage",[
      "chat_id" => $chat_id,
      "text" => "
      تم تعيين الكلشه *". $rshq['xdmaxs'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]]."* في قسم *".$rshq['NAMES'][explode("|",$rshq['MGS'][$from_id])[1]]."*
      ",
      "parse_mode"=>"markdown",
      'reply_markup' => json_encode($backers),
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['klishs'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]] = $text ;
    $rshq['MGS'][$from_id] = null;
    SETJSON($rshq); SETJSON12($modes);
  }
}

if(explode("|",$data)[0]=="setkey"){
  $key = ['inline_keyboard' => []];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "$xcmp"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
- عزيزي المطور اهلا بك في خدمه *$name_xadm* داخل اقسام *$name_qsm*
~ في وضع ( API_KEY الخدمه ) 
~ أرسل الأن مفتاح API الخدمه :
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = "setkey";
  $rshq['MGS'][$from_id] = "MGS|".explode("|",$data)[1]."|".explode("|",$data)[2];
  SETJSON($rshq); SETJSON12($modes);
}
$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/rshq.json"),true);

if($text and $modes['mode'][$from_id] == "setkey"){
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    $bA = $text / 1000;
    bot("sendmessage",[
      "chat_id" => $chat_id,
      "text" => "
      تم تعيين API KEY *". $rshq['xdmaxs'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]]."* في قسم *".$rshq['NAMES'][explode("|",$rshq['MGS'][$from_id])[1]]."*
      ",
      "parse_mode"=>"markdown",
      'reply_markup' => json_encode($backers),
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['key'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]] = $text ;
    $rshq['MGS'][$from_id] = null;
    SETJSON($rshq); SETJSON12($modes);
  }
}

if(explode("|",$data)[0]=="setmix"){
  $key = ['inline_keyboard' => []];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "$xcmp"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
- عزيزي المطور اهلا بك في خدمه *$name_xadm* داخل اقسام *$name_qsm*
~ في وضع ( اقصى حد الخدمه ) 
~ أرسل الأن اقصى حد الخدمه :
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = "setmix";
  $rshq['MGS'][$from_id] = "MGS|".explode("|",$data)[1]."|".explode("|",$data)[2];
  SETJSON($rshq); SETJSON12($modes);
}

if(is_numeric($text) and $modes['mode'][$from_id] == "setmix"){
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
   
    bot("sendmessage",[
      "chat_id" => $chat_id,
      "text" => "
      تم تعيين اقصي حد *". $rshq['xdmaxs'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]]."* في قسم *".$rshq['NAMES'][explode("|",$rshq['MGS'][$from_id])[1]]."*
      ",
      "parse_mode"=>"markdown",
      'reply_markup' => json_encode($backers),
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['mix'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]] = $text ;
    $rshq['MGS'][$from_id] = null;
    SETJSON($rshq); SETJSON12($modes);
  }
}


if(is_numeric($text) and $modes['mode'][$from_id] == "setprice"){
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    $bA = $text / 1000;
    bot("sendmessage",[
      "chat_id" => $chat_id,
      "text" => "
      تم تعيين سعر *". $rshq['xdmaxs'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]]."* في قسم *".$rshq['NAMES'][explode("|",$rshq['MGS'][$from_id])[1]]."*
      ",
      "parse_mode"=>"markdown",
      'reply_markup' => json_encode($backers),
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['S3RS'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]] = $bA;
    $rshq['MGS'][$from_id] = null;
    SETJSON($rshq); SETJSON12($modes);
  }
}

if(explode("|",$data)[0]=="setWeb"){
  $key = ['inline_keyboard' => []];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "$xcmp"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
- عزيزي المطور اهلا بك في خدمه *$name_xadm* داخل اقسام *$name_qsm*
~ في وضع ( رابط موقع الخدمه ) 
~ أرسل الأن رابط موقع الخدمه :
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = "setWeb";
  $rshq['MGS'][$from_id] = "MGS|".explode("|",$data)[1]."|".explode("|",$data)[2];
  SETJSON($rshq); SETJSON12($modes);
}

if($text and $modes['mode'][$from_id] == "setWeb"){
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
$IMSALEH = parse_url($text);
$INSALEH = $IMSALEH['host'];

    bot("sendmessage",[
      "chat_id" => $chat_id,
      "text" => "
      تم تعيين ربط موقع *". $rshq['xdmaxs'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]]."* في قسم *".$rshq['NAMES'][explode("|",$rshq['MGS'][$from_id])[1]]."*
      ",
      "parse_mode"=>"markdown",
      'reply_markup' => json_encode($backers),
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['Web'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]] = $INSALEH;
    $rshq['MGS'][$from_id] = null;
    SETJSON($rshq); SETJSON12($modes);
  }
}

if(explode("|",$data)[0]=="setdes"){
  $key = ['inline_keyboard' => []];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "$xcmp"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
    *
    هنا خدمه ".$rshq['xdmaxs'][explode("|",$data)[1]][explode("|",$data)[2]]." في قسم ".$rshq['NAMES'][explode("|",$data)[1]]."
    ارسل وصف الخدمه الان؟
    *
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = "setdes";
  $rshq['MGS'][$from_id] = "MGS|".explode("|",$data)[1]."|".explode("|",$data)[2];
  SETJSON($rshq); SETJSON12($modes);
}

if($text and $modes['mode'][$from_id] == "setdes"){
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    
    bot("sendmessage",[
      "chat_id" => $chat_id,
      "text" => "
      تم تعيين وصف ر *". $rshq['xdmaxs'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]]."* في قسم *".$rshq['NAMES'][explode("|",$rshq['MGS'][$from_id])[1]]."*
      ",
      "parse_mode"=>"markdown",
      'reply_markup' => json_encode($backers),
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['WSF'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]] = $text;
    $rshq['MGS'][$from_id] = null;
    SETJSON($rshq); SETJSON12($modes);
  }
}

if(explode("|",$data)[0]=="setid"){
  $key = ['inline_keyboard' => []];
  $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "$xcmp"]];
  bot('EditMessageText', [
    'chat_id' => $chat_id,
    'message_id' => $message_id,
    'text' => "
- عزيزي المطور اهلا بك في خدمه *$name_xadm* داخل اقسام *$name_qsm*
~ في وضع ( ايدي الخدمه ) 
~ أرسل الأن ايدي الخدمه الخدمه :
    ",
    'parse_mode' => "markdown",
    'reply_markup' => json_encode($key),
  ]);
  $modes['mode'][$from_id] = explode("|",$data)[0];
  $rshq['MGS'][$from_id] = "MGS|".explode("|",$data)[1]."|".explode("|",$data)[2];
  SETJSON($rshq); SETJSON12($modes);
}

if(is_numeric($text) and $modes['mode'][$from_id] == "setid"){
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    
    bot("sendmessage",[
      "chat_id" => $chat_id,
      "text" => "
      تم تعيين ايدي خدمه ر *". $rshq['xdmaxs'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]]."* في قسم *".$rshq['NAMES'][explode("|",$rshq['MGS'][$from_id])[1]]."*
      ",
      "parse_mode"=>"markdown",
      'reply_markup' => json_encode($backers),
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['IDSSS'][explode("|",$rshq['MGS'][$from_id])[1]][explode("|",$rshq['MGS'][$from_id])[2]] = $text;
    $rshq['MGS'][$from_id] = null;
    SETJSON($rshq); SETJSON12($modes);
  }
}

  if ($data == "addqsm") {
    if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "
        *
        ارسل اسم القسم الان مثلا خدمات انستاكرام
        *
        ",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [['text' => 'رجوع', 'callback_data' => "xdmat"]],
          ]
        ])
      ]);
      $modes['mode'][$from_id] = $data;
      $rshq = json_encode($rshq, 32 | 128 | 265);
      file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
    }
  }
  
  if ($text and $modes["mode"][$from_id] == "addqsm") {
    if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      $bSALEH = "SALEH" . rand(0, 999999999999999);
      bot("sendmessage", [
        "chat_id" => $chat_id,
        "text" => "
تم إضافة هذا القسم بنجاح. 🎉
- اسم القسم: $text
- كود القسم: $bSALEH

شكرًا لتحسيناتك القيمة! 🚀
        ",
        "parse_mode" => "markdown",
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [['text' => 'للدخول لهذا القسم', 'callback_data' => "CHANGE|$bSALEH"]],
          ]
        ])
      ]);
      $rshq['qsm'][] = $text . '-' . $bSALEH;
      $rshq['NAMES'][$bSALEH] = $text;
      $modes['mode'][$from_id] = null;
      $rshq = json_encode($rshq, 32 | 128 | 265);
      file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
    }
  }
  
  $UUS = explode("|", $data);
  if ($UUS[0] == "CHANGE") {
    if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      $bSALEH = $UUS[1];
      if ($rshq['NAMES'][$bSALEH] != null) {
        $key = ['inline_keyboard' => []];
        foreach ($rshq['xdmaxs'][$bSALEH] as $i) {
          $name = $rshq['nam'][$i];
          $ids = $rshq['ids'][$i];
          $key['inline_keyboard'][] = [['text' => "$name", 'callback_data' => "edits:$i"], ['text' => "🗑", 'callback_data' => "edits:$i"]];
        }
        $key['inline_keyboard'][] = [['text' => "+ أضافه خدمه يدويه", 'callback_data' => "add|$bSALEH"]];
        $key['inline_keyboard'][] = [['text' => "قسم الاضافه السريعه [ تلقائي ]", 'callback_data' => "addauto|$bSALEH"]];
        $key['inline_keyboard'][] = [['text' => "مسح هذا القسم", 'callback_data' => "delets|$bSALEH"]];
        bot('EditMessageText', [
          'chat_id' => $chat_id,
          'message_id' => $message_id,
          'text' => "
          *
          مرحبا بك في هذا القسم " . $rshq['NAMES'][$bSALEH] . "
          *
          ",
          'parse_mode' => "markdown",
          'reply_markup' => json_encode($key),
        ]);
      }
    }
  }

  if($UUS[0]=="add"){
    if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
      bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "
        *
        ارسل اسم الخدمه لاضافاتها الي قسم ".$bSALEH."
        *
        ",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
          'inline_keyboard' => [
            [['text' => 'رجوع', 'callback_data' => "xdmat"]],
          ]
        ])
      ]);
      $modes['mode'][$from_id] = "adders"; 
      $rshq['idxs'][$from_id] = $UUS[1];
      $rshq = json_encode($rshq, 32 | 128 | 265);
      file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
    }
  }

if($text and $modes['mode'][$from_id] == "adders"){
  if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    $bSALEH = $rshq['idxs'][$from_id];
    $bsf = rand(33,33333);
    $j=1;
    foreach ( $rshq['xdmaxs'][$bSALEH] as $hjjj => $i) {
$j+=1;
    }
    bot("sendmessaGE",[
      "chat_id" => $chat_id,
      "text" => "
      تم اضافه هذا الخدمه الي قسم *".$rshq['NAMES'][$bSALEH]."*
      ",
      "parse_mode" => "markdown",
      'reply_markup' => json_encode([
        'inline_keyboard' => [
          [['text' => 'دخول الي الخدمه', 'callback_data' => "editss|".$bSALEH."|$hjjj"]],
          [['text' => 'رجوع', 'callback_data' => "xdmat"]],
        ]
      ])
    ]);
    $modes['mode'][$from_id] = null;
    $rshq['idxs'][$from_id] = null;
    $rshq['xdmaxs'][$bSALEH][] = $text;
    $rshq= json_encode($rshq,32|128|265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }
}

$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/rshq.json"),true);

if($data == "onhdia"){
  if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot("deletemessage",[
      'chat_id' => $chat_id,
      'message_id' => $message_id,
    ]);
    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'message_id'=>$message_id,
      'text'=>"
      *
     تم تفعيل الهديه اليوميه .
      *
      
      ",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode([ 
      'inline_keyboard'=>[
           [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
      ]
      ])
      ]);

      $rshq['HDIA']  = "on";
      $rshq= json_encode($rshq,32|128|265);
      file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }
}

if($data == "ofhdia"){
  if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot("deletemessage",[
      'chat_id' => $chat_id,
      'message_id' => $message_id,
    ]);
    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'message_id'=>$message_id,
      'text'=>"
      *
     تم تعطيل الهديه اليوميه .
      *
      ",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode([ 
      'inline_keyboard'=>[
           [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
      ]
      ])
      ]);

      $rshq['HDIA']  = "of";
      $rshq= json_encode($rshq,32|128|265);
      file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }
}

if($data == "sAKTHAR"){
if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
  bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    *
   ارسل الان العدد ( ادني حد لتحويل ال$name3mla (
    *
    
    ",
    'parse_mode'=>"markdown",
    'reply_markup'=>json_encode([ 
    'inline_keyboard'=>[
         [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
    ]
    ])
    ]);
    $modes['mode'][$from_id]  = $data;
    $rshq= json_encode($rshq,32|128|265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
}
}

if($text and $modes['mode'][$from_id] == "sAKTHAR"){
if(is_numeric($text)){
  bot("sendmessage",[
    'chat_id'=>$chat_id,
    'text'=>"تم التعيين بنجاح ادني حد للتحويل هو *$text*",
    'parse_mode'=>"markdown",
    'reply_markup'=>json_encode([ 
      'inline_keyboard'=>[
           [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
      ]
      ])
  ]);
  $rshq['AKTHAR']  = $text;
  $modes['mode'][$from_id]  = null;
  $rshq= json_encode($rshq,32|128|265);
  file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
}else{
  bot("sendmessage",[
    'chat_id'=>$chat_id,
    'text'=>"ارسل *الارقام* فقط عزيزي",
    'parse_mode'=>"markdown",
    'reply_markup'=>json_encode([ 
      'inline_keyboard'=>[
           [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
      ]
      ])
  ]);

}
}

if($data == "setphone"){
  if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
    bot('EditMessageText',[
      'chat_id'=>$chat_id,
      'message_id'=>$message_id,
      'text'=>"
      *
     ارسل الان رقم الهاتف 
      *
      
      ",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode([ 
      'inline_keyboard'=>[
           [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
      ]
      ])
      ]);
      $modes['mode'][$from_id]  = $data;
      $rshq= json_encode($rshq,32|128|265);
      file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }
  }
  
  if($text and $modes['mode'][$from_id] == "setphone"){
  if(is_numeric($text)){
    bot("sendmessage",[
      'chat_id'=>$chat_id,
      'text'=>"تم التعيين بنجاح رقم الهاتف هو *$text*",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode([ 
        'inline_keyboard'=>[
             [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
        ]
        ])
    ]);
    $rshq["phone"]  = $text;
    $modes['mode'][$from_id]  = null;
    $rshq= json_encode($rshq,32|128|265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
  }else{
    bot("sendmessage",[
      'chat_id'=>$chat_id,
      'text'=>"ارسل *الارقام* فقط عزيزي",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode([ 
        'inline_keyboard'=>[
             [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
        ]
        ])
    ]);
  
  }
  }

if($data == "sethdia"){
if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
  bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    *
   ارسل الان عدد الهدیه الیومیه .
    *
    ",
    'parse_mode'=>"markdown",
    'reply_markup'=>json_encode([ 
    'inline_keyboard'=>[
         [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
    ]
    ])
    ]);
    $modes['mode'][$from_id]  = $data;
    $rshq= json_encode($rshq,32|128|265);
    file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
}
}

if($text and $modes['mode'][$from_id] == "sethdia"){
if(is_numeric($text)){
  bot("sendmessage",[
    'chat_id'=>$chat_id,
    'text'=>"تم التعيين بنجاح عدد الهديه اليوميه هو *$text*",
    'parse_mode'=>"markdown",
    'reply_markup'=>json_encode([ 
      'inline_keyboard'=>[
           [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
      ]
      ])
  ]);
  $rshq['hdias']  = $text;
  $modes['mode'][$from_id]  = null;
  $rshq= json_encode($rshq,32|128|265);
  file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
	file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
}else{
  bot("sendmessage",[
    'chat_id'=>$chat_id,
    'text'=>"ارسل *الارقام* فقط عزيزي",
    'parse_mode'=>"markdown",
    'reply_markup'=>json_encode([ 
      'inline_keyboard'=>[
           [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
      ]
      ])
  ]);

}
}

// ======================================================
//  (جديد) 11. أكواد الهدية الأسبوعية (للأدمن)
// ======================================================

// 11.1: زر الفتح والقفل
if($data == "toggle_weekly_gift") {
    if ($chat_id == $sudo) {
        $status = $rshq['weekly_gift_status'] ?? 'on';
        
        if ($status == 'on') {
            $rshq['weekly_gift_status'] = 'off';
            $alert_text = '❌ تم تعطيل الهدية الأسبوعية.';
        } else {
            $rshq['weekly_gift_status'] = 'on';
            $alert_text = '✅ تم تفعيل الهدية الأسبوعية.';
        }
        SETJSON($rshq);
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => $alert_text, 'show_alert' => true]);
    }
}

// 11.2: زر تعيين النقاط
if($data == "set_weekly_gift"){
if($chat_id == $sudo ) {
  $current_points = $rshq['weekly_gift_points'] ?? 100; // افتراضي 100
  bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    *🗓️ ارسل الآن عدد نقاط الهدية الأسبوعية.*
    
    *الحالي:* $current_points $name3mla
    ",
    'parse_mode'=>"markdown",
    'reply_markup'=>json_encode([ 
    'inline_keyboard'=>[
         [['text'=>'رجوع' ,'callback_data'=>"Hdias_j"]],
    ]
    ])
    ]);
    $modes['mode'][$from_id]  = 'set_weekly_gift_points';
    SETJSON12($modes);
}
}

// 11.3: استلام النقاط
if($text && is_numeric($text) && $modes['mode'][$from_id] == "set_weekly_gift_points"){
if($chat_id == $sudo){
  bot("sendmessage",[
    'chat_id'=>$chat_id,
    'text'=>"✅ *تم حفظ :* $text $name3mla",
    'parse_mode'=>"markdown",
    'reply_markup'=>json_encode([ 
      'inline_keyboard'=>[
           [['text'=>'رجوع' ,'callback_data'=>"Hdias_j"]],
      ]
      ])
  ]);
  $rshq['weekly_gift_points']  = $text;
  unset($modes['mode'][$from_id]);
  SETJSON($rshq); 
  SETJSON12($modes);
}
}


if($data == "infoRshq") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ) {
		
		if($rshq["sToken"] == null){
			$sTok="مامخلي توكن موقع انت";
			}else{
				$sTok=$rshq["sToken"];
				}
				
				if($rshq["sToken"] == null){
			$Sdom="مامخلي دومين الموقع انت";
			}else{
				$Sdom=$rshq["sSite"];
				}
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
معلومات الرشق
*

توكن الموقع : `$sTok`
دومين موقع الرشق : `$Sdom`

",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
     [['text'=>'رجوع' ,'callback_data'=>"Brook"]],
]
])
]);
$modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
}
}



if($data == "token"  ) {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ){
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
ارسل الان توكن الموقع 🕸️
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]],
       
      ]
    ])
]);
    $modes['mode'][$from_id]  = "sToken";
SETJSON($rshq); SETJSON12($modes);
} 
}

 
$rnd=rand(999,99999);
if($text and $modes['mode'][$from_id] == "sToken") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ){
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
   
  تم تعيين توكن الموقع
 - - - - - - - - - - - - - - - - - - 
`$text`
 - - - - - - - - - - - - - - - - - - 
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]],
       
      ]
    ])
]);
$modes['mode'][$from_id]  = null;
$rshq["sToken"]  = $text;
SETJSON($rshq); SETJSON12($modes);
} 
}

if($data == "SiteDomen"  ) {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ){
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
ارسل الان رابط الموقع مال الرشق 🧾
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]],
       
      ]
    ])
]);
    $modes['mode'][$from_id]  = "SiteDomen";
SETJSON($rshq); SETJSON12($modes);
} 
}

 
$rnd=rand(999,99999);
if($text and $modes['mode'][$from_id] == "SiteDomen") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ){
		$IMSALEH = parse_url($text);
$INSALEH = $IMSALEH['host'];
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
   
  تم تعيين موقع الرشق
 - - - - - - - - - - - - - - - - - - 
`$INSALEH`
 - - - - - - - - - - - - - - - - - - 
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]],
       
      ]
    ])
]);
$modes['mode'][$from_id]  = null;
$rshq["sSite"]  = $INSALEH;
SETJSON($rshq); SETJSON12($modes);
} 
}

if($data == "sCh"  ) {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ){
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
ارسل الان معرف القناة مع @ او بدون ⚜️
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]],
       
      ]
    ])
]);
    $modes['mode'][$from_id]  = "sCh";
SETJSON($rshq); SETJSON12($modes);
} 
}

$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/rshq.json"),true);
 
$rnd=rand(999,99999);
if($text and $modes['mode'][$from_id] == "sCh") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ){
		$text = str_replace("@",null,$text); 
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
   
  تم تعيين قناة الاثباتات
 - - - - - - - - - - - - - - - - - - 
[@$text]
 - - - - - - - - - - - - - - - - - - 
 - تأكد من ان البوت مشرف بالقناة {⚠️}
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]],
       
      ]
    ])
]);
$modes['mode'][$from_id]  = null;
$rshq["sCh"]  = "@".$text;
SETJSON($rshq); SETJSON12($modes);
} 
}
if($data == "hdiamk" ) {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ){
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
ارسل عدد ال$name3mla داخل الهديه 

*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]],
       
      ]
    ])
]);
    $modes['mode'][$from_id]  = "hdiMk0";
SETJSON($rshq); SETJSON12($modes);
die();
} 
}

if ($text and $modes['mode'][$from_id] == "hdiMk0") {
    if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo) {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "
   
- ارسل الأن عدد الاشخاص لأستخدام الكود
  ",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "$NamesBACK", 'callback_data' => "Brook"]],
                ]
            ])
        ]);
        $modes['mode'][$from_id] = "hdiMk";
        $rshq['_HD'][$from_id] = $text;
        $rshq["SALEH" . $rnd] = "on|$text";
        SETJSON($rshq);
        SETJSON12($modes);
        die();

    }
}

if ($text and $modes['mode'][$from_id] == "hdiMk") {
  if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo) {
      bot('sendMessage', [
          'chat_id' => $chat_id,
          'text' => "
 
- ارسل الأن أسم الكود مثلا ( SALEH )
",
          'parse_mode' => "markdown",
          'reply_markup' => json_encode([
              'inline_keyboard' => [
                  [['text' => "$NamesBACK", 'callback_data' => "Brook"]],
              ]
          ])
      ]);
      $modes['mode'][$from_id] = "hdiMk00";
      $rshq['hdiacount'][$from_id] = $text;
      SETJSON($rshq);
      SETJSON12($modes);
      die();
  }
}
# - الملف كتابة بيرو @V44VV

if ($text and $modes['mode'][$from_id] == "hdiMk00") {
    if ($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo) {
        if ($text) {
          $mts = $text;

            $text = $rshq['hdiacount'][$from_id];
            
            $text1 = $rshq['_HD'][$from_id];
            if ($mts and $text) {
                bot('sendMessage', [
                    'chat_id' => $chat_id,
                    'text' => "
💳 كود جديد نقاط مجاناً 🎁
🔡] الكود : `" . $mts . "`
💰] عدد ال" . $name3mla . " : $text1
👤] عدد الأشخاص : ".$rshq['hdiacount'][$from_id]."
🩸البوت [@" . bot('getme')->result->username . "]
  ",
                    'parse_mode' => "markdown",
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [['text' => "$NamesBACK", 'callback_data' => "Brook"]],
                        ]
                    ])
                ]);
                $modes['mode'][$from_id] = null;
                $rshq[$mts] = "on|$text1|$text";
                $rshq["A#D" . $mts] = "$text";
                SETJSON($rshq);
                SETJSON12($modes);
            }
        } else {
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => "
ارسل *الأرقام* فقط!!
   ",
                'parse_mode' => "markdown",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$NamesBACK", 'callback_data' => "Brook"]],
                    ]
                ])
            ]);
        }
    }
}

if($data == "onrshq") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo  ) {
// تم تصحيح اخطاء الملف بواسطه كيلوا@X_V_44 @ka7h_bot

    if($rshq["sSite"] != null and $rshq["sToken"] != null){
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
تم فتح استقبال الرشق
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]], 
]
])
]);
$rshq['Brook']  = "on";
SETJSON($rshq); SETJSON12($modes);
      } else {
        bot('EditMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
          *
         لازم تكمل معلومات الرشق بلاول 
         - التوكن او دومين موقع الرشق مامحطوط
          *
          ",
          'parse_mode'=>"markdown",
          'reply_markup'=>json_encode([ 
          'inline_keyboard'=>[
            [['text'=>"معلومات حول الرشق 📋",'callback_data'=>"infoRshq" ]],
            [['text'=>"تعين توكن لموقع 🎟️",'callback_data'=>"token" ],['text'=>"تعين موقع الرشق ⚙️",'callback_data'=>"SiteDomen" ]],
            [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]], 
          ]
          ])
          ]);
      }

}
}


if($data == "ontrend") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo  ) {
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
تم فتح ترند اضهار اكثر المشاركين لرابط الدعوء بنجاح ! 🎉
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]], 
]
])
]);

$rshq['trend'] = true;
SETJSON($rshq); SETJSON12($modes);
}
}

if($data == "oftrend") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo  ) {
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
تم قفل اضهار ترند اكثر مشاركين لرابط الدعوى
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]], 
]
])
]);

$rshq['trend'] = "x";
SETJSON($rshq); SETJSON12($modes);
}
}


if($data == "ofrshq") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo  ) {
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
تم قفل استقبال الرشق
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]], 
]
])
]);

$rshq['Brook']  = "of";
SETJSON($rshq); SETJSON12($modes);
}
}

if($data == "coins" ) {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ){
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
ارسل ايدي الشخص الان

*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]],
       
      ]
    ])
]);
    $modes['mode'][$from_id]  = "coins";
SETJSON($rshq); SETJSON12($modes);
} 
}
if($text and $modes['mode'][$from_id] == "coins") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ){
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
   
   ارسل عدد ال$name3mla لاضافته للشخص
   
اذا تريد تخصم كتب ويا - 
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]],
       
      ]
    ])
]);
$modes['mode'][$from_id]  = "coins2";
$rshq['id'][$from_id]  = "$text";
SETJSON($rshq); SETJSON12($modes);
} 
}

if($text and $modes['mode'][$from_id] == "coins2") {
	if($chat_id == $sudo or $chat_id == $sudo or $chat_id == $sudo ){
        if($text != $rshq['id'][$from_id] ){
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
   
  تم اضافه $text ل". $rshq['id'][$from_id]. "
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]],
        
      ]
    ])
]);
$modes['mode'][$from_id]  = null;
$rshq["coin"][$rshq['id'][$from_id]] += $text;
SETJSON($rshq); SETJSON12($modes);
        }
} 
}

$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/rshq.json"),true);


// # --- بداية كود قسم الإعلانات (للمطور) [تحديث v2] --- #

// دالة لعرض قائمة إعدادات الإعلانات (الشكل الجديد)
function showAdsSectionMenu($chat_id, $message_id, $rshq, $name3mla, $NamesBACK) {
    $status_text = ($rshq['ads']['status'] ?? 'off') == 'on' ? "مفعل ✅ (القسم ظاهر للمستخدمين)" : "معطل ❌ (القسم مخفي عن المستخدمين)";
    $cost = $rshq['ads']['cost'] ?? 0;
    $channel = $rshq['ads']['channel'] ?? 'لم يتم التعيين';
    $duration = $rshq['ads']['duration_hours'] ?? 24;
    $words_count = count($rshq['ads']['forbidden_words'] ?? []);

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "
        **📢 
        - إعدادات قسم الإعلانات 
        **

        **⚙️ الحالة الحالية:**
        - حالة القسم: **$status_text**
        - سعر الإعلان: **$cost $name3mla**
        - قناة النشر: **$channel**
        - مدة بقاء الإعلان: **$duration ساعة**
        - عدد الكلمات الممنوعة: **$words_count**

        **🕹️ أزرار التحكم:**
        ",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'تفعيل القسم ✅', 'callback_data' => 'set_ads_on'], ['text' => 'تعطيل القسم ❌', 'callback_data' => 'set_ads_off']],
                [['text' => '💰 تعيين سعر الإعلان', 'callback_data' => 'set_ads_cost']],
                [['text' => '📺 تعيين قناة النشر', 'callback_data' => 'set_ads_channel']],
                [['text' => '⏳ تعيين مدة الإعلان', 'callback_data' => 'set_ads_duration']],
                [['text' => '🚫 إدارة الكلمات الممنوعة', 'callback_data' => 'manage_forbidden_words']],
                [['text' => "$NamesBACK", 'callback_data' => 'Brook']],
            ]
        ])
    ]);
}

// عرض اللوحة الرئيسية للقسم (مع إلغاء أي وضع)
if ($data == "ads_section") {
    if ($chat_id == $sudo) {
        // لإلغاء أي وضع إدخال سابق (زي ما طلبت)
        if (isset($modes['mode'][$from_id])) {
            unset($modes['mode'][$from_id]);
            SETJSON12($modes);
        }
        showAdsSectionMenu($chat_id, $message_id, $rshq, $name3mla, $NamesBACK);
    }
}

// زر التفعيل
if ($data == "set_ads_on") {
    if ($chat_id == $sudo) {
        $rshq['ads']['status'] = 'on';
        SETJSON($rshq);
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => "✅ تم تفعيل قسم الإعلانات بنجاح"]);
        showAdsSectionMenu($chat_id, $message_id, $rshq, $name3mla, $NamesBACK);
    }
}

// زر التعطيل
if ($data == "set_ads_off") {
    if ($chat_id == $sudo) {
        $rshq['ads']['status'] = 'off';
        SETJSON($rshq);
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => "❌ تم تعطيل قسم الإعلانات بنجاح"]);
        showAdsSectionMenu($chat_id, $message_id, $rshq, $name3mla, $NamesBACK);
    }
}

// --- تعيين سعر الإعلان
if ($data == "set_ads_cost") {
    if ($chat_id == $sudo) {
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "💰 أرسل الآن سعر الإعلان (أرقام فقط).\n\n• السعر الحالي: " . ($rshq['ads']['cost'] ?? 0),
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'إلغاء ↪️', 'callback_data' => 'ads_section']]]])
        ]);
        $modes['mode'][$from_id] = 'set_ads_cost';
        SETJSON12($modes);
    }
}

if (is_numeric($text) && $modes['mode'][$from_id] == 'set_ads_cost') {
    if ($chat_id == $sudo) {
        $rshq['ads']['cost'] = $text;
        SETJSON($rshq);
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "✅ تم تعيين سعر الإعلان: **$text $name3mla**",
            'parse_mode' => 'markdown',
        ]);
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
        showAdsSectionMenu($chat_id, $message_id, $rshq, $name3mla, $NamesBACK);
    }
}

// --- تعيين قناة النشر
if ($data == "set_ads_channel") {
    if ($chat_id == $sudo) {
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "📺 أرسل الآن يوزر القناة (مثال: @MyChannel).\n\nتأكد أن البوت مشرف في القناة.",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'إلغاء ↪️', 'callback_data' => 'ads_section']]]])
        ]);
        $modes['mode'][$from_id] = 'set_ads_channel';
        SETJSON12($modes);
    }
}

if ($text && $modes['mode'][$from_id] == 'set_ads_channel') {
    if ($chat_id == $sudo) {
        if (strpos($text, '@') !== 0) {
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => "❌ خطأ. اليوزر يجب أن يبدأ بـ @. أرسل اليوزر الصحيح أو اضغط 'إلغاء'.",
                'parse_mode' => 'markdown',
                'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'إلغاء ↪️', 'callback_data' => 'ads_section']]]])
            ]);
        } else {
            // حفظ القناة
            $rshq['ads']['channel'] = $text;
            SETJSON($rshq);

            // إرسال رسالة تأكيد
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => "✅ تم تعيين قناة النشر: **$text**",
                'parse_mode' => 'markdown',
            ]);

            // إلغاء وضع الإدخال
            unset($modes['mode'][$from_id]);
            SETJSON12($modes);
            
            // تحديث القائمة الرئيسية للإعلانات لإظهار القناة الجديدة
            // ملاحظة: سيتم تحديث الرسالة التي ضغطت عليها في البداية
            showAdsSectionMenu($chat_id, $message_id, $rshq, $name3mla, $NamesBACK);
        }
    }
}

// --- تعيين مدة الإعلان
if ($data == "set_ads_duration") {
    if ($chat_id == $sudo) {
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "⏳ أرسل الآن مدة بقاء الإعلان بالساعات (أرقام فقط).\n\n• المدة الحالية: " . ($rshq['ads']['duration_hours'] ?? 24) . " ساعة",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'إلغاء ↪️', 'callback_data' => 'ads_section']]]])
        ]);
        $modes['mode'][$from_id] = 'set_ads_duration';
        SETJSON12($modes);
    }
}

if (is_numeric($text) && $modes['mode'][$from_id] == 'set_ads_duration') {
    if ($chat_id == $sudo) {
        $rshq['ads']['duration_hours'] = $text;
        SETJSON($rshq);
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "✅ تم تعيين مدة الإعلان: **$text ساعة**",
            'parse_mode' => 'markdown',
        ]);
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
        showAdsSectionMenu($chat_id, $message_id, $rshq, $name3mla, $NamesBACK);
    }
}

// --- إدارة الكلمات الممنوعة
if ($data == "manage_forbidden_words") {
    if ($chat_id == $sudo) {
        $words_list = $rshq['ads']['forbidden_words'] ?? [];
        $words_text = count($words_list) > 0 ? implode("\n- ", $words_list) : "لا يوجد كلمات ممنوعة حاليًا.";
        if(count($words_list) > 0) $words_text = "- " . $words_text;

        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "
            **🚫 إدارة الكلمات الممنوعة 🚫**

            **الكلمات الممنوعة الحالية:**
            $words_text
            ",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'إضافة كلمة +', 'callback_data' => 'add_forbidden_word']],
                    [['text' => 'حذف كل الكلمات 🗑️', 'callback_data' => 'clear_all_forbidden_words']],
                    [['text' => 'إلغاء ↪️', 'callback_data' => 'ads_section']],
                ]
            ])
        ]);
    }
}

if ($data == "add_forbidden_word") {
    if ($chat_id == $sudo) {
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "🚫 أرسل الآن الكلمة التي تريد منعها:",
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'إلغاء ↪️', 'callback_data' => 'manage_forbidden_words']]]])
        ]);
        $modes['mode'][$from_id] = 'add_forbidden_word';
        SETJSON12($modes);
    }
}

if ($text && $modes['mode'][$from_id] == 'add_forbidden_word') {
    if ($chat_id == $sudo) {
        $rshq['ads']['forbidden_words'][] = $text;
        SETJSON($rshq);
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "✅ تم إضافة الكلمة: **$text**",
            'parse_mode' => 'markdown',
        ]);
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
        
        // Refresh "manage_forbidden_words" menu
        $words_list = $rshq['ads']['forbidden_words'] ?? [];
        $words_text = count($words_list) > 0 ? implode("\n- ", $words_list) : "لا يوجد كلمات ممنوعة حاليًا.";
        if(count($words_list) > 0) $words_text = "- " . $words_text;
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "
            **🚫 إدارة الكلمات الممنوعة 🚫**

            **الكلمات الممنوعة الحالية:**
            $words_text
            ",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'إضافة كلمة +', 'callback_data' => 'add_forbidden_word']],
                    [['text' => 'حذف كل الكلمات 🗑️', 'callback_data' => 'clear_all_forbidden_words']],
                    [['text' => 'إلغاء ↪️', 'callback_data' => 'ads_section']],
                ]
            ])
        ]);
    }
}

if ($data == "clear_all_forbidden_words") {
    if ($chat_id == $sudo) {
        unset($rshq['ads']['forbidden_words']);
        SETJSON($rshq);
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => '✅ تم حذف جميع الكلمات الممنوعة.']);
        
        // Refresh "manage_forbidden_words" menu
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "
            **🚫 إدارة الكلمات الممنوعة 🚫**

            **الكلمات الممنوعة الحالية:**
            لا يوجد كلمات ممنوعة حاليًا.
            ",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'إضافة كلمة +', 'callback_data' => 'add_forbidden_word']],
                    [['text' => 'حذف كل الكلمات 🗑️', 'callback_data' => 'clear_all_forbidden_words']],
                    [['text' => 'إلغاء ↪️', 'callback_data' => 'ads_section']],
                ]
            ])
        ]);
    }
}

// # --- نهاية كود قسم الإعلانات (للمطور) [تحديث v2] --- #

// # --- بداية كود قسم الإعلانات (للمستخدم) [تحديث v4 - تنسيق التوقيع] --- #

if ($data == "post_ad_start") {
    // جلب الرصيد الحالي للمستخدم
    $coin = $rshq["coin"][$from_id] ?? 0;

    // 1. نتأكد إن الإعدادات كاملة
    $cost = $rshq['ads']['cost'] ?? 0;
    $channel = $rshq['ads']['channel'] ?? null;
    $duration = $rshq['ads']['duration_hours'] ?? 24;

    if ($cost <= 0 || $channel == null || $duration <= 0) {
        bot('answerCallbackQuery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "عذرًا، القسم قيد الصيانة حاليًا.",
            'show_alert' => true
        ]);
        die();
    }

    // 2. تعديل التدفق (زي ما طلبت): نعرض المعلومات أولاً
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "
        🌟 أرسل الآن إعلانك (سواء كان نص، صورة، فيديو...).

        - سيتم نشر إعلانك في القناة: **$channel**
        - سيبقى الإعلان لمدة: **$duration ساعة**
        - التكلفة: **$cost $name3mla**
        - نقاطك الحالية: **$coin $name3mla**

        سيتم فحص رصيدك والكلمات الممنوعة بعد إرسال الإعلان.
        ",
        'parse_mode' => 'markdown',
        'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'إلغاء ↪️', 'callback_data' => 'tobot']]]])
    ]);

    $modes['mode'][$from_id] = 'post_ad_submit';
    SETJSON12($modes);
}

// 3. كود استلام الإعلان ونشره
if ($message && $modes['mode'][$from_id] == 'post_ad_submit') {
    // جلب الرصيد *لحظة الإرسال* (لإصلاح المشكلة)
    $coin = $rshq["coin"][$from_id] ?? 0; 

    $ad_text = $message->text ?? $message->caption ?? '';
    $cost = $rshq['ads']['cost'] ?? 0;
    $channel = $rshq['ads']['channel'] ?? null;
    $duration = $rshq['ads']['duration_hours'] ?? 24;
    $forbidden_words = $rshq['ads']['forbidden_words'] ?? [];

    // 4. نتأكد من الفلوس (هنا الفحص بيتم)
    if ($coin < $cost) {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "
            ❌ عذرًا، نقاطك غير كافية.

            - سعر الإعلان: **$cost $name3mla**
            - نقاطك الحالية: **$coin $name3mla**

            أرسل إعلانك مرة أخرى بعد شحن حسابك.
            ",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'إلغاء ↪️', 'callback_data' => 'tobot']]]])
        ]);
        die();
    }

    // 5. نتأكد من الكلمات الممنوعة
    foreach ($forbidden_words as $word) {
        if (stripos($ad_text, $word) !== false) { // جعلناه غير حساس لحالة الأحرف
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => "❌ تم رفض إعلانك لوجود كلمات ممنوعة.\n\nالكلمة: ($word)\n\nأرسل إعلانك مرة أخرى بدون الكلمة الممنوعة.",
                'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'إلغاء ↪️', 'callback_data' => 'tobot']]]])
            ]);
            die();
        }
    }

    // 6. ننشر الإعلان
    $sent_ad = CopyMessage($channel, $chat_id, $message_id);

    if ($sent_ad->ok) {
        $new_message_id = $sent_ad->result->message_id;

        // # --- هنا التعديل الجديد (v4) --- #
        // 6.1. تجهيز التوقيع
        $name_user = $message->from->first_name;
        // (تنظيف الاسم من أي حروف ممكن تبوظ الماركداون)
        $name_user = str_replace(["[", "]", "(", ")", "`", "*", "_"], "", $name_user); 
        // شيلنا الخط وحطينا الاسم في سطر جديد
        $footer_text = "\n\nصاحب الاعلان:\n[$name_user](tg://user?id=$from_id)";
        // # --- نهاية التعديل الجديد (v4) --- #

        // 6.2. نعدل الرسالة في القناة
        if (isset($message->text)) {
            // لو الإعلان كان "نص" فقط
            $original_text = $message->text;
            $new_text = $original_text . $footer_text;

            bot('editMessageText', [
                'chat_id' => $channel,
                'message_id' => $new_message_id,
                'text' => $new_text,
                'parse_mode' => 'markdown',
                'disable_web_page_preview' => true
            ]);

        } else {
            // لو الإعلان كان "ميديا" (صورة، فيديو، الخ)
            $original_caption = $message->caption ?? "";
            $new_caption = $original_caption . $footer_text;

            bot('editMessageCaption', [
                'chat_id' => $channel,
                'message_id' => $new_message_id,
                'caption' => $new_caption,
                'parse_mode' => 'markdown'
            ]);
        }

        // 7. نخصم النقاط
        $rshq["coin"][$from_id] -= $cost;

        // 8. نسجل الإعلان عشان الحذف التلقائي
        $delete_at_timestamp = time() + ($duration * 3600);
        $rshq['ads']['scheduled_deletions'][] = [
            'channel' => $channel,
            'msg_id' => $new_message_id,
            'delete_at' => $delete_at_timestamp,
            'user' => $from_id
        ];

        $ad_link = "https://t.me/" . str_replace('@', '', $channel) . "/$new_message_id";

        // 9. نبعت رسالة النجاح
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "
            ✅ تم إرسال إعلانك بنجاح!

            - صاحب الإعلان: @$username
            - مدة الإعلان: $duration ساعة
            ",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'لرؤية إعلانك اضغط هنا 🚀', 'url' => $ad_link]],
                    [['text' => 'رجوع للقائمة', 'callback_data' => 'tobot']]
                ]
            ])
        ]);

        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
        SETJSON($rshq);

    } else {
        // لو البوت مش ادمن في القناة أو القناة غلط
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "❌ حدث خطأ أثناء نشر الإعلان. \n\nتأكد من أن البوت مشرف في قناة الإعلانات وأن اليوزر صحيح.\n\nلم يتم خصم نقاطك. حاول مرة أخرى أو تواصل مع الأدمن.",
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'رجوع ↪️', 'callback_data' => 'tobot']]]])
        ]);
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
    }
}

// # --- نهاية كود قسم الإعلانات (للمستخدم) [تحديث v4] --- #

// # --- [v3] بداية كود (تشغيل) لوحة تحكم المغادرة --- #

// عرض اللوحة الرئيسية للقسم
if ($data == "strict_leave_system") {
    if ($chat_id == $sudo) {
        // إلغاء أي وضع إدخال
        if (isset($modes['mode'][$from_id])) {
            unset($modes['mode'][$from_id]);
            SETJSON12($modes);
        }
        showStrictLeaveMenu($chat_id, $message_id, $rshq, $NamesBACK);
    }
}

// زر التفعيل
if ($data == "strict_leave_on") {
    if ($chat_id == $sudo) {
        $rshq['strict_leave']['status'] = 'on';
        SETJSON($rshq);
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => "✅ تم تفعيل نظام المغادرة الصارم"]);
        showStrictLeaveMenu($chat_id, $message_id, $rshq, $NamesBACK);
    }
}

// زر التعطيل
if ($data == "strict_leave_off") {
    if ($chat_id == $sudo) {
        $rshq['strict_leave']['status'] = 'off';
        SETJSON($rshq);
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => "❌ تم تعطيل نظام المغادرة الصارم"]);
        showStrictLeaveMenu($chat_id, $message_id, $rshq, $NamesBACK);
    }
}

// --- تعيين نقاط الخصم
if ($data == "set_leave_penalty") {
    if ($chat_id == $sudo) {
        global $name3mla; // عشان نجيب اسم العملة
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "💸 أرسل الآن عدد النقاط التي سيتم خصمها (أرقام فقط).\n\n• العدد الحالي: " . ($rshq['strict_leave']['penalty'] ?? 0) . " $name3mla",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => 'إلغاء ↪️', 'callback_data' => 'strict_leave_system']]]])
        ]);
        $modes['mode'][$from_id] = 'set_leave_penalty';
        SETJSON12($modes);
    }
}

if (is_numeric($text) && $modes['mode'][$from_id] == 'set_leave_penalty') {
    if ($chat_id == $sudo) {
        global $name3mla; // عشان نجيب اسم العملة
        $rshq['strict_leave']['penalty'] = $text;
        SETJSON($rshq);
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "✅ تم تعيين نقاط الخصم: **$text $name3mla**",
            'parse_mode' => 'markdown',
        ]);
        unset($modes['mode'][$from_id]);
        SETJSON12($modes);
        showStrictLeaveMenu($chat_id, $message_id, $rshq, $NamesBACK);
    }
}

// # --- [v3] نهاية كود (تشغيل) لوحة تحكم المغادرة --- #


$coin = $rshq["coin"][$from_id];
$bot_tlb = $rshq['bot_tlb'];
$mytl = $rshq["cointlb"][$from_id];
$share = $rshq["mshark"][$from_id] ;
$coinss = $rshq["coinss"][$from_id];
$tlby =$rshq["tlby"][$from_id];
if($rshq["coin"][$from_id] == null) {
	$coin = 0;
	}
	if($rshq["tlby"][$from_id] == null) {
	$tlby = 0;
	}
	if($rshq["coinss"][$from_id] == null) {
	$coinss = 0;
	}
	if($rshq["mshark"][$from_id] == null) {
	$share = 0;
	}
	if($rshq["cointlb"][$from_id] == null) {
	$mytl = 0;
	}
	if($rshq['bot_tlb'] == null) {
	$bot_tlb = 0;
	}

mkdir("FCZR/". bot("getme")->result->username) ;
$zr = json_decode(file_get_contents("FCZR/". bot("getme")->result->username. "/zr.json"),true);


if(explode(":",$data)[0] == "enter"){
    if($zr['infonam'][explode(":",$data)[1]]){
    
    if($zr['infosect'][explode(":",$data)[1]] == "edit"){
    	$fic = "editmessagetext";
    
    
    }
    
    if($zr['infosect'][explode(":",$data)[1]] == "send"){
    	$fic = "sendMessage";
    
    }
    
    if($zr['infosect'][explode(":",$data)[1]] == "hmsa"){
    	$fic = "answerCallbackQuery";
    
    }
   
    
    
    
    
    
    $k15[inline_keyboard][]=[[text=>"• رجوع •",callback_data=>"tobot"]];
    bot($fic,[ 
    'chat_id'=>$chat_id, 
    'message_id'=>$message_id,
    'text'=>$zr['infodesc'][explode(":",$data)[1]],
    'parse_mode'=>"MARKDOWN",
    'callback_query_id'=>$update->callback_query->id,
    'reply_markup'=>json_encode($k15),
    'show_alert'=>true,
	]);
} 
	}


	
  if($izr_sock['mode'] == "✅"){
	$key=[];
  $addedIds = [];
  //$key[inline_keyboard][]=[['text'=>"خدمات بوت الرشق 🔰",'callback_data'=>"service"]];
  $key[inline_keyboard][]=[['text'=>"الخدمات 🛍️ ",'callback_data'=>"joo"]];
  $key[inline_keyboard][]=[['text'=>"تجميع النقاط ❇️",'callback_data'=>"plus"], ['text'=>"اعدادات الحساب ⚙️",'callback_data'=>"account_settings"]];
  $key[inline_keyboard][]=[['text'=>"استخدام كود 🪪",'callback_data'=>"hdia"], ['text'=>"تحويل $name3mla ♻️",'callback_data'=>"transer"]];
  $key[inline_keyboard][]=[['text'=>"معلومات الطلب 🌐",'callback_data'=>"infotlb"],['text'=>" الطلبات 📮",'callback_data'=>"myrders"]];
  $key[inline_keyboard][]=[['text'=>"التحديثات  ⚙️",'url'=>"$chabot.t.me"],['text'=>"الاحصائيات 📊",'callback_data'=>"Namero"]];
  $key[inline_keyboard][]=[['text'=>"شراء $name3mla 💰",'callback_data'=>"buy"],['text'=>"الشروط 🗒",'callback_data'=>"termss"]];
  $key[inline_keyboard][]=[['text'=>"عدد الطلبات : $bot_tlb ✅",'callback_data'=>"jj"]];
   
  }else{
    $key=[];
    $key[inline_keyboard][]=[['text'=>"",'callback_data'=>"jj"]];
  }
    foreach ($zr['id'] as $i){
    $namem = $zr['infonam'][$i];
    $biozr = $zr['infodesc'][$i];
    if (!in_array($i, $addedIds)) {
      $addedIds[] = $i;
    if(preg_match("#http#",$biozr)) {
    	
    $key[inline_keyboard][]=[[text=>"$namem",url=>$biozr]];

   } elseif(preg_match("/SALEH:/",$biozr)) {
    $decv = base64_decode(explode('SALEH:',$biozr)[1]);
    $key[inline_keyboard][]=[[text=>"$namem",callback_data=>"$decv" ]];
   }else{
   $key[inline_keyboard][]=[[text=>"$namem",callback_data=>"enter:$i" ]];
  } 
  
}
} 

$RSALEHO = $key;

if(!$start_msg){
  $starts = "
🔹*اهلا بك عزيزي* {[$name](tg://user?id=$chat_id)}* 🎖في بوت خدمات $nambot *➢
⌯ يتوفر في البوت العديد من الخدمات الرائعة والمتنوعة بأسعار مناسبة✅
⌯┊💻يتوفر🫴🏼زياده متابعين انستا ~ تيليجرام ~ تيك توك ~ يوتيوت ~ توتير وغيرها📲
يتوفر 🎐رشق تصويتات تفاعلات تيليجرام ولايكات انستا ~ تيك توك وبرامج اخرى📑
🤏🏻يمكنك رشق مشاهدات تيليجرام مجانآ 💯
🔺*اكتشف باقي الخدمات بنفسك🎐من خلال الضغط على زر الخدمات*🛒
~ ".$name3mla."ك♻️ :$coin
~ ايديك `🆔 : `$from_id
 " ;
}else{
  $starts = $start_msg;
}
$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/rshq.json"),true);

// ======================================================
//  📬 5. قسم الطلبات التفاعلي الجديد (مع الصفحات)
// ======================================================

if ($data == "myrders") {
    // إذا ضغط "طلباتي" لأول مرة، اعرض الصفحة 1
    $data = "myrders_page|1";
}

if (explode("|", $data)[0] == "myrders_page") {
    $page = intval(explode("|", $data)[1]);
    if ($page < 1) $page = 1;

    $all_orders_raw = $tlbsme["orders"][$from_id] ?? [];
    
    // فلترة الطلبات لإزالة أي بيانات قديمة (نصية)
    $all_orders = [];
    foreach ($all_orders_raw as $order) {
        if (is_array($order) && isset($order['id'])) {
            $all_orders[] = $order;
        }
    }
    
    // عكس المصفوفة لعرض الأحدث أولاً
    $all_orders = array_reverse($all_orders);
    
    $per_page = 5; // عدد الطلبات في كل صفحة
    $total_orders = count($all_orders);
    $total_pages = ceil($total_orders / $per_page);
    
    // جلب الطلبات الخاصة بهذه الصفحة
    $orders_for_this_page = array_slice($all_orders, ($page - 1) * $per_page, $per_page);
    
    $keyboard = ['inline_keyboard' => []];
    
    if (empty($orders_for_this_page)) {
        $keyboard['inline_keyboard'][] = [['text' => 'ℹ️ لا توجد طلبات لعرضها حاليًا', 'callback_data' => 'null_data']];
    } else {
        foreach ($orders_for_this_page as $index_in_slice => $order) {
            // حساب الرقم الحقيقي للطلب في المصفوفة الأصلية
            $original_index = ($page - 1) * $per_page + $index_in_slice;
            
            $order_id = $order['id'] ?? 'N/A';
            $service_name = $order['name'] ?? 'خدمة غير معروفة';
            
            // عرض اسم الخدمة وايدي الطلب في الزر
            $keyboard['inline_keyboard'][] = [['text' => "($order_id) $service_name", 'callback_data' => "view_order_detail|$original_index|$page"]];
        }
    }
    
    // --- بناء أزرار الصفحات ---
    $pagination_buttons = [];
    if ($page > 1) {
        $pagination_buttons[] = ['text' => '◀️ السابق', 'callback_data' => "myrders_page|" . ($page - 1)];
    }
    if ($page < $total_pages) {
        $pagination_buttons[] = ['text' => 'التالي ▶️', 'callback_data' => "myrders_page|" . ($page + 1)];
    }
    
    if (!empty($pagination_buttons)) {
        $keyboard['inline_keyboard'][] = $pagination_buttons;
    }
    
    $keyboard['inline_keyboard'][] = [['text' => $NamesBACK, 'callback_data' => "tobot"]];
    
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "
        📬 *طلباتي* (صفحة $page / $total_pages)
        
        اضغط على أي طلب لعرض تفاصيله:
        ",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode($keyboard)
    ]);
    exit;
}

// --- عند الضغط على زر طلب معين ---
if (explode("|", $data)[0] == "view_order_detail") {
    $order_index = intval(explode("|", $data)[1]);
    $page_to_return = intval(explode("|", $data)[2]); // الصفحة للرجوع إليها
    
    $all_orders = $tlbsme["orders"][$from_id] ?? [];
    $all_orders = array_reverse($all_orders); // يجب أن تكون بنفس ترتيب العرض
    
    if (!isset($all_orders[$order_index])) {
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => '❌ خطأ: لم يتم العثور على الطلب.', 'show_alert' => true]);
        exit;
    }
    
    $order = $all_orders[$order_index];
    
    // جلب البيانات المحفوظة
    $order_id = $order['id'];
    $service_name = $order['name'];
    $cost = $order['cost'];
    $quantity = $order['quantity'];
    $link = $order['link'];
    $date = $order['date'];
    
    // جلب بيانات الـ API المحفوظة مع الطلب
    $sSite = $order['api_site'] ?? $rshq["sSite"]; // استخدم الموقع المحفوظ، أو الافتراضي
    $Api_Tok = $order['api_key'] ?? $rshq["sToken"]; // استخدم المفتاح المحفوظ، أو الافتراضي

    // جلب الحالة الحية من الـ API
    $req = json_decode(file_get_contents("https://" . $sSite . "/api/v2?key=$Api_Tok&action=status&order=" . $order_id));
    
    $start_count = $req->start_count ?? '---';
    $remains = $req->remains ?? '---';
    $api_status = $req->status ?? 'Unknown';

    // ترجمة الحالة
    $status_text = $api_status;
    if ($api_status == 'Pending' || $api_status == 'Processing') $status_text = 'قيد التنفيذ ⏳';
    if ($api_status == 'Completed') $status_text = 'مكتمل ✅';
    if ($api_status == 'Partial') $status_text = 'مكتمل جزئيا 🟡';
    if ($api_status == 'Canceled' || $api_status == 'Refunded') $status_text = 'ملغي ❌';

    $details_text = "
    *تفاصيل الطلب (ID: $order_id)*
    
    *الخدمة:* $service_name
    *الحالة:* $status_text
    
    *الرابط:* `$link`
    *التاريخ:* $date
    
    --- *التفاصيل* ---
    *الكمية المطلوبة:* $quantity
    *النقاط المدفوعة:* $cost $name3mla
    
    --- *حالة المخدم* ---
    *عدد البدء:* $start_count
    *المتبقي:* $remains
    ";
    
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => $details_text,
        'parse_mode' => "markdown",
        'disable_web_page_preview' => true,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                // زر الرجوع يعيدك إلى نفس الصفحة التي كنت فيها
                [['text' => $NamesBACK, 'callback_data' => "myrders_page|$page_to_return"]]
            ]
        ])
    ]);
    exit;
}

  
  $JAWA = $rshq['JAWA'];
if($data == "Namero") {
    $priv = count(file("Users/member.txt"));
    $s_all = count(file("Users/allchat.txt"));
    $d = date('Y-m-d');
    $online_fiday = count(file("onliner/".USR_BOT."/".$d.".txt"));

    $template = $rshq['klisha_stats'] ?? "
📊] الأحصائيات

👥] مستخدمين البوت : #users | #active_now 👤
🗣️] مستخدمين نشطين الان : #active_now 🟢
⭐️] مستخدمين نشطين اليوم : #active_today ⚡

🟢] طلبات انجزناها : #orders ✅
----------------------------
🌀] الاعلى في الدعوات : 
#top_invites
----------------------------
📣] قنوات قيد التمويل : #funding_channels ⏳
";
    
    $ok = ''; // Ensure $ok is defined
    if(isset($rshq['trend']) && $rshq['trend'] != "x"){
        // Your existing logic to build the $ok variable
    }

    $text_to_send = str_replace(
        ['#users', '#active_now', '#active_today', '#orders', '#top_invites', '#funding_channels'],
        [$priv, $s_all, $online_fiday, $bot_tlb, $ok, (count($tmoil['db']["chs"] ?? []))],
        $template
    );
    
    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=> $text_to_send,
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
            ]
        ])
    ]);
    unset($modes['mode'][$from_id]);
    SETJSON12($modes);
    die();
}

if($data == "termss"){
  if($rshq['KLISHA'] == null){
bot('editmessagetext',[
  'chat_id'=>$chat_id,
  'message_id' => $message_id,
  'text'=>"
شروط استخدام بوت $nambot 

- بوت $nambot اول بوت عربي في التلجرام مخصص لجميع خدمات برامج التواصل الاجتماعي انستقرام - تيك توك - يوتيوب - تيوتر - فيسبوك وللخ... هناك العديد من الشروط حول استخدام بوت $nambot.

- الامان والثقه الموضوع الاول لدينا وحماية خصوصية جميع المستخدمين من الاولويات لدينا لذالك جميع المعلومات من ال$name3mla والطلبات هي محصنة تماماً لا يسمح لـ اي شخص الاطلاع عليها الا في حالة طلب المستخدم ذالك من الدعم الفني

- على جميع المستخدمين التركيز في حالة طلب اي شيء من البوت في حالة كان حسابك او قناتك او ماشبه ذالك خاص سيلغي طلبك نهائياً لذالك لايوجد استرداد او اي تعويض لذالك وجب التنبيه

- جميع الخدمات تتحدث يومياً لا يوجد لدينا خدمات ثابته يتم اضافة يومياً العديد من الخدمات التي تكون مناسبة لجميع المستخدمين في البوت لنكون الاول والافضل دائماً

- لا يوجد اي استرداد او الغاء في حالة تم الرشق او الدعم لحساب او لقناة او لمنشور في الغلط 

- جميع الخدمات المتوفره هي موثوقه تماماً ويتم التجربه عليها قبل اضافاتها للبوت لذالك يتوفر انواع الخدمات بأسعار مختلفة من خدمة لخدمة اخرى
 ", 

 'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
       
      ]
    ])
]); 
     }else{
       $k=$rshq['KLISHA'];
       bot('editmessagetext',[
        'chat_id'=>$chat_id,
        'message_id' => $message_id,
        'text'=>"
     $k
       ", 
      
       'reply_markup'=>json_encode([
           'inline_keyboard'=>[
           
           [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
             
             
            ]
          ])
      ]); 
     }
}

if($data == "JAWA"){
	if($rshq['JAWA'] == null) {
  bot('editmessagetext',[
    'chat_id'=>$chat_id,
    'message_id' => $message_id,
    'text'=>"
لم يتم تعيين كليشه
   ", 
  
   'reply_markup'=>json_encode([
       'inline_keyboard'=>[
       
       [['text'=>"$NamesBACK",'callback_data'=>"linkme" ]],
         
         
        ]
      ])
  ]); 
 } else {
 	bot('editmessagetext',[
    'chat_id'=>$chat_id,
    'message_id' => $message_id,
    'text'=>$rshq['JAWA'], 
  
   'reply_markup'=>json_encode([
       'inline_keyboard'=>[
       
       [['text'=>"$NamesBACK",'callback_data'=>"linkme" ]],
         
         
        ]
      ])
  ]); 
} 
  }

$hHSALEH = $a3thu['HACKER'][$from_id];
$SALEH = json_decode(file_get_contents("RSHQ/ALLS/".USR_BOT."/SALEH.json"),1);
if($text == "/start" and $hHSALEH == "I") {
if (isset($modes['mode'][$from_id])) {
    unset($modes['mode'][$from_id]);
    SETJSON12($modes);
}

  $e[1] = $a3thu['HACK'][$from_id];
  $e1=$e[1];
  $e1 = str_replace(" ", null, $e1) ;
	if(true){
		if($e1 != $from_id) {
			if(!in_array($from_id , $a3thu["3thu"])){
				$c = $rshq["coinshare"]??"25";
				if (!in_array($e1 ,$SALEH['SALEH']['send']['uname'])){
$SALEH['SALEH']['send']['uname'][] = $e1 ;
$SALEH['SALEH']['send']['add'][] = 0;
file_put_contents("RSHQ/ALLS/".USR_BOT."/SALEH.json",json_encode($SALEH));

}
				if (in_array($e1,$SALEH['SALEH']['send']['uname'])){
$yes = array_search($e1,$SALEH['SALEH']['send']['uname']);
$SALEH['SALEH']['send']['add'][$yes]+=1;
file_put_contents("RSHQ/ALLS/".USR_BOT."/SALEH.json",json_encode($SALEH));
}
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
♦️لقد دخلت لرابط صديقك وحصل على $c $name3mla ✅

  ", 
  'parse_mode'=>"markdown",
]);
$cf = $rshq["coin"][str_replace(" ", null, $e1)] + $c;
bot('sendMessage',[
   'chat_id'=>str_replace(" ", null, $e1),
   'text'=>"
لقد حصلت على $c $name3mla من [". $update->message->from->first_name."](tg://user?id=$chat_id)

  ", 
  'parse_mode'=>"markdown",
]);
bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);

  $a3thu['HACKER'][$from_id] = null;
  $a3thu['HACK'][$from_id] = null;
$a3thu["3thu"][] = $from_id ;
$rshq["coin"][str_replace(" ", null, $e1)] += ($rshq["coinshare"]?? "25");
$rshq["mshark"][str_replace(" ", null, $e1)] += 1;
SETJSON($rshq); SETJSON12($modes);
file_put_contents("$a3thuFILE",json_encode($a3thu));
} else {
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);
$a3thu['HACKER'][$from_id] = null;
$a3thu['HACK'][$from_id] = null;
file_put_contents("$a3thuFILE",json_encode($a3thu));
} 
} else {
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
لايمكنك الدخول لرابط الدعوه الخاص بك ⚠️
  ", 

]);
bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);
$a3thu['HACKER'][$from_id] = null;
$a3thu['HACK'][$from_id] = null;
file_put_contents("$a3thuFILE",json_encode($a3thu)); 
} 
} else {
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);
$a3thu['HACKER'][$from_id] = null;
$a3thu['HACK'][$from_id] = null;
SETJSON3($a3thu);
} 
} 

$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/rshq.json"),true);

if($text == "MMTEST"){
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"
 $b
   ", 
   'parse_mode'=>"markdown",
 ]);
}
$SALEH = json_decode(file_get_contents("RSHQ/ALLS/".USR_BOT."/SALEH.json"),1);
$e=explode("|", $data) ;
$e1=str_replace("/start",null,$text); 
if($text == "/start$e1" and is_numeric($e1) and !preg_match($text,"#SALEH#")) {
	if(true){
		$e1 = str_replace(" ", null, $e1) ;
		if($e1 != $from_id) {
			if(!in_array($from_id , $a3thu["3thu"])){
	$c = $rshq["coinshare"]??"25";
	
	if (!in_array($e1 ,$SALEH['SALEH']['send']['uname'])){
$SALEH['SALEH']['send']['uname'][] = $e1 ;
$SALEH['SALEH']['send']['add'][] = 0;
file_put_contents("RSHQ/ALLS/".USR_BOT."/SALEH.json",json_encode($SALEH));

}
				if (in_array($e1,$SALEH['SALEH']['send']['uname'])){
$yes = array_search($e1,$SALEH['SALEH']['send']['uname']);
$SALEH['SALEH']['send']['add'][$yes]+=1;
file_put_contents("RSHQ/ALLS/".USR_BOT."/SALEH.json",json_encode($SALEH));
}
	
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
♦️لقد دخلت لرابط صديقك وحصل علي $c $name3mla ✅

  ", 
  'parse_mode'=>"markdown",
]);
$cf = $rshq["coin"][str_replace(" ", null, $e1)] + $c;
bot('sendMessage',[
   'chat_id'=>str_replace(" ", null, $e1),
   'text'=>"
لقد🔹 حصلت على ( $c ) $name3mla من ( [". $update->message->from->first_name."](tg://user?id=$chat_id) ) قام بالدخول ع رابط الدعوة الخاص بك 🏆

  ", 
  'parse_mode'=>"markdown",
]);
bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);

$a3thu["3thu"][] = $from_id ;
file_put_contents("$a3thuFILE",json_encode($a3thu));
$rshq["coin"][str_replace(" ", null, $e1)] += ($rshq["coinshare"]?? "25");
$rshq["mshark"][str_replace(" ", null, $e1)] += 1;
SETJSON($rshq); SETJSON12($modes); 
} else {
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);
} 
} else {
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
لايمكنك الدخول لرابط الدعوه الخاص بك ⚠️
  ", 

]);
bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);
} 
} else {
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);
} 
} 


 
 if($text == "/start"){
  if($hHSALEH != "I"){
  if($start_sock['mode'] == "✅"){
bot("sendmessage",[
  'chat_id' => $chat_id,
  'text' => $start_msg,
  'parse_mode' => 'MaRKDOWN',
  'reply_to_message_id' => $message_id,
  "reply_markup" => json_encode($key),
]);
  }else{
      bot("sendmessage",[
          'chat_id' => $chat_id,
          'text' => $start_msgmm,
          'parse_mode' => 'MaRKDOWN',
          "reply_markup" => json_encode($key),
      ]);
  }
}
 }
 
 if($data == "buy") {
   if( $rshq['buy'] == null){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
• لشراء رصيد من بوت خدمات $nambot 💡 
      
•︰1$  : 3000 في البوت 
•︰5$  : 15000 في البوت
•︰10$ : 30000 في البوت 
•︰15$ : 45000 في البوت
•︰25$ : 75000 في البوت 
• 50$ : 150000 في البوت 

• للتواصل مع الوكيل :@DMM2M

",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[

     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
      ]
    ])
]);
} else {
  $k =  $rshq['buy'];
  bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
   $k
    
    ",
    'parse_mode'=>"markdown",
    'reply_markup'=>json_encode([
         'inline_keyboard'=>[
    
         [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
           
          ]
        ])
    ]);
         }
         }



if($data == "tobot") {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
$starts
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($RSALEHO)
]);
$modes['mode'][$from_id] = null ;
SETJSON($rshq) ;
return false ;
} 

$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/rshq.json"),true);
if($data == "hdia") {
    $klisha = $rshq['klisha_use_code'] ?? "~ ارسل كود النقاط 🎁";
    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=> $klisha,
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>"الغاء ❎",'callback_data'=>"tobot" ]],
            ]
        ])
    ]);
    $modes['mode'][$from_id]  = "hdia";
    SETJSON($rshq); SETJSON12($modes);
}


// ...
if ($data == "transer") {
    $buttons = []; // مصفوفة فارغة للأزرار

    // 1. التحقق من حالة التحويل بالرابط
    if (($rshq['link_transfer_status'] ?? 'on') == 'on') {
        $buttons[] = [['text' => "تحويل عن طريق الرابط 🔗", 'callback_data' => "linkerm"]];
    }

    // 2. التحقق من حالة التحويل بالآيدي
    if (($rshq['id_transfer_status'] ?? 'on') == 'on') {
        $buttons[] = [['text' => "تحويل عن طريق الأيدي 🆔", 'callback_data' => "thoils"]];
    }
    
    // 3. زر الرجوع
    $buttons[] = [['text' => $NamesBACK, 'callback_data' => "tobot"]];

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "♻️ *قسم تحويل $name3mla*
        
اختر طريقة التحويل التي تفضلها:",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
}


if($data == "thoils") {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
 » ارسل ايدي الشخص لبدا عملية التحويل 🔐
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
      ]
    ])
]);
    $modes['mode'][$from_id]  = $data;
   
    
SETJSON($rshq); SETJSON12($modes);
}


if (is_numeric($text) and $modes['mode'][$from_id] == "thoils") {
    // جلب العمولة الحقيقية
    $commission = $rshq['id_transfer_commission'] ?? "0";

    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "
 » ارسل الكمية التي تريد تحوليها إلى `$text` 🗳
 » يجب ان يكون عدد التحويل 10 فأكثر 📤
 
 - *ملاحظة: سيتم تطبيق عمولة بنسبة $commission% ♻️*
",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "إلغاء ❌", 'callback_data' => "tobot"]], // زر إلغاء
            ]
        ])
    ]);
    $modes['mode'][$from_id] = "FGTO|$text";
    SETJSON12($modes);
    exit;
}


// ...
if (is_numeric($text) && explode("|", $modes['mode'][$from_id])[0] == "FGTO") {
    
    $receiver_id = explode("|", $modes['mode'][$from_id])[1]; 

    $min = $rshq['id_transfer_min'] ?? 10;
    $max = $rshq['id_transfer_max'] ?? 10000;
    $commission_percent = $rshq['id_transfer_commission'] ?? 0;

    if ($text < $min) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ الحد الأدنى للتحويل هو $min $name3mla."]);
        exit;
    }
    if ($text > $max) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ الحد الأقصى للتحويل هو $max $name3mla."]);
        exit;
    }

    // *** بداية الإصلاح ***
    $commission_amount = ceil(($text * $commission_percent) / 100);
    $total_deduct = $text + $commission_amount;
    // *** نهاية الإصلاح ***
            // --- (جديد) تسجيل التحويل والسجل ---
            $rshq['transfers_made'][$from_id] = (intval($rshq['transfers_made'][$from_id] ?? 0)) + 1;

            $log_entry = [
                'type' => 'sent', 'partner_id' => $receiver_id, 'amount' => $text, 
                'commission' => $commission_amount, 'total' => $total_deduct, 
                'balance_after' => $rshq['coin'][$from_id], 'date' => time()
            ];
            $transferLog[$from_id][] = $log_entry;

            $log_entry_receiver = [
                'type' => 'received', 'partner_id' => $from_id, 'amount' => $text, 
                'commission' => 0, 'total' => $text, 
                'balance_after' => $rshq['coin'][$receiver_id], 'date' => time()
            ];
            $transferLog[$receiver_id][] = $log_entry_receiver;
            // --- نهاية التسجيل ---
    
    if ($rshq["coin"][$from_id] >= $total_deduct) { // **تم التعديل**
        
        $sender_old_balance = $rshq["coin"][$from_id];
        $receiver_old_balance = $rshq["coin"][$receiver_id] ?? 0;
        
        $rshq['coin'][$from_id] -= $total_deduct; // **تم التعديل** (خصم الإجمالي)
        $rshq['coin'][$receiver_id] += $text; // (إضافة الصافي)
        
        $sender_new_balance = $rshq['coin'][$from_id];
        $receiver_new_balance = $rshq['coin'][$receiver_id];

        bot('sendMessage', [
            'chat_id' => $chat_id, 
            'text' => "✅ *تم التحويل بنجاح*
            
• *إلى:* `$receiver_id`
• *المبلغ المُرسل:* $text $name3mla
• *العمولة ($commission_percent%):* $commission_amount $name3mla
• *الإجمالي المخصوم: $total_deduct* $name3mla
            
• *رصيدك القديم:* $sender_old_balance
• *رصيدك الحالي:* $sender_new_balance",
            'parse_mode' => "markdown",
        ]);

        bot('sendMessage', [
            'chat_id' => $receiver_id, 
            'text' => "📥 *تم استلام $name3mla*
            
• *من:* [$name](tg://user?id=$from_id) (ID: `$from_id`)
• *المبلغ المُستلم:* $text $name3mla
            
• *رصيدك القديم:* $receiver_old_balance
• *رصيدك الحالي:* $receiver_new_balance",
            'parse_mode' => "markdown",
        ]);

        unset($modes['mode'][$from_id]);
        SETJSON($rshq);
        SETJSON12($modes);
                    file_put_contents($transferLogFile, json_encode($transferLog, JSON_PRETTY_PRINT)); // حفظ السجل
                    

    } else {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "❌ *رصيدك غير كافي*
            
لتحويل *$text* $name3mla، تحتاج إلى *$total_deduct* $name3mla (شاملة العمولة).
رصيدك الحالي: " . ($rshq["coin"][$from_id] ?? 0) . " $name3mla.",
            'parse_mode' => "markdown",
        ]);
    }
    exit;
}
// ...



if ($data == "linkerm") {
    // جلب العمولة الحقيقية من الإعدادات
    $commission = $rshq['link_transfer_commission'] ?? "0";

    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "
 - *ملاحظة: سيتم تطبيق عمولة بنسبة $commission% ♻️*

 - ارسل كمية ال$name3mla المراد تحويلها 🔃
",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "إلغاء ❌", 'callback_data' => "tobot"]], // زر إلغاء
            ]
        ])
    ]);
    $modes['mode'][$from_id] = $data;
    SETJSON12($modes);
}

		
		$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/rshq.json"),true);
	
if($text and $modes['mode'][$from_id] == "hdia") {
	if(explode("|", $rshq[$text])[0] == "on") {
		if($rshq['mehdia'][$from_id][$text] !="on" ) {
      if(explode("|", $rshq[$text])[2] >= $rshq["TASY_$text"]){
		bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
تم اضافة ".explode("|", $rshq[$text])[1]." ".$name3mla." الى حسابك ✅
  ", 
  'parse_mode'=>"markdown",
]);
$coij = $modes['mode'][$from_id] + explode("|", $rshq[$text])[1];
bot('sendMessage',[
   'chat_id'=>$admin,
   'text'=>"
 ~ هذا اخذ كود الهديه بقيمه".explode("|", $rshq[$text])[1]."
 
 ~ [$name](tg://user?id=$chat_id) 
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
       
      ]
    ])
]);

$rshq["TASY_$text"] +=1;
$modes['mode'][$from_id] = null;
$rshq['mehdia'][$from_id][$text] = "on" ;
$rshq["coin"][$from_id] += explode("|", $rshq[$text])[1];
// --- (جديد) تسجيل إحصائيات الأكواد ---
$rshq['codes_used'][$from_id] = (intval($rshq['codes_used'][$from_id] ?? 0)) + 1;
// --- نهاية التسجيل ---
SETJSON($rshq); SETJSON12($modes);

bot('sendMessage',[
  'chat_id'=>$chat_id,
  'text'=>"
$starts 
 ", 
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode($RSALEHO)
]);
     } else {
      bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"
الكود خطأ او تم استخدامه ❌
       ", 
       'parse_mode'=>"markdown",
       'reply_markup'=>json_encode([
          'inline_keyboard'=>[
          
          [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
            
            
           ]
         ])
     ]);
     $modes['mode'][$from_id] = null;
SETJSON($rshq); SETJSON12($modes);
     }
} else {
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
الكود خطأ او تم استخدامه ❌
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
       
      ]
    ])
]);
	} 
	} else {
		bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
الكود خطأ او تم استخدامه ❌
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
       
      ]
    ])
]);
$modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
		} 
	}
	
	if(explode("|", $data)[0]== "getNqat"){
	$hSs = explode("|", $data)[1];
	if($rshq['thoiler'][$hSs]["to"] != null) {
		$cvc = $rshq['thoiler'][$hSs]["coin"];
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
 -  تم استرداد $cvc $name3mla الى حسابك ✅

 - الرابط المعطل : https://t.me/[". bot('getme')->result->username. "]?start=SALEH$hSs 💹
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
      ]
    ])
]);
$rshq["coin"][$from_id] += $cvc;
$rshq['thoiler'][$hSs]["to"] = null;
SETJSON($rshq); SETJSON12($modes);
} else {
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
الكود منتهي الصلاحية ⏳❌
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
      ]
    ])
]);
	} 
	} 



  $tnb=explode('|',$data);
  if($tnb[0] == "dseign"){
    $MakLink=$tnb[1];
    $cok = $rshq['thoiler'][$MakLink]["coin"];
    bot('EditMessageText',[
      'chat_id'=>$chat_id,
      'message_id'=>$message_id,
      'text'=>"
♻️ عدد النقاط ~ $cok ~
🔱 ايدي الشخص الذي حول النقاط ~ `$from_id` ~
♌ يوزر البوت ~ [@". USR_BOT."] ~
🚸 اضغط هنا ليتم تحويل النقاط اليك 👇👇
      ",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode([
           'inline_keyboard'=>[
           [['text'=>"اضغط هنا",'url'=>"https://t.me/". bot('getme')->result->username. "?start=SALEH$MakLink"]],
             
            ]
          ])
      ]);
  }

if (is_numeric($text) && $modes['mode'][$from_id] == "linkerm") {
    
    $min = $rshq['link_transfer_min'] ?? 10;
    $max = $rshq['link_transfer_max'] ?? 10000;
    $commission_percent = $rshq['link_transfer_commission'] ?? 0; 

    if ($text < $min) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ الحد الأدنى للتحويل هو $min $name3mla.", 'reply_markup' => json_encode([ 'inline_keyboard' => [[['text' => "$NamesBACK", 'callback_data' => "tobot"]]] ])]);
        exit;
    }
    if ($text > $max) {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ الحد الأقصى للتحويل هو $max $name3mla.", 'reply_markup' => json_encode([ 'inline_keyboard' => [[['text' => "$NamesBACK", 'callback_data' => "tobot"]]] ])]);
        exit;
    }

    // *** بداية الإصلاح ***
    $commission_amount = ceil(($text * $commission_percent) / 100); 
    $total_deduct = $text + $commission_amount; // الإجمالي المطلوب خصمه
    // *** نهاية الإصلاح ***
            // --- (جديد) تسجيل التحويل ---
            $rshq['transfers_made'][$from_id] = (intval($rshq['transfers_made'][$from_id] ?? 0)) + 1;
            // --- نهاية التسجيل ---

    if ($rshq["coin"][$from_id] >= $total_deduct) { // **تم التعديل**
        
        $rshq["coin"][$from_id] -= $total_deduct; // **تم التعديل** (الخصم الفوري)
        
        $MakLink = md5(rand(10000, 89999999) . $from_id); 
        
        $rshq['thoiler'][$MakLink]["coin"] = $text; // المبلغ الصافي للمستلم
        $rshq['thoiler'][$MakLink]["to"] = $from_id; 

        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "✅ *تم إنشاء رابط التحويل بنجاح*
            
• تم خصم: *$text* $name3mla
• عمولة التحويل ($commission_percent%): *$commission_amount* $name3mla
• *الإجمالي المخصوم: $total_deduct* $name3mla

• *رابط التحويل:*
`https://t.me/" . bot('getme')->result->username . "?start=SALEH$MakLink`

• أرسل الرابط للشخص المراد تحويل النقاط له.",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "تعطيل الرابط واسترداد النقاط", 'callback_data' => "getNqat|$MakLink"]],
                    [['text' => "$NamesBACK", 'callback_data' => "tobot"]],
                ]
            ])
        ]);

        unset($modes['mode'][$from_id]);
        SETJSON($rshq);
        SETJSON12($modes);

    } else {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "❌ *رصيدك غير كافي*
            
لتحويل *$text* $name3mla، تحتاج إلى *$total_deduct* $name3mla (شاملة العمولة).
رصيدك الحالي: " . $rshq["coin"][$from_id] . " $name3mla.",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode([ 'inline_keyboard' => [[['text' => "$NamesBACK", 'callback_data' => "tobot"]]] ])
        ]);
    }
    exit; 
}




if($data == "plus") {

    // بناء الأزرار الديناميكية (الكود يبقى كما هو)
    $plus_keyboard = [  
        [['text'=>"🌍 الانضمام إلى القنوات",'callback_data'=>"joins|1"]],
    ];  
    $plus_keyboard[] = [
        ['text'=>"🪪 كود هدية",'callback_data'=>"hdia"],
        ['text'=>"📣 رابط الدعوة",'callback_data'=>"linkme"]
    ];
    if (($rshq['apple_game_status'] ?? 'on') == 'on' && ($rshq['wheel_game']['status'] ?? 'on') == 'on') {
        $plus_keyboard[] = [
            ['text'=>'🍎 لعبة التفاحة','callback_data'=>'apple_game_main'],
            ['text'=>'🎡 عجلة الحظ','callback_data'=>'play_wheel_game']
        ];
    } elseif (($rshq['apple_game_status'] ?? 'on') == 'on') {
        $plus_keyboard[] = [['text'=>'🍎 لعبة التفاحة','callback_data'=>'apple_game_main']];
    } elseif (($rshq['wheel_game']['status'] ?? 'on') == 'on') {
        $plus_keyboard[] = [['text'=>'🎡 عجلة الحظ','callback_data'=>'play_wheel_game']];
    }
    $gift_buttons = [];
    if($HDIAS) {  
        $gift_buttons[] = ['text'=>"🎁 الهدية اليومية",'callback_data'=>"hdiaa"];  
    }  
    if (($rshq['weekly_gift_status'] ?? 'on') == 'on') {
        $gift_buttons[] = ['text'=>'🗓️ الهدية الأسبوعية', 'callback_data'=>'weekly_gift_claim'];
    }
    if (!empty($gift_buttons)) {
        $plus_keyboard[] = $gift_buttons;
    }
    $plus_keyboard[] = [['text'=>"↩️ رجوع",'callback_data'=>"tobot" ]];  

    // --- [هنا التعديل] ---
    // جلب الكليشة المخصصة أو استخدام النص الافتراضي
    $default_plus_text = "
» في قسم ربح النقاط مجاناً  
» يمكنك تجميع النقاط من خلال:

• دعوة الأصدقاء 👥  
• الاشتراك في القنوات 🌀  
• الهدية اليومية 🎁  
• الهدية الأسبوعية 🗓️
• استخدام كود هدية 🔖  
• لعبة التفاحة 🍎  
• عجلة الحظ 🎡
    ";
    $plus_menu_text = $rshq['klisha_plus_menu'] ?? $default_plus_text;
    // --- [نهاية التعديل] ---

    bot('EditMessageText',[  
        'chat_id'=>$chat_id,  
        'message_id'=>$message_id,  
        'text'=> $plus_menu_text,  // <-- استخدام المتغير الجديد
        'parse_mode'=>"markdown",  
        'reply_markup'=>json_encode(['inline_keyboard'=> $plus_keyboard ])  
    ]);

}

// --- دالة مساعدة لتنسيق الوقت (مهمة للعبة والهدية اليومية) ---
if (!function_exists('format_seconds_to_hms')) {
    function format_seconds_to_hms($seconds) {
        $h = floor($seconds / 3600);
        $m = floor(($seconds % 3600) / 60);
        $s = $seconds % 60;
        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }
}

// ===========================================
//  لعبة عجلة الحظ (للمستخدم)
// ===========================================
if($data == "play_wheel_game") {

    // 1. التحقق إذا كانت اللعبة معطلة
    if (($rshq['wheel_game']['status'] ?? 'on') == 'off') {
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => '❌ لعبة عجلة الحظ معطلة حاليًا.', 'show_alert' => true]);
        exit;
    }

    // 2. جلب الإعدادات من الأدمن
    $cooldown_hours = intval($rshq['wheel_game']['cooldown_hours'] ?? 24);
    $cooldown_seconds = $cooldown_hours * 3600;

    // 3. التحقق من وقت الانتظار
    $last_played = intval($rshq['wheel_game_last_played'][$from_id] ?? 0);
    $time_now = time();
    $next_play_time = $last_played + $cooldown_seconds;

    if ($time_now < $next_play_time) {
        // المستخدم يجب أن ينتظر
        $remaining_seconds = $next_play_time - $time_now;
        $remaining_time_formatted = format_seconds_to_hms($remaining_seconds);

        bot('answerCallbackQuery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "⏳ يجب أن تنتظر: $remaining_time_formatted",
            'show_alert' => true
        ]);
        exit;

    } else {
        // 4. يمكنه اللعب - إظهار رسالة "جاري التدوير"
        bot('EditMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"
🎡 *عجلة الحظ* 🎡

جاري تدوير العجلة 🎯...
انتظر لحظة لمعرفة حظك!
            ",
            'parse_mode'=>"markdown"
        ]);

        // 5. محاكاة وقت التدوير
        sleep(3); // انتظر 3 ثواني

        // 6. حساب الربح
        $min_win = intval($rshq['wheel_game']['min'] ?? 10);
        $max_win = intval($rshq['wheel_game']['max'] ?? 100);

        // تأكد أن الحد الأقصى أكبر من الأدنى
        if ($max_win < $min_win) $max_win = $min_win; 

        $win_amount = rand($min_win, $max_win);

        // 7. إضافة النقاط وتحديث وقت اللعب
        $current_coin = $rshq["coin"][$from_id] ?? 0;
        $rshq["coin"][$from_id] = $current_coin + $win_amount;
        $rshq['wheel_game_last_played'][$from_id] = $time_now;
        SETJSON($rshq);

        // 8. إظهار النتيجة
        bot('EditMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"
🎡 *العجلة توقفت!* 🎡

✨ تهانينا! لقد فزت بـ *$win_amount* $name3mla ✨

• نقاطك الحالية: " . $rshq["coin"][$from_id] . " 💰
• يمكنك اللعب مرة أخرى بعد: *$cooldown_hours ساعة* ⏳
            ",
            'parse_mode'=>"markdown",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=> $NamesBACK, 'callback_data'=> 'plus']]
                ]
            ])
        ]);
        exit;
    }
}


if($rshq['trend'] != "x"){
$SALEH = json_decode(file_get_contents("RSHQ/ALLS/".USR_BOT."/SALEH.json"),1);
$f= $SALEH['SALEH']['send']['add'];
rsort($f);
var_dump($f);
for($i=0;$i<5;$i++){
$dets = json_decode(file_get_contents("http://api.telegram.org/bot$token/getChat?chat_id=$f[$i]"));
$name =$dets->result->title;
if($f[$i] != null){
$V = array_search($f[$i],$SALEH['SALEH']['send']['add']);
$uS = $SALEH['SALEH']['send']['uname'][$V];
$u=$i+1;

$Numbers = array(
'1' ,
'2' ,
'3',
'4' ,
'5', 


);
$NumbersBe = array('🥇' ,
'🥈' ,
'🥉' , 
'🏅' , 
'🏅' , 

);

$u = str_replace($Numbers,$NumbersBe,$u);

$dh=bot("getchat",['chat_id'=>$uS])->result->title;
if($dh != null) {
  $fk = $dh;
  } 
  if($dh == null) {
    $fk = $uS;
    } 
$ok = $ok. " $u ★ *$f[$i]* -> [$fk](tg://user?id=$uS) \n";
}
}
}
if($rshq['trend'] != "x"){
$b="🛡] المستخدمين الاكثر مشاركة للرابط : \n$ok" ;
}else{
  $b = null;
}

// تم تصحيح اخطاء الملف بواسطه كيلوا@X_V_44 @ka7h_bot

if($data == "linkme") {
	$sx = ($rshq["coinshare"]?? "25");
  bot('EditMessageText',[
  'chat_id'=>$chat_id,
  'message_id'=>$message_id,
  'text'=>"
✳️ تجميع ".$name3mla."

لقد دعوت : $share 👤

عندما تقوم بدعوة شخص من خلال الرابط :
https://t.me/[".bot("getme")->result->username."]?start=$from_id
ستحصل على $sx $name3mla  👤

$b
  ",
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
       'inline_keyboard'=>[
       [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
         
        ]
      ])
  ]);
  } 

  mkdir("HD_P");
$d = date('D');
$day = explode("\n",file_get_contents("HD_P/".$d."_".USR_BOT.".txt"));
if($d == "Sat"){
unlink("HD_P/Fri_$usrbot.txt");
}
if($d == "Sun"){
unlink("HD_P/Sat_".USR_BOT.".txt");
}
if($d == "Mon"){
unlink("HD_P/Sun_".USR_BOT.".txt");
}
if($d == "Tue"){
unlink("MHD_P/on_".USR_BOT.".txt");
}
if($d == "Wed"){
unlink("HD_P/The_".USR_BOT.".txt");
}
if($d == "Thu"){
unlink("HD_P/Wed_".USR_BOT.".txt");
}
if($d == "Fri"){
unlink("HD_P/Thu_".USR_BOT.".txt");
}
    if($data == "hdiaa"){ 
    // --- بداية الإصلاح: استخدام التوقيت الدقيق + تسجيل الإحصائيات ---
    $last_claim_time = $rshq['daily_gift_last_claimed'][$from_id] ?? 0;
    $time_now = time();
    $cooldown_24h = 24 * 3600; // 24 ساعة بالثواني
    $next_claim_time = $last_claim_time + $cooldown_24h;

    if ($time_now >= $next_claim_time) {
    // --- نهاية الإصلاح ---
        
        $HDIASs = ($rshq['hdias'] ?? "20");
        bot('answercallbackquery',[
            'callback_query_id'=>$update->callback_query->id,
            'text'=>"
 لقد حصلت علي $HDIASs ".$name3mla." 💠
",
         'show_alert'=>true,
        ]);
        
        // --- (جديد) تسجيل الإحصائيات ---
        $rshq["coin"][$from_id] = (intval($rshq["coin"][$from_id] ?? 0)) + intval($HDIASs);
        $rshq['daily_gift_last_claimed'][$from_id] = $time_now; 
        $rshq['daily_gifts_collected'][$from_id] = (intval($rshq['daily_gifts_collected'][$from_id] ?? 0)) + 1;
        $rshq['gift_points_received'][$from_id] = (intval($rshq['gift_points_received'][$from_id] ?? 0)) + intval($HDIASs);
        // --- نهاية التسجيل ---
        
        SETJSON($rshq);
        
    } else {
        // --- بداية الإصلاح: إظهار الوقت المتبقي الدقيق ---
        $remaining_seconds = $next_claim_time - $time_now;
        $remaining_time_formatted = format_seconds_to_hms($remaining_seconds);
        
        bot('answercallbackquery',[
                'callback_query_id'=>$update->callback_query->id,
         'text' =>"
⏳ يجب أن تنتظر : $remaining_time_formatted
 ",
                'show_alert'=>true,
        ]);
        // --- نهاية الإصلاح ---
    }
}


// ======================================================
//  (جديد) 11.1: كود الهدية الأسبوعية (للمستخدم)
// ======================================================
if($data == "weekly_gift_claim"){ 
    
    $weekly_cooldown = 7 * 24 * 3600; // 7 أيام بالثواني
    $last_claim = $rshq['weekly_gift_last_claimed'][$from_id] ?? 0;
    $time_now = time();
    $next_claim = $last_claim + $weekly_cooldown;

    if ($time_now >= $next_claim) {
        
        $points_to_give = intval($rshq['weekly_gift_points'] ?? 100);
        
        bot('answercallbackquery',[
            'callback_query_id'=>$update->callback_query->id,
            'text'=>"🎉 تهانينا! لقد حصلت على هديتك الأسبوعية: $points_to_give $name3mla 💠",
            'show_alert'=>true,
        ]);
        
        $rshq["coin"][$from_id] = (intval($rshq["coin"][$from_id] ?? 0)) + $points_to_give;
        $rshq['weekly_gift_last_claimed'][$from_id] = $time_now; 
        SETJSON($rshq);
        
    } else {
        $remaining_seconds = $next_claim - $time_now;
        
        // تحويل الثواني إلى أيام وساعات
        $days = floor($remaining_seconds / (3600*24));
        $hours = floor(($remaining_seconds % (3600*24)) / 3600);
        
        $time_text = "";
        if ($days > 0) $time_text .= "$days يوم و ";
        if ($hours > 0) $time_text .= "$hours ساعة";
        
        bot('answercallbackquery',[
                'callback_query_id'=>$update->callback_query->id,
         'text' =>"⏳ يجب أن تنتظر!
طالب بالهدية الأسبوعية بعد:
$time_text
 ",
                'show_alert'=>true,
        ]);
    }
}


if($data == "info") {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
البوت الاول في التليجرام لزيادة متابعين الانستقرام بشكل فوري و سريع و بنسبة ثبات 99% 

    كل ماعليك هو دعوة اصدقائك من خلال الرابط الخاص بك وستحصل على متابعين مقابل كل شخص تحصل تدعوه تحصل على 10 $name3mla
    
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
      ]
    ])
]);
} 

$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/rshq.json"),true);


if($data == "mstqbll") {
	if($rshq['Brook'] == "on") {
	$ster = "مفتوح ✅" ;
	$wsfer = "يمكنك الرشق ✅" ;
	} else {
		$ster = "مقفل ❌" ;
		$wsfer = "لايمكنك الرشق حاليا اجمع $name3mla لحد ما ينفتح ❌" ;
		} 
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
استقبال الرشق $ster
- $wsfer
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
      ]
    ])
]);

} 

$e1 = str_replace("/start SALEH", null, $text);
if (preg_match('/start SALEH/', $text)) {
    
    // التحقق أولاً إذا كان الرابط موجوداً وصالحا
                // --- (جديد) تسجيل سجل التحويلات (للرابط) ---
            $log_entry_sender = [
                'type' => 'sent_link', 'partner_id' => $from_id, 'amount' => $transfer_amount,
                'commission' => 'N/A', 'total' => $transfer_amount, 
                'balance_after' => $rshq["coin"][$creator_id], 'date' => time()
            ];
            $transferLog[$creator_id][] = $log_entry_sender;

            $log_entry_receiver = [
                'type' => 'received_link', 'partner_id' => $creator_id, 'amount' => $transfer_amount,
                'commission' => 0, 'total' => $transfer_amount,
                'balance_after' => (intval($rshq["coin"][$from_id] ?? 0)) + intval($transfer_amount), 'date' => time()
            ];
            $transferLog[$from_id][] = $log_entry_receiver;
            file_put_contents($transferLogFile, json_encode($transferLog, JSON_PRETTY_PRINT)); // حفظ السجل
            // --- نهاية التسجيل ---

    if (isset($rshq['thoiler'][$e1]["to"]) && $rshq['thoiler'][$e1]["to"] != null) {
        
        $creator_id = $rshq['thoiler'][$e1]["to"]; // آيدي منشئ الرابط
        $transfer_amount = $rshq['thoiler'][$e1]["coin"]; // المبلغ

        // 🛑 !! التحقق الجديد: منع الاستخدام الذاتي
        if ($creator_id == $from_id) {
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => "❌ *لا يمكنك استخدام رابط تحويل قمت أنت بإنشائه!*
                
يمكنك استرداد نقاطك إذا لم يتم استخدام الرابط بالذهاب إلى:
*قسم التحويل ⬅️ تحويل عن طريق الرابط ⬅️ إرسال المبلغ ⬅️ الضغط على زر (تعطيل الرابط)*",
                'parse_mode' => "markdown",
                'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "$NamesBACK", 'callback_data' => "tobot"]]]])
            ]);
            
            // لا تقم بإلغاء الرابط، دعه متاحاً للاسترداد
            exit; // منع إكمال التحويل
        }
        
        // (الكود الحالي لإتمام التحويل للشخص الآخر)
        $receiver_old_balance = $rshq["coin"][$from_id] ?? 0;
        $receiver_new_balance = $receiver_old_balance + $transfer_amount;

        bot('sendMessage', [
            'chat_id' => $chat_id, // إرسال للمستلم
            'text' => "✅ *تم استلام التحويل*
            
👤 *من:* `$creator_id`
💰 *المبلغ:* $transfer_amount $name3mla
            
• ".$name3mla."ك القديمة: $receiver_old_balance
• ".$name3mla."ك الحالية: $receiver_new_balance",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "$NamesBACK", 'callback_data' => "tobot"]]]])
        ]);

        bot('sendMessage', [
            'chat_id' => $creator_id, // إرسال للمُرسل
            'text' => "✅ *اكتمل تحويلك*
            
تم استخدام الرابط الخاص بك بنجاح:
            
👤 *إلى:* [$name](tg://user?id=$from_id) (ID: `$from_id`)
💰 *المبلغ:* $transfer_amount $name3mla",
            'parse_mode' => "markdown",
        ]);

        // تعطيل الرابط بعد الاستخدام
        $rshq['thoiler'][$e1]["to"] = null; // جعل الرابط غير صالح
        $rshq["coin"][$from_id] += $transfer_amount; // إضافة النقاط للمستلم
        SETJSON($rshq);
        
    } else {
        // الرابط مستخدم بالفعل أو غير صالح
        bot('sendMessage', [
            'chat_id' => $from_id,
            'text' => "❌ *رابط التحويل هذا غير صالح*
            
قد يكون تم استخدامه بالفعل أو تم إلغاؤه.",
            'parse_mode' => "markdown",
            'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "$NamesBACK", 'callback_data' => "tobot"]]]])
        ]);
    }
    exit; // منع /start العادي من العمل
}
// ...



// ======================================================
//  (جديد) 10. قسم اعدادات الحساب المطور
// ======================================================

// 10.1: القائمة الرئيسية لـ "اعدادات الحساب"
if($data == "account_settings") {
    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"
• مرحبا بك في قسم اعدادات حسابك ⚙️

• اختر ما يناسبك من الازرار ادناه 📥 
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode([
             'inline_keyboard'=>[
                 [['text'=> '🗃️ معلومات حسابك', 'callback_data' => 'acc_info_menu']],
                 [['text'=> '👨‍💻 ابلاغ عن عطل', 'callback_data' => 'report_bug']],
               //  [['text'=> '♻️ سجل التحويلات', 'callback_data' => 'transfer_log_menu']],
      //           [['text'=> '🛒 التمويلات الجاريه', 'callback_data' => 'user_funding_menu']],
                 [['text'=> $NamesBACK, 'callback_data' => "tobot"]]
             ]
        ])
    ]);
    exit;
}

// 10.2: قائمة "معلومات حسابك" (الاحصائيات)
if($data == "acc_info_menu") {

    // --- جلب كل الإحصائيات ---
    $user_coin = intval($rshq["coin"][$from_id] ?? 0);
    $used_coin = intval($rshq["cointlb"][$from_id] ?? 0);
    $referrals_l1 = intval($rshq["mshark"][$from_id] ?? 0);
    $referrals_l2 = intval($rshq['referral_level_2'][$from_id] ?? 0); // (للنظام المستقبلي)
    $orders_made = intval($rshq["tlby"][$from_id] ?? 0);
    $transfers_made = intval($rshq['transfers_made'][$from_id] ?? 0);
    $gift_points = intval($rshq['gift_points_received'][$from_id] ?? 0);
    $codes_used = intval($rshq['codes_used'][$from_id] ?? 0);
    $daily_collected = intval($rshq['daily_gifts_collected'][$from_id] ?? 0);

    // --- حساب وقت الهدية ---
    $last_claim_time = $rshq['daily_gift_last_claimed'][$from_id] ?? 0;
    $time_now = time();
    $cooldown_24h = 24 * 3600; 
    $next_claim_time = $last_claim_time + $cooldown_24h;

    if ($time_now >= $next_claim_time) {
        $timehdia = "يمكنك المطالبة بها 🎁";
    } else {
        $remaining_seconds = $next_claim_time - $time_now;
        $timehdia = "متبقي: " . format_seconds_to_hms($remaining_seconds);
    }

    // --- القالب الافتراضي (إذا لم يضع الأدمن كليشة) ---
    $default_template = "
• 🗃️] معلومات حسابك 

• ❇️] عدد نقاط حسابك : *#coins*
• ❇️] النقاط التي استخدمتها : *#coinsx*

• 🌀] عدد عمليات الاحاله التي قمت بها : *#shares*
• 📮] عدد الطلبات التي طلبتها : *#xtlb*
• ♻️] عدد التحويلات التي قمت بها : *#transfers_made*

• ❇️] عدد النقاط اللي جمعتها من الهدايا اليومية : *#gift_points_received*
• 💳] عدد اكواد الهدايا التي استخدمتها : *#codes_used*
• 🎁] عدد الهدايا اليومية التي جمعتها : *#daily_gifts_collected*
• 🎁] متبقي علي الهدية : *#timehdia*
";

    // جلب القالب المخصص من الأدمن (s5Ch)
    $template = $rshq["msgMYACC"] ?? $default_template;

    // استبدال الرموز
    $ty = str_replace(
        [
            '#coins', '#coinsx', '#shares', '#referral_level_2', '#xtlb', 
            '#transfers_made', '#gift_points_received', '#codes_used', 
            '#daily_gifts_collected', '#timehdia', '#name_user', '#username', 
            '#name', '#id', 'نقاط'
        ],
        [
            $user_coin, $used_coin, $referrals_l1, $referrals_l2, $orders_made,
            $transfers_made, $gift_points, $codes_used,
            $daily_collected, $timehdia, "[$name](tg://user?id=$from_id)", 
            ($username ? "@$username" : "لا يوجد"), $name, $from_id, $name3mla
        ],
        $template
    );

    // --- الأزرار الجديدة ---
    $keyboard = [
        'inline_keyboard' => [
            [['text' => '🎁 الهدية اليومية', 'callback_data' => 'hdiaa'], ['text' => '🔗 رابط الدعوة', 'callback_data' => 'linkme']],
            [['text' => $NamesBACK, 'callback_data' => "account_settings"]] // (رجوع لقائمة الاعدادات)
        ]
    ];

    bot('EditMessageText',[
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => $ty,
        'parse_mode' => "markdown",
        'reply_markup' => json_encode($keyboard)
    ]);
} 

// 10.3: قسم "ابلاغ عن عطل"
if($data == "report_bug") {
    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"
• مرحبا بك في قسم التحدث مع المطور👨‍💻.

• رجاء ارسل رسالتك او مشكلتك باختصار .. 

• تجنب الالفاظ المسيئة وكن مهذب الاخلاق 😇

• في انتظار رسالتك ...📩
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode([
             'inline_keyboard'=>[
                 [['text'=> $NamesBACK, 'callback_data' => "account_settings"]]
             ]
        ])
    ]);
    $modes['mode'][$from_id] = 'report_bug_send';
    SETJSON12($modes);
    exit;
}

// 10.4: استلام رسالة العطل
if($text && $modes['mode'][$from_id] == 'report_bug_send') {

    // 1. إظهار رسالة "Please Wait" المتحركة
    $wait_msg = bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => '• Please Wait .',
        'parse_mode' => "markdown"
    ]);

    // 2. توجيه الرسالة للأدمن
    bot('forwardMessage', [
        'chat_id' => $sudo,
        'from_chat_id' => $chat_id,
        'message_id' => $message_id
    ]);
    // (إضافة معلومات عن المرسل)
    bot('sendMessage', [
        'chat_id' => $sudo,
        'text' => "
رسالة جديدة من:
الاسم: [$name](tg://user?id=$from_id)
الايدي: `$from_id`
المعرف: " . ($username ? "@$username" : "لا يوجد"),
        'parse_mode' => "markdown"
    ]);

    // 3. تحديث الرسالة (الأنميشن)
    sleep(1);
    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $wait_msg->result->message_id,
        'text' => '• Please Wait ..'
    ]);
    sleep(1); // (ثانية ونصف كما طلبت)
    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $wait_msg->result->message_id,
        'text' => '• Please Wait ...'
    ]);
    sleep(1);

    // 4. إظهار رسالة النجاح
    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $wait_msg->result->message_id,
        'text' => '• تم استقبال رسالتك بنجاح ، شكرا لك 😇',
        'reply_markup' => json_encode([
             'inline_keyboard'=>[
                 [['text'=> $NamesBACK, 'callback_data' => "account_settings"]]
             ]
        ])
    ]);

    unset($modes['mode'][$from_id]);
    SETJSON12($modes);
    exit;
}

// 10.5: قسم "سجل التحويلات" (جاهز للتطوير)
if($data == "transfer_log_menu") {
    // (الكود التالي سيعرض السجل، لكننا لم نبرمجه بعد)
    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"
• لم تقم مؤخراً بأي عمليات تحويل او استلام نقاط من بوت رشق العرب ♻️

(ملاحظة: سيتم بناء هذا القسم في التحديث القادم)
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode([
             'inline_keyboard'=>[
                 [['text'=> $NamesBACK, 'callback_data' => "account_settings"]]
             ]
        ])
    ]);
    exit;
}

// ======================================================
//  (تحديث) 10.6: قسم "التمويلات الجارية" (للمستخدم) - تصميم جديد (إرسال رسالة جديدة - إصلاح نهائي)
// ======================================================

// (هذا الكود يعالج زر الدخول + زر التحديث)
if($data == "user_funding_menu" || $data == "user_funding_refresh") {
    
    // (إضافة) إظهار رسالة "جاري التحديث..." عند الضغط على زر التحديث
    if($data == "user_funding_refresh"){
        bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id, 'text' => '🔄 جاري تحديث القائمة...']);
    }

    // --- طبقة حماية للتأكد أن المتغيرات هي مصفوفات ---
    $user_funding_list = $tmoil['db']["chsme"][$from_id] ?? [];
    if (!is_array($user_funding_list)) $user_funding_list = []; // تأمين

    $all_active_channels = $tmoil['db']["chs"] ?? [];
    if (!is_array($all_active_channels)) $all_active_channels = []; // تأمين
    // --- نهاية طبقة الحماية ---
    
    $active_user_funding = [];
    foreach($user_funding_list as $channel) {
        if (in_array($channel, $all_active_channels)) {
            $active_user_funding[] = $channel;
        }
    }
    
    $keyboard = ['inline_keyboard' => []];
    
    if (empty($active_user_funding)) {
        $keyboard[] = [['text' => '• لا توجد لديك تمويلات جارية حاليًا •', 'callback_data' => 'null_data']];
    } else {
        // --- بناء الجدول كما طلبت ---
        
        // 1. صف العناوين (أزرار زينة)
        $keyboard[] = [
            ['text' => 'حالة التمويل', 'callback_data' => 'null_data'],
            ['text' => 'القناة', 'callback_data' => 'null_data'],
            ['text' => 'المتبقي', 'callback_data' => 'null_data'],
            ['text' => 'العدد الكلي', 'callback_data' => 'null_data']
        ];
        
        // 2. صفوف البيانات (لكل قناة)
        foreach ($active_user_funding as $channel_username) {
            $idM = $tmoil['chanels']["id_$channel_username"] ?? null;
            if (!$idM || !isset($tmoil['db']["$idM"])) continue; // تخطي إذا كانت البيانات مفقودة
            
            $funding_data = $tmoil['db']["$idM"];
            
            $requested_count = intval($funding_data["count"]);
            $delivered_count = intval($funding_data["startc"] ?? 0);
            $remaining_count = $requested_count - $delivered_count;
            
            // بناء صف القناة
            $keyboard[] = [
                ['text' => 'قيد التنفيذ ⏳', 'callback_data' => 'null_data'], // الحالة
                ['text' => "@$channel_username", 'url' => "https://t.me/$channel_username"], // زر القناة (رابط)
                ['text' => "$remaining_count", 'callback_data' => 'null_data'], // المتبقي
                ['text' => "$requested_count", 'callback_data' => 'null_data']  // العدد الكلي
            ];
        }
    }

    // 3. الأزرار السفلية (التحديث والرجوع)
    $keyboard[] = [['text' => '🔄 تحديث القائمة', 'callback_data' => 'user_funding_refresh']];
    $keyboard[] = [['text' => $NamesBACK, 'callback_data' => "account_settings"]];
    
    // --- (هذا هو التعديل المطلوب) ---
    // 1. حذف الرسالة القديمة
    bot('deleteMessage', [
        'chat_id' => $chat_id,
        'message_id' => $message_id
    ]);
    
    // 2. إرسال رسالة جديدة (تم إصلاحها)
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        // (تم حذف message_id من هنا)
        'text'=>"
• جميع القنوات او مجموعاتك الجاري تمويلها التابعه لك 📮

- يمكنك ادارة ومتابعة تمويلاتك من هنا:
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=> json_encode(['inline_keyboard' => $keyboard])
    ]);
    // --- (نهاية التعديل) ---
    
    exit;
}


// ... (الكود الخاص بك)

// ===========================================
//  قسم الخدمات (للمستخدم) - (ترتيب الأزرار الجديد)
// ===========================================

 if($data == "service") {
 	if($rshq['Brook'] == "on" ) {

        // 1. مصفوفات لتخزين الأزرار
        $available_service_buttons = []; // الخدمات العادية (2x2)
        $free_service_button = null;     // زر الخدمات المجانية (علوي)
        $yearly_offer_button = null;   // (جديد) زر عروض السنه (علوي)
        
        // 2. جلب الأقسام الأساسية (الجاهزة)
        $basic_services_map = [
            'yearly_offers' => 'عروض السنه 🎉', // (جديد)
            'kwai' => 'كواي 🧡',
            'sweat' => 'واتساب 💚',
            'insta' => 'انستغرام 💜',
            'tik' => 'تيك توك 🖤',
            'telegram' => 'تيليجرام 💙',
            'youtube' => 'يوتيوب ❤️',
            'face' => 'فيسبوك 💖',
            'twit' => 'تويتر 🩵',
            'thread' => 'ثريدز 🤍',
            'gem' => 'شحن العاب 🤎',
            'offer' => 'عروض اليوم 🩶',
            'jjll' => 'ثريدز 🤍 '
        ];
        
        $basic_service_codes = $rshq['tasker_mcoide'] ?? [];
        
        foreach ($basic_services_map as $task_key => $service_name) {
            $service_code = $basic_service_codes[$task_key] ?? null;
            if ($service_code) {
                // التحقق إذا كان القسم الأساسي مُفعّل (في asaiasis) ومخفي
                if (($rshq['taskera'][$task_key] ?? "❌") == "✅" && ($rshq['IFWORK>'][$service_code] ?? 'ok') != "NOT") {
                    
                    // (تعديل) البحث عن الأزرار العلوية
                    if ($task_key == 'yearly_offers') {
                        $yearly_offer_button = ['text' => "$service_name", 'callback_data' => "SALEHENT|$service_code"];
                    } elseif (strpos($service_name, 'مجانية') !== false) {
                        $free_service_button = ['text' => "$service_name", 'callback_data' => "SALEHENT|$service_code"];
                    } else {
                        $available_service_buttons[] = ['text' => "$service_name", 'callback_data' => "SALEHENT|$service_code"];
                    }
                }
            }
        }
        
        // 3. جلب الأقسام المخصصة (التي أضافها الأدمن)
        $qsm_list = $rshq['qsm'] ?? [];
        foreach ($qsm_list as $qsm_entry) {
            $nameq = explode("-", $qsm_entry)[0];
            $service_code = explode("-", $qsm_entry)[1];
            $is_basic = in_array($service_code, $basic_service_codes);
            
            if (!$is_basic && ($rshq['IFWORK>'][$service_code] ?? 'ok') != "NOT") {
                
                // (تعديل) البحث عن الأزرار العلوية
                if (strpos($nameq, 'عروض السنه') !== false) {
                     $yearly_offer_button = ['text' => "$nameq", 'callback_data' => "SALEHENT|$service_code"];
                } elseif (strpos($nameq, 'مجانية') !== false) {
                    $free_service_button = ['text' => "$nameq", 'callback_data' => "SALEHENT|$service_code"];
                } else {
                    $available_service_buttons[] = ['text' => "$nameq", 'callback_data' => "SALEHENT|$service_code"];
                }
            }
        }
        
        // 4. إضافة قسم التمويل (إذا كان متاحًا)
        if($rshq['FREE'] != null) { 
            $available_service_buttons[] = ['text'=>"",'callback_data'=>"tmoile"]; 
        }

        // ===========================================
        //  (بناء لوحة المفاتيح بالترتيب الجديد)
        // ===========================================

        $key = ['inline_keyboard' => []];
        $services_found = count($available_service_buttons);

        // 1. إضافة "عروض السنه" (إذا وجد)
        if ($yearly_offer_button) {
            $key['inline_keyboard'][] = [$yearly_offer_button];
        }

        // 2. إضافة "خدمات مجانية" (إذا وجد)
        if ($free_service_button) {
            $key['inline_keyboard'][] = [$free_service_button];
        }

        // 3. التحقق إذا كانت هناك خدمات أخرى للعرض
        if ($services_found == 0) {
            // إذا لم نجد أي خدمات (لا عروض ولا مجانية ولا عادية)
            if (!$free_service_button && !$yearly_offer_button) {
                $key['inline_keyboard'][] = [['text' => 'ℹ️ لا توجد خدمات متاحة حاليًا', 'callback_data' => 'null_data']];
            }
        } else {
            // ----- توجد خدمات، رتبها في صفوف من زرين -----
            $row = []; // مصفوفة الصف المؤقت
            foreach ($available_service_buttons as $button) {
                $row[] = $button; // أضف الزر للصف
                
                if (count($row) == 2) {
                    $key['inline_keyboard'][] = $row;
                    $row = []; // أفرغ الصف
                }
            }
            
            // إذا تبقى زر واحد في النهاية، أضفه في صف لوحده
            if (count($row) > 0) {
                $key['inline_keyboard'][] = $row;
            }
        }

        // 4. إضافة زر الرجوع في النهاية
        $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "tobot"]];

        // 5. إرسال الرسالة
        // ... inside if($data == "service") ...

// الكود الجديد لتوليد النص
$template = $rshq['klisha_services_menu'] ?? "مرحبا بك في بوت $nambot 💚\n\n💠] نقاطك : #coins\n🔮] ايديك : #id";
$text_to_send = str_replace(
    ['#name', '#id', '#coins', '#name3mla'],
    [$name, $chat_id, $coin, $name3mla],
    $template
);

bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=> $text_to_send, // هنا التغيير
    'parse_mode'=>"markdown",
    'reply_markup'=>json_encode($key), 
]);

	} else {
        // (الكود الحالي إذا كان الرشق مقفولاً)
        $key = ['inline_keyboard' => []];
        if($rshq['FREE'] != null) {
            $key['inline_keyboard'][] = [['text'=>"",'callback_data'=>"tmoile"]];
        } 
        $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "tobot"]];
        bot('EditMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"$stopedkl", // رسالة "الرشق مقفول"
            'parse_mode'=>"markdown",
            'reply_markup'=>json_encode($key)
        ]);
	} 
    exit; // (مهم)
}

// (إضافة) كود للزر الوهمي (إذا لم يكن موجوداً)
if ($data == 'null_data') {
    bot('answerCallbackQuery', ['callback_query_id' => $update->callback_query->id]);
    exit;
}
// ...


if (explode("|",$data)[0] == "SALEHENT") {
    $key = ['inline_keyboard' => []];
    $vv = rand(100, 900);
    
    // تحقق مما إذا كان هناك خدمات لعرضها
    if (isset($rshq['xdmaxs'][explode("|",$data)[1]]) && !empty($rshq['xdmaxs'][explode("|",$data)[1]])) {
        foreach ($rshq['xdmaxs'][explode("|",$data)[1]] as $hjjj => $i) {
            $key['inline_keyboard'][] = [['text' => "$i", 'callback_data' => "type|".explode("|",$data)[1]."|$hjjj"]];
        }
    } else {
        // إذا لم يكن هناك خدمات، أضف زرًا للإشارة إلى عدم وجود خدمات
        $key['inline_keyboard'][] = [['text' => "لا توجد خدمات حتى الآن", 'callback_data' => "no_services"]];
    }
    
    $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "service"]];
    
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "🛍] اختر الخدمات التي تريدها ",
        'parse_mode' => "markdown",
        'reply_markup' => json_encode($key),
    ]);

    $modes['mode'][$from_id] = null;

    SETJSON($rshq); 
    SETJSON12($modes);
}

if($data == "infotlb") {
 	
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
*
🛡] ارسل ايدي الطلب :
*
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'رجوع' ,'callback_data'=>"tobot"]],
]])
]);
    $modes['mode'][$from_id]  = $data;
SETJSON($rshq); SETJSON12($modes);
}

$rshq["sSite"] = ($rshq["sites"][$text]??$rshq["sSite"]) ;
$Api_Tok = ($rshq["keys"][$text]?? $rshq["sToken"]) ;
if(is_numeric($text) and $modes['mode'][$from_id] == "infotlb"){
	if($text != null){
		$req = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=status&order=".$text));
$startcc = $req->start_count; //224
$status = $req->remains; 
if($status == "0"){
	$s= "طلب مكتمل 🟢";
	}else{
		$s="قيد المراجعة";
		}
		if($req) {
			if(!$rshq["ordn"][$text]) {
				bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
️هذا الطلب ليس موجود في طلباتك ❌
  ", 
 'parse_mode'=>"markdown",
]);
				$modes['mode'][$from_id]  = null;
SETJSON12($modes);
				exit;
				} 
		bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
   ️⃣] معلومات عن الطلب :

- 🔡] اسم الخدمة : ".$rshq["ordn"][$text]."
- 🛡] ايدي الطلب : `$text`
- ♻️] حالة الطلب : $s
- ⏳] المتبقي : $status
  ", 
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>'تحديث' ,'callback_data'=>"updates|".$text]],
     [['text'=>'رجوع' ,'callback_data'=>"tobot"]],
       
      ]
    ])
]);
$modes['mode'][$from_id]  = null;
SETJSON($rshq); SETJSON12($modes);
} else {
	bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
️هذا الطلب ليس موجود في طلباتك ❌
  ", 
 'parse_mode'=>"markdown",
]);
	} 
}
}


$s3rtmoil = $rshq["s3rtmoil"]?? "12";

if($data == "tmoile") {
 	

    $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "tobot"]];
$cbn = $coin / 8;
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
كل 1 عضو 👤 مقابل $s3rtmoil نقطة 
👤] ارسل الكمية :
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
      ]
    ])
]);
$modes['mode'][$from_id]  = $data ;
   
SETJSON($rshq); SETJSON12($modes);
} 


$data_ = explode("|", $data) ;
$helper = USR_BOT ;
$idna = $tmoil["tmoils"]??"10";
if(is_numeric($text) and $modes['mode'][$from_id] == "tmoile" ){
	$data_[1] = $text ;
	if($data_[1] < $idna){
		bot('sendmessage',[
      'chat_id' => $chat_id, 
      'text'=>"
اقل حد للطلب هو $idna ❌
",
      
      ]);
      
			exit ;
		}
	$PrIce = $data_[1] * $s3rtmoil;
	if($coin >= $PrIce) {
	bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
- ارفع البوت المساعد 🛠️ [@". $helper." ]
📣] ارسل معرف القناة :



",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
      ]
    ])
]);
$tmoil['sets'][$from_id]["count"] = $data_[1];
$tmoil["sets"][$from_id]["price"] = $PrIce;
$tmoil["sets"][$from_id]["to"] = "P1";
$modes['mode'][$from_id]  = null ;
   
SETJSON($rshq); SETJSON12($modes);
SETJSON1($tmoil);
} else {
	$g = $PrIce - $coin;
	bot('sendmessage',[
      'chat_id' => $chat_id, 
      'text'=>"
".$name3mla."ك لاتكفي ❌
▶️ متبقي $g
",
      'show_alert'=>true
      ]);
	} 
	}
	
	$coins = $coin;
	if(preg_match("/@/",$text) and $tmoil["sets"][$from_id]["to"] == "P1") {
		$text = str_replace ("@",null, $text) ;
		if(in_array($text, $tmoil["blocks"])) {
			bot('sendMessage',[
   'chat_id'=>$chat_id ,
   'text'=>"
⚠️ عذرا ولكن القناة تم حظرها من التمويل
🎟️] معرفها : [@$bv]
  ", 
  'parse_mode'=>"markdown",

]);
unset($tmoil["sets"][$from_id]);
SETJSON1($tmoil);
return false ;
			} 
		$getChatMemberReq = json_encode(bot('getChatMember', ['chat_id' => "@$text" , 'user_id' => IDBot]));
			$getChatMemberRes = json_decode($getChatMemberReq, true);
			if ($getChatMemberRes['result']['status'] == "administrator") {
				$kmia=$tmoil['sets'][$from_id]["count"];
				$coi=$tmoil["sets"][$from_id]["price"];
				$idM = rand(999999,9999999999);
				bot('sendMessage',[
   'chat_id'=>$chat_id ,
   'text'=>"
📜] معلومات الطلب :

📣) معرف القناة : [@$text] 
🎾) الكمية : $kmia
??) السعر : $coi
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"تأكيد الطلب ✅",'callback_data'=>"ADDMOL|$idM" ]], 
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]], 
       
      ]
    ])
]);
$tmoil['info']["$idM"] = "$text|$kmia|$coi" ;
$tmoil['chanels']["id_$text"] = $idM;
$tmoil["sets"][$from_id]["price"] = $PrIce;
$tmoil["sets"][$from_id]["to"] = "P2";
SETJSON1($tmoil);
				} else {
					bot('sendMessage',[
   'chat_id'=>$chat_id ,
   'text'=>"
- ارفع البوت المساعد 🛠️ [@". $helper." ]
📣] ارسل معرف القناة :


  ", 
  'parse_mode'=>"markdown",
]);

					} 
		
		} 
	if($data_[0] == "getv") {
				$chs = $data_[1];
				$bv = $chs;
				$mt = json_encode(bot('getChatMember', ['chat_id' => "@".$chs , 'user_id' => IDBot]));
			$nt = json_decode($mt, true);
			$bv = $chs ;
			if ($nt['result']['status'] == "administrator") {
				$getChatMemberReq = file_get_contents("https://api.telegram.org/bot". API_KEY. "/getChatMember?chat_id=@" . $bv . "&user_id=" . $from_id);
			$getChatMemberRes = json_decode($getChatMemberReq, true);
			if ($getChatMemberRes['result']['status'] != "left" ) {
				$coinIshtrak = $coinIshtrak??"5";
				bot('answerCallbackQuery',[
      'callback_query_id'=>$update->callback_query->id,
      'text'=>"
تم اضافه $coinIshtrak $name3mla الي حسابك ✅
",
      'show_alert'=>true
      ]);
				$rshq["coin"][$from_id] += $coinIshtrak??"10";
				SETJSON($rshq); SETJSON12($modes); 
$idM = $tmoil['chanels']["id_$bv"] ;
$ci =$tmoil['db']["$idM"]["count"] ;
$vx = $ci - $tmoil['db']["$idM"]["startc"] ;
$vx = $vx - 1;
bot('sendMessage',[
   'chat_id'=>$tmoil['db']["$idM"]["owner"] ,
   'text'=>"
👤اشترك شخص جديد في قناتك✅ [@$bv]
📝العدد المطلوب : $ci
🛡العدد المتبقي لتمويلك : $vx
⚠️) لا تقم بتنزيل البوت [@".USR_BOT."] 
من الادمنية حتى لا يتم الغاء طلبك 🚫
  ",
  'disable_web_page_preview' => true, 
  'parse_mode'=>"markdown",
]);
if($vx == 0){
	bot('sendMessage',[
   'chat_id'=>$tmoil['db']["$idM"]["owner"] ,
   'text'=>"
تم الانتهاء من تمويل قناتك ✅

📣) معرف القناة : [@$bv]
🛡) العدد المطلوب : $ci
  ", 
  'parse_mode'=>"markdown",
]);

$st=$bv;
$st=array_search($st,$tmoil['db']["chs"]);
unset($tmoil['db']["chs"][$st]);

$tmoil['db']["complete"][] =$bv;
$F = "tmoil/". USR_BOT."/tmoil.json";
        $N = json_encode($tmoil, JSON_PRETTY_PRINT);
        
        file_put_contents($F, $N, LOCK_EX);

	}

$tmoil['botCom'] +=1;
$tmoil['db']["$idM"]["startc"] +=1;
		$tmoil["coin"][$from_id] += $coinIshtrak??"5";
		
		$coinb = $tmoil["coin"][$from_id] + $coinIshtrak?? "5";
		$tmoil["chids"][$from_id][] = $idM;
		$tmoil["mechs"][$from_id] += 1;
		
		SETJSON1($tmoil); 
		
        // --- بداية كود حفظ الاشتراك (لنظام المغادرة الصارم) ---
        if(!isset($tmoil['permanent_joins'][$from_id])) {
            $tmoil['permanent_joins'][$from_id] = [];
        }
        // بنسجل اليوزر نيم بتاع القناة، ومين صاحبها، عشان نرجعله الفلوس
        $channel_owner_id = $tmoil['db']["$idM"]["owner"] ?? null;
        // هنا بنستخدم $bv (يوزر القناة) كمفتاح عشان نمنع التكرار
        if(!isset($tmoil['permanent_joins'][$from_id][$bv])) { 
            $tmoil['permanent_joins'][$from_id][$bv] = [
                'username' => $bv, // يوزر القناة
                'owner_id' => $channel_owner_id, // آي دي صاحبها
                'joined_at' => time() // وقت الانضمام
            ];
            SETJSON1($tmoil); // نحفظ البيانات دي في ملف التمويل
        }
        // --- نهاية كود حفظ الاشتراك ---
		
				}
				
				foreach ($tmoil['db']["chs"] as $chs) {
					
					$mt = json_encode(bot('getChatMember', ['chat_id' => "@".$chs , 'user_id' => IDBot]));
			$nt = json_decode($mt, true);
			$bv = $chs ;
			if ($nt['result']['status'] == "administrator") {
				$getChatMemberReq = file_get_contents("https://api.telegram.org/bot". API_KEY. "/getChatMember?chat_id=@" . $bv . "&user_id=" . $from_id);
			$getChatMemberRes = json_decode($getChatMemberReq, true);
			if ($getChatMemberRes['result']['status'] == "left" ) {
				$getch2 = json_decode(file_get_contents("http://api.telegram.org/bot". API_KEY. "/getChat?chat_id=@$bv"))->result;
$getN = $getch2->title;
if($getN == null) { $getN = "@$bv";}
				bot('editMessagetext',[
					
   'chat_id'=>$chat_id ,
   'message_id' => $message_id, 
   'text'=>"
🍪] ".$name3mla."ك : $coin 👤
اشترك في القناة [@$bv] 

  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$getN",'url'=>"https://t.me/$bv" ]], 
     [['text'=>"اشتركت ✅",'callback_data'=>"getv|$bv" ],['text'=>"ارسـال ابـلاغ ⚠️",'callback_data'=>"sendblock|$bv" ]],[['text'=>"$NamesBACK",'callback_data'=>"tobot" ]], 
       
      ]
    ])
]);
				exit ;
				}
				}
				} 
			
				if($bv == null or $getN == null ) {
					bot('answerCallbackQuery',[
      'callback_query_id'=>$update->callback_query->id,
      'text'=>"
⛔ انتهت قنوات التمويل قم بتجميع ال$name3mla عن طريق رابط الدعوه
",
      'show_alert'=>true
      ]);
      bot('editMessagetext',[
   'chat_id'=>$chat_id,
   'message_id' => $message_id, 
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);
exit;
					}
					} 
	} 
	if($data_[0] == "ADDMOL") {
		$h= $data_[1];
		$vZ = explode("|", $tmoil['info']["$h"]);
		$text = str_replace ("@",null, $vZ[0]) ;
		if(in_array($text,$tmoil['db']["chs"])) {
			bot('answerCallbackQuery',[
      'callback_query_id'=>$update->callback_query->id,
      'text'=>"
🔶 هذا القناة قيد التمويل بالفعل
",
      'show_alert'=>true
      ]);
      bot('editMessagetext',[
   'chat_id'=>$chat_id,
   'message_id' => $message_id, 
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);
			exit ;
			} 
		$getChatMemberReq = json_encode(bot('getChatMember', ['chat_id' => "@$text" , 'user_id' => IDBot]));
			$getChatMemberRes = json_decode($getChatMemberReq, true);
			if ($getChatMemberRes['result']['status'] == "administrator") {
				$kmia=$vZ[1];
				$coi=$vZ[2];
				$idM = $data_[1];
				if($coins >= $coi) {
					$rshq["coin"][$from_id] -= $coi;
					SETJSON($rshq); SETJSON12($modes);
					$date = date("d|m|y:H:i:s");
				bot('editMessagetext',[
   'chat_id'=>$chat_id ,
   'message_id' => $message_id, 
   'text'=>"
📜] تم انشاء طلب بنجاح ✅ :

📣) معرف القناة : [@$text]
🎾) الكمية : $kmia
🍪) السعر : $coi 
⏳] التاريخ : $date

⚠️) لا تقم بتنزيل المساعد [@". bot("getme")->result->username. "] 
من الادمنية حتى لا يتم الغاء طلبك 🤍
  ", 
  'parse_mode'=>"markdown",
]);

$tmoil['coin'][$from_id] -= $coi;

$tmoil['chanels']["id_$text"] = $idM;
$tmoil['db']["$idM"]["count"] = $kmia;
$tmoil['db']["chs"][] = $text ;
$tmoil['db']["chsme"][$from_id][] = $text ;
$tmoil['db']["$idM"]["price"] = $coi;
$tmoil['db']["$idM"]["owner"] = $from_id ;
$tmoil['db']["$idM"]["create"] = $date ;
$tmoil["sets"][$from_id]["price"] = $PrIce;
$tmoil["sets"][$from_id]["to"] =null ;
SETJSON1($tmoil);

$coin = $coin - $coi;
$getChatMemberReq = file_get_contents("https://api.telegram.org/bot" . $API_KEY . "/getChatMember?chat_id=" . $forwardFromChat['id'] . "&user_id=" . IDBot);
			$getChatMemberRes = json_decode($getChatMemberReq, true);
			$al3dd = json_decode(file_get_contents("https://api.telegram.org/bot". API_KEY. "/getChatMemberscount?chat_id=@" . $text))->result;
			$ch2 = file_get_contents("https://api.telegram.org/bot". API_KEY. "/getChatMember?chat_id=@$text&user_id=".$from_id);
$getch2 = json_decode(file_get_contents("http://api.telegram.org/bot". API_KEY. "/getChat?chat_id=@$text"))->result;
$nm = $getch2->title;
$bv = $text ;
if($nm == null) { $nm = "@$bv";}
$lnk = "https://t.me/$bv" ;

$mes=array("$admin", "$sudo") ;
foreach($mes as $v) {
bot('sendMessage',[
   'chat_id'=>$v ,
   'text'=>"
- بدء تمويل قناة [$nm]($lnk) بـ $kmia عضو🚸
• العدد قبل التمويل : $al3dd
  ", 
  'parse_mode'=>"markdown",
 'disable_web_page_preview' => true, 
]);
} 
bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
$starts 
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);
} else {
	bot('sendmessage',[
   'chat_id'=>$chat_id ,
   'message_id' => $message_id, 
   'text'=>"
⁉️] ".$name3mla."ك لاتكفي، 

  ", 
  'parse_mode'=>"markdown",
]);
bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);
	} 
				} else {
					bot('sendMessage',[
   'chat_id'=>$chat_id ,
   'text'=>"
- ارفع البوت المساعد 🛠️ [@". $helper." ]
📣] ارسل معرف القناة :


  ", 
  'parse_mode'=>"markdown",
]);
					} 
		
		}
		// تم تصحيح اخطاء الملف بواسطه كيلوا@X_V_44 @ka7h_bot

		
		
		
		if($data_[0] == "sendblock") {
					if(!in_array($data_[1],$tmoil['blockers']["$from_id"])){
						$bv = $data_[1];
					bot('answerCallbackQuery',[
      'callback_query_id'=>$update->callback_query->id,
      'text'=>"
⛔] تم ارسال الابلاغ شكرا علي تعاونك معنا
",
      'show_alert'=>true
      ]);
					bot('sendMessage',[
   'chat_id'=>$sudo ,
   'text'=>"
🍪] ابلاغ جديد عزيزي المطور

🔛] من [$name](tg://user?id=$chat_id) 
👤] معرفه : [@$user] 
🔔] الي القناة : [@$bv] 
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"@$bv",'url'=>"https://t.me/$data_[1]" ]], 
     [['text'=>"ازاله من التمويل 🌀",'callback_data'=>"delete|$bv" ]], 
       
      ]
    ])
]);
$tmoil['blockers']["$from_id"][] = $data_[1];
SETJSON1($tmoil); 
}else{
	bot('answerCallbackQuery',[
      'callback_query_id'=>$update->callback_query->id,
      'text'=>"
📛] القناة مبلغ عليها من قبلك بلفعل
",
      'show_alert'=>true
      ]);
	} 
					}
					
					if($data_[0] == "delete") {
	$f="@".$data_[1];
	$bv = str_replace("@",null, $f) ;
						bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
- هل انت متاكد من ازاله القناة? ⚠️

",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"نعم",'callback_data'=>"deletere|$bv" ]],
       [['text'=>"نعم + حظر القناة",'callback_data'=>"deletereblock|$bv" ]],
       [['text'=>"لا",'callback_data'=>"deysx|$bv" ]],
      ]
    ])
]);
						}
						
						if($data_[0] == "deysx") {
							$bv = $data_[1];
							bot('editMessagetext',[
   'chat_id'=>$sudo ,
   "message_id" => $message_id, 
   'text'=>"
🍪] قائمه الابلاغ

🔔] الي القناة : [@$bv] 
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"@$bv",'url'=>"https://t.me/$data_[1]" ]], 
     [['text'=>"ازاله من التمويل 🌀",'callback_data'=>"delete|$bv" ]], 
       
      ]
    ])
]);
							} 
						
					if($data_[0] == "deletere") {
	$f="@".$data_[1];
	$bv = str_replace("@",null, $f) ;
						bot('answerCallbackQuery',[
      'callback_query_id'=>$update->callback_query->id,
      'text'=>"
📊] تم ازاله القناة [$f] من التمويل 
",
      'show_alert'=>true
      ]);
      $bv = $data_[1];
      $st=array_search($bv,$tmoil['db']["chs"]);
$tmoil['db']["chs"]=array_values($tmoil['db']["chs"]);
unset($tmoil['db']["chs"][$st]);
SETJSON1($tmoil); 
						}
						
						if($data_[0] == "deletereblock") {
	$f="@".$data_[1];
	$bv = str_replace("@",null, $f) ;
						bot('answerCallbackQuery',[
      'callback_query_id'=>$update->callback_query->id,
      'text'=>"
📊] تم ازاله القناة [$f] من التمويل  وتم حظرها من التمويل 
",
      'show_alert'=>true
      ]);
      $bv = $data_[1];
      $st=array_search($bv,$tmoil['db']["chs"]);
$tmoil['db']["chs"]=array_values($tmoil['db']["chs"]);
unset($tmoil['db']["chs"][$st]);
$tmoil["blocks"][] = $bv;
SETJSON1($tmoil); 
						}
					
if($data_[0] == "joins") {
    
    // --- بداية فحص المغادرة الصارم ---
    // بنشغل الدالة اللي بتفحص وتخصم
    list($rshq, $tmoil) = checkStrictLeave($from_id, $tmoil, $rshq, API_KEY, $name3mla);
    // --- نهاية فحص المغادرة الصارم ---
    
			if($data_[1] == "1"){
				
				
				foreach ($tmoil['db']["chs"] as $chs) {
					$idM = $tmoil['chanels']["id_$chs"] ;
					if(!in_array($idM, $tmoil["chids"][$from_id])) {
					$mt = json_encode(bot('getChatMember', ['chat_id' => "@".$chs , 'user_id' => IDBot]));
			$nt = json_decode($mt, true);
			$bv = $chs ;
			if ($nt['result']['status'] == "administrator") {
				$getChatMemberReq = file_get_contents("https://api.telegram.org/bot". API_KEY. "/getChatMember?chat_id=@" . $bv . "&user_id=" . $from_id);
			$getChatMemberRes = json_decode($getChatMemberReq, true);
			if ($getChatMemberRes['result']['status'] == "left" ) {
				$getch2 = json_decode(file_get_contents("http://api.telegram.org/bot". API_KEY. "/getChat?chat_id=@$bv"))->result;
$getN = $getch2->title;
if($getN == null) { $getN = "@$bv";}
				bot('editMessagetext',[
					
   'chat_id'=>$chat_id ,
   'message_id' => $message_id, 
   'text'=>"
اشترك فالقناة @$bv
  ", 
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$getN",'url'=>"https://t.me/$bv" ]], 
     [['text'=>"اشتركت ✅",'callback_data'=>"getv|$bv" ],['text'=>"ارسـال ابـلاغ ⚠️",'callback_data'=>"sendblock|$bv" ]],[['text'=>"$NamesBACK",'callback_data'=>"tobot" ]], 
       
      ]
    ])
]);
				exit ;
				} 
				}
				
				}
				
					
					}
					} 
				

if($bv == null or $getN == null ) {
					bot('answerCallbackQuery',[
      'callback_query_id'=>$update->callback_query->id,
      'text'=>"
⛔ انتهت قنوات التمويل قم بتجميع ال$name3mla عن طريق رابط الدعوه
",
      'show_alert'=>true
      ]);
      bot('editMessagetext',[
   'chat_id'=>$chat_id,
   'message_id' => $message_id, 
   'text'=>"
$starts
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode($RSALEHO)
]);
					}
					
				}
				
				if($data_[0] == "skip") {
	
	$tmoil["mechs"][$from_id] += 1;
	SETJSON($tmoil); 
	
	$b=count($tmoil['db']["chs"]) - 1;
				
				if($tmoil['db']["chs"] != null){
					$bn = rand(0,$b) ;
$bv = $tmoil['db']["chs"][$bn] ;
					$ch2 = file_get_contents("https://api.telegram.org/bot". API_KEY. "/getChatMember?chat_id=@$bv&user_id=".$from_id);
$getch2 = json_decode(file_get_contents("http://api.telegram.org/bot". API_KEY. "/getChat?chat_id=@$bv"))->result;
$getN = $getch2->title;
if($getN == null) { $getN = "@$bv";}
if($tmoil["mechs"][$from_id] <= $b) {
					bot('editMessagetext',[
					
   'chat_id'=>$chat_id ,
   'message_id' => $message_id, 
   'text'=>"
اشترك فالقناة @$bv
  ", 
  'parse_mode'=>"markdown",
  'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$getN",'url'=>"https://t.me/$bv" ]], 
     [['text'=>"اشتركت ✅",'callback_data'=>"getv|$bv" ],['text'=>"ارسـال ابـلاغ ⚠️",'callback_data'=>"sendblock|$bv" ]],[['text'=>"$NamesBACK",'callback_data'=>"tobot" ]], 
       
      ]
    ])
]);
}
} 
} 
if($e[0] == "updates"){
	$req = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=status&order=".$e[1]));
$startcc = $req->start_count; 
$status = $req->remains; 
if($status == "0"){
	$sberero= "طلب مكتمل 🟢";
	}else{
		$sberero="قيد الانتضار ....";
		}
		bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
️⃣] معلومات عن الطلب :

- 🔡] اسم الخدمة : ".$rshq["ordn"][$e[1]]."
- 🛡] ايدي الطلب : `$e[1]`
- ♻️] حالة الطلب : $sberero
- ⏳] المتبقي : $status
  ", 
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>'تحديث' ,'callback_data'=>"updates|".$e[1]]],
     [['text'=>'رجوع' ,'callback_data'=>"tobot"]],
       
      ]
    ])
]);
	}
if($e[0] == "type"){
	
	if($e[1] == "thbt" or $e[1] == "mthbt" or $e[1] == "hq" ) {
		$typee = "متابعين" ;
		} elseif($e[1] == "view"){
			$typee = "مشاهدات";
			}elseif($e[1] == "like"){
				$typee = "لايكات";
				}
		
		if($e[1] == "thbt") {
			$s3r = 1;
			
			}
			if($e[1] == "mthbt") {
			$s3r = 2;
			}
			if($e[1] == "hq") {
			$s3r = 0.2;
			}
			if($e[1] == "view") {
			$s3r = 25;
			}
			
			if($e[1] == "like") {
			$s3r = 18;
			}
			
			if($rshq["s3rr"][$e[1]] !=null) {
			$s3r = $rshq["s3rr"][$e[1]] ;
			}
        
        $s3r = $rshq['S3RS'][explode("|",$data)[1]][explode("|",$data)[2]];
        $web = ($rshq['Web'][explode("|",$data)[1]][explode("|",$data)[2]]??$rshq["sSite"]) ;
        $s3r = ($s3r ?? "1");
        $key = ($rshq['key'][explode("|",$data)[1]][explode("|",$data)[2]] ?? $rshq["sToken"]);
        $mix = ($rshq['mix'][explode("|",$data)[1]][explode("|",$data)[2]] ?? "1000");
        $min = ($rshq['min'][explode("|",$data)[1]][explode("|",$data)[2]] ?? "100");
        $g= $s3r * 1000;
        $kli = "
        *
       👮🏽] اسم الخدمة : ".$rshq['xdmaxs'][explode("|",$data)[1]][explode("|",$data)[2]]."
       *

💰] السعر : ". $g ." نقطة لكل 1000

📊] الحد الادني للرشق : $min
🎟️] الحد الاقصي للرشق : $mix

🦾] ارسل الكمية التي تريد طلبها :

 
       ";
      
      $wsfer = $rshq['WSF'][explode("|",$data)[1]][explode("|",$data)[2]]??$kli;
      $tri = $abb = $rshq['wsfer'][explode("|",$data)[1]][explode("|",$data)[2]];
      if($tri == null){
        $tri = $kli;
      }

bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
$tri
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'رجوع' ,'callback_data'=>"SALEHENT"]],
]])
]);
$rshq['IDX'][$from_id]  =  $rshq['IDSSS'][explode("|",$data)[1]][explode("|",$data)[2]];
$rshq['WSFV'][$from_id]  =  $rshq['klishs'][explode("|",$data)[1]][explode("|",$data)[2]];
$rshq['S3RS'][$from_id]  =  $s3r;
$rshq['web'][$from_id]  =  $web;
$rshq['key'][$from_id]  =  $key;
$rshq['min_mix'][$from_id]  = "$min|$mix" ;
$rshq['SB1'][$from_id]  =  explode("|",$data)[1];
$modes['mode'][$from_id]  =  "SETd";
$rshq['SB2'][$from_id]  =  explode("|",$data)[2];
$rshq["="][$from_id] = $rshq['xdmaxs'][explode("|",$data)[1]][explode("|",$data)[2]];
SETJSON($rshq); SETJSON12($modes); 
} 

if($e[0] == "kmiat"){
	
	$s3r = $rshq['S3RS'][$from_id];
        $s3r = ($s3r ?? "1");
        $g= $s3r * 1000;

bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
👮🏽] اسم الخدمة : [".$rshq['xdmaxs'][explode("|",$data)[1]][explode("|",$data)[2]]."]

💰] السعر : ". $g ." نقطة لكل 1000

🦾] اختر الكمية التي تريد طلبها :
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
  [['text'=>'السعر' ,'callback_data'=>"type|$thbt"], ['text'=>'العدد' ,'callback_data'=>"type|$mthbt"]],
  [['text'=>"$ ".$nm.$s3r*1000,'callback_data'=>"to|1000|$e[1]"], ['text'=>'1000 $' ,'callback_data'=>"to|1000|$e[1]"]],
  [['text'=>"$ ".$nm.$s3r*2000,'callback_data'=>"to|2000|$e[1]"], ['text'=>'2000 $' ,'callback_data'=>"to|2000|$e[1]"]],
  [['text'=>"$ ".$nm.$s3r*4000,'callback_data'=>"to|4000|$e[1]"], ['text'=>'4000 $' ,'callback_data'=>"to|4000|$e[1]"]],
  [['text'=>"$ ".$nm.$s3r*8000,'callback_data'=>"to|8000|$e[1]"], ['text'=>'8000 $' ,'callback_data'=>"to|8000|$e[1]"]],
  [['text'=>"$ ".$nm.$s3r*10000,'callback_data'=>"to|10000|$e[1]"], ['text'=>'10000 $' ,'callback_data'=>"to|10000|$e[1]"]],
  [['text'=>"$ ".$nm.$s3r*20000,'callback_data'=>"to|20000|$e[1]"], ['text'=>'20000 $' ,'callback_data'=>"to|400|$e[1]"]],  
[['text'=>'رجوع' ,'callback_data'=>"type|". $rshq['SB1'][$from_id]."|".$rshq['SB2'][$from_id]]],
]])
]);
} 

if($data  == "tobon"){
  bot("deletemessage",["message_id" => $message_id,"chat_id" => $chat_id,]);
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"
 تم الالغاء بنجاح |
   ", 
   'parse_mode'=>"markdown",
 ]);
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"
مرحبا بك في بوت $nambot 💚

💠] نقاطك : $coin
🔮] ايديك : $chat_id
   ", 
   'parse_mode'=>"markdown",
   'reply_markup'=>json_encode($RSALEHO)
 ]);
 $rshq['3dd'][$from_id][$from_id]  = null;
    $modes['mode'][$from_id]  = null;
   
    $rshq["tlbia"][$from_id] = null;
    $rshq["cointlb"][$from_id] += null;
    $rshq["s3rltlb"][$from_id] = null;
    $rshq['tp'][$from_id] = null;
    $rshq['coinn'] = null;
SETJSON($rshq); SETJSON12($modes);
}

if(is_numeric($text) and $modes['mode'][$from_id]  ==  "SETd") {
  $s3r = $rshq['S3RS'][$from_id];
    $e[1] = $text;
    $s3r = $s3r * $text;
    $min = explode("|", $rshq['min_mix'][$from_id])[0];
    $mix = explode("|", $rshq['min_mix'][$from_id])[1];
	if($coin >= $s3r){
		if($rshq['Brook'] == "on" ) {
			if($text >= $min){
				if($text <= $mix){

$stb = $rshq['WSFV'][$from_id];
if($stb != null){
  $stb = "$stb";
}else{
  $stb = "• ارسل الرابط الخاص بك 📥 :";
}

			bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"

$stb

",
'reply_markup'=>json_encode([ 
  'inline_keyboard'=>[
  
  [['text'=>'رجوع + الغاء' ,'callback_data'=>"tobon"]],
  ]])
]);

$rshq['3dd'][$from_id][$from_id]  = $e[1];
    $modes['mode'][$from_id]  = "MJK";
   
    $rshq["tlbia"][$from_id] = $tlbia;
   
    $rshq["s3rltlb"][$from_id] = $s3r;
    $rshq['tp'][$from_id] = $e[2];
    $rshq['coinn'] = $s3r;
SETJSON($rshq); SETJSON12($modes);
return false ;
} else {
	bot('sendmessage',[
      'chat_id'=>$chat_id,
      'message_id'=>$message_id,
      'text'=>"
      *
      • العدد كبير جدا
      • ارسل عدد اصغر او يساوي $mix 😅
      *
      ",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode([ 
      'inline_keyboard'=>[
      
        [['text'=>'رجوع + الغاء' ,'callback_data'=>"tobon"]],
      ]])
      ]);
      return false ;
	} 
  } else {
    bot('sendmessage',[
      'chat_id'=>$chat_id,
      'message_id'=>$message_id,
      'text'=>"
      *
      • العدد صغير جدا 🤏
      • ارسل عدد اكبر من او يساوي $min 🎟️
      *
      ",
      'parse_mode'=>"markdown",
      'reply_markup'=>json_encode([ 
      'inline_keyboard'=>[
      
        [['text'=>'رجوع + الغاء' ,'callback_data'=>"tobon"]],
      ]])
      ]);
      return false ;
  }
} else {
	

    $key = ['inline_keyboard' => []];
	if($rshq['FREE'] != null) {
	$key['inline_keyboard'][] = [['text'=>"",'callback_data'=>"tmoile"]];
	} 
    $key['inline_keyboard'][] = [['text' => "$NamesBACK", 'callback_data' => "tobot"]];
	bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
$stopedkl
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($key)
]);
} 

} else {
	$s3r = $rshq['S3RS'][$from_id];
        $s3r = ($s3r ?? "1");
        $g= $s3r * $text ;

	bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
❌] عذرا ".$name3mla."ك غير كافيه
💰] سعر طلبك :". $g. " $name3mla


",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>'رجوع + الغاء' ,'callback_data'=>"tobon"]],
       
      ]
    ])
]);
return false ;
} 
} 

if($text and $modes['mode'][$from_id] == "MJK") {
    // التحقق من أن النص يحتوي على http أو https فقط
    if(strpos($text, "http") !== false || strpos($text, "https") !== false) {
    	$s3r = $rshq['S3RS'][$from_id];
        $s3r = ($s3r ?? "1");
        $g= $s3r * $rshq['3dd'][$from_id][$from_id]  ;
        $aer4 = $rshq['3dd'][$from_id][$from_id] ;
        $rf = rand(999,9999);
    bot('sendmessage',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"
💌] هل أنت متأكد 
----------------------------
🔐] ايدي الخدمة : $rf
🔰] الى : $text 
👥] الكمية : $aer4
        ",
'disable_web_page_preview' => true, 
        'reply_markup'=>json_encode([
             'inline_keyboard'=>[
             [['text'=>"موافق ✅",'callback_data'=>"YESS|$from_id" ]],
             [['text'=>"الغاء ❌",'callback_data'=>"tobot" ]],
               
              ]
            ])
        ]);
        $rshq['LINKS_$from_id'] = $text;
        $modes['mode'][$from_id] = "PROG";
        $rshq = json_encode($rshq, 32|128|265);
        file_put_contents("RSHQ/ALLS/". USR_BOT."/rshq.json", $rshq);
        file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json", json_encode($modes));
    } else {
        // إذا لم يكن الرابط يحتوي على http أو https يتم إظهار رسالة خطأ
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"
            ❌] الرابط غير صحيح، يجب أن يبدأ بـ http أو https.
            ",
            'parse_mode'=>"markdown"
        ]);
    }
}

$rshq["sSite"] = ($rshq['web'][$from_id]?? $rshq["sSite"]) ;
$Api_Tok = ($rshq['key'][$from_id]?? $rshq["sToken"]) ;
$rshqaft =$rshq['bot_tlb']+1;
$rnd = rand(9999999,9999999999);
if(explode("|",$data)[0] == "YESS" and $modes['mode'][$from_id]  == "PROG") {
	$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT."/rshq.json"),true);
  $rshq['S3RS'][$from_id] =  $rshq["s3rltlb"][$from_id]; 
      $inid = $rshq['IDX'][$from_id];
      $text = $rshq['LINKS_$from_id'];
      $web=$rshq['web'][$from_id] ;
$key=$rshq['key'][$from_id];
			$requst = json_decode(file_get_contents("https://".$web."/api/v2?key=$key&action=add&service=$inid&link=$text&quantity=". $rshq['3dd'][$from_id][$from_id]));
$idreq = $requst->order;

$ala3d = $rshq['3dd'][$from_id][$from_id];
$name = $message->from->first_name;

$no3 = $rshq["="][$from_id];
$tlbs = $bot_tlb +1;
$noe = $rshq["="][$from_id] ;
$s3rt = $rshq["s3rltlb"][$from_id];

setlocale(LC_TIME, 'ar_AE.utf8');

$date = strftime('%A %d %B %Y');

$rshq["coin"][$from_id] -=  $rshq["s3rltlb"][$from_id];

    $rshq['bot_tlb']+= 1;

$msg_orde = str_replace(
  array(
    '#name_user',
    '#username',
    '#name',
    '#coins',
    '#tlbs',
    '#shares',
    '#xtlb',
    'نقاط',
    
    '#idorder',
    '#type',
    '#count',
    '#price',

    '#id',
    '#linker'
  )
  ,
  array(
    "[$name](tg://user?id=$from_id)",
    "[$user_me]",
    $name,
    $rshq["coin"][$from_id]??"0",
    $rshq['bot_tlb'] ?? "0",
    $rshq["mshark"][$from_id] ?? "0",
    $rshq["tlby"][$from_id] ?? "0",
        $rshq["name3mla"] ?? "نقاط",

    $idreq,
    $noe,
    $ala3d,
    $s3rt,

    $from_id,
    "[$text]",
  )
  , $rshq["msgorde"]);

  if($rshq["msgorde"] == null ){
    $r09 = "✅] تم انشاء طلب بنجاح : 
        
🛡] ايدي الطلب : `". $idreq."`
🌐] تم الطلب الى : [$text]";
  }else{
    $r09 = "$msg_orde";
  }

	bot('editmessagetext',[
   'chat_id'=>$chat_id,
   "message_id" => $message_id,
   'text'=>"
$r09
  ",
  'disable_web_page_preview' => true, 
 'parse_mode'=>"markdown",

]);

bot('sendMessage',[
  'chat_id'=>$chat_id,
  'text'=>"
مرحبا بك في بوت $nambot 💚

💠] نقاطك : $coin
🔮] ايديك : $chat_id
 ", 
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode($RSALEHO)
]);


bot('sendMessage',[
   'chat_id'=>$admin,
   'text'=>"
♻️ تم الطلب من بوتــك 


🛡ايدي العضو  `$from_id`
💎 يوزره  [@$user]
💠 نقاطـه  ".$rshq["coin"][$from_id]."
🔰 ايدي الطلب  `$idreq`
⛔اسم الخدمه ~ *$noe*
⛔ الرابط ~ [$text]
🛡العـدد~ `$ala3d`
☣️تاريخ الطلب ~ $date
🗓️ وقت الطلب : ". date('H:i:s') ."

  ",
  'disable_web_page_preview' => true, 
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"ترجيع ".$name3mla."ه",'callback_data'=>"ins|$from_id|". $rshq['coinn']]],
     [['text'=>"طلب تعويض تلقائيا",'callback_data'=>"tEwth|$idreq"]],
     [['text'=>"تصفير ".$name3mla."ه",'callback_data'=>"msft|$from_id"]],
       
      ]
    ])
]);



$us = "[@".USR_BOT. "]" ;
$name = $update->callback_query->message->chat->first_name;

$msg_thbt = str_replace(
  array(
    '#name_user',
    '#username',
    '#name',
    '#coins',
    '#tlbs',
    '#shares',
    '#xtlb',
    'نقاط',
    
    '#idorder',
    '#type',
    '#count',
    '#price',

    '#id',
    '#linker'
  )
  ,
  array(
    "[$name](tg://user?id=$from_id)",
    "[$user_me]",
    $name,
    $rshq["coin"][$from_id]??"0",
    $rshq['bot_tlb'] ?? "0",
    $rshq["mshark"][$from_id] ?? "0",
    $rshq["tlby"][$from_id] ?? "0",
        $rshq["name3mla"] ?? "نقاط",

    $idreq,
    $noe,
    $ala3d,
    $s3rt,

    $from_id,
    "[$text]",
  )
  , $rshq["msgthbat"]);

  if($rshq["msgthbat"] != null){
    $mshm = $msg_thbt;
  }else{
    $mshm = "
  ✅ اكتمل طـلب الخدمة بنجاح .
- - - - - - - - - - - - - - - - - - 
🆔ايدي الطلب : `$idreq`
🗓️نوع الطلب : $noe
💰سعر الطلب : $s3rt
🛡العدد : $ala3d
🎫حساب المشتري : [$name](tg://user?id=$from_id)
📲الرقم التسلسلي للطلب : $tlbs
•┉ ┉ ┉ ┉ ┉ ┉ ┉ ┉ ┉ ┉ ┉┉ ┉•
    ";

  }
bot('sendMessage',[
   'chat_id'=>$rshq["sCh"],
   'text'=>"
$mshm
  ", 
  
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"خدمات $nambot ➢ 💎",'url'=>"https://t.me/". bot('getme')->result->username]],
       
      ]
    ])
]);
// --- بداية: كود حفظ الطلب الجديد ---
$new_order_data = [
    'id' => $idreq,           // ايدي الطلب
    'name' => $noe,           // اسم الخدمة
    'quantity' => $ala3d,     // العدد المطلوب
    'cost' => $s3rt,          // النقاط المدفوعة
    'link' => $text,          // الرابط
    'date' => date('Y-m-d H:i:s'), // تاريخ الطلب
    'api_site' => $web,       // الموقع المستخدم للطلب
    'api_key' => $key,        // المفتاح المستخدم للطلب
];
$tlbsme["orders"][$from_id][] = $new_order_data; // حفظ الطلب

$rshq['S3RS'][$from_id] = 0;
// --- نهاية: كود حفظ الطلب الجديد ---
$rshq["order"][$rnd]= $idreq;
$rshq["ordn"][$idreq]= $rshq["="][$from_id];
unset($rshq["sites"][$idreq]);
unset($rshq["keys"][$idreq]);
$rshq["tlby"][$from_id] += 1;
$rshq["cointlb"][$from_id] +=  $rshq["s3rltlb"][$from_id];
unset($rshq['3dd'][$from_id][$from_id]);
unset($modes['mode'][$from_id]);
    file_put_contents("RSHQ/ALLS/" . USR_BOT . "/tlbsme.json",json_encode($tlbsme));
SETJSON($rshq); SETJSON12($modes);  
file_put_contents("RSHQ/ALLS/". USR_BOT."/modes.json",json_encode($modes));
} 
 
if($e[0] == "msft" and $from_id == $admin) {
	$requst = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=refil&order=$e[1]"));
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"

تم تصفير ".$name3mla."ه ✅
ايديه : [$e[1]](tg://user?id=$e[1]])

",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
      ]
    ])
]);
$rshq["coin"][$e[1]] = 0;
SETJSON($rshq); SETJSON12($modes); 
	} 
	
if($e[0] == "tEwth" and $from_id == $admin) {
	$requst = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=refil&order=$e[1]"));
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"

تم طلب تعويض تلقائي للطلب
ايدي الطلب `$e[1]`

",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
      ]
    ])
]);
	} 
	
	if($e[0] == "sendrq" and $from_id == $admin) {
	$requst = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=refil&order=$e[1]"));
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"

تم طلب مراجعه طلبك بنجاح ✅
ايدي الطلب `$e[2]`

",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"tobot" ]],
       
      ]
    ])
]);

bot('sendMessage',[
   'chat_id'=>$admin,
   'text'=>"
طلب مراجعه للطلب عزيزي المطور ✨
- - - - - - - - - - - - - - - - - - 
ايدي الطلب : `". $e[2]. "`
الي داز الطلب : [$name](tg://user?id=$chat_id)
- - - - - - - - - - - - - - - - - - 
  ", 
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"ترجيع ".$name3mla."ه",'callback_data'=>"ins|$from_id|". $e[3]]],
       
      ]
    ])
]);
	} 

if($e[0] == "ins" and $from_id == $admin) {
	bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"

تم ارجاع $e[2] $name3mla لحساب [$e[1]](tg://user?id=$e[1])

",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[
     [['text'=>"$NamesBACK",'callback_data'=>"Brook" ]],
       
      ]
    ])
]);
$rshq["coin"][$e[1]] += $e[2];

$rshq["coinss"][$e[1]] += $e[2];
SETJSON($rshq); SETJSON12($modes);
	}
	
	
// ===========================================
//  (تحديث) 9. قائمة الخدمات الموحدة (الرئيسية)
// ===========================================
If($data == "joo") { // (تم تغيير الاسم حسب طلبك)
    
    $keyboard_buttons = [];
    
    // 1. زر خدمات الرشق (يظهر دائمًا)
    $keyboard_buttons[] = [['text'=>"الخدمات الرئيسيه 🛍️",'callback_data'=>"service" ]];
    
    // 2. زر الإعلانات (يظهر فقط لو الأدمن فاتحه)
    if (($rshq['ads']['status'] ?? 'off') == 'on') {
        $keyboard_buttons[] = [['text'=>"خدمات الإعلانات 📢",'callback_data'=>"post_ad_start" ]];
    }
    
    // 3. زر التمويل (يظهر فقط لو الأدمن فاتحه)
    if($rshq['FREE'] == "TR") { 
        $keyboard_buttons[] = [['text'=>"تمويل قناتك او مجموعه 👥",'callback_data'=>"tmoile" ]];
    }

    // (تعديل) تنظيم الأزرار كما طلبت (2 في صف واحد)
    $final_keyboard = [];
    $row1 = [];
    
    if (isset($keyboard_buttons[1])) { // إذا كان زر الإعلانات موجودًا
         $row1[] = $keyboard_buttons[1][0]; // زر الإعلانات
    }
    $row1[] = $keyboard_buttons[0][0]; // زر الخدمات الرئيسية
    $final_keyboard[] = $row1;
    
    if (isset($keyboard_buttons[2])) { // إذا كان زر التمويل موجودًا
        $final_keyboard[] = $keyboard_buttons[2];
    }
    
    $final_keyboard[] = [['text'=>"رجوع ",'callback_data'=>"tobot" ]];
    

    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"
        • مرحبا بك في قسم الخدمات ، اختر من بين الازرار ادناه 〽️
        ",
        'parse_mode'=>"markdown",
        'reply_markup'=>json_encode([
             'inline_keyboard'=> $final_keyboard // استخدام الأزرار المحدثة
        ])
    ]);
    exit; // (مهم جدًا إضافة exit هنا)
}

if ($data_[0] == "show_fundings") {
    $buttons = [];
    foreach ($tmoil['db']["chs"] as $chs) {
        $idM = $tmoil['chanels']["id_$chs"];
        $ci = $tmoil['db']["$idM"]["count"];
        $vx = $ci - $tmoil['db']["$idM"]["startc"];
        $buttons[] = [['text' => "- قناه @$chs 📤", 'callback_data' => "funding_info|$chs"]];
        $buttons[] = [['text' => "رجوع ♻️", 'callback_data' => "tmoil-Namero"]];
    }
    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "- القنوات الجاري تمويلها هنا 🛍
- يمكنك متابعه تمويلاتك من هنا من الاسفل 🛒",
        'reply_markup' => json_encode([
            'inline_keyboard' => $buttons
        ])
    ]);
}




<?php
error_reporting(0);
ob_start();
header("Content-Type: application/json; charset=UTF-8");
ob_start();
date_default_timezone_set('Asia/Baghdad');

$API_KEY = "8177219985:AAHii1xWe9tz3s-nHwfO5_7nUn8IgjnmfC4";
define('API_KEY', $API_KEY);
define("IDBot", explode(":", $API_KEY)[0]);

$sudo = 7328300457; // آيدي حسابك
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

// تفعيل الويب هوك بشكل آمن
if(isset($_GET['setup'])){
    echo file_get_contents("https://api.telegram.org/bot" . API_KEY . "/setwebhook?url=https://" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']);
    exit;
}


// مفاتيح التشفير للحماية (لا تقم بتغييرها بعد بدء استخدام البوت)
$SEC_KEY = "A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6"; // 32 حرف
$SEC_IV = "1234567890123456"; // 16 حرف

function encrypt_data($data) {
    global $SEC_KEY, $SEC_IV;
    $cipher = "aes-256-cbc";
    $encrypted = openssl_encrypt($data, $cipher, $SEC_KEY, 0, $SEC_IV);
    return base64_encode($SEC_IV . $encrypted);
}

function decrypt_data($data) {
    global $SEC_KEY;
    $cipher = "aes-256-cbc";
    $decoded = base64_decode($data);
    if ($decoded === false) return $data; 
    $iv = substr($decoded, 0, 16);
    $encrypted_text = substr($decoded, 16); 
    $decrypted = openssl_decrypt($encrypted_text, $cipher, $SEC_KEY, 0, $iv);
    return $decrypted ? $decrypted : $data;
}

function replaceTextInJson($data, $search, $replace) {
    foreach ($data as $key => $value) {
        if (is_array($value) || is_object($value)) {
            $data->$key = replaceTextInJson($value, $search, $replace);
        } else if (is_string($value)) {
            $data->$key = str_replace($search, $replace, $value);
        }
    }
    return $data;
}

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
// تم ترقيع ثغرة حقن المسار
define("USR_BOT", $usrbot);
$emoji = 
"➡️
🎟️
↪️
🔘
🏠
" ;
$emoji = explode ("\n", $emoji) ;
$b = $emoji[rand(0,4)];
$NamesBACK = "رجوع ➡️" ;
$rshq = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT. "/rshq.json"),true);
$modes = json_decode(file_get_contents("RSHQ/ALLS/". USR_BOT. "/modes.json"),true);



mkdir("RSHQ/ALLS") ;

function SETJSON($INPUT){
   if ($INPUT !== null && $INPUT !== "") {
       $file_path = "RSHQ/ALLS/" . USR_BOT . "/rshq.json";
 
       $backup_dir = "RSHQ/ALLS/" . USR_BOT . "/backup/";
       if (!is_dir($backup_dir)) {
           mkdir($backup_dir, 0777, true);
       }
 
       $backup_path = $backup_dir . "rshq_backup_" . time() . ".json";
       copy($file_path, $backup_path);
 
       $backup_files = glob($backup_dir . "rshq_backup_*.json");
       if (count($backup_files) > 1) {
           $last_backup = max($backup_files);
           unlink($last_backup);
       }
 
       $encoded_input = json_encode($INPUT, JSON_PRETTY_PRINT);
 
       $temp_path = $file_path . ".temp";
       file_put_contents($temp_path, $encoded_input);
 
       rename($temp_path, $file_path);
 
       // sleep(1);
 
       $max_file_size = 1 * 1024 * 1024 * 1024; 
       if (filesize($file_path) > $max_file_size) {
 
           $temp_path = "RSHQ/ALLS/" . USR_BOT . "/temp/rshq_temp_" . time() . ".json";
           rename($file_path, $temp_path);
       }
   }
 }
 
$updata = json_decode(file_get_contents('php://input'));
if(isset($updata->message)) {
$message = $updata->message;
$message_id = $message->message_id ?? null;
$username = $message->from->username ?? null;
$chat_id = $message->chat->id ?? null;
$title = $message->chat->title ?? null;
$text = $message->text ?? null;
$username = $message->from->username ?? null;
$name = $message->from->first_name ?? null;
$from_id = $message->from->id ?? null;
}

if(isset($updata->callback_query)) {
$data = $updata->callback_query->data ?? null;
$chat_id = $updata->callback_query->message->chat->id ?? null;
$title = $updata->callback_query->message->chat->title ?? null;
$message_id = $updata->callback_query->message->message_id ?? null;
$name = $updata->callback_query->message->chat->first_name ?? null;
$username = $updata->callback_query->message->chat->username ?? null;
$from_id = $updata->callback_query->from->id ?? null;
}
$name_tag  = "[$name](tg://user?id=$from_id)";
#==============================#
#The beginning of communications#
function GUID(){
if(function_exists('com_create_guid') === true){
return trim(com_create_guid(), '{}');
}
return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
function smsva(){
$head = array(
"Host: odpapp.asiacell.com",
"Accept: application/json",
"Cache-Control: no-cache",
"Content-Type: application/json",
"User-Agent: Mozilla/5.0 (iPad; CPU OS 15_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.2 Mobile/15E148 Safari/604.1",
);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://odpapp.asiacell.com/api/v1/login-screen?lang=ar");
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $head);
curl_setopt($curl, CURLOPT_HEADER, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
preg_match_all("/Cookie=[^;]+/", $result, $session_data);
return $session_data[0][0];
}
#طلب كود تحقق لرقم للادمن#
function sendCode($asiacell, $DeviceID, $Cookie, $username) {
global $asiacell;
$headers = array(
"Host: odpapp.asiacell.com",
'Cookie: ' . $Cookie,
'DeviceID: ' . $DeviceID,
"Connection: keep-alive",
"Accept: application/json",
"Cache-Control: no-cache",
"Content-Type: application/json",
"User-Agent: Mozilla/5.0 (iPad; CPU OS 15_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.2 Mobile/15E148 Safari/604.1",
);
$ch = curl_init();
curl_setopt_array($ch, [
CURLOPT_URL => 'https://odpapp.asiacell.com/api/v1/login?lang=ar',
CURLOPT_POST =>true,
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_HTTPHEADER => $headers,
CURLOPT_POSTFIELDS => '{"username":"' . $username . '","captchaCode":""}',
]);
$res = curl_exec($ch);
$response = json_decode($res, true);
if(isset($response['nextUrl'])) {
$nextUrl = $response['nextUrl'];
$PID = explode("PID=", $nextUrl)[1];
$asiacell['asiacell']["PID"] = $PID;
file_put_contents("Asiacell/".USR_BOT."/asiacell.json",json_encode($asiacell,128|32|256));
return [$nextUrl, $PID];
} else {
return false;
}
}
#طلب كود تحقق لرقم العضو#
function sendCodeTransfer($Transfer,$from_id,$Cookie,$DeviceID,$username) {
global $Transfer;
$headers = array(
"Host: odpapp.asiacell.com",
'Cookie: ' . $Cookie,
'DeviceID: ' . $DeviceID,
"Connection: keep-alive",
"Accept: application/json",
"Cache-Control: no-cache",
"Content-Type: application/json",
"User-Agent: Mozilla/5.0 (iPad; CPU OS 15_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.2 Mobile/15E148 Safari/604.1",
);
$ch = curl_init();
curl_setopt_array($ch, [
CURLOPT_URL => 'https://odpapp.asiacell.com/api/v1/login?lang=ar',
CURLOPT_POST =>true,
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_HTTPHEADER => $headers,
CURLOPT_POSTFIELDS => '{"username":"' . $username . '","captchaCode":""}',
]);
$res = curl_exec($ch);
$response = json_decode($res, true);
if(isset($response['nextUrl'])) {
$nextUrl = $response['nextUrl'];
$PID = explode("PID=", $nextUrl)[1];
$Transfer['Transfer'][$from_id]["PID"] = $PID;
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
return [$nextUrl, $PID];
} else {
return false;
}
}
#تسجيل الدخول الى الارقام#
function smsvalidation($session,$DeviceID,$PID,$passcode){
$headers = array(
"Host: odpapp.asiacell.com",
'Cookie: '.$session,
'DeviceID: '.$DeviceID,
"Connection: keep-alive",
"Accept: application/json",
"Cache-Control: no-cache",
"Content-Type: application/json",
"User-Agent: Mozilla/5.0 (iPad; CPU OS 15_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.2 Mobile/15E148 Safari/604.1",
);
$ch = curl_init();
curl_setopt_array($ch,[
CURLOPT_URL => 'https://odpapp.asiacell.com/api/v1/smsvalidation?lang=ar',
CURLOPT_POST =>true,
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_HTTPHEADER =>$headers,
CURLOPT_POSTFIELDS =>json_encode(array(
"PID"=>$PID,
"token"=>"",
"passcode"=>$passcode
)),
]);
$res = curl_exec($ch);
$response = json_decode($res, true);
if(isset($response)) {
return $response;
}
}
#املأ البطاقة تلقائيأ#
function top_up($Cookie,$DeviceID,$access_token,$voucher){
$headers = array(
"Host: odpapp.asiacell.com",
'Cookie: '.$Cookie,
'DeviceID: '.$DeviceID,
'Authorization: Bearer '.$access_token,
"Connection: keep-alive",
"Accept: application/json",
"Cache-Control: no-cache",
"Content-Type: application/json",
"User-Agent: Mozilla/5.0 (iPad; CPU OS 15_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.2 Mobile/15E148 Safari/604.1",
);
$ch = curl_init();
curl_setopt_array($ch,[
CURLOPT_URL=>'https://odpapp.asiacell.com/api/v1/top-up?lang=ar',
CURLOPT_POST=>true,
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_HTTPHEADER=>$headers,
CURLOPT_POSTFIELDS=>json_encode(array(
"voucher"=>$voucher,
"msisdn"=>"",
"rechargeType"=>1
)),
]);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
$decodedResponse = json_decode($response, true);
return $decodedResponse;
}
}
#عرض رصيد الرقم#
function getcredit($Cookie,$DeviceID,$access_token){
$headers = array(
"Host: odpapp.asiacell.com",
'Cookie: '.$Cookie,
'DeviceID: '.$DeviceID,
'Authorization: Bearer '.$access_token,
"Connection: keep-alive",
"Accept: application/json",
"Cache-Control: no-cache",
"Content-Type: application/json",
"User-Agent: Mozilla/5.0 (iPad; CPU OS 15_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.2 Mobile/15E148 Safari/604.1",
);
$url = 'https://odpapp.asiacell.com/api/v2/home?lang=ar';
$ch = curl_init();
curl_setopt_array($ch, [
CURLOPT_URL => $url,
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_HTTPHEADER => $headers,
]);
$response = curl_exec($ch);
curl_close($ch);
if ($response !== false) {
$decodedResponse = json_decode($response, true);
return $decodedResponse;
}
}
#ارسال كود التحقق لرقم العضو عند ارسال عدد الامول#
function credittransfer($Cookie,$DeviceID,$access_token,$ph,$amount){
$headers = array(
"Host: odpapp.asiacell.com",
'Cookie: '.$Cookie,
'DeviceID: '.$DeviceID,
'Authorization: Bearer '.$access_token,
"Connection: keep-alive",
"Accept: application/json",
"Cache-Control: no-cache",
"Content-Type: application/json",
"User-Agent: Mozilla/5.0 (iPad; CPU OS 15_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.2 Mobile/15E148 Safari/604.1",
);
$ch = curl_init();
curl_setopt_array($ch, [
CURLOPT_URL => 'https://odpapp.asiacell.com/api/v1/credit-transfer/start?lang=ar',
CURLOPT_POST =>true,
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_HTTPHEADER => $headers,
CURLOPT_POSTFIELDS =>'{"amount": '.$amount.',"receiverMsisdn": "0'.$ph.'"}'
]);
$response = curl_exec($ch);
curl_close($ch);
if ($response !== false){
$decodedResponse = json_decode($response, true);
return $decodedResponse;
}
}
#تاكد من عملية التحويل ناجحة او لا#
function dotransfer($PID,$Cookie,$DeviceID,$access_token,$passcode) {
$headers = array(
"Host: odpapp.asiacell.com",
'Cookie: '.$Cookie,
'DeviceID: '.$DeviceID,
'Authorization: Bearer '.$access_token,
"Connection: keep-alive",
"Accept: application/json",
"Cache-Control: no-cache",
"Content-Type: application/json",
"User-Agent: Mozilla/5.0 (iPad; CPU OS 15_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.2 Mobile/15E148 Safari/604.1",
);
$ch = curl_init();
curl_setopt_array($ch, [
CURLOPT_URL => 'https://odpapp.asiacell.com/api/v1/credit-transfer/do-transfer?lang=ar',
CURLOPT_POST =>true,
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_HTTPHEADER => $headers,
CURLOPT_POSTFIELDS => json_encode(array(
"pid"=>$PID,
"passcode"=>$passcode,
)),
]);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false) {
$decodedResponse = json_decode($response, true);
return $decodedResponse;
}
}
#==============================#
mkdir("Asiacell");
mkdir("Asiacell/".USR_BOT);
mkdir("data");
mkdir("data/".USR_BOT);
$z_Bots  = json_decode(file_get_contents("data/".USR_BOT."/z_Bots.json"),true);
function z_Bots($array){
$F = "data/".USR_BOT."/z_Bots.json";
$N = json_encode($array,64|128|256);   
file_put_contents($F, $N, LOCK_EX);
}
$klesha_1 = $z_Bots['klesha_1'] ?? "لم يتم تعين";
$rabet = $z_Bots['klesha'] ?? "https://t.me/STrillion";
$wakel = $z_Bots['wakel'] ?? "https://t.me/STrillion";
$asiacell = json_decode(file_get_contents("Asiacell/".USR_BOT."/asiacell.json"),true);
$asiacellph = isset($asiacell['asiacell']["ph"]) ? $asiacell['asiacell']["ph"] : "لايوجد";
$Set = json_decode(file_get_contents("Asiacell/".USR_BOT."/Set.json"),true);
$Transfer = json_decode(file_get_contents("Asiacell/".USR_BOT."/Transfer.json"),true);
#==============================#
$admin = $explodedAPI[1];
$HaSo_id = "7328300457";
$admins = array("$admin","$HaSo_id");
$members = file_get_contents("data/".USR_BOT."/members.txt");
$count = explode("\n",$members);
$count_1 = count($count) ?? "0";
if($message and !in_array($from_id,$count)){
file_put_contents("data/".USR_BOT."/members.txt",$from_id . "\n" ,FILE_APPEND);
$count_1 = $count_1 + 1;
foreach($admins as $s){
bot('sendmessage',[
'chat_id'=>$s,
'text'=>"
*٭ تم دخول شخص جديد الى البوت الخاص بك 👾*
            -----------------------
• معلومات العضو الجديد .

• الاسم : [$name](tg://user?id=$from_id)
• المعرف : [@$username] .
• الايدي : [$from_id](tg://user?id=$from_id)
            -----------------------
• عدد الاعضاء الكلي :* $count_1*
",
'disable_web_page_preview'=>'true',
'parse_mode'=>'markdown',
]);
}
}
#كود توجية جميع الميديا#
if($updata and !$data and $chat_id != $admin){
if($chat_id != $admin){
if($chat_id != $HaSo_id){
bot('forwardMessage', [
'chat_id'=>$admin,
'from_chat_id'=>$chat_id,
'message_id'=>$updata->message->message_id
]);
}
}
} 
if($updata and $chat_id == $admin){
bot('copyMessage',[
'chat_id'=>$message->reply_to_message->forward_from->id,
'from_chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
#==============================#
$Host_api = "رابط";
function z_add($id,$c){
global $Host_api;
return file_get_contents($Host_api . "?pass=12345&id=".$id."&add=".$c); 
}
function z_coin($id){
global $Host_api;
return file_get_contents($Host_api . "?pass=123&id=".$id)['coin']; 
}


$rshqFile = "RSHQ/ALLS/" . USR_BOT . "/rshq.json";


$rshq = json_decode(file_get_contents($rshqFile), true);
$coin = $rshq["coin"][$chat_id]??"0";
$start =
"مرحباً بك في بوت شحن RASHKM  
نقاطك : ". $coin ."
";
#==============================#
if($text == "/start" and in_array($chat_id,$admins)){
   $key = $asiacell['asiacell']["ph"];
$numbers = $asiacell["sessions:$key"];
// فك التشفير قبل الاستخدام
$Cookie = decrypt_data($numbers["Cookie"]); 
$DeviceID = $numbers["DeviceID"]; 
$PID = $numbers["PID"]; 
$access_token = decrypt_data($numbers["access_token"]);
$getcredit = getcredit($Cookie,$DeviceID,$access_token);
$mainBalance = $getcredit["watch"]["information"]["mainBalance"] ?? "0";
$mainBalance = str_replace(" IQD","",$mainBalance);
$expiryDate = $getcredit["watch"]["information"]["expiryDate"];
if(!$asiacell['asiacell']["ph"]){
$s = "
- لم يتم تسجيل رقم الهاتف للادمن ؟
";
}else{
$s = "رقم الهاتف : `$key`
رصيدك : $mainBalance 
";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
قسم التحكم الخاص ببوت الشحن الخاص بك .

$s
",
"disable_web_page_preview"=>true,
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
   [['text'=>"تعيين رقم الهاتف",'callback_data'=>"AddAsiacell"]],
[['text'=>"تعيين رابط ( الشرح )",'callback_data'=>"klesha"],['text'=>"تعيين رابط ( الوكيل )",'callback_data'=>"wakel"]],
]])
]);
}
if($data == "Basis" and in_array($chat_id,$admins)){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
قسم التحكم الخاص ببوت الشحن الخاص بك .

$s
",
"disable_web_page_preview"=>true,
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
   [['text'=>"تعيين رقم الهاتف",'callback_data'=>"AddAsiacell"]],
[['text'=>"تعيين رابط ( الشرح )",'callback_data'=>"klesha"],['text'=>"تعيين رابط ( الوكيل )",'callback_data'=>"wakel"]],
]])
]);
}
#==============================#

#كود اضافة التالي#
$ex = explode("|", $data);

if($data == 'wakel'){
   bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
أرسل رابط الوكيل الأن :
",
"disable_web_page_preview"=>true,
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
   [['text'=>"رجوع",'callback_data'=>"Basis"]],
]])
]);
$z_Bots[$chat_id]['member'] = "$data";
z_Bots($z_Bots);
}
if($text and $z_Bots[$chat_id]['member'] == 'wakel'){
   bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"
- تم حفظ الرابط ( الوكيل ) .
",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"Basis"]],
]])
]); 
unset($z_Bots[$chat_id]['member']);
$z_Bots['wakel'] = "$text";

z_Bots($z_Bots); 
}
if($data == "klesha") {
$z = "- ارسل الرابط :";
}

$z_1 = $z_Bots[$chat_id]['member'];
if($data == "klesha") {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
$z
",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"Basis"]],
]])
]); 
$z_Bots[$chat_id]['member'] = "$ex[1]";
z_Bots($z_Bots);
}
if($text and $z_1 == "klesha" or $z_1 == "klesha_1" and in_array($chat_id,$admins)){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"
- تم حفظ الرابط ( الشرح ) .
",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"Basis"]],
]])
]);   
unset($z_Bots[$chat_id]['member']);
$z_Bots[$z_1] = $text;
z_Bots($z_Bots);
}

#تسجيل الدخول الئ الرقم الذي سوف يتم استلام الاموال عليه#
if($data == "AddAsiacell"){
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
ارسل رقم الهاتف الان لاستلام الرصيد :
[077********]
",
'parse_mode'=>'markdown',
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"Basis"]],
]])
]);
$asiacell['asiacell']["set"] = "SetNum";
file_put_contents("Asiacell/".USR_BOT."/asiacell.json",json_encode($asiacell,128|32|256));
}
if(!$data and $text and is_numeric($text) and $asiacell['asiacell']['set'] == "SetNum"){
$DeviceID = GUID();
$Cookie = smsva();
$FUN = sendCode($asiacell,$DeviceID,$Cookie,$text);
if($FUN[0] && $FUN[1]){
$asiacell['asiacell']["Cookie"] = $Cookie;
$asiacell['asiacell']["DeviceID"] = $DeviceID;
$asiacell['asiacell']["ph"] = $text;
$asiacell['asiacell']["set"] = "6Code";
file_put_contents("Asiacell/".USR_BOT."/asiacell.json",json_encode($asiacell,128|32|256));
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
أرسل رمز تسجيل الدخول الذي تم أرساله الى هاتفك :
", 
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"Basis"]],
]])
]);
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"🚫 حاول مره اخرى", 
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"Basis"]],
]])
]);
unset($asiacell['asiacell']["set"]);
file_put_contents("Asiacell/".USR_BOT."/asiacell.json",json_encode($asiacell,128|32|256));
}
}
if(strlen($text) == 6){
if($text && is_numeric($text)){
if($asiacell['asiacell']['set'] == "6Code"){
$arrayinfo = smsvalidation($asiacell['asiacell']["Cookie"],$asiacell['asiacell']["DeviceID"],$asiacell['asiacell']["PID"],$text);
$ph = $asiacell['asiacell']["ph"];
if($arrayinfo["access_token"]){
$s = "
Done Login | تسجيل دخول ناجح 
";
}else{
$s = "
Failed To Login | فشل تسجيل الدخول
";
}
if($arrayinfo["access_token"]){
$getcredit = getcredit($asiacell['asiacell']["Cookie"],$asiacell['asiacell']["DeviceID"],$asiacell['asiacell']["access_token"]);
$mainBalance = $getcredit["watch"]["information"]["mainBalance"] ?? "0";
$rsed = str_replace(" IQD","",$mainBalance);
$ph = $asiacell['asiacell']["ph"];
bot('sendmessage',[
'chat_id'=>$chat_id,
"text"=>"$s",
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"Basis"]],
]])
]);
$arrayinfo["PID"] = $asiacell['asiacell']["PID"];
$arrayinfo["ph"] = $asiacell['asiacell']["ph"];
$arrayinfo["DeviceID"] = $asiacell['asiacell']["DeviceID"];
$arrayinfo["Cookie"] = $asiacell['asiacell']["Cookie"];

// -- بداية التشفير --
$arrayinfo["access_token"] = encrypt_data($arrayinfo["access_token"]);
$arrayinfo["Cookie"] = encrypt_data($arrayinfo["Cookie"]);
// -- نهاية التشفير --

$asiacell["sessions:".$asiacell['asiacell']["ph"]] = $arrayinfo;
unset($asiacell['asiacell']["set"]);
file_put_contents("Asiacell/".USR_BOT."/asiacell.json",json_encode($asiacell,128|32|256));
}
}
}
}
#==============================#
#رسالة البدء#
if(preg_match('/\/(start)(.*)/',$text)){
    $coin = z_coin($from_id);
    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "$start",
        'parse_mode' => 'markdown',
        'disable_web_page_preview' => 'true',
        'reply_markup' => json_encode([ 
            'inline_keyboard' => [
                [['text' => "TeleStars - نجوم تلكرام", 'callback_data' => "teles"]],
                [['text' => "AsiaCell - اسياسيل", 'callback_data' => "GetNum_Asia"]],
                [['text' => "أسعار النقاط 💠", 'callback_data' => "prices"]],
                [['text' => "طريقه أستخدام البوت ⁉️", 'url' => "$rabet"]],
                [['text' => "شراء النقاط من الوكيل", 'url' => "$wakel"]],
            ]
        ])
    ]);
}

if($data == "Back"){
    bot('editMessageText',[
        'chat_id' => $from_id,
        'message_id' => $message_id,
        'text' => "$start",
        'parse_mode' => 'markdown',
        'disable_web_page_preview' => 'true',
        'reply_markup' => json_encode([ 
            'inline_keyboard' => [
                [['text' => "TeleStars - نجوم تلكرام", 'callback_data' => "teles"]],
                [['text' => "AsiaCell - اسياسيل", 'callback_data' => "GetNum_Asia"]],
                [['text' => "أسعار النقاط 💠", 'callback_data' => "prices"]],
                [['text' => "طريقه أستخدام البوت ⁉️", 'url' => "$rabet"]],
                [['text' => "شراء النقاط من الوكيل", 'url' => "$wakel"]],
            ]
        ])
    ]);
    unset($Set['Set'][$from_id]);
    file_put_contents("Set.json", json_encode($Set, JSON_PRETTY_PRINT));
    unset($Transfer['Transfer'][$from_id]["addfunds"]);
    file_put_contents("Transfer.json", json_encode($Transfer, JSON_PRETTY_PRINT));
}

if($data == "teles"){
    bot('sendMessage', [
    'chat_id' => $from_id,
    'text' => "• الشحن عن طريق النجوم مربوط بحساب [$name]",
    'parse_mode' => 'markdown',
    'disable_web_page_preview' => 'true',
    'reply_markup' => json_encode([ 
        'keyboard' => [
            [['text' => "شحن 300 نقطه"]],
            [['text' => "شحن 1000 نقطه"]],
            [['text' => "شحن 5000 نقطه"]],
            [['text' => "شحن 10000 نقطه"]],
            [['text' => "شحن 15000 نقطه"]],
            [['text' => "شحن 20000 نقطه"]],
            [['text' => "شحن 25000 نقطه"]],
            [['text' => "شحن 30000 نقطه"]],
            [['text' => "رجوع"]],
        ],
        'resize_keyboard' => true,  // This makes the keyboard smaller and easier to use
        'one_time_keyboard' => true  // Keyboard hides after one use
    ])
]);

    unset($Set['Set'][$from_id]);
    file_put_contents("Set.json", json_encode($Set, JSON_PRETTY_PRINT));
    unset($Transfer['Transfer'][$from_id]["addfunds"]);
    file_put_contents("Transfer.json", json_encode($Transfer, JSON_PRETTY_PRINT));
}

function rand_text(){
    $abc = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0");
    $fol = '#'.$abc[rand(5,36)].$abc[rand(5,36)].$abc[rand(5,36)].$abc[rand(5,36)].$abc[rand(5,36)].$abc[rand(5,36)].$abc[rand(5,36)].$abc[rand(5,36)].$abc[rand(5,36)].$abc[rand(5,36)];
    return $fol;
   
}
$h = explode("sh7n5|", $data)[1];
$up = file_get_contents('php://input');
$update = json_decode($up);
if ($update->message) {
    $message = $update->message;
    $chat_id = $message->chat->id;
    $text = $message->text;
    $extext = explode(" ", $text);
    $first_name = $update->message->from->first_name;
    $username = $message->from->username;
    $id = $message->from->id;
    $message_id = $message->message_id;
    $entities = $message->entities;
    $language_code = $message->from->language_code;
    $tc = $update->message->chat->type;
    $re_message = $update->message->reply_to_message;
    $re_text = $re_message->text;

if ($text) {
    if (preg_match("/شحن/", $text)) {
        preg_match('/\d+/', $text, $matches);

        // عدد النقاط المطلوب شحنها
        $number = $matches[0];
        
        // حساب النجوم المطلوبة بناءً على 78 نجمة = 5000 نقطة
        $SALEH = $number * (78 / 5000);
        
        // تقريب عدد النجوم المطلوبة إلى عدد صحيح
        $amount = ceil($SALEH);
        
        // تجهيز الفاتورة المطلوبة
        $LabeledPrice = json_encode([
            [
                'label' => "شحن نقاط تلقائي | Bero",
                'amount' => $amount * 100 // تحويل المبلغ إلى النظام الفرعي للوحدة النقدية
            ]
        ]);
        
        // إرسال الفاتورة
        bot('sendInvoice', [
            'chat_id' => $chat_id,
            'title' => "شحن نقاط تلقائي | Bero",
            'description' => "لشحن نقاط البوت اكمل الدفع التالي لتحويل النقاط اليك",
            'payload' => $number,
            'provider_token' => "",  // أضف توكن الدفع هنا
            'start_parameter' => "",
            'currency' => "XTR",  // أضف العملة المناسبة
            'prices' => $LabeledPrice,
        ]);
    }
}

if($message->successful_payment) {
    $currency = $message->successful_payment->currency;
    $total_amount = $message->successful_payment->total_amount;
    $hlkd = $message->successful_payment->invoice_payload;
    $telegram_payment_charge_id = $message->successful_payment->telegram_payment_charge_id;

    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "🔼تم شحن $hlkd نقطة",
        'parse_mode' => "markdown",
    ]);

    $rshq["coin"][$chat_id] += $hlkd;
    SETJSON($rshq);

    bot('sendMessage', [
        'chat_id' => $admin,
        'text' => "
        عملية شراء ناجحة
        [$first_name](tg://user?id=$id) - @$username
        >> $total_amount 🌟
        ",
        'parse_mode' => "markdown",
    ]);
}
} 

if($update->pre_checkout_query){
    $id_query = $update->pre_checkout_query->id;
    $invoice_payload = $update->pre_checkout_query->invoice_payload;
    bot('answerPreCheckoutQuery', [
        'pre_checkout_query_id' => $id_query,
        'ok' => true
    ]);
}


if($data == "prices") {
   if( $rshq['buy'] == null){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
💰] $name3mla بوت الشحن 

1$ = 5000 نقطة
2$ = 10000 نقطة
3$ = 15000 نقطة
4$ = 20000 نقطة
5$ = 25000 نقطة
10$ = 50000 نقطة
15$ = 75000 نقطة
20$ = 100000 نقطة
25$ = 125000 نقطة

- [@DMM2M]
- [@STrillion]

",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
     'inline_keyboard'=>[

     [['text'=>"رجوع",'callback_data'=>"Back" ]],
       
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


#==============================#
if($data == "treqo"){
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
$klesha
",
'parse_mode'=>'markdown',
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>'Back']],
]])
]);
unset($Set['Set'][$from_id]);
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
unset($Transfer['Transfer'][$from_id]["addfunds"]);
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
}
if($data == "aschar"){
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
$klesha_1
",
'parse_mode'=>'markdown',
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>'Back']],
]])
]);
unset($Set['Set'][$from_id]);
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
unset($Transfer['Transfer'][$from_id]["addfunds"]);
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
}
#==============================#
if($data == "Driqa_Dfch"){
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
*• حسناً, الان اختر طريقة الدفع :*
",
'parse_mode'=>'markdown',
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"AsiaCell - اسياسيل",'callback_data'=>"GetNum_Asia"]],
[['text'=>"رجوع",'callback_data'=>'Back']],
]])
]);
unset($Set['Set'][$from_id]);
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
unset($Transfer['Transfer'][$from_id]["addfunds"]);
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
}
#==============================#
if($data == "GetNum_Asia"){
$key = $Transfer['Transfer'][$from_id]["ph"];
$numbers = $Transfer["sessions:".$from_id.":".$key];
$Cookie = decrypt_data($numbers["Cookie"]); 
$DeviceID = $numbers["DeviceID"]; 
$access_token = decrypt_data($numbers["access_token"]);
$getcredit = getcredit($Cookie,$DeviceID,$access_token);
$mainBalance = $getcredit["watch"]["information"]["mainBalance"] ?? "0";
$mainBalance = str_replace(" IQD","",$mainBalance);
if($Transfer['Transfer'][$from_id]["ph"]){
if(!getcredit($Cookie,$DeviceID,$access_token)["watch"]["information"]["mainBalance"]){

bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
ارسل رقمك مثل :
[077********]
",
'parse_mode'=>'markdown',
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"Back"]],
]])
]);
$Set['Set'][$from_id] = "Transfer";
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
$key = $Transfer['Transfer'][$from_id]["ph"];
unset($Transfer["sessions:".$from_id.":".$key]);
unset($Transfer['Transfer'][$from_id]["ph"]);
unset($Transfer['Transfer'][$from_id]["PID"]);
unset($Transfer['Transfer'][$from_id]["DeviceID"]);
unset($Transfer['Transfer'][$from_id]["Cookie"]);
unset($Transfer['Transfer'][$from_id]["access_token"]);
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
}
}
if($Transfer['Transfer'][$from_id]["ph"]){
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
معلومات الرقم :

رصيدك : $mainBalance
رقمك : $key
",
'parse_mode'=>'markdown',
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"تحويل رصيد",'callback_data'=>"SetTransfer"]],
[['text'=>"كارت رصيد",'callback_data'=>"SetAsiacell"]],
[['text'=>"الغاء الرقم 🚫",'callback_data'=>'Exit_1']],
[['text'=>"رجوع",'callback_data'=>'Back']],
]])
]);
unset($Set['Set'][$from_id]);
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
unset($Transfer['Transfer'][$from_id]["addfunds"]);
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
}else{
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
ارسل رقمك مثل :
[077********]
",
'parse_mode'=>'markdown',
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"Back"]],
]])
]);
$Set['Set'][$from_id] = "Transfer";
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
}
} 
if($data == "SetTransfer"){
$sw = $Transfer["sessions:".$from_id.":".$Transfer['Transfer'][$from_id]["ph"]];
$Cookie = decrypt_data($sw['Cookie']);
$DeviceID = $sw['DeviceID'];
$access_token = decrypt_data($sw['access_token']);
if(!$Transfer['Transfer'][$from_id]["ph"]){
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
*• حسنأ, ارسل رقمك الاسياسيل مثل :*

[077********]
",
'parse_mode'=>'markdown',
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]);
$Set['Set'][$from_id] = "Transfer";
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
}else {
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
يمكنك اضافة من 1 الى 60 اسياسيل
ارسل الرقم المراد اضافته :
",
'parse_mode'=>'MarkDown',
'reply_markup' =>json_encode([
'inline_keyboard'=>[

[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]);
$Set['Set'][$from_id] = "setnumb";
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
}
}
if(!$data and is_numeric($text) and $Set['Set'][$from_id] == "Transfer"){
$DeviceID = GUID();
$Cookie = smsva();
$FUN = sendCodeTransfer($Transfer,$from_id,$Cookie,$DeviceID,$text);
if($FUN[0] && $FUN[1]){
$Transfer['Transfer'][$from_id]["Cookie"] = $Cookie;
$Transfer['Transfer'][$from_id]["DeviceID"] = $DeviceID;
$Transfer['Transfer'][$from_id]["ph"] = $text;
$Transfer['Transfer'][$from_id]["set"] = "Transfer6Code";
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
أرسل رمز تسجيل الدخول الذي تم أرساله الى هاتفك :
", 
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]);
unset($Set['Set'][$from_id]);
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
🚫 حاول مره اخرى
", 
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]);
}
}
if(strlen($text) == 6){
if($text && is_numeric($text)){
if($Transfer['Transfer'][$from_id]["set"] == "Transfer6Code"){
$arrayinfo = smsvalidation($Transfer['Transfer'][$from_id]["Cookie"],$Transfer['Transfer'][$from_id]["DeviceID"],$Transfer['Transfer'][$from_id]["PID"],$text);

$getcredit = getcredit($Transfer['Transfer'][$from_id]["Cookie"],$Transfer['Transfer'][$from_id]["DeviceID"],$Transfer['Transfer'][$from_id]["access_token"]);
$mainBalance = $getcredit["watch"]["information"]["mainBalance"] ?? "0";
$mainBalance = str_replace(" IQD","",$mainBalance);
if($arrayinfo["access_token"]){
bot('sendmessage',[
'chat_id'=>$chat_id,
"text"=>"
معلومات الرقم :

رصيدك : $mainBalance 
رقمك : ". $Transfer['Transfer'][$from_id]["ph"] ."
",
'parse_mode'=>'MarkDown',
'disable_web_page_preview'=>'true',
'reply_markup' =>json_encode([
'inline_keyboard'=>[
   [['text'=>"تحويل رصيد",'callback_data'=>"SetTransfer"]],
   [['text'=>"كارت رصيد",'callback_data'=>"SetAsiacell"]],
   [['text'=>"الغاء الرقم 🚫",'callback_data'=>'Exit_1']],
   [['text'=>"رجوع",'callback_data'=>'Back']],
]])
]);
$arrayinfo["PID"] = $Transfer['Transfer'][$from_id]["PID"];
$arrayinfo["ph"] = $Transfer['Transfer'][$from_id]["ph"];
$arrayinfo["DeviceID"] = $Transfer['Transfer'][$from_id]["DeviceID"];
$arrayinfo["Cookie"] = $Transfer['Transfer'][$from_id]["Cookie"];

// -- تشفير بيانات الأعضاء --
$arrayinfo["access_token"] = encrypt_data($arrayinfo["access_token"]);
$arrayinfo["Cookie"] = encrypt_data($arrayinfo["Cookie"]);

$Transfer["sessions:".$from_id.":".$Transfer['Transfer'][$from_id]["ph"]] = $arrayinfo;
unset($Transfer['Transfer'][$from_id]["PID"]);
unset($Transfer['Transfer'][$from_id]["set"]);
unset($Transfer['Transfer'][$from_id]["DeviceID"]);
unset($Transfer['Transfer'][$from_id]["Cookie"]);
unset($Transfer['Transfer'][$from_id]["access_token"]);
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
} else {
bot('sendmessage',[
'chat_id'=>$chat_id,
"text"=>"
🚫 حاول مره اخرى
",
'parse_mode'=>'MarkDown',
'disable_web_page_preview'=>'true',
'reply_markup' =>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]); 
unset($Transfer['Transfer'][$from_id]["PID"]);
unset($Transfer['Transfer'][$from_id]["set"]);
unset($Transfer['Transfer'][$from_id]["DeviceID"]);
unset($Transfer['Transfer'][$from_id]["Cookie"]);
unset($Transfer['Transfer'][$from_id]["access_token"]);
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
} 
} 
}
}
#==============================#
if(is_numeric($text) and $Set['Set'][$from_id] == 'setnumb'){
$addfunds[0] = $text;
$addfunds[1] = $text;
if($data && $addfunds[0] == "addfunds" && $addfunds[1]){
$key = $Transfer['Transfer'][$from_id]["ph"];
$ph = $asiacell['asiacell']["ph"];
$numbers = $Transfer["sessions:".$from_id.":".$key];
$Cookie = decrypt_data($numbers["Cookie"]); 
$DeviceID = $numbers["DeviceID"]; 
$access_token = decrypt_data($numbers["access_token"]);
$PID = credittransfer($Cookie,$DeviceID,$access_token,$ph,$addfunds[1]);
if($PID["success"] == true){
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
أرسل رمز التحويل الذي تم أرساله الى هاتفك :
",
'parse_mode'=>'MarkDown',
'disable_web_page_preview'=>'true',
'reply_markup' =>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]);
unset($Set['Set'][$from_id]);
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
$Transfer['Transfer'][$from_id]["addfunds"]["amount"] = $addfunds[1];
$Transfer['Transfer'][$from_id]["addfunds"]["using"] = "addfunds";
$Transfer['Transfer'][$from_id]["addfunds"]["PID"] = $PID["PID"];
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
} else {
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
🚫 حاول مره اخرى
",
'parse_mode'=>'MarkDown',
'reply_markup' =>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]);
unset($Set['Set'][$from_id]);
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
}
}
}
if(strlen($text) >= 5){
if($text && is_numeric($text)){
if($Transfer['Transfer'][$from_id]["addfunds"]["using"] == "addfunds"){
$key = $Transfer['Transfer'][$from_id]["ph"];
$numbers = $Transfer["sessions:".$from_id.":".$key];
$Cookie = decrypt_data($numbers["Cookie"]); 
$DeviceID = $numbers["DeviceID"]; 
$access_token = decrypt_data($numbers["access_token"]);
$PID = $Transfer['Transfer'][$from_id]["addfunds"]["PID"];
$getcredit = getcredit($Cookie,$DeviceID,$access_token);
$mainBalance = $getcredit["watch"]["information"]["mainBalance"] ?? "0";
$IQD = str_replace(" IQD","",$mainBalance);
$message = dotransfer($PID,$Cookie,$DeviceID,$access_token,$text);
if($message["success"] == true){
$x = $Transfer['Transfer'][$from_id]["addfunds"]["amount"];
$x = $x."000";
if($x == "5000"){
$d = "1$";
}
elseif($x == "10000"){
$d = "2$";
}
elseif($x == "15000"){
$d = "3$";
}
elseif($x == "20000"){
$d = "4$";
}
elseif($x == "25000"){
$d = "5$";
}
elseif($x == "30000"){
$d = "6$";
}
elseif($x == "35000"){
$d = "7$";
}
elseif($x == "40000"){
$d = "8$";
}
elseif($x == "45000"){
$d = "9$";
}
elseif($x == "50000"){
$d = "10$";
}
elseif($x == "55000"){
$d = "11$";
}
elseif($x == "60000"){
$d = "12$";
}
elseif($x == "65000"){
$d = "13$";
}
elseif($x == "70000"){
$d = "14$";
}
elseif($x == "75000"){
$d = "15$";
}
elseif($x == "80000"){
$d = "16$";
}
elseif($x == "85000"){
$d = "17$";
}
elseif($x == "90000"){
$d = "18$";
}
elseif($x == "95000"){
$d = "19$";
}
elseif($x == "100000"){
$d = "20$";
}
elseif($x == "105000"){
$d = "21$";
}
elseif($x == "110000"){
$d = "22$";
}
elseif($x == "115000"){
$d = "23$";
}
elseif($x == "120000"){
$d = "24$";
}
elseif($x == "125000"){
$d = "25$";
}
elseif($x == "130000"){
$d = "26$";
}
elseif($x == "135000"){
$d = "27$";
}
elseif($x == "140000"){
$d = "28$";
}
elseif($x == "29000"){
$d = "29$";
}
elseif($x == "30000"){
$d = "30$";
}
elseif($x == "31000"){
$d = "31$";
}
elseif($x == "32000"){
$d = "32$";
}
elseif($x == "33000"){
$d = "33$";
}
elseif($x == "34000"){
$d = "34$";
}
elseif($x == "35000"){
$d = "35$";
}
elseif($x == "36000"){
$d = "36$";
}
elseif($x == "37000"){
$d = "37$";
}
elseif($x == "38000"){
$d = "38$";
}
elseif($x == "39000"){
$d = "39$";
}
elseif($x == "40000"){
$d = "40$";
}
elseif($x == "41000"){
$d = "41$";
}
elseif($x == "42000"){
$d = "42$";
}
elseif($x == "43000"){
$d = "43$";
}
elseif($x == "44000"){
$d = "44$";
}
elseif($x == "45000"){
$d = "45$";
}
elseif($x == "46000"){
$d = "46$";
}
elseif($x == "47000"){
$d = "47$";
}
elseif($x == "48000"){
$d = "48$";
}
elseif($x == "49000"){
$d = "49$";
}
elseif($x == "50000"){
$d = "50$";
}
elseif($x == "51000"){
$d = "51$";
}
elseif($x == "52000"){
$d = "52$";
}
elseif($x == "53000"){
$d = "53$";
}
elseif($x == "54000"){
$d = "54$";
}
elseif($x == "55000"){
$d = "55$";
}
elseif($x == "56000"){
$d = "56$";
}
elseif($x == "57000"){
$d = "57$";
}
elseif($x == "58000"){
$d = "58$";
}
elseif($x == "59000"){
$d = "59$";
}
elseif($x == "60000"){
$d = "60$";
}
$d = str_replace('$','',$d);

 
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
تم شحن $d نقطه بنجاح ✅
",
'parse_mode'=>'markdown',
'reply_to_message_id'=>$message_id,
]);
$rshq["coin"][$from_id] += $d;
SETJSON($rshq);
$s = $message["success"];
foreach($admins as $s){
bot('sendmessage',[
'chat_id'=>$s,
'text'=>"
المستخدم : $name_tag .
قام بتعبئة : *$x*
تم تسليمه : $d نقطه
",
'parse_mode'=>'markdown',
]);
unset($Transfer['Transfer'][$from_id]["addfunds"]["amount"]);
unset($Transfer['Transfer'][$from_id]["addfunds"]["PID"]);
unset($Transfer['Transfer'][$from_id]["addfunds"]["using"]);
unset($Transfer['Transfer'][$from_id]["addfunds"]);
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
}
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
"text"=>"
🚫 حاول مره اخرى
",
'parse_mode'=>'markdown',
'disable_web_page_preview'=>'true',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]);
unset($Transfer['Transfer'][$from_id]["addfunds"]["amount"]);
unset($Transfer['Transfer'][$from_id]["addfunds"]["PID"]);
unset($Transfer['Transfer'][$from_id]["addfunds"]["using"]);
unset($Transfer['Transfer'][$from_id]["addfunds"]);
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
}
} 
}
} 
#==============================#
if($data == "SetAsiacell"){
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
"text"=>"
حسناً، قم بأرسال رقم بطاقة التعبئة :
        
يجب ان يكون مكون من 13 او 14 رقم
",
'parse_mode'=>'markdown',
'disable_web_page_preview'=>'true',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]);
$Set['Set'][$from_id] = "Charge";
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
}
if(strlen($text) >= 13 and $Set['Set'][$from_id] == "Charge"){
if($text && is_numeric($text)){
if($Set['Set'][$from_id] == "Charge"){
$Msg = bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"حسناً، جاري فحص الكارت الان ⏳ ...

- 🚸 ملاحظة تعبئة الكارت قد تتأخر قليلاً من 1 دقيقة الى 5 دقائق بسبب بعد السيرفرات",
'reply_to_message_id'=>$message_id, 
'parse_mode'=>'markdown',
]);
$key = $asiacell['asiacell']["ph"];
$numbers = $asiacell["sessions:$key"];
// فك التشفير قبل الاستخدام
$Cookie = decrypt_data($numbers["Cookie"]); 
$DeviceID = $numbers["DeviceID"]; 
$PID = $numbers["PID"]; 
$access_token = decrypt_data($numbers["access_token"]);
$getcredit = getcredit($Cookie,$DeviceID,$access_token);
$mainBalance = $getcredit["watch"]["information"]["mainBalance"] ?? "0";
$getFirst = str_replace(" IQD","",$mainBalance);
if(isset($getFirst)){
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$Msg->result->message_id,
'text'=>"🚫 حاول مره اخرى",
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]);
$ph = $asiacell['asiacell']["ph"];
foreach($admins as $s){
bot('sendmessage',[
'chat_id'=>$s,
"text"=>"
*• عذراً, يبدو انه هناك مشكله في الاتصال الى الرقم :* `$ph` .

*• يرجى اعادة تعيين رقم الهاتف مره اخرى .*
",
'parse_mode'=>'markdown',
]);
}
} 
$topmessage = top_up($Cookie,$DeviceID,$access_token,$text);
if($topmessage and $topmessage["success"] == true){
$key = $asiacell['asiacell']["ph"];
$numbers = $asiacell["sessions:$key"];
// فك التشفير قبل الاستخدام
$Cookie = decrypt_data($numbers["Cookie"]); 
$DeviceID = $numbers["DeviceID"]; 
$PID = $numbers["PID"]; 
$access_token = decrypt_data($numbers["access_token"]);
$getcredit = getcredit($Cookie,$DeviceID,$access_token);
$mainBalance = $getcredit["watch"]["information"]["mainBalance"] ?? "0";
$getSecond = str_replace(" IQD","",$mainBalance);
$CountCharge = ($getSecond - $getFirst);
if($CountCharge == "1"){
$d = "1$";
}
elseif($CountCharge == "2"){
$d = "2$";
}
elseif($CountCharge == "3"){
$d = "3$";
}
elseif($CountCharge == "4"){
$d = "4$";
}
elseif($CountCharge == "5"){
$d = "5$";
}
elseif($CountCharge == "6"){
$d = "6$";
}
elseif($CountCharge == "7"){
$d = "7$";
}
elseif($CountCharge == "8"){
$d = "8$";
}
elseif($CountCharge == "9"){
$d = "9$";
}
elseif($CountCharge == "10"){
$d = "10$";
}
elseif($CountCharge == "11"){
$d = "11$";
}
elseif($CountCharge == "12"){
$d = "12$";
}
elseif($CountCharge == "13"){
$d = "13$";
}
elseif($CountCharge == "14"){
$d = "14$";
}
elseif($CountCharge == "15"){
$d = "15$";
}
elseif($CountCharge == "16"){
$d = "16$";
}
elseif($CountCharge == "17"){
$d = "17$";
}
elseif($CountCharge == "18"){
$d = "18$";
}
elseif($CountCharge == "19"){
$d = "19$";
}
elseif($CountCharge == "20"){
$d = "20$";
}
elseif($CountCharge == "21"){
$d = "21$";
}
elseif($CountCharge == "22"){
$d = "22$";
}
elseif($CountCharge == "23"){
$d = "23$";
}
elseif($CountCharge == "24"){
$d = "24$";
}
elseif($CountCharge == "25"){
$d = "25$";
}
elseif($CountCharge == "26"){
$d = "26$";
}
elseif($CountCharge == "27"){
$d = "27$";
}
elseif($CountCharge == "28"){
$d = "28$";
}
elseif($CountCharge == "29"){
$d = "29$";
}
elseif($CountCharge == "30"){
$d = "30$";
}
elseif($CountCharge == "31"){
$d = "31$";
}
elseif($CountCharge == "32"){
$d = "32$";
}
elseif($CountCharge == "33"){
$d = "33$";
}
elseif($CountCharge == "34"){
$d = "34$";
}
elseif($CountCharge == "35"){
$d = "35$";
}
elseif($CountCharge == "36"){
$d = "36$";
}
elseif($CountCharge == "37"){
$d = "37$";
}
elseif($CountCharge == "38"){
$d = "38$";
}
elseif($CountCharge == "39"){
$d = "39$";
}
elseif($CountCharge == "40"){
$d = "40$";
}
elseif($CountCharge == "41"){
$d = "41$";
}
elseif($CountCharge == "42"){
$d = "42$";
}
elseif($CountCharge == "43"){
$d = "43$";
}
elseif($CountCharge == "44"){
$d = "44$";
}
elseif($CountCharge == "45"){
$d = "45$";
}
elseif($CountCharge == "46"){
$d = "46$";
}
elseif($CountCharge == "47"){
$d = "47$";
}
elseif($CountCharge == "48"){
$d = "48$";
}
elseif($CountCharge == "49"){
$d = "49$";
}
elseif($CountCharge == "50"){
$d = "50$";
}
elseif($CountCharge == "51"){
$d = "51$";
}
elseif($CountCharge == "52"){
$d = "52$";
}
elseif($CountCharge == "53"){
$d = "53$";
}
elseif($CountCharge == "54"){
$d = "54$";
}
elseif($CountCharge == "55"){
$d = "55$";
}
elseif($CountCharge == "56"){
$d = "56$";
}
elseif($CountCharge == "57"){
$d = "57$";
}
elseif($CountCharge == "58"){
$d = "58$";
}
elseif($CountCharge == "59"){
$d = "59$";
}
elseif($CountCharge == "60"){
$d = "60$";
}
$d = str_replace('$','',$d);
$s = $topmessage["message"];
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$Msg->result->message_id,
'text'=>"
تم شحن $d نقطه بنجاح ✅
",
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]);
$rshq["coin"][$from_id] += $d;
SETJSON($rshq);
unset($Set['Set'][$from_id]);
file_put_contents("Asiacell/".USR_BOT."/Set.json",json_encode($Set,128|32|256));
foreach($admins as $s){
bot('sendmessage',[
'chat_id'=>$s,
'text'=>"
المستخدم : $name_tag .
قام بتعبئة : *$CountCharge*
تم تسليمه : $d نقطه
",
'parse_mode'=>'markdown',
]);
}
}else{
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$Msg->result->message_id,
'text'=>"حدث خطأ اثناء تعبئة الكارت ❌",
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"GetNum_Asia"]],
]])
]);
}
}
}
}else{
  
}
if($data == "Exit_1"){
bot('answercallbackquery',[
'callback_query_id'=>$updata->callback_query->id,
'text'=>"تم الغاء الرقم",
'show_alert'=>'true',
]);
$key = $Transfer['Transfer'][$from_id]["ph"];
unset($Transfer["sessions:".$from_id.":".$key]);
unset($Transfer['Transfer'][$from_id]["ph"]);
unset($Transfer['Transfer'][$from_id]["PID"]);
unset($Transfer['Transfer'][$from_id]["DeviceID"]);
unset($Transfer['Transfer'][$from_id]["Cookie"]);
unset($Transfer['Transfer'][$from_id]["access_token"]);
file_put_contents("Asiacell/".USR_BOT."/Transfer.json",json_encode($Transfer,128|32|256));
bot('editmessagetext',[
   'chat_id'=>$from_id,
   'message_id'=>$message_id,
   'text'=>"$start",
   'parse_mode'=>'markdown',
   'disable_web_page_preview'=>'true',
   'reply_markup'=>json_encode([ 
   'inline_keyboard'=>[
      [['text'=>"AsiaCell - اسياسيل",'callback_data'=>"GetNum_Asia"]],
      [['text'=>"أسعار النقاط 💠",'callback_data'=>"prices"]],
      [['text'=>"قناة البوت",'url'=>"https://t.me/STrillion"]],
      [['text'=>"شراء النقاط من الوكيل",'url'=>"https://t.me/DMM2M"]],
   ]])
   ]);
unset($Set['Set'][$from_id]);
file_put_contents("Set.json",json_encode($Set,128|32|256));
unset($Transfer['Transfer'][$from_id]["addfunds"]);
file_put_contents("Transfer.json",json_encode($Transfer,128|32|256));
}

?>
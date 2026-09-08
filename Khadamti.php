<?php
ob_start();
error_reporting(0);
// ضع توكن البوت الخاص بك بين علامتي التنصيص
define('API_KEY', '8177219985:AAE5Lyk7RA5RuQ22cpIh1BJtBp-EX7oc3Ls'); 

// ضع الآيدي الخاص بك هنا بدلاً من الرقم الموجود
$saleh = 7328300457;

function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}
}

$usrbot = bot("getme")->result->username;
include ("admin.php"); 
include ("azrar.php"); 
$bot_id = bot("getme")->result->id;
define("IDBot",$bot_id);
define("USR_BOT",$usrbot);

function initDatabase($bot_id){
$dir = __DIR__ . "/databases/$bot_id/";
if(!file_exists($dir)) mkdir($dir,0777,true);
return [
'settings' => new SQLite3($dir . "settings.db"),
'services' => new SQLite3($dir . "services.db"),
'orders' => new SQLite3($dir . "orders.db"),
'funding' => new SQLite3($dir . "funding.db"),
'codes' => new SQLite3($dir . "codes.db"),
'users' => new SQLite3($dir . "users.db"),
'backup' => new SQLite3($dir . "backup.db")
];
}

$db = initDatabase($bot_id);

foreach($db as $name => $conn){
$conn->exec("CREATE TABLE IF NOT EXISTS data (key TEXT PRIMARY KEY, value TEXT)");
}

function getData($db, $key) {
$stmt = $db->prepare("SELECT value FROM data WHERE key = :key");
$stmt->bindValue(':key', $key, SQLITE3_TEXT);
$result = $stmt->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);
if ($row) {
return json_decode($row['value'], true);
}
return null;
}

function setData($db, $key, $value) {
$json = json_encode($value);
$stmt = $db->prepare("INSERT OR REPLACE INTO data (key, value) VALUES (:key, :value)");
$stmt->bindValue(':key', $key, SQLITE3_TEXT);
$stmt->bindValue(':value', $json, SQLITE3_TEXT);
$stmt->execute();
}

$rshq = getData($db['settings'], 'rshq');
if(!$rshq) $rshq = [];
$tmoil = getData($db['funding'], 'tmoil');
if(!$tmoil) $tmoil = [];
$modes = getData($db['settings'], 'modes');
if(!$modes) $modes = [];
$SALEH = getData($db['settings'], 'saleh');
if(!$SALEH) $SALEH = [];
$timer = getData($db['settings'], 'timer');
if(!$timer) $timer = [];

if(!isset($tmoil['db'])) $tmoil['db'] = [];
if(!isset($tmoil['db']['chs'])) $tmoil['db']['chs'] = [];
if(!isset($tmoil['chanels'])) $tmoil['chanels'] = [];
if(!isset($tmoil['sets'])) $tmoil['sets'] = [];
if(!isset($tmoil['blockers'])) $tmoil['blockers'] = [];
if(!isset($tmoil['blocks'])) $tmoil['blocks'] = [];
if(!isset($tmoil['chids'])) $tmoil['chids'] = [];
if(!isset($tmoil['info'])) $tmoil['info'] = [];
if(!isset($tmoil['funding_terms'])) $tmoil['funding_terms'] = "📋 شروط التمويل:\n1. يجب أن يكون البوت مشرفاً في قناتك\n2. الحد الأدنى للتمويل هو {min_count} عضو\n3. سعر العضو الواحد {price} {currency}\n4. يتم خصم الرصيد فور إنشاء الطلب\n5. لا يمكن استرجاع الرصيد بعد إنشاء الطلب";
if(!isset($modes['mode'])) $modes['mode'] = [];

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

if(!isset($timer['TIME'])) $timer['TIME'] = [];
if(!isset($timer['acount'])) $timer['acount'] = [];

if($update->callback_query){
if( $timer['TIME'][$from_id] >= date("h:s")){
$data = $update->callback_query->data;
$chat_id = $update->callback_query->message->chat->id;
$title = $update->callback_query->message->chat->title;
$message_id = $update->callback_query->message->message_id;
$name = $update->callback_query->message->chat->first_name;
$user = $update->callback_query->message->chat->username;
$from_id = $update->callback_query->from->id;
$timer['TIME'][$from_id] = date("h:s");
setData($db['settings'], 'timer', $timer);
}
}

if(!isset($rshq['api_users'])) $rshq['api_users'] = [];
if(!isset($rshq['api_orders'])) $rshq['api_orders'] = [];

function generateApiKey($user_id) {
return hash('sha256', $user_id . time() . bin2hex(random_bytes(16)));
}

function getUserByApiKey($key, $rshq) {
foreach($rshq['api_users'] as $uid => $data) {
if($data['key'] == $key) return $uid;
}
return null;
}

function getDomain() {
$domain = $_SERVER['HTTP_HOST'];
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
return "$protocol://$domain";
}

$asia_settings = $rshq['asia_settings'] ?? [];
if(empty($asia_settings)){
$asia_settings = ['receive_number' => '', 'points_per_asia' => 1, 'status' => 'on'];
$rshq['asia_settings'] = $asia_settings;
setData($db['settings'], 'rshq', $rshq);
}
$asia_receive_number = $asia_settings['receive_number'] ?? '';
$points_per_asia = $asia_settings['points_per_asia'] ?? 1;
$asia_status = $asia_settings['status'] ?? 'on';
define('ASIA_API_KEY', '1ccbc4c913bc4ce785a0a2de444aa0d6');

$stars_settings = $rshq['stars_settings'] ?? [];
if(empty($stars_settings)){
$stars_settings = ['points_per_star' => 10, 'status' => 'on'];
$rshq['stars_settings'] = $stars_settings;
setData($db['settings'], 'rshq', $rshq);
}
$points_per_star = $stars_settings['points_per_star'] ?? 10;
$stars_status = $stars_settings['status'] ?? 'on';

$chnl = $rshq["sCh"];
$Api_Tok = $rshq["sToken"];
$dqiq = date('i');
$s = date('s');

if($update->callback_query){
if ($timer["acount"][$from_id] < time()) {
if($update->callback_query->message->chat->id != $saleh and $update->callback_query->message->chat->id != $saleh) {
$data = $update->callback_query->data;
$chat_id = $update->callback_query->message->chat->id;
$title = $update->callback_query->message->chat->title;
$message_id = $update->callback_query->message->message_id;
$name = $update->callback_query->message->chat->first_name;
$user = $update->callback_query->message->chat->username;
$from_id = $update->callback_query->from->id;
} else{
$data = $update->callback_query->data;
$chat_id = $update->callback_query->message->chat->id;
$title = $update->callback_query->message->chat->title;
$message_id = $update->callback_query->message->message_id;
$name = $update->callback_query->message->chat->first_name;
$user = $update->callback_query->message->chat->username;
$from_id = $update->callback_query->from->id;
}
}
}

function checkAndRefundRejectedOrders(&$rshq, &$db, $saleh, $currency_name) {
if(!isset($rshq['pending_orders']) || !is_array($rshq['pending_orders'])) {
$rshq['pending_orders'] = [];
}
$updated = false;
foreach($rshq['pending_orders'] as $order_id => $order) {
if($order['status'] == 'pending') {
$site = $order['site'] ?? $rshq["sSite"];
$api_key = $order['api_key'] ?? $rshq["sToken"];
$req = @json_decode(@file_get_contents("https://$site/api/v2?key=$api_key&action=status&order=".$order['service_order_id']));
if($req && isset($req->status)) {
if($req->status == 'canceled' || $req->status == 'error' || $req->status == 'refunded') {
$user_id = $order['user_id'];
$points = $order['points'];
if(!isset($rshq["coin"][$user_id])) $rshq["coin"][$user_id] = 0;
$rshq["coin"][$user_id] += $points;
$rshq['pending_orders'][$order_id]['status'] = 'refunded';
$refund_message = "❌ تم رفض طلبك واسترداد رصيدك\n🆔 ايدي الطلب: $order_id\n💰 المبلغ المسترد: $points $currency_name\n💳 رصيدك الحالي: {$rshq["coin"][$user_id]} $currency_name";
bot('sendMessage',['chat_id' => $user_id, 'text' => $refund_message, 'parse_mode' => "markdown"]);
bot('sendMessage',['chat_id' => $saleh, 'text' => "🔄 تم استرداد نقاط للمستخدم $user_id\n📦 ايدي الطلب: $order_id\n💰 المبلغ: $points $currency_name", 'parse_mode' => "markdown"]);
$updated = true;
} elseif($req->status == 'completed') {
$rshq['pending_orders'][$order_id]['status'] = 'completed';
$updated = true;
}
}
}
}
if($updated) {
setData($db['settings'], 'rshq', $rshq);
}
}

checkAndRefundRejectedOrders($rshq, $db, $saleh, $currency_name);

$rsedi = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=balance"));
$flos = $rsedi->balance;
$treqa = $rsedi->currency;

if($rshq['currency'] == null){
$rshq['currency'] = "نقاط";
setData($db['settings'], 'rshq', $rshq);
}
$currency_name = $rshq['currency'];
$developer_id = $rshq['developer_id'] ?? $saleh;

$adm = [
'inline_keyboard'=>[
[['text'=>"الاعدادات العامة ️",'callback_data'=>"general_settings"]],
[['text'=>"اعدادات الشحن بينانس ",'callback_data'=>"binance_section"]],
[['text'=>"اعدادات الشحن ",'callback_data'=>"asia_admin_settings"],['text'=>"‍ تعيين المطور",'callback_data'=>"set_developer"]],
[['text'=>"قسم الرشق ",'callback_data'=>"qsmsa"],["text" => "ماركت البوت","callback_data"=>"market_sections"]],
[['text'=>"الهدايا والتحويلات ",'callback_data'=>"gift_settings"],['text'=>"التحكم في الرشق",'callback_data'=>"rshq_toggle"]],
[['text'=>"تعيين موقع الرشق",'callback_data'=>"infoRshq"],['text'=>"التحكم بالنقاط",'callback_data'=>"member_control"]],
[['text'=>"اعدادات التمويل ",'callback_data'=>"admin_funding_settings"],['text'=>"قنوات البوت ",'callback_data'=>"admin_bot_channels"]],
[['text'=>"النسخ الاحطياطي",'callback_data'=>"backup_panel"]],
[['text'=>'رجوع' ,'callback_data'=>"setting"]],
]
];

$general_settings = [
'inline_keyboard'=>[
[['text'=>"تعيين عمله البوت ",'callback_data'=>"set_currency"],['text'=>"تعيين اقل حد للتحويل ",'callback_data'=>"sAKTHAR"]],
[['text'=>"تعيين عدد نقاط المشاركه ",'callback_data'=>"setshare"],['text'=>"تعيين قناة الاثباتات ",'callback_data'=>"sCh"]],
[['text'=>"تعيين اسم البوت 🏷️",'callback_data'=>"setname"]],
[['text'=>"تعيين كليشه الشروط ",'callback_data'=>"settext"],['text'=>"تعيين كليشه الشراء ",'callback_data'=>"setbuy"]],
[['text'=>"كليشه الاثبات في القنوات ",'callback_data'=>"set_channel_proof"]],
[['text'=>'رجوع' ,'callback_data'=>"rshqG"]],
]
];

$funding_settings = [
'inline_keyboard'=>[
[['text'=>"فتح التمويل 🔓",'callback_data'=>"funding_toggle_on"], ['text'=>"قفل التمويل 🔒",'callback_data'=>"funding_toggle_off"]],
[['text'=>"تعيين شروط التمويل 📜",'callback_data'=>"set_funding_terms"]],
[['text'=>"تعيين ادنى حد للتمويل 🔻",'callback_data'=>"set_min_funding"]],
[['text'=>"تعيين سعر العضو 💰",'callback_data'=>"set_funding_price"]],
[['text'=>"تعيين نقاط الاشتراك في القنوات 🎁",'callback_data'=>"set_join_points"]],
[['text'=>"تعيين نقاط خصم المغادرة ⚠️",'callback_data'=>"set_leave_penalty"]],
[['text'=>"ادارة قنوات التمويل ",'callback_data'=>"admin_funding_panel"]],
[['text'=>"الاستعلام عن قناة ",'callback_data'=>"query_funding_channel"]],
[['text'=>'رجوع' ,'callback_data'=>"rshqG"]],
]
];

$gift_settings = [
'inline_keyboard'=>[
[['text'=>"فتح الهديه اليومي 🎁",'callback_data'=>"onhdia"], ['text'=>"قفل الهديه اليومي 🔒",'callback_data'=>"ofhdia"]],
[['text'=>"تعيين عدد الهديه 🔢",'callback_data'=>"sethdia"]],
[['text'=>"صنع كود هديه 🆕",'callback_data'=>"hdiamk"]],
[['text'=>"فتح التحويل 🔓",'callback_data'=>"open_transfer"], ['text'=>"قفل التحويل 🔒",'callback_data'=>"close_transfer"]],
[['text'=>"تعيين اقل حد للتحويل 🔻",'callback_data'=>"set_min_transfer"]],
[['text'=>"🎮 تعيين جائزة اللعبة",'callback_data'=>"set_game_reward"]],
[['text'=>'رجوع' ,'callback_data'=>"rshqG"]],
]
];

$member_control = [
'inline_keyboard'=>[
[['text'=>"اضافه او خصم رصيد ➕➖",'callback_data'=>"coins"]],
[['text'=>"تصفير نقاط شخص 🗑️",'callback_data'=>"msfrn"]],
[['text'=>"معلومات العضو 📋",'callback_data'=>"member_info"]],
[['text'=>"اخر 5 طلبات للعضو 📝",'callback_data'=>"member_orders"]],
[['text'=>'رجوع' ,'callback_data'=>"rshqG"]],
]
];

$asia_admin_menu = [
'inline_keyboard'=>[
[['text'=>"فتح الشحن اسياسيل",'callback_data'=>"asia_status_on"], ['text'=>"قفل الشحن اسياسيل",'callback_data'=>"asia_status_off"]],
[['text'=>"رقم الاستلام",'callback_data'=>"set_asia_number"]],
[['text'=>"سعر النقاط اسياسيل",'callback_data'=>"set_asia_points"]],
[['text'=>"فتح الشحن نجوم",'callback_data'=>"stars_status_on"], ['text'=>"قفل الشحن نجوم",'callback_data'=>"stars_status_off"]],
[['text'=>"سعر النجمة",'callback_data'=>"set_stars_points"]],
[['text'=>"رجوع",'callback_data'=>"rshqG"]],
]
];

$admnb = [
'inline_keyboard'=>[
[['text'=>'رجوع' ,'callback_data'=>"rshqG"]],
]
];

if($data == "set_developer"){
$key = ['inline_keyboard' => []];
$current_dev = $rshq['developer_id'] ?? $saleh;
$key['inline_keyboard'][] = [['text' => "➕ تعيين مطور جديد", 'callback_data' => "set_new_developer"]];
$key['inline_keyboard'][] = [['text' => "📋 عرض المطور الحالي", 'callback_data' => "show_current_developer"]];
$key['inline_keyboard'][] = [['text' => "🗑 حذف المطور", 'callback_data' => "remove_developer"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "rshqG"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*👨‍💻 اعدادات المطور\n\nالمطور الحالي: `$current_dev`*\n\nيمكنك تعيين مطور جديد للبوت (يمكنه استلام اشعارات الطلبات والنسخ الاحتياطي)",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if($data == "set_new_developer"){
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*👨‍💻  ارسل ايدي المطور: 123456789*\n\n⚠️ ملاحظة: هذا الشخص سيستلم اشعارات الطلبات والنسخ الاحتياطي",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "• رجوع •", 'callback_data' => "set_developer"]]]]),
]);
$rshq['mode'][$from_id] = "waiting_developer_username";
setData($db['settings'], 'rshq', $rshq);
}

if($data == "show_current_developer"){
$current_dev = $rshq['developer_id'] ?? $saleh;
$user_info = bot('getChat', ['chat_id' => $current_dev]);
$user_name = $user_info->result->first_name ?? 'غير معروف';
$user_username = $user_info->result->username ?? 'لا يوجد';
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*👨‍💻 المطور الحالي\n\n🆔 الايدي: `$current_dev`\n📛 الاسم: $user_name\n👤 اليوزر: @$user_username*\n\nجميع اشعارات الطلبات والنسخ الاحتياطي تصل لهذا الشخص",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "• رجوع •", 'callback_data' => "set_developer"]]]]),
]);
}

if($data == "remove_developer"){
$rshq['developer_id'] = $saleh;
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*✅ تم حذف المطور وعودة الصلاحيات للمطور الاساسي `$saleh`*",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "• رجوع •", 'callback_data' => "set_developer"]]]]),
]);
}

if($text and $rshq['mode'][$from_id] == "waiting_developer_username"){
$input = trim($text);
$user_id = null;
if(preg_match('/^@([a-zA-Z0-9_]+)$/', $input, $matches)){
$username = $matches[1];
$user_info = bot('getChat', ['chat_id' => "@$username"]);
if($user_info && isset($user_info->result->id)){
$user_id = $user_info->result->id;
} else {
bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ لم يتم العثور على المستخدم @$username\nتأكد من صحة اليوزر", 'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "set_developer"]]]])]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
exit;
}
} elseif(is_numeric($input)){
$user_id = (int)$input;
$user_info = bot('getChat', ['chat_id' => $user_id]);
if(!$user_info || !isset($user_info->result->id)){
bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ لا يوجد مستخدم بهذا الايدي `$user_id`", 'parse_mode' => "markdown", 'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "set_developer"]]]])]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
exit;
}
} else {
bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ يرجى ارسال يوزر صحيح مع @ او ارسال ايدي رقمي", 'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "set_developer"]]]])]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
exit;
}
$rshq['developer_id'] = $user_id;
setData($db['settings'], 'rshq', $rshq);
$user_name = $user_info->result->first_name ?? 'المستخدم';
bot('sendMessage', [
'chat_id' => $chat_id,
'text' => "✅ *تم تعيين $user_name كمطور جديد للبوت*\n\n🆔 الايدي: `$user_id`\n\nجميع اشعارادات الطلبات والنسخ الاحتياطي سترسل لهذا الشخص",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "• رجوع •", 'callback_data' => "set_developer"]]]]),
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "asia_admin_settings"){
$status_text = ($asia_status == "on") ? "✅ مفعل" : "❌ معطل";
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"اعدادات الشحن آسياسيل\nالحالة: $status_text\nرقم الاستلام: ".($asia_receive_number ?: "غير محدد")."\nسعر النقاط: $points_per_asia نقطة لكل 1 آسياسيل",'parse_mode'=>"markdown",'reply_markup'=>json_encode($asia_admin_menu)]);
}

if($data == "asia_status_on"){
$rshq['asia_settings']['status'] = "on";
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"✅ تم فتح الشحن",'reply_markup'=>json_encode($asia_admin_menu)]);
}

if($data == "asia_status_off"){
$rshq['asia_settings']['status'] = "off";
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"❌ تم قفل الشحن",'reply_markup'=>json_encode($asia_admin_menu)]);
}

if($data == "set_asia_number"){
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"ارسل رقم الاستلام",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"asia_admin_settings"]]]])]);
$rshq['mode'][$from_id] = "set_asia_number";
setData($db['settings'], 'rshq', $rshq);
}

if($data == "set_asia_points"){
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"ارسل عدد النقاط لكل 1 آسياسيل",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"asia_admin_settings"]]]])]);
$rshq['mode'][$from_id] = "set_asia_points";
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "set_asia_number"){
$rshq['asia_settings']['receive_number'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ تم تعيين رقم الاستلام: $text",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"asia_admin_settings"]]]])]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "set_asia_points"){
$rshq['asia_settings']['points_per_asia'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ تم تعيين سعر النقاط: $text نقطة لكل 1 آسياسيل",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"asia_admin_settings"]]]])]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "stars_status_on"){
$rshq['stars_settings']['status'] = "on";
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"✅ تم فتح الشحن بالنجوم",'reply_markup'=>json_encode($asia_admin_menu)]);
exit;
}

if($data == "stars_status_off"){
$rshq['stars_settings']['status'] = "off";
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"❌ تم قفل الشحن بالنجوم",'reply_markup'=>json_encode($asia_admin_menu)]);
exit;
}

if($data == "set_stars_points"){
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"ارسل عدد النقاط لكل نجمة",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"asia_admin_settings"]]]])]);
$rshq['mode'][$from_id] = "set_stars_points";
setData($db['settings'], 'rshq', $rshq);
exit;
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "set_stars_points"){
$rshq['stars_settings']['points_per_star'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ تم تعيين سعر النجمة: $text نقطة لكل نجمة",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"asia_admin_settings"]]]])]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
exit;
}

if($data == "admin_bot_channels"){
$key = ['inline_keyboard' => []];
if(isset($rshq['bot_channels']) && is_array($rshq['bot_channels'])){
foreach($rshq['bot_channels'] as $channel_id => $channel){
$key['inline_keyboard'][] = [['text' => $channel['name'], 'callback_data' => "edit_bot_channel|$channel_id"], ['text' => "🗑", 'callback_data' => "delete_bot_channel|$channel_id"]];
}
}
$key['inline_keyboard'][] = [['text' => "+ اضافه قناة جديده", 'callback_data' => "add_bot_channel"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "general_settings"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*قنوات البوت 📢\nيمكنك اضافة قنوات البوت التي تظهر للمستخدمين\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if($data == "add_bot_channel"){
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*ارسل اسم القناة (العنوان الذي سيظهر للمستخدم)\nمثال: قناة البوت الرسمية\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "• رجوع •", 'callback_data' => "admin_bot_channels"]],
]
])
]);
$rshq['mode'][$from_id] = "add_bot_channel_name";
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "add_bot_channel_name"){
$rshq['temp_channel_name'] = $text;
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*الان ارسل رابط القناة (مع https://t.me/)\nمثال: https://t.me/NameroBots\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"admin_bot_channels"]],
]
])
]);
$rshq['mode'][$from_id] = "add_bot_channel_link";
setData($db['settings'], 'rshq', $rshq);
exit; 
}

if($text and $rshq['mode'][$from_id] == "add_bot_channel_link"){
$channel_name = $rshq['temp_channel_name'];
$channel_link = $text;
if(!isset($rshq['bot_channels'])) $rshq['bot_channels'] = [];
$channel_id = "channel_".rand(100000,999999);
$rshq['bot_channels'][$channel_id] = [
'name' => $channel_name,
'link' => $channel_link
];
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم اضافه قناة $channel_name بنجاح ✅\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"admin_bot_channels"]],
]
])
]);
$rshq['mode'][$from_id] = null;
$rshq['temp_channel_name'] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0] == "edit_bot_channel"){
$channel_id = explode("|",$data)[1];
$channel = $rshq['bot_channels'][$channel_id];
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "تعديل الاسم", 'callback_data' => "edit_channel_name|$channel_id"]];
$key['inline_keyboard'][] = [['text' => "تعديل الرابط", 'callback_data' => "edit_channel_link|$channel_id"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "admin_bot_channels"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*القناة: ".$channel['name']."\nالرابط: ".$channel['link']."*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if(explode("|",$data)[0] == "edit_channel_name"){
$channel_id = explode("|",$data)[1];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*ارسل الاسم الجديد للقناة\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "• رجوع •", 'callback_data' => "edit_bot_channel|$channel_id"]],
]
])
]);
$rshq['mode'][$from_id] = "edit_channel_name_$channel_id";
setData($db['settings'], 'rshq', $rshq);
}

if($text and strpos($rshq['mode'][$from_id], "edit_channel_name_") === 0){
$channel_id = str_replace("edit_channel_name_", "", $rshq['mode'][$from_id]);
$rshq['bot_channels'][$channel_id]['name'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعديل اسم القناة بنجاح ✅\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"admin_bot_channels"]],
]
])
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0] == "edit_channel_link"){
$channel_id = explode("|",$data)[1];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*ارسل الرابط الجديد للقناة\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "• رجوع •", 'callback_data' => "edit_bot_channel|$channel_id"]],
]
])
]);
$rshq['mode'][$from_id] = "edit_channel_link_$channel_id";
setData($db['settings'], 'rshq', $rshq);
}

if($text and strpos($rshq['mode'][$from_id], "edit_channel_link_") === 0){
$channel_id = str_replace("edit_channel_link_", "", $rshq['mode'][$from_id]);
$rshq['bot_channels'][$channel_id]['link'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعديل رابط القناة بنجاح ✅\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"admin_bot_channels"]],
]
])
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0] == "delete_bot_channel"){
$channel_id = explode("|",$data)[1];
unset($rshq['bot_channels'][$channel_id]);
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
if(isset($rshq['bot_channels']) && is_array($rshq['bot_channels'])){
foreach($rshq['bot_channels'] as $cid => $channel){
$key['inline_keyboard'][] = [['text' => $channel['name'], 'callback_data' => "edit_bot_channel|$cid"], ['text' => "🗑", 'callback_data' => "delete_bot_channel|$cid"]];
}
}
$key['inline_keyboard'][] = [['text' => "+ اضافه قناة جديده", 'callback_data' => "add_bot_channel"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "general_settings"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*تم حذف القناة بنجاح ✅\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if($data == "admin_funding_settings"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*اعدادات نظام التمويل 💰\nيمكنك التحكم في جميع اعدادات التمويل من هنا\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($funding_settings)
]);
}

if($data == "query_funding_channel"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل يوزر القناة (مع @ او بدون)*\nمثال: [@channel_username]",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"admin_funding_settings"]],
]
])
]);
$rshq['mode'][$from_id] = "query_funding_channel";
setData($db['settings'], 'rshq', $rshq);
}

if($text && $rshq['mode'][$from_id] == "query_funding_channel"){
$channel_user = str_replace("@", "", $text);
$found = false;
$funding_status = $rshq['funding_status'] ?? "on";
if(!empty($tmoil['db']['chs'])){
foreach($tmoil['db']['chs'] as $chs){
if($chs == $channel_user){
$idM = $tmoil['chanels']["id_$chs"];
$ci = $tmoil['db'][$idM]['count'];
$startc = $tmoil['db'][$idM]['startc'];
$vx = max(0, $ci - $startc);
$status_text = $funding_status == "on" ? "✅ مفعل" : "❌ معطل";
$owner = $tmoil['db'][$idM]['owner'];
if(is_numeric($owner)){
$owner_text = "[$owner](tg://user?id=$owner)";
}else{
$owner_text = $owner;
}
$details = "🔍 تفاصيل القناة [@$channel_user] 📡\n";
$details .= "📌 العدد المطلوب: $ci\n";
$details .= "📈 العدد المتبقي: $vx\n";
$details .= "👤 المالك: $owner_text\n";
$details .= "⚙️ حالة النظام: $status_text";
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$details,
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"ازاله القناة من التمويل 🗑",'callback_data'=>"delete_fund_channel_admin|$channel_user"]],
[['text'=>"• رجوع •",'callback_data'=>"admin_funding_settings"]],
]
])
]);
$found = true;
break;
}
}
}
if(!$found){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"❌ لم يتم العثور على قناة [@$channel_user] في قائمة التمويل",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"admin_funding_settings"]],
]
])
]);
}
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data_[0] == "delete_fund_channel_admin"){
$channel_user = $data_[1];
$st = array_search($channel_user, $tmoil['db']["chs"]);
if($st !== false){
unset($tmoil['db']["chs"][$st]);
$tmoil['db']["chs"] = array_values($tmoil['db']["chs"]);
$idM = $tmoil['chanels']["id_$channel_user"];
unset($tmoil['db'][$idM]);
unset($tmoil['chanels']["id_$channel_user"]);
setData($db['funding'], 'tmoil', $tmoil);
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"✅ تم ازاله قناة @$channel_user من التمويل بنجاح",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"admin_funding_settings"]],
]
])
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"❌ القناة غير موجودة",
'show_alert'=>true
]);
}
}

if($data == "set_funding_terms"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل شروط التمويل الجديدة\nيمكنك استخدام:\n{min_count} - الحد الأدنى للتمويل\n{price} - سعر العضو\n{currency} - اسم العملة\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = "set_funding_terms";
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "set_funding_terms"){
$tmoil['funding_terms'] = $text;
setData($db['funding'], 'tmoil', $tmoil);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين شروط التمويل بنجاح ✅\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "funding_toggle_on"){
$rshq['funding_status'] = "on";
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*تم فتح نظام التمويل بنجاح ✅\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"admin_funding_settings"]],
]
])
]);
}

if($data == "funding_toggle_off"){
$rshq['funding_status'] = "off";
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*تم قفل نظام التمويل بنجاح ❌\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"admin_funding_settings"]],
]
])
]);
}

if($data == "set_min_funding"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل ادنى حد للتمويل (عدد الاعضاء) بالارقام فقط\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = "set_min_funding";
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "set_min_funding"){
$tmoil["tmoils"] = $text;
setData($db['funding'], 'tmoil', $tmoil);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين ادنى حد للتمويل: $text عضو\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "set_funding_price"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل سعر العضو الواحد بالارقام فقط\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = "set_funding_price";
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "set_funding_price"){
$rshq["s3rtmoil"] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين سعر العضو: $text $currency_name\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "set_join_points"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل عدد نقاط الاشتراك في القنوات بالارقام فقط\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = "set_join_points";
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "set_join_points"){
$rshq["coinNmero"] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين نقاط الاشتراك في القنوات: $text $currency_name\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "set_leave_penalty"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل عدد نقاط خصم المغادرة من القنوات بالارقام فقط\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = "set_leave_penalty";
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "set_leave_penalty"){
$rshq["leave_penalty"] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين نقاط خصم المغادرة: $text $currency_name\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "admin_funding_panel"){
$buttons = [];
if(!empty($tmoil['db']['chs'])){
foreach($tmoil['db']['chs'] as $chs){
$idM = $tmoil['chanels']["id_$chs"] ?? null;
if(!$idM || !isset($tmoil['db'][$idM])) continue;
$ci = $tmoil['db'][$idM]["count"];
$startc = $tmoil['db'][$idM]["startc"];
$vx = max(0, $ci - $startc);
$buttons[] = [[
'text'=>"[@$chs] 📡 (✅ $vx / $ci)",
'callback_data'=>"show_fund_admin|$chs"
]];
}
}
$buttons[] = [['text'=>"رجوع ⬅️", 'callback_data'=>"admin_funding_settings"]];
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"- لوحة إدارة تمويل القنوات 👮‍♂️",
'reply_markup'=>json_encode(['inline_keyboard'=>$buttons])
]);
}

if($data_[0] == "show_fund_admin"){
$chs = $data_[1];
$idM = $tmoil['chanels']["id_$chs"] ?? null;
if(!$idM || !isset($tmoil['db'][$idM])){
bot('answerCallbackQuery', [
'callback_query_id'=>$update->callback_query->id,
'text'=>"القناة غير موجودة"
]);
return;
}
$ci = $tmoil['db'][$idM]["count"];
$startc = $tmoil['db'][$idM]["startc"];
$vx = max(0, $ci - $startc);
$owner = $tmoil['db'][$idM]["owner"];
if(is_numeric($owner)){
$owner_text = "[$owner](tg://user?id=$owner)";
}else{
$owner_text = $owner;
}
$create = $tmoil['db'][$idM]["create"] ?? "غير محدد";
$buttons = [
[['text'=>"❌ حذف القناة", 'callback_data'=>"delete_fund_channel|$chs"]],
[['text'=>"⬅️ رجوع", 'callback_data'=>"admin_funding_panel"]]
];
$text = "تفاصيل القناة [@$chs] 📡\n";
$text .= "📌 العدد المطلوب: $ci\n";
$text .= "📈 المتبقي: $vx\n";
$text .= "👤 المالك: $owner_text\n";
$text .= "📅 تاريخ الإنشاء: $create";
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>$text,
'parse_mode'=>"markdown",
'reply_markup'=>json_encode(['inline_keyboard'=>$buttons])
]);
}

if($data_[0] == "delete_fund_channel"){
$chs = $data_[1];
$idM = $tmoil['chanels']["id_$chs"];
if($idM){
unset($tmoil['db'][$idM]);
unset($tmoil['chanels']["id_$chs"]);
$index = array_search($chs, $tmoil['db']['chs']);
if($index !== false) unset($tmoil['db']['chs'][$index]);
$tmoil['db']['chs'] = array_values($tmoil['db']['chs']);
setData($db['funding'], 'tmoil', $tmoil);
}
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"✅ تم حذف قناة @$chs من التمويل بنجاح.",
'reply_markup'=>json_encode(['inline_keyboard'=>[
[['text'=>"رجوع ⬅️", 'callback_data'=>"admin_funding_panel"]]
]])
]);
}

if($data == "set_channel_proof"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل كليشه الاثبات في القنوات\nيمكنك استخدام الهاشتاجات التاليه:\n#username - اسم المستخدم\n#user_id - ايدي المستخدم\n#first_name - الاسم الاول\n#order_id - ايدي الطلب\n#service_name - اسم الخدمه\n#quantity - الكميه\n#link - الرابط\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = "set_channel_proof";
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "set_channel_proof"){
$rshq['channel_proof_text'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين كليشه الاثبات في القنوات بنجاح\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "open_transfer"){
$rshq['transfer_status'] = "on";
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*تم فتح التحويلات بنجاح ✅\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"gift_settings"]],
]
])
]);
}

if($data == "close_transfer"){
$rshq['transfer_status'] = "off";
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*تم قفل التحويلات بنجاح ❌\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"gift_settings"]],
]
])
]);
}

if($data == "set_min_transfer"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل اقل حد للتحويل بالارقام فقط\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = "set_min_transfer";
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "set_min_transfer"){
$rshq['min_transfer'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين اقل حد للتحويل: $text $currency_name\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "rshq_toggle"){
$key = ['inline_keyboard' => []];
$status = ($rshq['rshqG'] == "on") ? "✅ مفتوح" : "❌ مقفل";
$key['inline_keyboard'][] = [['text' => "فتح استقبال الرشق", 'callback_data' => "onrshq"]];
$key['inline_keyboard'][] = [['text' => "قفل استقبال الرشق", 'callback_data' => "ofrshq"]];
$key['inline_keyboard'][] = [['text' => "الحاله الحاليه: $status", 'callback_data' => "noop"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "general_settings"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*التحكم في استقبال الرشق\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if($data == "free_toggle"){
$key = ['inline_keyboard' => []];
$status = ($rshq['FREE'] == "TR") ? "✅ مفتوح" : "❌ مقفل";
$key['inline_keyboard'][] = [['text' => "فتح القسم المجاني", 'callback_data' => "onfr"]];
$key['inline_keyboard'][] = [['text' => "قفل القسم المجاني", 'callback_data' => "offr"]];
$key['inline_keyboard'][] = [['text' => "الحاله الحاليه: $status", 'callback_data' => "noop"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "general_settings"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*التحكم في القسم المجاني\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if($data == "general_settings"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*الاعدادات العامة للبوت\nيمكنك التحكم في جميع الاعدادات من هنا\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($general_settings)
]);
}

if($data == "gift_settings"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*اعدادات الهدايا والتحويلات\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($gift_settings)
]);
}

if($data == "member_control"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*التحكم بالاعضاء\nيمكنك ادارة الاعضاء من هنا\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($member_control)
]);
}

if($data == "member_info"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل ايدي العضو للحصول على معلوماته\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = "get_member_info";
setData($db['settings'], 'rshq', $rshq);
}

if($data == "member_orders"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل ايدي العضو لعرض اخر 5 طلبات له\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = "get_member_orders";
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "get_member_info"){
$member_id = $text;
$member_coin = $rshq["coin"][$member_id] ?? 0;
$member_share = $rshq["mshark"][$member_id] ?? 0;
$member_tlby = $rshq["tlby"][$member_id] ?? 0;
$member_cointlb = $rshq["cointlb"][$member_id] ?? 0;
$member_info_text = "*معلومات العضو*:\n\n";
$member_info_text .= "🆔 الايدي: `$member_id`\n";
$member_info_text .= "👤 اليوزر: ";
$member_info = bot("getchat",['chat_id'=>$member_id]);
if($member_info->result->username){
$member_info_text .= "@".$member_info->result->username."\n";
}else{
$member_info_text .= "لا يوجد\n";
}
$member_info_text .= "📛 الاسم: ".($member_info->result->first_name ?? "غير معروف")."\n";
$member_info_text .= "💰 الرصيد: $member_coin $currency_name\n";
$member_info_text .= "📊 الرصيد المستخدم: $member_cointlb $currency_name\n";
$member_info_text .= "👥 عدد الدعوات: $member_share\n";
$member_info_text .= "📦 عدد الطلبات: $member_tlby\n";
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$member_info_text,
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "get_member_orders"){
$member_id = $text;
$orders_text = "*اخر 5 طلبات للعضو `$member_id`*:\n\n";
$orders_list = $rshq["orders"][$member_id] ?? [];
$orders_count = count($orders_list);
$start_index = max(0, $orders_count - 5);
$counter = 1;
for($i = $start_index; $i < $orders_count; $i++){
$orders_text .= "$counter- ".$orders_list[$i]."\n";
$counter++;
}
if($orders_count == 0){
$orders_text .= "لا توجد طلبات لهذا العضو";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$orders_text,
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "set_currency"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل اسم العمله الجديده للبوت\nمثال: نقاط, كريدت, رصيد\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = "set_currency";
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "set_currency"){
$rshq['currency'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين عمله البوت الى: $text بنجاح\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($rshq['AKTHAR']==null){
$AKTHAR=20;
}else{
$AKTHAR = $rshq['AKTHAR'];
}

if($rshq['min_transfer']==null){
$min_transfer=10;
}else{
$min_transfer = $rshq['min_transfer'];
}

if($rshq["HDIA"] == null or $rshq["HDIA"] == "on"){
$HDIAS = "الهديه اليوميه";
$mj = "✅";
}else{
$HDIAS = null;
$mj = "❌";
}

if($data == "rshqG") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$rsedi = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=balance"));
$flos = $rsedi->balance;
$treqa = $rsedi->currency;
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*- اهلا لك عزيزي الادمن في لوحه المطور 📝\n----------------------------\n• عمله البوت : $currency_name*\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($adm)
]);
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}

if($text == "/sدtart") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$rsedi = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=balance"));
$flos = $rsedi->balance;
$treqa = $rsedi->currency;
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*- اهلا لك عزيزي الادمن في لوحه المطور 📝\n----------------------------\n• عمله البوت : *$currency_name*\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($adm)
]);
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "VIPME") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"* قسم الكلايش يمكنك التحكم في الكليشات\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnvip)
]);
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "settext"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل الكليشه الان\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id]= $data;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "msfrn"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل ايدي الشخص لتصفير نقاطه\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id]= $data;
setData($db['settings'], 'rshq', $rshq);
}
}

if($text and $rshq['mode'][$from_id]== "msfrn"){
if(true){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تصفير نقاط $text\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq["coin"][$text] = 0;
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "setname"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل اسم البوت الان .\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id]= $data;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "setcha"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل يوزر القناة الان مع @\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id]= $data;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "setbuy"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل كليشه شراء رصيد الان\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id]= $data;
setData($db['settings'], 'rshq', $rshq);
}
}

if (strpos($text, "/start T") === 0) {
    $code = str_replace("/start T", "", $text);
    if (isset($rshq['thoiler'][$code])) {
        $amount = $rshq['thoiler'][$code]["coin"];
        $sender = $rshq['thoiler'][$code]["to"];
        if ($sender != $from_id) {
            $rshq["coin"][$from_id] += $amount;
            unset($rshq['thoiler'][$code]); // حذف الرابط بعد الاستخدام
            setData($db['settings'], 'rshq', $rshq);
            bot('sendMessage', ['chat_id' => $chat_id, 'text' => "✅ تم استلام $amount $currency_name بنجاح!"]);
            bot('sendMessage', ['chat_id' => $sender, 'text' => "✅ تم استلام رابط التحويل الخاص بك من قبل [$name](tg://user?id=$from_id)"]);
        } else {
            bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ لا يمكنك استلام رابط التحويل الخاص بك!"]);
        }
    } else {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "❌ الرابط غير صالح أو تم استخدامه من قبل!"]);
    }
    exit;
}

if($data == "setshare"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل عدد النقاط الان\nنقاط مشاركه رابط لدعوه،\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['mode'][$from_id]= $data;
setData($db['settings'], 'rshq', $rshq);
}
}

if(is_numeric($text) and $rshq['mode'][$from_id]== "setshare"){
if(true){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين عدد النقاط\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq["coinshare"] = $text;
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}

if($text and $rshq['mode'][$from_id]== "setbuy"){
if(true){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين الكليشه\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['buy']= $text;
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}

$chabot = $rshq['cha']; if ($chabot == null){$chabot = "sero_bots";}

if($text and $rshq['mode'][$from_id]== "setname"){
if(true){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين اسم البوت\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['namebot']= $text;
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}

$nambot = $rshq['namebot']; if($nambot == null){$nambot = "خدماتي - Khadamti";}

if($text and $rshq['mode'][$from_id]== "settext"){
if(true){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين الكليشه بنجاح\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['KLISHA']= $text;
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}

if($text and $rshq['mode'][$from_id]== "setcha"){
if(true){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين القناة بنجاح\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($admnb)
]);
$rshq['cha']= str_replace("@","",$text);
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}

if ($data == "offr") {
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "* تم القفل\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => 'رجوع', 'callback_data' => "general_settings"]],
]
])
]);
$rshq['mode'][$from_id] = null;
$rshq['FREE'] = null;
setData($db['settings'], 'rshq', $rshq);
}
}

if ($data == "onfr") {
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "* تم الفتح\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => 'رجوع', 'callback_data' => "general_settings"]],
]
])
]);
$rshq['mode'][$from_id] = null;
$rshq['FREE'] = "TR";
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "market_sections"){
$key = ['inline_keyboard' => []];
if(isset($rshq['market_sections'])){
foreach($rshq['market_sections'] as $code => $section){
$key['inline_keyboard'][] = [
['text' => $section['name'], 'callback_data' => "market_edit|$code"],
['text' => "🗑 حذف", 'callback_data' => "delete_market_section|$code"]
];
}
}
$key['inline_keyboard'][] = [['text' => "+ اضافه قسم جديد", 'callback_data' => "add_market_section"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "rshqG"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*اقسام ماركت البوت\nاضغط على 🗑 حذف لازالة القسم بالكامل مع جميع منتجاته*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if(explode("|",$data)[0] == "delete_market_section"){
$code = explode("|",$data)[1];
$section_name = $rshq['market_sections'][$code]['name'] ?? 'هذا القسم';
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "✅ نعم، احذف القسم", 'callback_data' => "confirm_delete_section|$code"]];
$key['inline_keyboard'][] = [['text' => "❌ لا، رجوع", 'callback_data' => "market_sections"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*⚠️ تحذير!\nهل انت متأكد من حذف قسم \"$section_name\"؟\nسيتم حذف القسم بالكامل وجميع المنتجات الموجودة فيه.*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if(explode("|",$data)[0] == "confirm_delete_section"){
$code = explode("|",$data)[1];
$section_name = $rshq['market_sections'][$code]['name'] ?? 'القسم';
unset($rshq['market_sections'][$code]);
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
if(isset($rshq['market_sections'])){
foreach($rshq['market_sections'] as $code => $section){
$key['inline_keyboard'][] = [
['text' => $section['name'], 'callback_data' => "market_edit|$code"],
['text' => "🗑 حذف", 'callback_data' => "delete_market_section|$code"]
];
}
}
$key['inline_keyboard'][] = [['text' => "+ اضافه قسم جديد", 'callback_data' => "add_market_section"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "rshqG"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*✅ تم حذف قسم \"$section_name\" بنجاح*\n*اقسام ماركت البوت*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if($data == "add_market_section"){
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*ارسل اسم القسم الجديد\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "• رجوع •", 'callback_data' => "market_sections"]],
]
])
]);
$rshq['mode'][$from_id] = "add_market_section";
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "add_market_section"){
$emoji_id = null;
if(isset($update->message->entities)){
foreach($update->message->entities as $ent){
if($ent->type == "custom_emoji"){
$emoji_id = $ent->custom_emoji_id;
$offset = $ent->offset;
$length = $ent->length;
$text = mb_substr($text, 0, $offset) . mb_substr($text, $offset + $length);
}
}
}
if($emoji_id){
$text = preg_replace('/[\x{1F300}-\x{1FAFF}]/u', '', $text);
}
$text = trim($text);
$code = "market_".rand(100000,999999);
$rshq['market_sections'][$code] = [
'name' => $text,
'products' => []
];
if($emoji_id){
$rshq['market_sections'][$code]['emoji'] = $emoji_id;
}
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم اضافه قسم $text بنجاح\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"market_sections"]],
]
])
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0] == "market_edit"){
$code = explode("|",$data)[1];
$key = ['inline_keyboard' => []];
if(isset($rshq['market_sections'][$code]['products'])){
foreach($rshq['market_sections'][$code]['products'] as $pcode => $product){
$key['inline_keyboard'][] = [['text' => $product['name'], 'callback_data' => "product_edit|$code|$pcode"]];
}
}
$key['inline_keyboard'][] = [['text' => "+ اضافه منتج جديد", 'callback_data' => "add_product|$code"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "market_sections"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*قسم: ".$rshq['market_sections'][$code]['name']."*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if(explode("|",$data)[0] == "add_product"){
$code = explode("|",$data)[1];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*ارسل اسم المنتج\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "• رجوع •", 'callback_data' => "market_edit|$code"]],
]
])
]);
$rshq['mode'][$from_id] = "add_product_name";
$rshq['temp_market_code'] = $code;
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "add_product_name"){
$code = $rshq['temp_market_code'];
$pcode = "product_".rand(100000,999999);
$rshq['market_sections'][$code]['products'][$pcode] = [
'name' => $text,
'price' => 0,
'description' => ""];
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم اضافه المنتج $text\nالان قم بتعيين سعر المنتج\nارسل السعر بالارقام فقط\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"market_edit|$code"]],
]
])
]);
$rshq['mode'][$from_id] = "set_product_price";
$rshq['temp_product_code'] = $pcode;
$rshq['temp_market_code'] = $code;
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "set_product_price"){
$code = $rshq['temp_market_code'];
$pcode = $rshq['temp_product_code'];
$rshq['market_sections'][$code]['products'][$pcode]['price'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين السعر: $text\nالان قم بتعيين وصف المنتج\nارسل الوصف\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"market_edit|$code"]],
]
])
]);
$rshq['mode'][$from_id] = "set_product_desc";
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "set_product_desc"){
$code = $rshq['temp_market_code'];
$pcode = $rshq['temp_product_code'];
$rshq['market_sections'][$code]['products'][$pcode]['description'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين الوصف بنجاح\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"market_edit|$code"]],
]
])
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0] == "product_edit"){
$code = explode("|",$data)[1];
$pcode = explode("|",$data)[2];
$product = $rshq['market_sections'][$code]['products'][$pcode];
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "تعيين السعر", 'callback_data' => "edit_product_price|$code|$pcode"]];
$key['inline_keyboard'][] = [['text' => "تعيين الوصف", 'callback_data' => "edit_product_desc|$code|$pcode"]];
$key['inline_keyboard'][] = [['text' => "حذف المنتج", 'callback_data' => "delete_product|$code|$pcode"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "market_edit|$code"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*المنتج: ".$product['name']."\nالسعر: ".$product['price']." $currency_name\nالوصف: ".$product['description']."*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if(explode("|",$data)[0] == "edit_product_price"){
$code = explode("|",$data)[1];
$pcode = explode("|",$data)[2];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*ارسل السعر الجديد بالارقام فقط\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "• رجوع •", 'callback_data' => "product_edit|$code|$pcode"]],
]
])
]);
$rshq['mode'][$from_id] = "edit_product_price";
$rshq['temp_market_code'] = $code;
$rshq['temp_product_code'] = $pcode;
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "edit_product_price"){
$code = $rshq['temp_market_code'];
$pcode = $rshq['temp_product_code'];
$rshq['market_sections'][$code]['products'][$pcode]['price'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين السعر الجديد: $text $currency_name\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"product_edit|$code|$pcode"]],
]
])
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0] == "edit_product_desc"){
$code = explode("|",$data)[1];
$pcode = explode("|",$data)[2];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*ارسل الوصف الجديد\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "• رجوع •", 'callback_data' => "product_edit|$code|$pcode"]],
]
])
]);
$rshq['mode'][$from_id] = "edit_product_desc";
$rshq['temp_market_code'] = $code;
$rshq['temp_product_code'] = $pcode;
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "edit_product_desc"){
$code = $rshq['temp_market_code'];
$pcode = $rshq['temp_product_code'];
$rshq['market_sections'][$code]['products'][$pcode]['description'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*تم تعيين الوصف الجديد\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"product_edit|$code|$pcode"]],
]
])
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0] == "delete_product"){
$code = explode("|",$data)[1];
$pcode = explode("|",$data)[2];
unset($rshq['market_sections'][$code]['products'][$pcode]);
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
if(isset($rshq['market_sections'][$code]['products'])){
foreach($rshq['market_sections'][$code]['products'] as $pcode => $product){
$key['inline_keyboard'][] = [['text' => $product['name'], 'callback_data' => "product_edit|$code|$pcode"]];
}
}
$key['inline_keyboard'][] = [['text' => "+ اضافه منتج جديد", 'callback_data' => "add_product|$code"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "market_sections"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*قسم: ".$rshq['market_sections'][$code]['name']."\nتم حذف المنتج\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if($data == "qsmsa"){
$key = ['inline_keyboard' => []];
foreach ($rshq['qsm'] as $i) {
$nameq = explode("-",$i)[0];
$i = explode("-",$i)[1];
if($rshq['IFWORK>'][$i] != "NOT"){
$timer_status = ($rshq['section_timer'][$i] == "on") ? "⏰✅" : "⏰❌";
$key['inline_keyboard'][] = [['text' => "$nameq", 'callback_data' => "edits|$i"], ['text' => "$timer_status", 'callback_data' => "section_timer|$i"], ['text' => "🗑", 'callback_data' => "delets|$i"]];
}
}
$key['inline_keyboard'][] = [['text' => "+ اضافه قسم جديد", 'callback_data' => "addqsm"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "rshqG"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*الاقسام الموجوده في البوت\n⏰✅ التفعيل يعني نظام 24 ساعه مفعل علي كل خدمات القسم\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0] == "section_timer"){
$section_id = explode("|",$data)[1];
if($rshq['section_timer'][$section_id] == "on"){
$rshq['section_timer'][$section_id] = "off";
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*تم تعطيل نظام ال 24 ساعه لهذا القسم ❌\nيمكن للاعضاء طلب الخدمات من هذا القسم بدون انتظار\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "• رجوع •", 'callback_data' => "qsmsa"]],
]
])
]);
}else{
$rshq['section_timer'][$section_id] = "on";
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*تم تفعيل نظام ال 24 ساعه لهذا القسم ✅\nلا يمكن للعضو طلب اي خدمه من هذا القسم الا بعد 24 ساعه من اخر طلب\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "• رجوع •", 'callback_data' => "qsmsa"]],
]
])
]);
}
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0] == "delets"){
$rshq['IFWORK>'][explode("|",$data)[1]] = "NOT";
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
foreach ($rshq['qsm'] as $i) {
$nameq = explode("-",$i)[0];
$i = explode("-",$i)[1];
if($rshq['IFWORK>'][$i] != "NOT"){
$timer_status = ($rshq['section_timer'][$i] == "on") ? "⏰✅" : "⏰❌";
$key['inline_keyboard'][] = [['text' => "$nameq", 'callback_data' => "edits|$i"], ['text' => "$timer_status", 'callback_data' => "section_timer|$i"], ['text' => "🗑", 'callback_data' => "delets|$i"]];
}
}
$key['inline_keyboard'][] = [['text' => "+ اضافه قسم جديد", 'callback_data' => "addqsm"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "qsmsa"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*الاقسام الموجوده في البوت\n⏰✅ التفعيل يعني نظام 24 ساعه مفعل علي كل خدمات القسم\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

function getServices($site, $key){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://$site/api/v2");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
"key" => $key,
"action" => "services"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
return json_decode($res, true);
}

if(explode("|",$data)[0]=="edits"){
$key = ['inline_keyboard' => []];
$vv = rand(100,900);
foreach ( $rshq['xdmaxs'][explode("|",$data)[1]] as $hjjj => $i) {
$key['inline_keyboard'][] = [['text' => "$i", 'callback_data' => "editss|".explode("|",$data)[1]."|$hjjj"], ['text' => "", 'callback_data' => "delets|".explode("|",$data)[1]."|$hjjj"]];
}
$NameroBots = explode("|",$data)[1];
$key['inline_keyboard'][] = [['text' => "+ اضافه خدمات الي هذا القسم", 'callback_data' => "add|$NameroBots"]];
$key['inline_keyboard'][] = [['text' => "📥 سحب خدمات من الموقع", 'callback_data' => "getapi|$NameroBots|0"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "qsmsa"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*الخدمات الموجوده في قسم *".$rshq['NAMES'][explode("|",$data)[1]]."*\nنظام 24 ساعه: ".($rshq['section_timer'][explode("|",$data)[1]] == "on" ? "✅ مفعل" : "❌ معطل")."*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
$rshq['idTIMER'][$vv] = $rshq['NAMES'][explode("|",$data)[1]];
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0] == "getapi"){
$section_id = explode("|",$data)[1];
$page = explode("|",$data)[2];
$services = getServices($rshq["sSite"], $rshq["sToken"]);
$per_page = 20;
$start = $page * $per_page;
$slice = array_slice($services, $start, $per_page);
$key = ['inline_keyboard'=>[]];
foreach($slice as $i => $srv){
$id = $srv['service'];
$name = $srv['name'];
$selected = isset($rshq['import'][$from_id][$id]) ? "✅" : "❌";
$key['inline_keyboard'][] = [[
'text' => "$selected $name",
'callback_data' => "selectsrv|$section_id|$id|$page"
]];
}
$nav = [];
if($page > 0){
$prev = $page - 1;
$nav[] = ['text'=>"⬅️",'callback_data'=>"getapi|$section_id|$prev"];
}
if(count($services) > $start + $per_page){
$next = $page + 1;
$nav[] = ['text'=>"➡️",'callback_data'=>"getapi|$section_id|$next"];
}
if(!empty($nav)){
$key['inline_keyboard'][] = $nav;
}
$key['inline_keyboard'][] = [[
'text'=>"✅ اضافه المحدد",
'callback_data'=>"import|$section_id"
]];
$key['inline_keyboard'][] = [[
'text'=>"• رجوع •",
'callback_data'=>"CHANGE|$section_id"
]];
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*اختار الخدمات اللي عايز تضيفها*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($key)
]);
}

if(explode("|",$data)[0] == "selectsrv"){
$section_id = explode("|",$data)[1];
$srv_id = explode("|",$data)[2];
$page = explode("|",$data)[3];
if(isset($rshq['import'][$from_id][$srv_id])){
unset($rshq['import'][$from_id][$srv_id]);
} else {
$rshq['import'][$from_id][$srv_id] = true;
}
setData($db['settings'], 'rshq', $rshq);
$services = getServices($rshq["sSite"], $rshq["sToken"]);
$per_page = 20;
$start = $page * $per_page;
$slice = array_slice($services, $start, $per_page);
$key = ['inline_keyboard'=>[]];
foreach($slice as $i => $srv){
$id = $srv['service'];
$name = $srv['name'];
$selected = isset($rshq['import'][$from_id][$id]) ? "✅" : "❌";
$key['inline_keyboard'][] = [[
'text' => "$selected $name",
'callback_data' => "selectsrv|$section_id|$id|$page"
]];
}
$nav = [];
if($page > 0){
$prev = $page - 1;
$nav[] = ['text'=>"⬅️",'callback_data'=>"getapi|$section_id|$prev"];
}
if(count($services) > $start + $per_page){
$next = $page + 1;
$nav[] = ['text'=>"➡️",'callback_data'=>"getapi|$section_id|$next"];
}
if(!empty($nav)){
$key['inline_keyboard'][] = $nav;
}
$key['inline_keyboard'][] = [['text'=>"✅ اضافه المحدد",'callback_data'=>"import|$section_id"]];
$key['inline_keyboard'][] = [['text'=>"• رجوع •",'callback_data'=>"CHANGE|$section_id"]];
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*اختار الخدمات اللي عايز تضيفها*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($key)
]);
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"",
'show_alert'=>false
]);
}

if(explode("|",$data)[0] == "import"){
$section_id = explode("|",$data)[1];
$services = getServices($rshq["sSite"], $rshq["sToken"]);
foreach($services as $srv){
$id = $srv['service'];
if(isset($rshq['import'][$from_id][$id])){
$rshq['xdmaxs'][$section_id][] = $srv['name'];
$rshq['IDSSS'][$section_id][] = $id;
$rshq['min'][$section_id][] = $srv['min'];
$rshq['mix'][$section_id][] = $srv['max'];
$rshq['S3RS'][$section_id][] = $srv['rate'];
$rshq['Web'][$section_id][] = $rshq["sSite"];
$rshq['key'][$section_id][] = $rshq["sToken"];
}
}
unset($rshq['import'][$from_id]);
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"✅ تم اضافه الخدمات بنجاح",
'parse_mode'=>"markdown"
]);
}

if(explode("|",$data)[0]=="editss"){
$section_id = explode("|",$data)[1];
$service_index = explode("|",$data)[2];
$service_name = $rshq['xdmaxs'][$section_id][$service_index];
$service_price = ($rshq['S3RS'][$section_id][$service_index] ?? "1") * 1000;
$service_min = $rshq['min'][$section_id][$service_index] ?? "100";
$service_max = $rshq['mix'][$section_id][$service_index] ?? "1000";
$service_desc = $rshq['WSF'][$section_id][$service_index] ?? "لا يوجد وصف";
$service_id = $rshq['IDSSS'][$section_id][$service_index] ?? "غير محدد";
$service_web = $rshq['Web'][$section_id][$service_index] ?? $rshq["sSite"] ?? "غير محدد";
$service_key = $rshq['key'][$section_id][$service_index] ?? $rshq["sToken"] ?? "غير محدد";
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "ربط الخدمه علي الموقع الاساسي", 'callback_data' => "setauto|$section_id|$service_index"]];
$key['inline_keyboard'][] = [['text' => "تعيين سعر الخدمه", 'callback_data' => "setprice|$section_id|$service_index"]];
$key['inline_keyboard'][] = [['text' => "تعيين ايدي الخدمه", 'callback_data' =>"setid|$section_id|$service_index"]];
$key['inline_keyboard'][] = [['text' => "تعيين ادني حد للخدمه", 'callback_data' =>"setmin|$section_id|$service_index"]];
$key['inline_keyboard'][] = [['text' => "تعيين اقصي حد للخدمه", 'callback_data' =>"setmix|$section_id|$service_index"]];
$key['inline_keyboard'][] = [['text' => "تعيين وصف الخدمه", 'callback_data' =>"setdes|$section_id|$service_index"]];
$key['inline_keyboard'][] = [['text' => "تعيين ربط الموقع", 'callback_data' =>"setWeb|$section_id|$service_index"]];
$key['inline_keyboard'][] = [['text' => "تعيين API KEY الموقع", 'callback_data' =>"setkey|$section_id|$service_index"]];
$key['inline_keyboard'][] = [['text' => "امسح الخدمه", 'callback_data' =>"delt|$section_id|$service_index"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "edits|$section_id"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*📋 معلومات الخدمه\n\n🔹 اسم الخدمه: $service_name\n🔸 السعر: $service_price $currency_name لكل 1000\n🔹 ايدي الخدمه: $service_id\n🔸 ادني حد: $service_min\n🔹 اقصي حد: $service_max\n🔸 وصف الخدمه: $service_desc\n🔹 ربط الموقع: $service_web\n🔸 API KEY: $service_key\n\nيمكنك التحكم في الخدمه من الازرار ادناه\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
$rshq['current_edit_section'] = $section_id;
$rshq['current_edit_service'] = $service_index;
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0]=="delt"){
$section_id = explode("|",$data)[1];
$service_index = explode("|",$data)[2];
unset($rshq['xdmaxs'][$section_id][$service_index]);
$rshq['xdmaxs'][$section_id] = array_values($rshq['xdmaxs'][$section_id]);
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
foreach ( $rshq['xdmaxs'][$section_id] as $hjjj => $i) {
$key['inline_keyboard'][] = [['text' => "$i", 'callback_data' => "editss|$section_id|$hjjj"], ['text' => "", 'callback_data' => "delets|$section_id|$hjjj"]];
}
$key['inline_keyboard'][] = [['text' => "+ اضافه خدمات الي هذا القسم", 'callback_data' => "add|$section_id"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "edits|$section_id"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*الخدمات الموجوده في قسم *".$rshq['NAMES'][$section_id]."*\nنظام 24 ساعه: ".($rshq['section_timer'][$section_id] == "on" ? "✅ مفعل" : "❌ معطل")."*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0]=="setprice"){
$section_id = explode("|",$data)[1];
$service_index = explode("|",$data)[2];
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*هنا خدمه ".$rshq['xdmaxs'][$section_id][$service_index]." في قسم ".$rshq['NAMES'][$section_id]."ارسل سعر الخدمه الان (سعر 1000)؟\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = "setprice";
$rshq['MGS'][$from_id] = "MGS|$section_id|$service_index";
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0]=="setauto"){
$section_id = explode("|",$data)[1];
$service_index = explode("|",$data)[2];
$rshq['Web'][$section_id][$service_index] = $rshq["sSite"];
$rshq['key'][$section_id][$service_index] = $rshq["sToken"];
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*تم ربط الخدمه ".$rshq['xdmaxs'][$section_id][$service_index]." علي الموقع الاساسي \n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(explode("|",$data)[0]=="setmin"){
$section_id = explode("|",$data)[1];
$service_index = explode("|",$data)[2];
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*هنا خدمه ".$rshq['xdmaxs'][$section_id][$service_index]." في قسم ".$rshq['NAMES'][$section_id]."ارسل ادني عدد للخدمه الان؟\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = "setmin";
$rshq['MGS'][$from_id] = "MGS|$section_id|$service_index";
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "setmin"){
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$mgs = explode("|",$rshq['MGS'][$from_id]);
$section_id = $mgs[1];
$service_index = $mgs[2];
$rshq['min'][$section_id][$service_index] = $text;
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot("sendmessage",[
"chat_id" => $chat_id,
"text" => "تم تعيين ادني حد *". $rshq['xdmaxs'][$section_id][$service_index]."* في قسم *".$rshq['NAMES'][$section_id]."* الى $text",
"parse_mode"=>"markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
$rshq['MGS'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}
}

if(explode("|",$data)[0]=="setkey"){
$section_id = explode("|",$data)[1];
$service_index = explode("|",$data)[2];
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*هنا خدمه ".$rshq['xdmaxs'][$section_id][$service_index]." في قسم ".$rshq['NAMES'][$section_id]."ارسل API KEY الموقع الان؟\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = "setkey";
$rshq['MGS'][$from_id] = "MGS|$section_id|$service_index";
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "setkey"){
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$mgs = explode("|",$rshq['MGS'][$from_id]);
$section_id = $mgs[1];
$service_index = $mgs[2];
$rshq['key'][$section_id][$service_index] = $text;
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot("sendmessage",[
"chat_id" => $chat_id,
"text" => "تم تعيين API KEY *". $rshq['xdmaxs'][$section_id][$service_index]."* في قسم *".$rshq['NAMES'][$section_id]."*",
"parse_mode"=>"markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
$rshq['MGS'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}
}

if(explode("|",$data)[0]=="setmix"){
$section_id = explode("|",$data)[1];
$service_index = explode("|",$data)[2];
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*هنا خدمه ".$rshq['xdmaxs'][$section_id][$service_index]." في قسم ".$rshq['NAMES'][$section_id]."ارسل اقصي حد للخدمه الان؟\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = "setmix";
$rshq['MGS'][$from_id] = "MGS|$section_id|$service_index";
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "setmix"){
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$mgs = explode("|",$rshq['MGS'][$from_id]);
$section_id = $mgs[1];
$service_index = $mgs[2];
$rshq['mix'][$section_id][$service_index] = $text;
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot("sendmessage",[
"chat_id" => $chat_id,
"text" => "تم تعيين اقصي حد *". $rshq['xdmaxs'][$section_id][$service_index]."* في قسم *".$rshq['NAMES'][$section_id]."* الى $text",
"parse_mode"=>"markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
$rshq['MGS'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "setprice"){
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$mgs = explode("|",$rshq['MGS'][$from_id]);
$section_id = $mgs[1];
$service_index = $mgs[2];
$bA = $text / 1000;
$rshq['S3RS'][$section_id][$service_index] = $bA;
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot("sendmessage",[
"chat_id" => $chat_id,
"text" => "تم تعيين سعر *". $rshq['xdmaxs'][$section_id][$service_index]."* في قسم *".$rshq['NAMES'][$section_id]."* الى $text $currency_name لكل 1000",
"parse_mode"=>"markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
$rshq['MGS'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}
}

if(explode("|",$data)[0]=="setWeb"){
$section_id = explode("|",$data)[1];
$service_index = explode("|",$data)[2];
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*هنا خدمه ".$rshq['xdmaxs'][$section_id][$service_index]." في قسم ".$rshq['NAMES'][$section_id]."ارسل رابط الموقع؟\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = "setWeb";
$rshq['MGS'][$from_id] = "MGS|$section_id|$service_index";
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "setWeb"){
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$IMSALEH = parse_url($text);
$INSALEH = $IMSALEH['host'];
$mgs = explode("|",$rshq['MGS'][$from_id]);
$section_id = $mgs[1];
$service_index = $mgs[2];
$rshq['Web'][$section_id][$service_index] = $INSALEH;
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot("sendmessage",[
"chat_id" => $chat_id,
"text" => "تم تعيين ربط موقع *". $rshq['xdmaxs'][$section_id][$service_index]."* في قسم *".$rshq['NAMES'][$section_id]."*",
"parse_mode"=>"markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
$rshq['MGS'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}
}

if(explode("|",$data)[0]=="setdes"){
$section_id = explode("|",$data)[1];
$service_index = explode("|",$data)[2];
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*هنا خدمه ".$rshq['xdmaxs'][$section_id][$service_index]." في قسم ".$rshq['NAMES'][$section_id]."ارسل وصف الخدمه الان؟\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = "setdes";
$rshq['MGS'][$from_id] = "MGS|$section_id|$service_index";
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "setdes"){
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$mgs = explode("|",$rshq['MGS'][$from_id]);
$section_id = $mgs[1];
$service_index = $mgs[2];
$rshq['WSF'][$section_id][$service_index] = $text;
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot("sendmessage",[
"chat_id" => $chat_id,
"text" => "تم تعيين وصف *". $rshq['xdmaxs'][$section_id][$service_index]."* في قسم *".$rshq['NAMES'][$section_id]."*",
"parse_mode"=>"markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
$rshq['MGS'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}
}

if(explode("|",$data)[0]=="setid"){
$section_id = explode("|",$data)[1];
$service_index = explode("|",$data)[2];
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*هنا خدمه ".$rshq['xdmaxs'][$section_id][$service_index]." في قسم ".$rshq['NAMES'][$section_id]."ارسل ايدي الخدمه الان ؟\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = "setid";
$rshq['MGS'][$from_id] = "MGS|$section_id|$service_index";
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "setid"){
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$mgs = explode("|",$rshq['MGS'][$from_id]);
$section_id = $mgs[1];
$service_index = $mgs[2];
$rshq['IDSSS'][$section_id][$service_index] = $text;
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "editss|$section_id|$service_index"]];
bot("sendmessage",[
"chat_id" => $chat_id,
"text" => "تم تعيين ايدي خدمه *". $rshq['xdmaxs'][$section_id][$service_index]."* في قسم *".$rshq['NAMES'][$section_id]."* الى $text",
"parse_mode"=>"markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
$rshq['MGS'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}
}

if ($data == "addqsm") {
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*ارسل اسم القسم الان *",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => 'رجوع', 'callback_data' => "qsmsa"]],
]
])
]);
$rshq['mode'][$from_id] = $data;
setData($db['settings'], 'rshq', $rshq);
}
}

if ($text and $rshq["mode"][$from_id] == "addqsm") {
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$emoji_id = null;
if(isset($update->message->entities)){
foreach($update->message->entities as $ent){
if($ent->type == "custom_emoji"){
$emoji_id = $ent->custom_emoji_id;
$offset = $ent->offset;
$length = $ent->length;
$text = mb_substr($text, 0, $offset) . mb_substr($text, $offset + $length);
}
}
}
if($emoji_id){
$text = preg_replace('/[\x{1F300}-\x{1FAFF}]/u', '', $text);
}
$text = trim($text);
$NameroBots = "SALEH" . rand(0, 999999999999999);
$rshq['qsm'][] = $text . '-' . $NameroBots;
$rshq['NAMES'][$NameroBots] = $text;
if($emoji_id){
$rshq['EMOJI'][$NameroBots] = $emoji_id;
}
bot("sendmessage", [
"chat_id" => $chat_id,
"text" => "تم اضافه هذا القسم بنجاح .\n\nاسم القسم : $text\n\nكود القسم ( $NameroBots )",
"parse_mode" => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => 'للدخول لهذا القسم', 'callback_data' => "CHANGE|$NameroBots"]],
[['text' => "• رجوع •", 'callback_data' => "qsmsa"]],
]
])
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}
}

$UUS = explode("|", $data);
if ($UUS[0] == "CHANGE") {
if (isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$NameroBots = $UUS[1];
if ($rshq['NAMES'][$NameroBots] != null) {
$key = ['inline_keyboard' => []];
foreach ($rshq['xdmaxs'][$NameroBots] as $hjjj => $i) {
if($i != null){
$key['inline_keyboard'][] = [['text' => "$i", 'callback_data' => "editss|".$NameroBots."|$hjjj"], ['text' => "🗑", 'callback_data' => "delets|".$NameroBots."|$hjjj"]];
}
}
$key['inline_keyboard'][] = [['text' => "+ اضافه خدمه", 'callback_data' => "add|$NameroBots"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "qsmsa"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*مرحبا بك في هذا القسم " . $rshq['NAMES'][$NameroBots] . "*\nنظام 24 ساعه: ".($rshq['section_timer'][$NameroBots] == "on" ? "✅ مفعل" : "❌ معطل")."",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}
}
}

if($UUS[0]=="add"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$section_id = $UUS[1];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*ارسل اسم الخدمه لاضافاتها الي قسم ".$rshq['NAMES'][$section_id]."*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => 'رجوع', 'callback_data' => "CHANGE|$section_id"]],
]
])
]);
$rshq['mode'][$from_id] = "adders";
$rshq['idxs'][$from_id] = $section_id;
setData($db['settings'], 'rshq', $rshq);
}
}

if($text and $rshq['mode'][$from_id] == "adders"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
$section_id = $rshq['idxs'][$from_id];
$j = count($rshq['xdmaxs'][$section_id]);
$rshq['xdmaxs'][$section_id][] = $text;
setData($db['settings'], 'rshq', $rshq);
$key = ['inline_keyboard' => []];
foreach ($rshq['xdmaxs'][$section_id] as $hjjj => $i) {
if($i != null){
$key['inline_keyboard'][] = [['text' => "$i", 'callback_data' => "editss|$section_id|$hjjj"], ['text' => "", 'callback_data' => "delets|$section_id|$hjjj"]];
}
}
$key['inline_keyboard'][] = [['text' => "+ اضافه خدمه", 'callback_data' => "add|$section_id"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "qsmsa"]];
bot("sendmessage",[
"chat_id" => $chat_id,
"text" => "تم اضافه الخدمه *$text* الي قسم *".$rshq['NAMES'][$section_id]."*",
"parse_mode" => "markdown",
'reply_markup' => json_encode($key),
]);
$rshq['mode'][$from_id] = null;
$rshq['idxs'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "onhdia"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot("deletemessage",[
'chat_id' => $chat_id,
'message_id' => $message_id,
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"* تم تفعيل الهديه اليوميه .\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>'رجوع' ,'callback_data'=>"gift_settings"]],
]
])
]);
$rshq['HDIA']= "on";
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "ofhdia"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot("deletemessage",[
'chat_id' => $chat_id,
'message_id' => $message_id,
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"* تم تعطيل الهديه اليوميه .\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>'رجوع' ,'callback_data'=>"gift_settings"]],
]
])
]);
$rshq['HDIA']= "of";
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "sAKTHAR"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"* ارسل الان العدد ( ادني حد لتحويل الرصيد (\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>'رجوع' ,'callback_data'=>"general_settings"]],
]
])
]);
$rshq['mode'][$from_id]= $data;
setData($db['settings'], 'rshq', $rshq);
}
}

if($text and $rshq['mode'][$from_id] == "sAKTHAR"){
if(is_numeric($text)){
bot("sendmessage",[
'chat_id'=>$chat_id,
'text'=>"تم التعيين بنجاح ادني حد للتحويل هو *$text* $currency_name",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>'رجوع' ,'callback_data'=>"general_settings"]],
]
])
]);
$rshq['AKTHAR']= $text;
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}else{
bot("sendmessage",[
'chat_id'=>$chat_id,
'text'=>"ارسل *الارقام* فقط عزيزي",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>'رجوع' ,'callback_data'=>"general_settings"]],
]
])
]);
}
}

if($data == "sethdia"){
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"* ارسل الان عدد الهدیه الیومیه .\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>'رجوع' ,'callback_data'=>"gift_settings"]],
]
])
]);
$rshq['mode'][$from_id]= $data;
setData($db['settings'], 'rshq', $rshq);
}
}

if($text and $rshq['mode'][$from_id] == "sethdia"){
if(is_numeric($text)){
bot("sendmessage",[
'chat_id'=>$chat_id,
'text'=>"تم التعيين بنجاح عدد الهديه اليوميه هو *$text* $currency_name",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>'رجوع' ,'callback_data'=>"gift_settings"]],
]
])
]);
$rshq['hdias']= $text;
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}else{
bot("sendmessage",[
'chat_id'=>$chat_id,
'text'=>"ارسل *الارقام* فقط عزيزي",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>'رجوع' ,'callback_data'=>"gift_settings"]],
]
])
]);
}
}

if($data == "infoRshq") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ) {
if($rshq["sToken"] == null){
$sTok="لم يتم تعيين توكن";
}else{
$sTok=$rshq["sToken"];
}
if($rshq["sSite"] == null){
$Sdom="لم يتم تعيين دومين";
}else{
$Sdom=$rshq["sSite"];
}
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*- معلومات حول اعدادات موقع الرشق*\n----------------------------\n- توكن الموقع : `$sTok`\n- دومين موقع الرشق : `$Sdom`\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>'تعيين التوكن' ,'callback_data'=>"token"]],
  [['text'=>'تعيين دومين الموقع ' ,'callback_data'=>"SiteDomen"]],
 [['text'=>'رجوع' ,'callback_data'=>"rshqG"]],
]
])
]);
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "token") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل الان توكن الموقع *\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"rshqG" ]],
]
])
]);
$rshq['mode'][$from_id]= "sToken";
setData($db['settings'], 'rshq', $rshq);
}
}

$rnd=rand(999,99999);
if($text and $rshq['mode'][$from_id] == "sToken") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"تم تعيين توكن الموقع `$text`\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"rshqG" ]],
]
])
]);
$rshq['mode'][$from_id]= null;
$rshq["sToken"]= $text;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "SiteDomen") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل الان رابط الموقع *",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"rshqG" ]],
]
])
]);
$rshq['mode'][$from_id]= "SiteDomen";
setData($db['settings'], 'rshq', $rshq);
}
}

$rnd=rand(999,99999);
if($text and $rshq['mode'][$from_id] == "SiteDomen") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
$IMSALEH = parse_url($text);
$INSALEH = $IMSALEH['host'];
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"تم تعيين موقع الرشق `$INSALEH`\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"rshqG" ]],
]
])
]);
$rshq['mode'][$from_id]= null;
$rshq["sSite"]= $INSALEH;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "sCh") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل الان معرف القناة مع @ او بدون \n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"general_settings"]],
]
])
]);
$rshq['mode'][$from_id]= "sCh";
setData($db['settings'], 'rshq', $rshq);
}
}

if($text and $rshq['mode'][$from_id] == "sCh") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
$text = str_replace("@",null,$text);
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"تم تعيين قناة الاثباتات [@$text] تأكد من ان البوت مشرف بالقناة \n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"general_settings"]],
]
])
]);
$rshq['mode'][$from_id]= null;
$rshq["sCh"]= "@".$text;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "hdiamk" ) {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل عدد الرصيد داخل الهديه\n\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"gift_settings"]],
]
])
]);
$rshq['mode'][$from_id]= "hdiMk0";
setData($db['settings'], 'rshq', $rshq);
}
}

if($text and $rshq['mode'][$from_id] == "hdiMk0") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"• ارسل الان عدد الاشخاص لاستخدام هذا الهديه وتحته اسم الاكود\nمثلا\n\n100\nSALEH\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"gift_settings"]],
]
])
]);
$rshq['mode'][$from_id]= "hdiMk";
$rshq['_HD'][$from_id]= $text;
$rshq["Namero".$rnd]= "on|$text";
setData($db['settings'], 'rshq', $rshq);
}
}

$rnd=rand(999,99999);
if($text and $rshq['mode'][$from_id] == "hdiMk") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
if($text){
$text1 = $rshq['_HD'][$from_id];
$mts = explode("\n",$text)[1];
$text = explode("\n",$text)[0];
if($mts and $text){
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"• تم صنع كود نقاط جديد ✨\n----------------------------\n🏷- الكود : `". $mts."`\n📦- عدد الرصيد : $text1 $currency_name\n👤- عدد الاشخاص : $text\n\n🤖- بوت الرشق : [@".bot('getme','bot')->result->username. "]\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"gift_settings"]],
]
])
]);
$rshq['mode'][$from_id]= null;
$rshq[$mts]= "on|$text1|$text";
$rshq["A#D".$mts]= "$text";
setData($db['settings'], 'rshq', $rshq);
 }
} else {
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"ارسل *الارقام* فقط!!\n ",
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"gift_settings"]],
]
 ])
]);
}
}
}

if($data == "onrshq") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*تم فتح قسم الرشق\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"general_settings"]],
]
])
]);
$rshq['rshqG']= "on";
setData($db['settings'], 'rshq', $rshq);
} 
}

if($data == "ofrshq") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*تم قفل قسم الرشق\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"general_settings"]],
]
])
]);
$rshq['rshqG']= "of";
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "coins" ) {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*ارسل ايدي الشخص الان\n\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"member_control"]],
]
])
]);
$rshq['mode'][$from_id]= "coins";
setData($db['settings'], 'rshq', $rshq);
}
}

if($text and $rshq['mode'][$from_id] == "coins") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>" ارسل عدد الرصيد لاضافته للشخص\n\nاذا تريد تخصم كتب  -\nمثال للخصم:  -500\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"member_control"]],
]
])
]);
$rshq['mode'][$from_id]= "coins2";
$rshq['id'][$from_id]= "$text";
setData($db['settings'], 'rshq', $rshq);
}
exit; 
}

if($text and $rshq['mode'][$from_id] == "coins2") {
if(isAdmin($kznn, $chat_id) || $chat_id == $saleh ){
$target_user_id = $rshq['id'][$from_id];
$amount = $text;
$is_deduction = ($amount < 0);
$absolute_amount = abs($amount);
if($amount != 0){
$rshq["coin"][$target_user_id] += $amount;
setData($db['settings'], 'rshq', $rshq);
if($is_deduction){
$message_text = "🔻 تم خصم $absolute_amount $currency_name من رصيدك\nرصيدك الحالي: {$rshq["coin"][$target_user_id]} $currency_name";
} else {
$message_text = "🟢 تم اضافة $absolute_amount $currency_name الى رصيدك\nرصيدك الحالي: {$rshq["coin"][$target_user_id]} $currency_name";
}
bot('sendMessage',['chat_id' => $target_user_id, 'text' => $message_text, 'parse_mode' => "markdown"]);
bot('sendMessage',['chat_id'=>$chat_id,'text'=>"✅ تم ".($is_deduction ? "خصم" : "إضافة")." $absolute_amount $currency_name " . ($is_deduction ? "من" : "لـ") . " ايدي $target_user_id",'parse_mode'=>"markdown",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"• رجوع •",'callback_data'=>"member_control"]]]])]);
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}
}

$coin = $rshq["coin"][$from_id] ?? 0;
$bot_tlb = $rshq['bot_tlb'] ?? 0;
$mytl = $rshq["cointlb"][$from_id] ?? 0;
$share = $rshq["mshark"][$from_id] ?? 0;
$tlby = $rshq["tlby"][$from_id] ?? 0;
$start_message = $rshq['start_message'] ?? "مرحبا بك في بوت تريليون 👑\n\n[💠] نقاطك : {balance}\n[🆔] ايديك : `{user_id}`";
$chnl_clean = str_replace('@', '', $chnl);
$RSALEH = [
'inline_keyboard'=>[
[['text'=>"الخدمات ",'callback_data'=>"service","style"=>"danger","icon_custom_emoji_id"=>"5278436402156031854"]],
[['text'=>"تمويل القنوات ",'callback_data'=>"user_funding_main","style"=>"danger","icon_custom_emoji_id"=>"5424818078833715060"]],
[['text'=>"تجميع ️$currency_name",'callback_data'=>"plus","style"=>"danger","icon_custom_emoji_id"=>"4965219701572503640"], ['text'=>"اداره الحساب️",'callback_data'=>"acc","style"=>"danger","icon_custom_emoji_id"=>"5231200819986047254"]],
[['text'=>"استخدام كود ",'callback_data'=>"hdia","style"=>"danger","icon_custom_emoji_id"=>"5445353829304387411"], ['text'=>"تحويل نقاط️",'callback_data'=>"transer","style"=>"danger","icon_custom_emoji_id"=>"5447410659077661506"]],
[['text'=>"متابعه طلب",'callback_data'=>"infotlb","style"=>"danger","icon_custom_emoji_id"=>"5231012545799666522"],['text'=>"جميع طلباتي",'callback_data'=>"myrders","style"=>"danger","icon_custom_emoji_id"=>"5197269100878907942"]],
[['text'=>"قنوات البوت ",'callback_data'=>"user_bot_channels","style" => "primary","icon_custom_emoji_id"=>"5864127571754489150"],['text'=>"قناه الاثبتات",'url'=>"https://t.me/$chnl_clean","style" => "danger","icon_custom_emoji_id" => "5854722989240619332"]],
[['text'=>"شحن نقاط ",'callback_data'=>"buy","style" => "primary","icon_custom_emoji_id" => "5359437015752401733"],['text'=>"الشروط ",'callback_data'=>"termss","style" => "primary","icon_custom_emoji_id" => "5334544901428229844"]],
[['text'=>"قسم ماركت البوت ️",'callback_data'=>"user_market","style" => "primary","icon_custom_emoji_id" => "5895407084131848348"]],
[['text'=>"عدد الطلبات : $bot_tlb ",'callback_data'=>"نن","style" => "success","icon_custom_emoji_id" => "6296577138615125756"]],
]
];

if($data == "user_bot_channels"){
$key = ['inline_keyboard' => []];
if(isset($rshq['bot_channels']) && is_array($rshq['bot_channels'])){
foreach($rshq['bot_channels'] as $channel){
$key['inline_keyboard'][] = [['text' => $channel['name'], 'url' => $channel['link'],"style" => "danger","icon_custom_emoji_id" => "5895407084131848348"]];
}
}
$key['inline_keyboard'][] = [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*• اهلا بك في قسم قنوات البوت ![📭](tg://emoji?id=5251203410396458957)\n*• اختر القناة التي تريد الاشتراك فيها* ![🌀](tg://emoji?id=5461151367559141950)\n*\n",
'parse_mode' => "markdownV2",
'reply_markup' => json_encode($key),
]);
}

if($data == "user_funding_main"){
$funding_status = $rshq['funding_status'] ?? "on";
if($funding_status == "off"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*نظام التمويل مغلق حاليا ❌\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"tobot"]],
]
])
]);
return;
}
$s3rtmoil = $rshq["s3rtmoil"]?? "12";
$idna = $tmoil["tmoils"]?? "10";
$terms = $tmoil['funding_terms'] ?? "📋 شروط التمويل:\n1. يجب أن يكون البوت مشرفاً في قناتك\n2. الحد الأدنى للتمويل هو {min_count} عضو\n3. سعر العضو الواحد {price} {currency}\n4. يتم خصم الرصيد فور إنشاء الطلب\n5. لا يمكن استرجاع الرصيد بعد إنشاء الطلب";
$terms = str_replace("{min_count}", $idna, $terms);
$terms = str_replace("{price}", $s3rtmoil, $terms);
$terms = str_replace("{currency}", $currency_name, $terms);
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => " تمويل قناتك", 'callback_data' => "tmoil-Namero","style" => "primary","icon_custom_emoji_id" => "5895407084131848348"]];
$key['inline_keyboard'][] = [['text' => " الاشتراك في القنوات", 'callback_data' => "joins|1","style" => "primary","icon_custom_emoji_id" => "6008220984346152956"]];
$key['inline_keyboard'][] = [['text' => " قنوات تحت التمويل", 'callback_data' => "user_active_fundings","style" => "primary","icon_custom_emoji_id" => "5251203410396458957"]];
$key['inline_keyboard'][] = [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*💥 اهلا بك في قسم التمويل\n\n$terms\n\n📊 رصيدك الحالي: $coin $currency_name\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if($data == "user_active_fundings"){
$buttons = [];
if(empty($tmoil['db']['chs'])){
$buttons[] = [['text' => "لا توجد قنوات تحت التمويل حالياً", 'callback_data' => "noop"]];
} else {
foreach($tmoil['db']['chs'] as $chs){
$idM = $tmoil['chanels']["id_$chs"];
$ci = $tmoil['db'][$idM]["count"];
$vx = $ci - $tmoil['db'][$idM]["startc"];
$buttons[] = [['text' => "@$chs 📡 ($vx / $ci)", 'callback_data' => "view_funding_channel|$chs"]];
}
}
$buttons[] = [['text' => "• رجوع •", 'callback_data' => "user_funding_main"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*📡 القنوات التي تحت التمويل حالياً:\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => $buttons]),
]);
}

if($data_[0] == "view_funding_channel"){
$chs = $data_[1];
$idM = $tmoil['chanels']["id_$chs"];
if(!$idM || !isset($tmoil['db'][$idM])){
bot('answerCallbackQuery', ['callback_query_id'=>$update->callback_query->id, 'text'=>"القناة غير موجودة"]);
return;
}
$ci = $tmoil['db'][$idM]["count"];
$vx = $ci - $tmoil['db'][$idM]["startc"];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*📡 تفاصيل القناة\n\nقناة: @$chs\nالعدد المطلوب: $ci\nالعدد المتبقي: $vx\n\nيمكنك الاشتراك فيها لكسب نقاط*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "✅ الاشتراك", 'callback_data' => "joins|1"]],
[['text' => "• رجوع •", 'callback_data' => "user_active_fundings"]],
]
]),
]);
}

if($data == "user_market"){
$key = ['inline_keyboard' => []];
$row = [];
if(isset($rshq['market_sections'])){
foreach($rshq['market_sections'] as $code => $section){
$btn = [
'text' => $section['name'],
'callback_data' => "user_market_products|$code"
];
if(isset($section['emoji'])){
$btn["icon_custom_emoji_id"] = $section['emoji'];
}
$row[] = $btn;
if(count($row) == 2){
$key['inline_keyboard'][] = $row;
$row = [];
}
}
}
if(!empty($row)){
$key['inline_keyboard'][] = $row;
}
$key['inline_keyboard'][] = [[
'text'=>"• رجوع •",
'callback_data'=>"tobot",
"style" => "danger",
"icon_custom_emoji_id" => "5449683594425410231"
]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*مرحبا بك في ماركت البوت ![🛍](tg://emoji?id=5278436402156031854)\n• اختر القسم المناسب ![⭐](tg://emoji?id=5197269100878907942)\n*\n",
'parse_mode' => "markdownV2",
'reply_markup' => json_encode($key),
]);
}

if(explode("|",$data)[0] == "user_market_products"){
$code = explode("|",$data)[1];
$key = ['inline_keyboard' => []];
if(isset($rshq['market_sections'][$code]['products'])){
foreach($rshq['market_sections'][$code]['products'] as $pcode => $product){
$key['inline_keyboard'][] = [['text' => $product['name']." - السعر: ".$product['price'], 'callback_data' => "buy_product|$code|$pcode"]];
}
}
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "user_market"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*قسم: ".$rshq['market_sections'][$code]['name']."*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if(explode("|",$data)[0] == "buy_product"){
$code = explode("|",$data)[1];
$pcode = explode("|",$data)[2];
$product = $rshq['market_sections'][$code]['products'][$pcode];
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "تأكيد الشراء ✅", 'callback_data' => "confirm_buy|$code|$pcode"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "user_market_products|$code"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*المنتج: ".$product['name']."\nالوصف: ".$product['description']."\nالسعر: ".$product['price']." $currency_name\nرصيدك: $coin $currency_name\nهل تريد شراء هذا المنتج؟\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if(explode("|",$data)[0] == "confirm_buy"){
$code = explode("|",$data)[1];
$pcode = explode("|",$data)[2];
$product = $rshq['market_sections'][$code]['products'][$pcode];
if($coin >= $product['price']){
$rshq["coin"][$from_id] -= $product['price'];
$rshq["market_purchases"][$from_id][] = [
'product' => $product['name'],
'price' => $product['price'],
'time' => date('Y-m-d H:i:s'),
'section' => $rshq['market_sections'][$code]['name']
];
setData($db['settings'], 'rshq', $rshq);
$proof_text = $rshq['channel_proof_text'] ?? "✅ تم شراء المنتج بنجاح\nالمنتج: {product_name}\nالسعر: {price} {currency}\nالمستخدم: {user_name}\nالايدي: {user_id}";
$proof_text = str_replace("{product_name}", $product['name'], $proof_text);
$proof_text = str_replace("{price}", $product['price'], $proof_text);
$proof_text = str_replace("{currency}", $currency_name, $proof_text);
$proof_text = str_replace("{user_name}", $name, $proof_text);
$proof_text = str_replace("{user_id}", $from_id, $proof_text);
$proof_text = str_replace("{username}", $user, $proof_text);
if($chnl){
bot('sendMessage',[
'chat_id'=>$chnl,
'text'=>$proof_text,
'parse_mode'=>"markdown",
]);
}
bot('sendMessage',[
'chat_id'=>$saleh,
'text'=>"🛍️ شراء جديد من الماركت\n- المنتج: ".$product['name']."\n- السعر: ".$product['price']." $currency_name\n- المشتري: [$name](tg://user?id=$from_id)\n- ايدي المشتري: `$from_id`\n- يوزر: [@$user]\n- القسم: ".$rshq['market_sections'][$code]['name'],
'parse_mode'=>"markdown",
]);
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*تم شراء المنتج بنجاح ✅\nالمنتج: ".$product['name']."\nالسعر: ".$product['price']." $currency_name\nرصيدك المتبقي: ".($coin - $product['price'])." $currency_name\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "• رجوع •", 'callback_data' => "user_market"]],
]
])
]);
}else{
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*رصيدك غير كافي للشراء ❌\nرصيدك: $coin $currency_name\nسعر المنتج: ".$product['price']." $currency_name\n*",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "• رجوع •", 'callback_data' => "user_market_products|$code"]],
]
])
]);
}
}

if($data == "myrders"){
$orders_text = "";
if(isset($rshq["orders"][$from_id])){
foreach($rshq["orders"][$from_id] as $m){
$orders_text .= $m."\n";
}
}
if($orders_text == ""){
$orders_text = "لا توجد طلبات";
}
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id' => $message_id,
'text'=>"• اهلا بك في قسم طلباتي ! 🛍\n----------------------------\n`$orders_text`\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
}

$JAWA = $rshq['JAWA'];
if($data == "termss"){
if($rshq['KLISHA'] == null){
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id' => $message_id,
'text'=>"• لم تتم التعين",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
}else{
$k=$rshq['KLISHA'];
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id' => $message_id,
'text'=>" $k\n",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
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
'text'=>"لم يتم تعيين كليشه\n",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"linkme" ]],
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
 [['text'=>"• رجوع •",'callback_data'=>"linkme" ]],
]
])
]);
}
}

function parse_start_message($message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user){
$message = str_replace("{balance}", $coin, $message);
$message = str_replace("{currency}", $currency_name, $message);
$message = str_replace("{invites}", $share, $message);
$message = str_replace("{orders_count}", $tlby, $message);
$message = str_replace("{user_id}", $from_id, $message);
$message = str_replace("{first_name}", $name, $message);
$message = str_replace("{username}", $user, $message);
$message = preg_replace('/\*\*(.*?)\*\*/s', '<b>$1</b>', $message);
$message = preg_replace('/!!(.*?)!!/s', '<b>$1</b>', $message);
return $message;
}

$start_message = $rshq['start_message'] ?? "مرحبا بك في بوت تريليون 👑\n\n[💠] نقاطك : <b>{balance}</b>\n[🆔] ايديك : <code>{user_id}</code>";

function handleInvite($from_id, $inviter_id, $chat_id, $name, $user, &$rshq, &$SALEH, $db) {
global $currency_name, $usrbot;
$coinshare_value = $rshq["coinshare"] ?? 25;
$inviter_id_clean = (int)str_replace(" ", "", $inviter_id);
$from_id_clean = (int)$from_id;
if($inviter_id_clean == $from_id_clean) {
bot('sendMessage', [
'chat_id' => $chat_id,
'text' => "⚠️ لا يمكنك استخدام رابط الدعوة الخاص بك ✅"
]);
return false;
}
if(isset($rshq["invited_users"][$from_id_clean])) {
bot('sendMessage', [
'chat_id' => $chat_id,
'text' => "ℹ️ لقد استخدمت رابط دعوة من قبل ولا يمكنك استخدام آخر"
]);
return false;
}
if(!isset($rshq["coin"][$inviter_id_clean])) $rshq["coin"][$inviter_id_clean] = 0;
if(!isset($rshq["mshark"][$inviter_id_clean])) $rshq["mshark"][$inviter_id_clean] = 0;
$rshq["coin"][$inviter_id_clean] += $coinshare_value;
$rshq["mshark"][$inviter_id_clean] += 1;
$rshq["invited_users"][$from_id_clean] = $inviter_id_clean;
if(!isset($SALEH['SALEH']['send']['uname'])) $SALEH['SALEH']['send']['uname'] = [];
if(!isset($SALEH['SALEH']['send']['add'])) $SALEH['SALEH']['send']['add'] = [];
if(!in_array($inviter_id_clean, $SALEH['SALEH']['send']['uname'])){
$SALEH['SALEH']['send']['uname'][] = $inviter_id_clean;
$SALEH['SALEH']['send']['add'][] = 1;
} else {
$yes = array_search($inviter_id_clean, $SALEH['SALEH']['send']['uname']);
$SALEH['SALEH']['send']['add'][$yes] += 1;
}
setData($db['settings'], 'saleh', $SALEH);
setData($db['settings'], 'rshq', $rshq);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"✅ تم تفعيل رابط الدعوة بنجاح!\n💰 لقد حصل صاحب الرابط على *$coinshare_value* $currency_name",
'parse_mode'=>"Markdown",
]);
$inviter_name = bot('getChat',['chat_id'=>$inviter_id_clean])->result->first_name ?? "المستخدم";
bot('sendMessage',[
'chat_id'=>$inviter_id_clean,
'text'=>"🎉 قام صديقك [$name](tg://user?id=$from_id_clean) بالدخول عبر رابط دعوتك!\n💰 تم إضافة *$coinshare_value* $currency_name إلى رصيدك\n📊 رصيدك الحالي: *{$rshq["coin"][$inviter_id_clean]}* $currency_name",
'parse_mode'=>"Markdown",
]);
return true;
}

$invite_code = null;
$text_clean = trim($text);
if (strpos($text_clean, "/start") === 0) {
$parts = explode(" ", $text_clean);
if (isset($parts[1])) {
$invite_code = is_numeric($parts[1]) ? (int)$parts[1] : null;
} elseif (strlen($text_clean) > 7) {
$num = substr($text_clean, 7);
$invite_code = is_numeric($num) ? (int)$num : null;
}
}
if ($invite_code === null && isset($update->message->entities)) {
foreach ($update->message->entities as $entity) {
if ($entity->type == "url" || $entity->type == "text_link") {
$url = $entity->url ?? substr($text_clean, $entity->offset, $entity->length);
if (preg_match('/[?&]start=(\d+)/', $url, $match)) {
$invite_code = (int)$match[1];
break;
}
}
}
}
$isInviteLink = ($invite_code !== null && $invite_code > 0);
$isNormalStart = ($text_clean == "/start" || $text_clean == "/start ");
$isUserStart = ($text_clean == "/stat");

if($isInviteLink || $isNormalStart) {
$inviter_id = $isInviteLink ? $invite_code : ($isNormalStart && isset($rshq['HACK'][$from_id]) ? $rshq['HACK'][$from_id] : null);
$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
if($inviter_id && $inviter_id != $from_id && !isset($rshq["invited_users"][$from_id])) {
handleInvite($from_id, $inviter_id, $chat_id, $name, $user, $rshq, $SALEH, $db);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$start_mg,
'parse_mode'=>"HTML",
'reply_markup'=>json_encode($RSALEH)
]);
} elseif($inviter_id == $from_id) {
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"⚠️ لايمكنك الدخول لرابط الدعوه الخاص بك✅",
]);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$start_mg,
'parse_mode'=>"HTML",
'reply_markup'=>json_encode($RSALEH)
]);
} else {
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$start_mg,
'parse_mode'=>"HTML",
'reply_markup'=>json_encode($RSALEH)
]);
}
$rshq['HACKER'][$from_id] = null;
$rshq['HACK'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($isUserStart) {
$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$start_sg,
'parse_mode'=>"HTML",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode($RSALEH)
]);
}

$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
$reply_markup = [];

if (($SALEh['main_buttons_status'] ?? "✅") == "✅") {
$reply_markup[] = [['text'=>"الخدمات ",'callback_data'=>"service","style"=>"danger","icon_custom_emoji_id"=>"5395545952566128749"]];
$reply_markup[] = [['text'=>"تمويل القنوات ",'callback_data'=>"user_funding_main","style"=>"primary","icon_custom_emoji_id"=>"5424818078833715060"]];
$reply_markup[] = [['text'=>"قسم متجر البوت ️",'callback_data'=>"user_market","style" => "primary","icon_custom_emoji_id" => "6082621264000719714"]];
$reply_markup[] = [['text'=>"تجميع ️$currency_name",'callback_data'=>"plus","style"=>"primary","icon_custom_emoji_id"=>"4965219701572503640"], ['text'=>"اداره الحساب️",'callback_data'=>"acc","style"=>"primary","icon_custom_emoji_id"=>"5231200819986047254"]];
$reply_markup[] = [['text'=>"استخدام كود ",'callback_data'=>"hdia","style"=>"primary","icon_custom_emoji_id"=>"5445353829304387411"], ['text'=>"تحويل نقاط️",'callback_data'=>"transer","style"=>"primary","icon_custom_emoji_id"=>"5447410659077661506"]];
$reply_markup[] = [['text'=>"متابعه طلب",'callback_data'=>"infotlb","style"=>"primary","icon_custom_emoji_id"=>"5231012545799666522"],['text'=>"جميع طلباتي",'callback_data'=>"myrders","style"=>"primary","icon_custom_emoji_id"=>"5197269100878907942"]];
$reply_markup[] = [['text'=>"شحن نقاط ",'callback_data'=>"buy","style" => "primary","icon_custom_emoji_id" => "5359437015752401733"],['text'=>"الشروط ",'callback_data'=>"termss","style" => "primary","icon_custom_emoji_id" => "6271786398404055377"]];
$reply_markup[] = [['text'=>"قنوات البوت ",'callback_data'=>"user_bot_channels","style" => "danger","icon_custom_emoji_id"=>"5188540541922480562"],['text'=>"قناه الاثباتات",'url'=>"https://t.me/$chnl_clean","style" => "danger","icon_custom_emoji_id" => "5413879192267805083"]];
$reply_markup[] = [['text'=>"عدد الطلبات : $bot_tlb ",'callback_data'=>"نن","style" => "success","icon_custom_emoji_id" => "5775911726633456945"]];
}

if($text == "/start"){
$rows = $SALEh['rows'] ?? [];
foreach ($rows as $row) {
$currentRow = [];
foreach ($row as $btn_id) {
if (isset($SALEh['SALEhs'][$btn_id])) {
$btn = $SALEh['SALEhs'][$btn_id];
$color = $btn['color'] ?? "default";
if($color == "default"){$color = "";}
$emoji = $btn['emoji'] ?? null;
if ($btn['Type'] == "callback") {
if($emoji){
$currentRow[] = ['text' => $btn['name'], 'callback_data' => $btn['mo'], 'style' => $color, 'icon_custom_emoji_id' => $emoji];
} else {
$currentRow[] = ['text' => $btn['name'], 'callback_data' => $btn['mo'], 'style' => $color];
}
} else {
if($emoji){
$currentRow[] = ['text' => $btn['name'], 'callback_data' => $btn_id, 'style' => $color, 'icon_custom_emoji_id' => $emoji];
} else {
$currentRow[] = ['text' => $btn['name'], 'callback_data' => $btn_id, 'style' => $color];
}
}
} elseif (isset($SALEh['links'][$btn_id])) {
$link = $SALEh['links'][$btn_id];
$color = $link['color'] ?? "default";
if($color == "default"){$color = "primary";}
$emoji = $link['emoji'] ?? null;
if($emoji){
$currentRow[] = ['text' => $link['name'], 'url' => $link['url'], 'style' => $color, 'icon_custom_emoji_id' => $emoji];
} else {
$currentRow[] = ['text' => $link['name'], 'url' => $link['url'], 'style' => $color];
}
}
}
if (!empty($currentRow)) {
$reply_markup[] = $currentRow;
}
}
$reply_markup = json_encode(['inline_keyboard' => $reply_markup]);
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => $start_msg,
'reply_to_message_id' => $message->message_id,
'parse_mode'=>"HTML",
'reply_markup' => $reply_markup,
]);
exit;
}

if($data == "tobot"){
$rows = $SALEh['rows'] ?? [];
foreach ($rows as $row) {
$currentRow = [];
foreach ($row as $btn_id) {
if (isset($SALEh['SALEhs'][$btn_id])) {
$btn = $SALEh['SALEhs'][$btn_id];
$color = $btn['color'] ?? "default";
if($color == "default"){$color = "";}
$emoji = $btn['emoji'] ?? null;
if ($btn['Type'] == "callback") {
if($emoji){
$currentRow[] = ['text' => $btn['name'], 'callback_data' => $btn['mo'], 'style' => $color, 'icon_custom_emoji_id' => $emoji];
} else {
$currentRow[] = ['text' => $btn['name'], 'callback_data' => $btn['mo'], 'style' => $color];
}
} else {
if($emoji){
$currentRow[] = ['text' => $btn['name'], 'callback_data' => $btn_id, 'style' => $color, 'icon_custom_emoji_id' => $emoji];
} else {
$currentRow[] = ['text' => $btn['name'], 'callback_data' => $btn_id, 'style' => $color];
}
}
} elseif (isset($SALEh['links'][$btn_id])) {
$link = $SALEh['links'][$btn_id];
$color = $link['color'] ?? "default";
if($color == "default"){$color = "primary";}
$emoji = $link['emoji'] ?? null;
if($emoji){
$currentRow[] = ['text' => $link['name'], 'url' => $link['url'], 'style' => $color, 'icon_custom_emoji_id' => $emoji];
} else {
$currentRow[] = ['text' => $link['name'], 'url' => $link['url'], 'style' => $color];
}
}
}
if (!empty($currentRow)) {
$reply_markup[] = $currentRow;
}
}
$reply_markup = json_encode(['inline_keyboard' => $reply_markup]);
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => $start_msg,
'parse_mode'=>"HTML",
'disable_web_page_preview' => true,
'reply_markup' => $reply_markup,
]);
exit;
}

$price = $SALEh['SALEhs'][$data]['mo'] ?? null;
if($price){
$price = str_replace('#name', $name, $price);
$price = str_replace('#username', "[@$username]", $price);
$price = str_replace('#id', $from_id, $price);
$price = str_replace('#coin', $rshq["coin"][$from_id] ?? 0, $price);
$price = str_replace('#coin_used', $rshq["cointlb"][$from_id] ?? 0, $price);
$price = str_replace('#orders_count', $rshq["tlby"][$from_id] ?? 0, $price);
$price = str_replace('#bot_orders', $rshq['bot_tlb'] ?? 0, $price);
$price = str_replace('#invites', $rshq["mshark"][$from_id] ?? 0, $price);
$price = str_replace('#invite_points', $rshq["coinshare"] ?? 25, $price);
$invite_link = "[https://t.me/".$usrbot."?start=$from_id]";
$price = str_replace('#invite_link', $invite_link, $price);
$top_invites = "";
$SALEH_DATA = getData($db['settings'], 'saleh');
if($SALEH_DATA && isset($SALEH_DATA['SALEH']['send']['uname'])){
$send_uname = $SALEH_DATA['SALEH']['send']['uname'];
$send_add = $SALEH_DATA['SALEH']['send']['add'];
$top_data = [];
for($i=0;$i<count($send_uname);$i++){
$top_data[] = ['user_id' => $send_uname[$i], 'count' => $send_add[$i]];
}
usort($top_data, function($a, $b){return $b['count'] - $a['count'];});
$top_list = "";
for($i=0;$i<min(5,count($top_data));$i++){
$rank = $i+1;
$rank_emoji = $rank == 1 ? "🥇" : ($rank == 2 ? "🥈" : ($rank == 3 ? "🥉" : ($rank == 4 ? "🏅" : "🏅")));
$user_info = bot('getChat',['chat_id'=>$top_data[$i]['user_id']]);
$user_name = $user_info->result->first_name ?? $top_data[$i]['user_id'];
$top_list .= "$rank_emoji $user_name - {$top_data[$i]['count']} دعوة\n";
}
$price = str_replace('#top_invites', $top_list, $price);
} else {
$price = str_replace('#top_invites', "لا توجد بيانات", $price);
}
$price = str_replace('#funding_count', count($tmoil['db']['chs'] ?? []), $price);
$funding_channels_list = "";
if(isset($tmoil['db']['chs']) && !empty($tmoil['db']['chs'])){
foreach($tmoil['db']['chs'] as $chs){
$funding_channels_list .= "- @$chs\n";
}
} else {
$funding_channels_list = "لا توجد قنوات تحت التمويل";
}
$price = str_replace('#funding_channels', $funding_channels_list, $price);
$currency_name = $rshq['currency'] ?? 'نقاط';
$price = str_replace('#currency', $currency_name, $price);
$Type = $SALEh['SALEhs'][$data]['Type'] ?? "EditMessageText";
$color = $SALEh['SALEhs'][$data]['color'] ?? "default";
if($color == "default"){$color = "primary";}
$emoji = $SALEh['SALEhs'][$data]['emoji'] ?? null;
if($emoji){
$reply_p = json_encode(['inline_keyboard' => [[['text'=>"رجوع",'callback_data'=>"tobot",'style'=>$color,'icon_custom_emoji_id'=>$emoji]]]]);
} else {
$reply_p = json_encode(['inline_keyboard' => [[['text'=>"رجوع",'callback_data'=>"tobot",'style'=>$color]]]]);
}
if($Type == "answercallbackquery"){
bot('answerCallbackQuery',[
'callback_query_id' => $callback_query->id,
'text' => $price,
'show_alert' => true
]);
} elseif($Type == "sendMessage"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$price,
'reply_to_message_id'=>$message->message_id ?? null,
'parse_mode'=>"MarkDown",
'reply_markup'=>$reply_p,
]);
} else {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>$price,
'reply_to_message_id'=>$message->message_id ?? null,
'parse_mode'=>"MarkDown",
'reply_markup'=>$reply_p,
]);
}
exit;
}

$steps = [];
if (file_exists("databases/" . $bot_id . "/steps.json")) {
$steps = json_decode(file_get_contents("databases/" . $bot_id . "/steps.json"), true);
if (!is_array($steps)) $steps = [];
}

$dev_id = $rshq['developer_id'] ?? $saleh;
$dev_info = bot('getChat', ['chat_id' => $dev_id]);
$dev_user = $dev_info->result->username ?? 'here_bot';
$dev_user = str_replace('@', '', $dev_user);

if($data == "buy") {
unset($steps[$from_id]);
file_put_contents("databases/" . $bot_id . "/steps.json", json_encode($steps, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
if($rshq['buy'] == null){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"• لم يتم التعيين",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"شحن آسياسيل ",'callback_data'=>"asia_charge_user","style" => "success","icon_custom_emoji_id" => "5334665620074017921"],
['text'=>"شحن نجوم ",'callback_data'=>"stars_charge_user","style" => "success","icon_custom_emoji_id" => "5951700382961898593"]],
[['text'=>"شحن بينانس usdt ",'callback_data'=>"charge_binance","style" => "primary","icon_custom_emoji_id" => "5280535348378609271"],
['text'=>"شحن عبر الدعم الفني",'url'=>"https://t.me/$dev_user","style" => "","icon_custom_emoji_id" => "5406683434124859552"]],
[['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
} else {
unset($steps[$from_id]);
file_put_contents("databases/" . $bot_id . "/steps.json", json_encode($steps, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>$rshq['buy'],
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"شحن آسياسيل ",'callback_data'=>"asia_charge_user","style" => "success","icon_custom_emoji_id" => "5334665620074017921"],
['text'=>"شحن نجوم ",'callback_data'=>"stars_charge_user","style" => "success","icon_custom_emoji_id" => "5951700382961898593"]],
[['text'=>"شحن بينانس usdt ",'callback_data'=>"charge_binance","style" => "primary","icon_custom_emoji_id" => "5280535348378609271"],
['text'=>"شحن عبر الدعم الفني",'url'=>"https://t.me/$dev_user","style" => "","icon_custom_emoji_id" => "5406683434124859552"]],
[['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
}
}

$binance_settings = $rshq['binance_settings'] ?? [];
if(empty($binance_settings)){
$binance_settings = [
'status' => 'off',
'api_key' => '',
'secret_key' => '',
'points_per_dollar' => 10,
'min_amount' => 1
];
$rshq['binance_settings'] = $binance_settings;
setData($db['settings'], 'rshq', $rshq);
}
$binance_status = $binance_settings['status'];
$binance_api_key = $binance_settings['api_key'];
$binance_secret_key = $binance_settings['secret_key'];
$points_per_dollar = $binance_settings['points_per_dollar'];
$binance_min_amount = $binance_settings['min_amount'];
$binance_admin_menu = [
'inline_keyboard'=>[
[['text'=>"فتح شحن Binance",'callback_data'=>"binance_status_on"],['text'=>"قفل شحن Binance",'callback_data'=>"binance_status_off"]],
[['text'=>"تعيين API Key",'callback_data'=>"set_binance_api_key"]],
[['text'=>"تعيين Secret Key",'callback_data'=>"set_binance_secret_key"]],
[['text'=>"تعيين سعر النقاط (1$ = ?)",'callback_data'=>"set_binance_points"]],
[['text'=>"تعيين الحد الأدنى ($)",'callback_data'=>"set_binance_min_amount"]],
[['text'=>"رجوع",'callback_data'=>"asia_admin_settings"]],
]
];

if($data == "binance_section"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"اعدادات شحن Binance",
'reply_markup'=>json_encode($binance_admin_menu)
]);
}

if($data == "binance_status_on"){
$rshq['binance_settings']['status'] = "on";
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"✅ تم فتح شحن Binance",'reply_markup'=>json_encode($binance_admin_menu)]);
}

if($data == "binance_status_off"){
$rshq['binance_settings']['status'] = "off";
setData($db['settings'], 'rshq', $rshq);
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"❌ تم قفل شحن Binance",'reply_markup'=>json_encode($binance_admin_menu)]);
}

if($data == "set_binance_api_key"){
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"ارسل API Key",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"binance_section"]]]])]);
$rshq['mode'][$from_id] = "set_binance_api_key";
setData($db['settings'], 'rshq', $rshq);
}

if($data == "set_binance_secret_key"){
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"ارسل Secret Key",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"binance_section"]]]])]);
$rshq['mode'][$from_id] = "set_binance_secret_key";
setData($db['settings'], 'rshq', $rshq);
}

if($data == "set_binance_points"){
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"ارسل عدد النقاط لكل 1 دولار",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"binance_section"]]]])]);
$rshq['mode'][$from_id] = "set_binance_points";
setData($db['settings'], 'rshq', $rshq);
}

if($data == "set_binance_min_amount"){
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"ارسل الحد الأدنى للشحن بالدولار",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"binance_section"]]]])]);
$rshq['mode'][$from_id] = "set_binance_min_amount";
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "set_binance_api_key"){
$rshq['binance_settings']['api_key'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ تم تعيين API Key",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"binance_section"]]]])]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($text and $rshq['mode'][$from_id] == "set_binance_secret_key"){
$rshq['binance_settings']['secret_key'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ تم تعيين Secret Key",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"binance_section"]]]])]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "set_binance_points"){
$rshq['binance_settings']['points_per_dollar'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ تم تعيين سعر النقاط: $text نقطة لكل 1 دولار",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"binance_section"]]]])]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "set_binance_min_amount"){
$rshq['binance_settings']['min_amount'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ تم تعيين الحد الأدنى: $text دولار",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"binance_section"]]]])]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

function binance_direct_request($endpoint, $params, $api_key, $secret_key) {
    $params['timestamp'] = number_format(microtime(true) * 1000, 0, '.', '');
    $query = http_build_query($params, '', '&');
    $signature = hash_hmac('sha256', $query, $secret_key);
    $url = "https://api.binance.com" . $endpoint . "?" . $query . "&signature=" . $signature;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-MBX-APIKEY: " . $api_key]);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

if($data == "charge_binance"){
if($binance_status == "off"){
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"نظام الشحن عبر Binance مغلق حاليا",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"tobot"]]]])]);
exit;
}
$steps[$from_id]['step'] = "enter_usdt_amount";
file_put_contents("databases/" . $bot_id . "/steps.json", json_encode($steps));
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"💰 ارسل المبلغ الذي تريد شحنه بالدولار (USDT TRC20)\n\n💡 الحد الأدنى: $binance_min_amount دولار",
'parse_mode'=>"Markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔙 رجوع",'callback_data'=>"tobot"]],
]
])
]);
exit;
}

if(isset($steps[$from_id]['step']) && $steps[$from_id]['step'] == "enter_usdt_amount"){
$amount = floatval($text);
if($amount < $binance_min_amount){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"⚠️ المبلغ الأدنى للشحن هو $binance_min_amount دولار.",
]);
exit;
}
$res = binance_direct_request("/sapi/v1/capital/deposit/address", ["coin" => "USDT", "network" => "TRX"], $binance_api_key, $binance_secret_key);
if(!isset($res['address'])){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"❌ حدث خطأ في الاتصال بـ Binance! تأكد من أن مفاتيح API صحيحة.",
]);
exit;
}
$address = $res['address'];
$steps[$from_id]['step'] = "send_txid";
$steps[$from_id]['amount'] = $amount;
$steps[$from_id]['address'] = $address;
file_put_contents("databases/" . $bot_id . "/steps.json", json_encode($steps));
$instructions = "💳 إرشادات الشحن:\n\n";
$instructions .= "1. 💵 أرسل المبلغ *$amount USDT* إلى:\n";
$instructions .= "`$address`\n\n";
$instructions .= "2. 🌐 الشبكة: TRC20 فقط\n\n";
$instructions .= "3. 📝 بعد الإرسال، أرسل معرف المعاملة (TXID) هنا\n\n";
$instructions .= "⚠️ مهم:\n• تأكد من إرسال المبلغ الصحيح\n• استخدم شبكة TRC20 فقط";
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$instructions,
'parse_mode'=>"Markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❓ ما هو TXID؟",'callback_data'=>"what_is_txid"]],
[['text'=>"❌ إلغاء",'callback_data'=>"cancel_deposit"]]
]
])
]);
exit;
}

if($data == "what_is_txid"){
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"TXID هو رقم المعاملة الذي تحصل عليه بعد إرسال العملية",
'show_alert'=>true
]);
exit;
}

if(isset($steps[$from_id]['step']) && $steps[$from_id]['step'] == "send_txid"){
$txid = trim($text);
$amount = $steps[$from_id]['amount'];
if(empty($txid) || strlen($txid) < 10){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"❌ TXID غير صحيح. يرجى إرسال معرف المعاملة الصحيح.",
]);
exit;
}
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"⏳ جاري التحقق من المعاملة...\n\nTXID: `$txid`\nالمبلغ: $amount USDT",
'parse_mode'=>"Markdown"
]);
$user_username = $update->message->from->username ?? "لا يوجد";
$res = binance_direct_request("/sapi/v1/capital/deposit/hisrec", ["coin" => "USDT", "network" => "TRX"], $binance_api_key, $binance_secret_key);
$is_success = false;
$actual_amount = 0;
$time = date('Y-m-d H:i:s');

if(is_array($res) && !isset($res['code'])) {
    foreach($res as $deposit) {
        if($deposit['txId'] == $txid && $deposit['status'] == 1) { 
            $is_success = true;
            $actual_amount = $deposit['amount'];
            $time = date('Y-m-d H:i:s', $deposit['insertTime'] / 1000);
            break;
        }
    }
}
$transactions_file = "databases/" . $bot_id . "/transactions.json";
if($is_success){
$transaction_txid = $txid;
$transactions = json_decode(file_get_contents($transactions_file) ?: "{}", true);
if (isset($transactions[$transaction_txid])) {
$error_msg = "⚠️ معاملة مكررة!\n\nهذه المعاملة تم شحنها مسبقاً.";
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$error_msg,
'parse_mode'=>"Markdown",
]);
unset($steps[$from_id]);
file_put_contents("databases/" . $bot_id . "/steps.json", json_encode($steps));
exit;
}
$points_to_add = $actual_amount * $points_per_dollar;
$rshq["coin"][$from_id] = ($rshq["coin"][$from_id] ?? 0) + $points_to_add;
setData($db['settings'], 'rshq', $rshq);
$transactions[$transaction_txid] = [
'user_id' => $from_id,
'username' => $user_username,
'amount_usdt' => $actual_amount,
'points_added' => $points_to_add,
'time' => $time,
'bot_record_time' => date('Y-m-d H:i:s'),
];
file_put_contents($transactions_file, json_encode($transactions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
$success_msg = "🎉 تم التحقق من الإيداع بنجاح!\n\n";
$success_msg .= "💰 المبلغ المستلم: *{$actual_amount} USDT*\n";
$success_msg .= "⭐ النقاط المضافة: *{$points_to_add}* $currency_name\n";
$success_msg .= "🆔 رقم المعاملة: `{$transaction_txid}`\n\n";
$success_msg .= "✅ تم شحن رصيدك بنجاح\n\n";
$success_msg .= "رصيدك الحالي: *{$rshq["coin"][$from_id]}* $currency_name";
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$success_msg,
'parse_mode'=>"Markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🏠 العودة للرئيسية",'callback_data'=>"tobot"]],
]
])
]);
$user_tag = $user_username != "لا يوجد" ? "@$user_username (ID: $from_id)" : "ID: $from_id";
$admin_msg = "🔔 💰 إيداع USDT جديد وناجح\n\n";
$admin_msg .= "👤 المستخدم: *{$user_tag}*\n";
$admin_msg .= "💵 المبلغ: *{$actual_amount} USDT*\n";
$admin_msg .= "⭐ النقاط: *{$points_to_add}* $currency_name\n";
$admin_msg .= "🆔 TXID: `{$transaction_txid}`\n";
$admin_msg .= "📊 الرصيد الجديد: *{$rshq["coin"][$from_id]}* $currency_name";
bot('sendMessage', [
'chat_id' => $saleh,
'text' => $admin_msg,
'parse_mode' => "Markdown",
]);
unset($steps[$from_id]);
file_put_contents("databases/" . $bot_id . "/steps.json", json_encode($steps));
} else {
$error_msg = "❌ فشل في التحقق من المعاملة\n\n";
$error_msg .= "🆔 TXID: `$txid`\n";
$error_msg .= "💰 المبلغ: $amount USDT\n\n";
$error_msg .= "الأسباب المحتملة:\n• لم تكتمل المعاملة بعد\n• TXID غير صحيح\n• المبلغ غير مطابق";
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>$error_msg,
'parse_mode'=>"Markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔄 حاول مرة أخرى",'callback_data'=>"charge_binance"]],
[['text'=>"📞 الدعم الفني",'url'=>"https://t.me/$developer_id"]]
]
])
]);
unset($steps[$from_id]);
file_put_contents("databases/" . $bot_id . "/steps.json", json_encode($steps));
}
exit;
}

if($data == "cancel_deposit"){
unset($steps[$from_id]);
file_put_contents("databases/" . $bot_id . "/steps.json", json_encode($steps));
bot('editMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"❌ تم إلغاء عملية الشحن.",
'parse_mode'=>"Markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🏠 العودة للرئيسية",'callback_data'=>"tobot"]]
]
])
]);
exit;
}

if($data == "stars_charge_user"){
if($stars_status == "off"){
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"نظام الشحن بالنجوم مغلق حاليا",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"tobot"]]]])]);
exit;
}
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"⭐ الشحن عبر نجوم تيليجرام\nسعر النجمة: $points_per_star نقطة\n\nارسل عدد النقاط التي تريد شراءها",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"tobot"]]]])]);
$rshq['stars_step'][$from_id] = "waiting_stars_amount";
setData($db['settings'], 'rshq', $rshq);
exit;
}

if(is_numeric($text) and $rshq['stars_step'][$from_id] == "waiting_stars_amount" and $text > 0){
$points_needed = $text;
$stars_needed = ceil($points_needed / $points_per_star);
$rshq['temp_stars'][$from_id] = ['points'=>$points_needed, 'stars'=>$stars_needed];
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"📋 فاتورة الشراء\n\nالنقاط المطلوبة: $points_needed نقطة\nعدد النجوم المطلوبة: $stars_needed نجمة\nسعر النجمة: $points_per_star نقطة\n\nلدفع $stars_needed نجمة اضغط على الزر ادناه",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"⭐ دفع $stars_needed نجمة",'callback_data'=>"pay_stars"]],[['text'=>"رجوع",'callback_data'=>"tobot"]]]])]);
$rshq['stars_step'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
exit;
}

if($data == "pay_stars"){
$temp = $rshq['temp_stars'][$from_id];
if(!$temp){
bot('answerCallbackQuery',['callback_query_id'=>$update->callback_query->id,'text'=>"حدث خطأ اعد المحاولة",'show_alert'=>true]);
exit;
}
bot('sendInvoice',[
'chat_id'=>$chat_id,
'title'=>"شحن $currency_name",
'description'=>"شراء $temp[points] $currency_name",
'payload'=>"stars_payment|$temp[points]",
'provider_token'=>"",
'currency'=>"XTR",
'prices'=>json_encode([['label'=>"نجوم تيليجرام",'amount'=>$temp['stars']]]),
'start_parameter'=>"stars_pay"
]);
unset($rshq['temp_stars'][$from_id]);
setData($db['settings'], 'rshq', $rshq);
exit;
}

if($update->pre_checkout_query){
$pre_checkout = $update->pre_checkout_query;
bot('answerPreCheckoutQuery',['pre_checkout_query_id'=>$pre_checkout->id,'ok'=>true]);
exit;
}

if(isset($update->message->successful_payment)){
$payload = $update->message->successful_payment->invoice_payload;
$points = explode("|",$payload)[1];
$rshq["coin"][$from_id] = ($rshq["coin"][$from_id] ?? 0) + $points;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ تم اضافة $points $currency_name الى حسابك"]);
bot('sendmessage',['chat_id'=>$saleh,'text'=>"🛍 عملية شحن بالنجوم\nالمستخدم: $name\nالايدي: $from_id\nالنقاط المضافة: $points"]);
exit;
}

if($data == "asia_charge_user"){
if($asia_status == "off"){
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"نظام الشحن مغلق حاليا",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"tobot"]]]])]);
exit;
} else {
bot('EditMessageText',['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"شحن آسياسيل\nسعر النقاط: $points_per_asia نقطة لكل 1 آسياسيل\n\nارسل رقم هاتفك للبدء",'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"رجوع",'callback_data'=>"tobot"]]]])]);
$rshq['asia_step'][$from_id] = "waiting_phone";
setData($db['settings'], 'rshq', $rshq);
exit;
}
}

if($text and $rshq['asia_step'][$from_id] == "waiting_phone" and is_numeric($text) and strlen($text) >= 10){
$deviceInfo = ['DeviceID' => 'afa89b0b-23d5-40d5-8494-a0e297afd291'];
$result = LoginDB($text, $deviceInfo);
if($result['success']){
$rshq['asia_temp'][$from_id] = ['step' => 'waiting_code', 'phone' => $text, 'PID' => $result['PID'], 'deviceInfo' => $deviceInfo];
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"تم ارسال كود التحقق الى $text\nارسل الكود"]);
} else {
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"فشل ارسال الكود"]);
}
exit;
}

if($text and isset($rshq['asia_temp'][$from_id]['step']) and $rshq['asia_temp'][$from_id]['step'] == 'waiting_code' and is_numeric($text)){
$temp = $rshq['asia_temp'][$from_id];
$result = pass($text, $temp['PID'], $temp['deviceInfo']);
if($result['success']){
$rshq['asia_session'][$from_id] = ['phone' => $temp['phone'], 'access_token' => $result['access_token'], 'fullname' => $result['fullname']];
unset($rshq['asia_temp'][$from_id]);
unset($rshq['asia_step'][$from_id]);
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ تم تسجيل الدخول\nارسل المبلغ (1-60 آسياسيل)"]);
$rshq['asia_step'][$from_id] = "waiting_amount";
setData($db['settings'], 'rshq', $rshq);
} else {
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"كود غير صحيح"]);
}
exit;
}

if(is_numeric($text) and $rshq['asia_step'][$from_id] == "waiting_amount" and $text >= 1 and $text <= 60){
if(!isset($rshq['asia_session'][$from_id])){
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"انتهت الجلسة اعد المحاولة"]);
unset($rshq['asia_step'][$from_id]);
setData($db['settings'], 'rshq', $rshq);
} else {
$session = $rshq['asia_session'][$from_id];
$points = $text * $points_per_asia;
$result = Tran($session['access_token'], $text, $asia_receive_number, ['DeviceID' => 'afa89b0b-23d5-40d5-8494-a0e297afd291']);
if($result['success']){
$rshq['asia_temp'][$from_id] = ['step' => 'waiting_transfer_code', 'amount' => $text, 'points' => $points, 'PID' => $result['PID']];
unset($rshq['asia_step'][$from_id]);
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"تم ارسال كود التحويل\nارسل الكود"]);
} else {
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"فشل ارسال طلب التحويل"]);
}
}
exit;
}

if($text and isset($rshq['asia_temp'][$from_id]['step']) and $rshq['asia_temp'][$from_id]['step'] == 'waiting_transfer_code'){
$temp = $rshq['asia_temp'][$from_id];
$session = $rshq['asia_session'][$from_id];
$result = Check($session['access_token'], $temp['PID'], $text, ['DeviceID' => 'afa89b0b-23d5-40d5-8494-a0e297afd291']);
if($result['success']){
$rshq["coin"][$from_id] = ($rshq["coin"][$from_id] ?? 0) + $temp['points'];
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ تم اضافة {$temp['points']} $currency_name الى حسابك"]);
bot('sendmessage',['chat_id'=>$saleh,'text'=>"📢 عملية شحن آسياسيل ناجحة\nالمستخدم: $name\nالايدي: $from_id\nالمبلغ: {$temp['amount']} آسياسيل\nالنقاط المضافة: {$temp['points']}\nالرصيد الحالي: {$rshq["coin"][$from_id]} $currency_name"]);
} else {
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"❌ فشل التحويل\nالكود غير صحيح"]);
}
unset($rshq['asia_temp'][$from_id]);
unset($rshq['asia_session'][$from_id]);
unset($rshq['asia_step'][$from_id]);
setData($db['settings'], 'rshq', $rshq);
exit;
}

if($data == "hdia") {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"![🏷](tg://emoji?id=5445353829304387411) ارسل الكود :\n",
'parse_mode'=>"markdownV2",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
$rshq['mode'][$from_id]= "hdia";
setData($db['settings'], 'rshq', $rshq);
}

if($data == "transer") {
if($rshq['transfer_status'] == "off"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*تحويل النقاط مغلق حاليا ❌\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
}else{
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"ارسل عدد الرصيد لتحويله ![🌀](tg://emoji?id=5854722989240619332)\n",
'parse_mode'=>"markdownV2",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
$rshq['mode'][$from_id]= $data;
setData($db['settings'], 'rshq', $rshq);
}
}

$MakLink = substr(str_shuffle('AbCdEfGhIjKlMnOpQrStU12345689807'),1,13);

if(is_numeric($text) and $rshq['mode'][$from_id] == "transer") {
if($rshq["coin"][$from_id] >= $text) {
if(is_numeric($text) && $text >= $min_transfer_amount && !strpos($text, '-') && !strpos($text, '+')) {
$min_transfer_amount = $rshq['min_transfer'] ?? 10;
if($text >= $min_transfer_amount) {
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"🛍- تم صنع رابط تحويل بقيمه $text $currency_name \n\n♻️- وتم استقطاع *$text* $currency_name من رصيدك \n\n📦- الرابط : https://t.me/". bot('getme','bot')->result->username. "?start=T$MakLink\n\n📋- ايدي وصل التحويل : `$MakLink`\n\n💰- عدد رصيدك : *". $rshq["coin"][$from_id]. "* $currency_name\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
$rshq["coin"][$from_id] -= $text;
$rshq['mode'][$from_id]= null;
$rshq['thoiler'][$MakLink]["coin"] = $text;
$rshq['thoiler'][$MakLink]["to"] = $from_id;
setData($db['settings'], 'rshq', $rshq);
}
else
{
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"يمكنك تحويل رصيد اكثر من $min_transfer_amount $currency_name فقط\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
}
}
} else {
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"رصيدك غير كافيه ❌\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
}
}

if($text and $rshq['mode'][$from_id] == "hdia") {
if(explode("|", $rshq[$text])[0] == "on") {
if($rshq['mehdia'][$from_id][$text] !="on" ) {
if(explode("|", $rshq[$text])[2] >= $rshq["TASY_$text"]){
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"🌀- تم اضافة ". explode("|", $rshq[$text])[1]." $currency_name الى حسابك 🎁\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
bot('sendMessage',[
 'chat_id'=>$saleh,
 'text'=>"شخص اخذ كود الرصيد: \n\n- القيمه: ".explode("|", $rshq[$text])[1]." $currency_name\n- الشخص: [$name](tg://user?id=$chat_id)\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
$rshq["TASY_$text"] +=1;
$rshq['mode'][$from_id] = null;
$rshq['mehdia'][$from_id][$text] = "on" ;
$rshq["coin"][$from_id] += explode("|", $rshq[$text])[1];
setData($db['settings'], 'rshq', $rshq);
} else {
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"الكود خطأ او تم استخدامه ❌\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}
} else {
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"الكود خطأ او تم استخدامه ❌\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
}
} else {
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"الكود خطأ او تم استخدامه ❌\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
}
}

if($data == "plus") {
if($HDIAS) {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*• اهلا بك عزيزي المستخدم في قسم تجميع الرصيد مجاني:* ![🛒](tg://emoji?id=4965219701572503640)\n\n*• يمكنك جميع الرصيد بدون شراء وبدون تعب عن طريق الخدمات التاليه:*  ![🎉](tg://emoji?id=5461151367559141950)\n*• اختر ما تريد من الاسفل ![📭](tg://emoji?id=5231012545799666522):* \n",
'parse_mode'=>"markdownV2",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
[['text'=>"رابط الدعوه ",'callback_data'=>"linkme","style" => "primary","icon_custom_emoji_id" => "5447410659077661506"],['text'=>"$HDIAS",'callback_data'=>"hdiaa","style" => "primary","icon_custom_emoji_id" => "5193085063998224234"]],
[['text' => " الاشتراك في القنوات", 'callback_data' => "joins|1","style" => "primary","icon_custom_emoji_id" => "6008220984346152956"],['text'=>"لعبة الارقام",'callback_data'=>"daily_game","style" => "primary","icon_custom_emoji_id" => "5188540541922480562"]],
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
} else {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*• اهلا بك عزيزي المستخدم في قسم تجميع الرصيد مجاني:* ![🛒](tg://emoji?id=4965219701572503640)\n\n*• يمكنك جميع الرصيد بدون شراء وبدون تعب عن طريق الخدمات التاليه:*  ![🎉](tg://emoji?id=5461151367559141950)\n*• اختر ما تريد من الاسفل ![📭](tg://emoji?id=5231012545799666522):* \n",
'parse_mode'=>"markdownV2",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
[['text'=>"رابط الدعوه ",'callback_data'=>"linkme","style" => "primary","icon_custom_emoji_id" => "5447410659077661506"]],
[['text' => " الاشتراك في القنوات", 'callback_data' => "joins|1","style" => "primary","icon_custom_emoji_id" => "6008220984346152956"],['text'=>"لعبة الارقام",'callback_data'=>"daily_game","style" => "primary","icon_custom_emoji_id" => "5188540541922480562"]],
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
}
}
if($data == "daily_game"){
$last_play = $rshq['daily_game'][$from_id] ?? 0;
$reward = $rshq['daily_game_reward'] ?? 25;

if(($last_play + 86400) > time()){
$remaining = ($last_play + 86400) - time();
$hours = floor($remaining / 3600);
$minutes = floor(($remaining % 3600) / 60);

bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"⏳ *لقد استخدمت محاولتك اليوم!*\n\n🕐 متبقي: *$hours ساعة و $minutes دقيقة*\n🎲 ارجع بكرة وخد $reward $currency_name",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🏠 رجوع",'callback_data'=>"tobot"]]
]
])
]);
exit;
}

// توليد رقم عشوائي
$random = rand(1, 100);
$rshq['daily_game_number'][$from_id] = $random;
setData($db['settings'], 'rshq', $rshq);

// إنشاء الأزرار
$keyboard = [];
$row = [];

for($i=1; $i<=10; $i++){
$start = ($i-1)*10 + 1;
$end = $i*10;

$row[] = ['text' => "$start-$end", 'callback_data' => "game_guess|$start|$end"];

if(count($row) == 2){
$keyboard[] = $row;
$row = [];
}
}

if(!empty($row)){
$keyboard[] = $row;
}

$keyboard[] = [['text' => "🚪 خروج", 'callback_data' => "tobot"]];

bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"🎲 *لعبة تخمين الرقم*\n------------------\n🎯 خمن الرقم بين *1* و *100*\n💰 الجائزة: *$reward* $currency_name\n📊 لديك محاولة واحدة يومياً\n\nℹ️ اختر المجموعة التي تعتقد أن الرقم فيها:",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode(['inline_keyboard'=>$keyboard])
]);
}
if(explode("|",$data)[0] == "game_guess"){

$ex = explode("|",$data);
$start = (int)$ex[1];
$end = (int)$ex[2];

$secret = $rshq['daily_game_number'][$from_id] ?? 0;
$reward = $rshq['daily_game_reward'] ?? 25;

if($secret == 0){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"⚠️ *لم تبدأ اللعبة بعد!*\nاضغط على زر اللعبة أولاً",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🎮 العب الآن",'callback_data'=>"daily_game"]]
]
])
]);
exit;
}

// ✅ هنا بنسجل إنه لعب فعلاً
$rshq['daily_game'][$from_id] = time();

// نحذف الرقم السري بعد المحاولة
unset($rshq['daily_game_number'][$from_id]);

if($secret >= $start && $secret <= $end){

$rshq["coin"][$from_id] = ($rshq["coin"][$from_id] ?? 0) + $reward;

$text = "🎉 *أصبت!*\n------------------\n🔢 الرقم السري: *$secret*\n✅ كان ضمن المجموعة *$start-$end*\n💰 ربحت *$reward* $currency_name\n💳 رصيدك: {$rshq["coin"][$from_id]} $currency_name";

} else {

$text = "❌ *أخطأت!*\n------------------\n🔢 الرقم السري: *$secret*\n📦 كان في مجموعة مختلفة\n💔 لم تربح نقاط\n🎲 جرب حظك غداً";

}

setData($db['settings'], 'rshq', $rshq);

bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>$text,
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🏠 رجوع",'callback_data'=>"tobot"]]
]
])
]);
}
if($data == "set_game_reward"){
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"💰 *تعيين جائزة اللعبة*\n------------------\n🎁 الجائزة الحالية: *" . ($rshq['daily_game_reward'] ?? 25) . "* $currency_name\n\n📝 ارسل الرقم الجديد (1-500):",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"🔙 رجوع",'callback_data'=>"rshqG"]]]])
]);
$rshq['mode'][$from_id] = "set_game_reward";
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id] == "set_game_reward" and $text >= 1 and $text <= 500){
$rshq['daily_game_reward'] = $text;
setData($db['settings'], 'rshq', $rshq);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"✅ *تم تعيين جائزة اللعبة إلى $text $currency_name*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"🔙 رجوع",'callback_data'=>"rshqG"]]]])
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

$SALEH = getData($db['settings'], 'saleh');
if(!$SALEH) $SALEH = [];
$f= $SALEH['SALEH']['send']['add'];
rsort($f);
$ok = "";
for($i=0;$i<5;$i++){
if($f[$i] != null){
$V = array_search($f[$i],$SALEH['SALEH']['send']['add']);
$uS = $SALEH['SALEH']['send']['uname'][$V];
$u=$i+1;
$Numbers = array('1','2','3','4','5');
$NumbersBe = array('🥇','🥈','🥉','🏅','🏅');
$u = str_replace($Numbers,$NumbersBe,$u);
$dh=bot("getchat",['chat_id'=>$uS])->result->title;
if($dh != null) {
$fk = $dh;
}
if($dh == null) {
$fk = $uS;
}
$ok = $ok .= " $u ) ❲<b>$f[$i]</b>❳ -> <a href='tg://user?id=$uS'>$fk</a>\n";
}
}

$bot_username = bot("getMe")->result->username;
$link = "https://t.me/$bot_username?start=$from_id";
$b="<tg-emoji emoji-id=\"5375338737028841420\">📬</tg-emoji>- الاعلى في الدعوات : \n$ok" ;

if($data == "linkme") {
$sx = ($rshq["coinshare"]?? "25");
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"<b>• اهلا بك في قسم رابط الدعوه الخالص بك <tg-emoji emoji-id=\"5447410659077661506\">🌐</tg-emoji>\n----------------------------\n- شارك رابط الدعوه واحصل علي رصيد بشكل مجاني <tg-emoji emoji-id=\"5278495204553282572\">🎁</tg-emoji>\n\n• عدد دعولتك : $share <tg-emoji emoji-id=\"5895407084131848348\">👤</tg-emoji>\n• رصيد الدعوه: $sx $currency_name <tg-emoji emoji-id=\"5280943438991214029\">🛍</tg-emoji>\n\n- الرابط الخاص بك <tg-emoji emoji-id=\"5854722989240619332\">🌀</tg-emoji> :\nhttps://t.me/".bot("getme")->result->username."?start=$from_id\n\n----------------------------</b>\n$b\n",
'parse_mode'=>"HTML",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
[[ 'text' => " نسخ الرابط", 'copy_text' => ['text' =>$link], 'icon_custom_emoji_id' => "5397916757333654639"]], 
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
}

$d = date('D');
$day = explode("\n",file_get_contents($d."_".USR_BOT.".txt"));
if($d == "Sat"){
unlink("Fri_$usrbot.txt");
}
if($d == "Sun"){
unlink("Sat_".USR_BOT.".txt");
}
if($d == "Mon"){
unlink("Sun_".USR_BOT.".txt");
}
if($d == "Tue"){
unlink("Mon_".USR_BOT.".txt");
}
if($d == "Wed"){
unlink("The_".USR_BOT.".txt");
}
if($d == "Thu"){
unlink("Wedtxt");
}
if($d == "Fri"){
unlink("Thu_".USR_BOT.".txt");
}

if($data == "hdiaa"){
if(!in_array($from_id, $day)){
$HDIASs = ($rshq['hdias'] ?? "20");
bot('answercallbackquery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"🎁 لقد حصلت علي $HDIASs $currency_name 🎁",
 'show_alert'=>true,
]);
$coin = $coin + $HDIASs;
$hour = explode (".",(strtotime('tomorrow') - time()) / (60 * 60))[0];
 file_put_contents($d."_".USR_BOT.".txt",$from_id."\n",FILE_APPEND);
 $rshq["coin"][$from_id] += $HDIASs;
 setData($db['settings'], 'rshq', $rshq);
}else{
$hour = explode (".",(strtotime('tomorrow') - time()) / (60 * 60))[0];
bot('answercallbackquery',[
'callback_query_id'=>$update->callback_query->id,
 'text' =>"- اليوميه بعد $hour ساعه 🌀\n ",
'show_alert'=>true,
]);
}
}

if($data == "acc") {
$hour = explode(".", (strtotime('tomorrow') - time()) / (60 * 60))[0];
if(!in_array($from_id, $day)){
$hour = "تستطيع المطالبة بها 🎁";
} else {
$hour = explode(".", (strtotime('tomorrow') - time()) / (60 * 60))[0]." ساعة";
}
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"<b>• اهلا بك في قسم معلومات الحساب</b> <tg-emoji emoji-id=\"5231200819986047254\">📊</tg-emoji>\n\n<tg-emoji emoji-id=\"5359437015752401733\">💰</tg-emoji>- رصيدك : $coin $currency_name\n<tg-emoji emoji-id=\"5280943438991214029\">💎</tg-emoji>- الرصيد المستخدمة: ".($rshq["cointlb"][$from_id] ?? "0")." $currency_name\n<tg-emoji emoji-id=\"5447410659077661506\">🌀</tg-emoji>- لقد دعوت: $share \n<tg-emoji emoji-id=\"5895407084131848348\">📋</tg-emoji>- عدد طلباتك: $tlby \n\n<tg-emoji emoji-id=\"5337080053119336309\">🗳</tg-emoji>- <b>عدد طلبات البوت: $bot_tlb</b>\n",
'parse_mode'=>"HTML",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
//  [['text'=>"API KEY ",'callback_data'=>"api_section","style"=>"danger","icon_custom_emoji_id"=>"5449683594425410231"]],
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style"=>"danger","icon_custom_emoji_id"=>"5449683594425410231"]],
]
])
]);
}

if($data == "service") {
if($rshq['rshqG'] == "on" ) {
$key = ['inline_keyboard' => []];
$row = [];
foreach ($rshq['qsm'] as $i) {
$nameq = explode("-",$i)[0];
$id = explode("-",$i)[1];
if($rshq['IFWORK>'][$id] != "NOT"){
$btn = [
'text' => "$nameq",
'callback_data' => "SALEHENT|$id",
"style" => ""
];
if(isset($rshq['EMOJI'][$id])){
$btn["icon_custom_emoji_id"] = $rshq['EMOJI'][$id];
}
$row[] = $btn;
if(count($row) == 2){
$key['inline_keyboard'][] = $row;
$row = [];
}
}
}
if(!empty($row)){
$key['inline_keyboard'][] = $row;
}
$key['inline_keyboard'][] = [[
'text'=>"• رجوع •",
'callback_data'=>"tobot",
"style" => "danger",
"icon_custom_emoji_id" => "5449683594425410231"
]];
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*• اهلا بك عزيزي في قسم الرشق* ![📭](tg://emoji?id=5278436402156031854)\n• اختار ما اريد من الاسفل ![🛒](tg://emoji?id=5814479721202716975)\n",
'parse_mode'=>"markdownV2",
'reply_markup'=>json_encode($key),
]);
} else {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"• قسم الرشق تحت الصيانه ![⁉️](tg://emoji?id=5420323339723881652) ",
'parse_mode'=>"markdownV2",
'reply_markup'=>json_encode([
'inline_keyboard'=>[[[
'text'=>"• رجوع •",
'callback_data'=>"tobot",
"style" => "danger",
"icon_custom_emoji_id" => "5449683594425410231"
]]]])
]);
}
}

if(explode("|",$data)[0]=="SALEHENT"){
$section_id = explode("|",$data)[1];
$key = ['inline_keyboard' => []];
foreach ( $rshq['xdmaxs'][$section_id] as $hjjj => $i) {
if($i != null){
$key['inline_keyboard'][] = [['text' => "$i", 'callback_data' => "type|".$section_id."|$hjjj","style" => "primary","icon_custom_emoji_id" => "5337080053119336309"]];
}
}
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "service","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "![🛒](tg://emoji?id=5280943438991214029) * اهلا بك في قسم الخدمات:*\n![📥](tg://emoji?id=5337080053119336309) اختر الخدمات التي تريدها :",
'parse_mode' => "markdownV2",
'reply_markup' => json_encode($key),
]);
$rshq['current_section'][$from_id] = $section_id;
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "infotlb") {
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"![🆔](tg://emoji?id=5278510335723066039) *ارسل ايدي الطلب :*\n",
'parse_mode'=>"markdownV2",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]])
]);
$rshq['mode'][$from_id]= $data;
setData($db['settings'], 'rshq', $rshq);
}

$rshq["sSite"] = ($rshq["sites"][$text]??$rshq["sSite"]) ;
$Api_Tok = ($rshq["keys"][$text]?? $rshq["sToken"]) ;

if(is_numeric($text) and $rshq['mode'][$from_id] == "infotlb"){
if($text != null){
$req = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=status&order=".$text));
$status = $req->remains;
if($status == "0"){
$s= "طلب مكتمل 🟢";
$order_id = $text;
$service_name = $rshq["ordn"][$text] ?? "غير معروف";
$user_info = bot("getchat",['chat_id'=>$from_id]);
$user_name = $user_info->result->first_name ?? $name;
$user_username = $user_info->result->username ?? $user;
$proof_text = $rshq['channel_proof_text'] ?? "✅ تم اكتمال طلبك بنجاح\nالخدمة: {service_name}\nايدي الطلب: {order_id}\nالمستخدم: {user_name}";
$proof_text = str_replace("{service_name}", $service_name, $proof_text);
$proof_text = str_replace("{order_id}", $order_id, $proof_text);
$proof_text = str_replace("{user_name}", $user_name, $proof_text);
$proof_text = str_replace("{user_id}", $from_id, $proof_text);
$proof_text = str_replace("{username}", $user_username, $proof_text);
bot('sendMessage',[
'chat_id'=>$from_id,
'text'=>$proof_text,
'parse_mode'=>"markdown",
]);
if($chnl){
bot('sendMessage',[
'chat_id'=>$chnl,
'text'=>$proof_text,
'parse_mode'=>"markdown",
]);
}
}else{
$s="قيد المراجعة";
}
if($req) {
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"- معلومات عن الطلب 📋: \n----------------------------\n-⁉️ اسم الخدمة : ".$rshq["ordn"][$text]."\n-🆔 ايدي الطلب : `$text`\n-📊 حالة الطلب : $s\n-📥 المتبقي : $status\n",
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]
])
]);
$rshq['mode'][$from_id]= null;
setData($db['settings'], 'rshq', $rshq);
} else {
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"️هذا الطلب ليس موجود في طلباتك ❌\n",
 'parse_mode'=>"markdown",
]);
}
}
}

$e = explode("|", $data);
if($e[0] == "type"){
$section_id = explode("|",$data)[1];
$service_index = explode("|",$data)[2];
$s3r = $rshq['S3RS'][$section_id][$service_index];
$web = ($rshq['Web'][$section_id][$service_index]??$rshq["sSite"]) ;
$s3r = ($s3r ?? "1");
$key = ($rshq['key'][$section_id][$service_index] ?? $rshq["sToken"]);
$mix = ($rshq['mix'][$section_id][$service_index] ?? "1000");
$min = ($rshq['min'][$section_id][$service_index] ?? "100");
$g= $s3r * 1000;
$last_request_time = $rshq['last_request_time'][$from_id][$section_id] ?? 0;
$section_timer_status = $rshq['section_timer'][$section_id] ?? "off";
if($section_timer_status == "on" && $last_request_time > 0){
$time_diff = time() - $last_request_time;
if($time_diff < 86400){
$remaining_hours = floor((86400 - $time_diff) / 3600);
$remaining_minutes = floor(((86400 - $time_diff) % 3600) / 60);
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*⚠️ نظام ال 24 ساعه مفعل في هذا القسم\nلا يمكنك طلب خدمه من هذا القسم الا بعد $remaining_hours ساعه و $remaining_minutes دقيقه\n*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'رجوع' ,'callback_data'=>"SALEHENT|$section_id"]],
]
])
]);
$rshq['mode'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
return;
}
}
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"<b> <tg-emoji emoji-id=\"5312361253610475399\">🛒</tg-emoji>- اهلا بك في خدمه : ".$rshq['xdmaxs'][$section_id][$service_index]."\n----------------------------\n<tg-emoji emoji-id=\"5193065010795911968\">🛍</tg-emoji>- السعر : ". $g ." $currency_name لكل 1000\n<tg-emoji emoji-id=\"5406683434124859552\">📊</tg-emoji>- الحد الادني للرشق : $min الحد الاقصي للرشق : $mix\n\n<tg-emoji emoji-id=\"5449683594425410231\">🌀</tg-emoji>- ارسل الكمية التي تريد طلبها :</b>\n",
'parse_mode'=>"HTML",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'رجوع' ,'callback_data'=>"SALEHENT|$section_id","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]])
]);
$rshq['IDX'][$from_id]=$rshq['IDSSS'][$section_id][$service_index];
$rshq['WSFV'][$from_id]=$rshq['WSF'][$section_id][$service_index];
$rshq['S3RS'][$from_id]=$s3r;
$rshq['web'][$from_id]=$web;
$rshq['key'][$from_id]=$key;
$rshq['min_mix'][$from_id]= "$min|$mix" ;
$rshq['SB1'][$from_id]=$section_id;
$rshq['mode'][$from_id]="SETd";
$rshq['SB2'][$from_id]=$service_index;
$rshq["="][$from_id] = $rshq['xdmaxs'][$section_id][$service_index];
$rshq['current_service_section'][$from_id] = $section_id;
setData($db['settings'], 'rshq', $rshq);
}

if($data== "tobon"){
bot("deletemessage",["message_id" => $message_id,"chat_id" => $chat_id,]);
$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"• تم الالغاء ارسل /start 🚫",
'parse_mode'=>"markdown",
]);
$rshq['3dd'][$from_id][$from_id]= null;
$rshq['mode'][$from_id]= null;
$rshq["tlbia"][$from_id] = null;
$rshq["cointlb"][$from_id] += null;
$rshq["s3rltlb"][$from_id] = null;
$rshq['tp'][$from_id] = null;
$rshq['coinn'] = null;
setData($db['settings'], 'rshq', $rshq);
}

if(is_numeric($text) and $rshq['mode'][$from_id]=="SETd") {
$s3r = $rshq['S3RS'][$from_id];
$e[1] = $text;
$s3r = $s3r * $text;
$min = explode("|", $rshq['min_mix'][$from_id])[0];
$mix = explode("|", $rshq['min_mix'][$from_id])[1];
if($coin >= $s3r){
if($rshq['rshqG'] == "on" ) {
if($text >= $min){
if($text <= $mix){
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"".$rshq['WSFV'][$from_id]."• ارسل الرابط الخاص بك 🌐 :\n",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'الغاء الطلب' ,'callback_data'=>"tobon"]],
]])
]);
$rshq['3dd'][$from_id][$from_id]= $e[1];
$rshq['mode'][$from_id]= "MJK";
$rshq["tlbia"][$from_id] = $tlbia;
$rshq["s3rltlb"][$from_id] = $s3r;
$rshq['tp'][$from_id] = $e[2];
$rshq['coinn'] = $s3r;
setData($db['settings'], 'rshq', $rshq);
} else {
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*• ارسل عدد اصغر او يساوي $mix 🗳*\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'الغاء الطلب' ,'callback_data'=>"tobon"]],
]])
]);
}
} else {
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*• ارسل عدد اكبر من او يساوي $min 🎉\n*\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'الغاء الطلب' ,'callback_data'=>"tobon"]],
]])
]);
}
} else {
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"• قسم الرشق تحت الصيانه ![⁉️](tg://emoji?id=5420323339723881652) ",
'parse_mode'=>"markdownV2",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"tobot","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
]])
]);
}
} else {
$s3r = $rshq['S3RS'][$from_id];
$s3r = ($s3r ?? "1");
$g= $s3r * $text ;
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*رصيدك لايكفي لطلب $text 🚫*\n----------------------------\n🛒- سعر طلبك :". $g. " $currency_name\n🛍- عدد طلبك : $text",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>'الغاء الطلب' ,'callback_data'=>"tobon"]],
]
])
]);
}
exit; 
}

if($text and $rshq['mode'][$from_id]== "MJK") {
if(preg_match("/http|https/",$text) ){
$s3r = $rshq['S3RS'][$from_id];
$s3r = ($s3r ?? "1");
$g= $s3r * $rshq['3dd'][$from_id][$from_id];
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"• لتاكيد الطلب التالي 📥\n----------------------------\n🛍- سعر طلبك :". $g. " $currency_name\n🆔- ايدي الخدمة : ".rand(999999,9999999999999)."\n🌐- الرابط: [$text]\n🛒- الكمية : ".$rshq['3dd'][$from_id][$from_id]."",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"تأكيد ♻️",'callback_data'=>"YESS|$from_id" ],['text'=>"الغاء ❌",'callback_data'=>"tobot" ]],
]
])
]);
$rshq['LINKS_$from_id'] = $text;
$rshq['mode'][$from_id] = "PROG";
setData($db['settings'], 'rshq', $rshq);
}else{
 bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"ارسل رابط صحيح!\n",
'parse_mode'=>"markdown",
]);
}
}

$rshq["sSite"] = ($rshq['web'][$from_id]?? $rshq["sSite"]) ;
$Api_Tok = ($rshq['key'][$from_id]?? $rshq["sToken"]) ;
$rshqaft =$rshq['bot_tlb']+1;
$rnd = rand(9999999,9999999999);

if(explode("|",$data)[0] == "YESS" and $rshq['mode'][$from_id]== "PROG") {
$rshq = getData($db['settings'], 'rshq');
$rshq['S3RS'][$from_id] =$rshq["s3rltlb"][$from_id];
$inid = $rshq['IDX'][$from_id];
$text = $rshq['LINKS_$from_id'];
$rsedi = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=balance"));
$flos = $rsedi->balance ?? 0;
if($flos <= 0) {
bot('deleteMessage',['chat_id'=>$chat_id, 'message_id'=>$message_id]);
bot('sendMessage',['chat_id'=>$chat_id, 'text'=>"❌ حدث خطأ برجاء التواصل مع الادمن", 'parse_mode'=>"markdown", 'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"• رجوع •",'callback_data'=>"tobot"]]]])]);
bot('sendMessage',['chat_id'=>$saleh, 'text'=>"⚠️ تنبيه: رصيد الموقع غير كافي!\nالمستخدم: $name\nالايدي: $from_id\nالخدمة: ".$rshq["="][$from_id]."\nالكمية: ".$rshq['3dd'][$from_id][$from_id], 'parse_mode'=>"markdown"]);
$rshq['mode'][$from_id] = null;
$rshq['3dd'][$from_id][$from_id] = null;
$rshq["s3rltlb"][$from_id] = null;
$rshq['current_service_section'][$from_id] = null;
setData($db['settings'], 'rshq', $rshq);
exit;
}
$requst = json_decode(file_get_contents("https://".$rshq["sSite"]."/api/v2?key=$Api_Tok&action=add&service=$inid&link=$text&quantity=". $rshq['3dd'][$from_id][$from_id]));
$idreq = $requst->order;
$current_section = $rshq['current_service_section'][$from_id];
if(!isset($rshq['pending_orders'])) $rshq['pending_orders'] = [];
$rshq['pending_orders'][$rnd] = [
'service_order_id' => $idreq,
'user_id' => $from_id,
'points' => $rshq["s3rltlb"][$from_id],
'site' => $rshq["sSite"],
'api_key' => $Api_Tok,
'status' => 'pending',
'created_at' => time()
];
if($current_section && $rshq['section_timer'][$current_section] == "on"){
$rshq['last_request_time'][$from_id][$current_section] = time();
}
bot('editmessagetext',[
 'chat_id'=>$chat_id,
 "message_id" => $message_id,
 'text'=>"*📥 تم انشاء طلب بنجاح 📥:*\n----------------------------\n🆔- ايدي الطلب : `". $idreq."`\n🌐- تم الطلب الى : [$text]\n",
 'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
]
])
]);
bot('sendMessage',[
 'chat_id'=>$saleh,
 'text'=>"• تم انشاء طلب جديد من البوت 📊\n----------------------------\n• معلومات العضو 🆔: \n\n- ايديه : `$from_id`\n- يوزره : [@$user]\n- اسمه : [$name](tg://user?id=$chat_id)\n\n• معلومات الطلب 🛍: \n\n- ايدي الطلب : `". $rnd. "`\n- الرابط: [$text]\n- العدد". $rshq['3dd'][$from_id][$from_id] . " $tp\n\n- رصيده المتبقي: ". $rshq["coin"][$from_id]. " 🎉\n",
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode([
 'inline_keyboard'=>[
]
])
]);
$service_name = $rshq["="][$from_id];
$proof_text = $rshq['channel_proof_text'] ?? "✅ طلب جديد\nالخدمة: #service_name\nالكمية: #quantity\nالرابط: #link\nالمستخدم: #first_name\nايدي المستخدم: #user_id\nايدي الطلب: #order_id";
$proof_text = str_replace(
[
"#service_name",
"#quantity",
"#link",
"#first_name",
"#user_name",
"#user_id",
"#username",
"#order_id"
],
[
$service_name,
$rshq['3dd'][$from_id][$from_id],
$text,
$name,
$name,
$from_id,
$user ? "@$user" : "لا يوجد",
$rnd
],
$proof_text
);
if($chnl){
bot('sendMessage',[
 'chat_id'=>$chnl,
 'text'=>"*$proof_text*]",
 'parse_mode'=>"markdown",
]);
}
$rnn = "- الطلب: ".$rshq["="][$from_id]."- ايدي: $rnd\n";
$rshq["coin"][$from_id] -=$rshq["s3rltlb"][$from_id];
$rshq['S3RS'][$from_id] = 0;
$rshq["orders"][$from_id][]= "$rnn";
$rshq["order"][$rnd]= $idreq;
$rshq["ordn"][$idreq]= $rshq["="][$from_id];
$rshq["sites"][$idreq]= $web;
$rshq["keys"][$idreq]= $Api_Tok;
$rshq["tlby"][$from_id] += 1;
$rshq["cointlb"][$from_id] +=$rshq["s3rltlb"][$from_id];
$rshq['3dd'][$from_id][$from_id]= null;
$rshq['mode'][$from_id]= null;
$rshq['current_service_section'][$from_id] = null;
$rshq['bot_tlb']+= 1;
setData($db['settings'], 'rshq', $rshq);
}

if($data == "tmoil-Namero") {
 $funding_status = $rshq['funding_status'] ?? "on";
 if($funding_status == "off") {
 bot('EditMessageText',[
 'chat_id'=>$chat_id,
 'message_id'=>$message_id,
 'text'=>"*نظام التمويل مغلق حاليا ❌\n*",
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"user_funding_main","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
 ]
 ])
 ]);
 die();
}
 $s3rtmoil = $rshq["s3rtmoil"]?? "12";
 $idna = $tmoil["tmoils"]??"10";
 bot('EditMessageText',[
 'chat_id'=>$chat_id,
 'message_id'=>$message_id,
 'text'=>"*💥- اهلا بك في تمويل قناتك\n\n🛍 سعر العضو : $s3rtmoil نقطة\n♻️- الحد الأدنى للتمويل:". $idna." عضو\n📣 ارسل عدد الاعضاء المراد تمويلهم*",
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"user_funding_main","style" => "danger","icon_custom_emoji_id" => "5449683594425410231"]],
 ]
 ])
 ]);
 $modes['mode'][$from_id]= $data ;
 setData($db['settings'], 'modes', $modes);
}

$data_ = explode("|", $data) ;
$helper = USR_BOT ;
$idna = $tmoil["tmoils"]??"10";

if(is_numeric($text) and $modes['mode'][$from_id] == "tmoil-Namero" ){
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
$s3rtmoil = $rshq["s3rtmoil"]?? "12";
$PrIce = $data_[1] * $s3rtmoil;
if($coin >= $PrIce) {
bot('sendmessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
- الان اضف هذه البوت @". $helper."مشرف في قناتك او مجموعتك مع اعطاء البوت الصلاحيات\n\n- ثم ارسل يوزر القناة او المجموعة \nبهذا الشكل (@اليوزر) \n\n~ اقرأ الخطوات جيدا ❤\n",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"• رجوع •",'callback_data'=>"user_funding_main"]],
 ]
 ])
]);
$tmoil['sets'][$from_id]["count"] = $data_[1];
$tmoil["sets"][$from_id]["price"] = $PrIce;
$tmoil["sets"][$from_id]["to"] = "P1";
$modes['mode'][$from_id]= null ;
setData($db['funding'], 'tmoil', $tmoil);
setData($db['settings'], 'modes', $modes);
} else {
$g = $PrIce - $coin;
bot('sendmessage',[
'chat_id' => $chat_id, 
'text'=>"
رصيدك لايكفي ❌
تحتاج $g نقطه فوق رصيدك لتتمكن من تمويل العدد المطلوب 
",
]);
} 
}

if(preg_match("/@/",$text) and $tmoil["sets"][$from_id]["to"] == "P1") {
$text = str_replace("@", "", $text);
if (in_array($text, $tmoil['db']["chs"])) {
bot('sendMessage', [
'chat_id' => $chat_id,
'text' => "⚠️ عذرًا، هذا المعرف قيد التمويل حاليًا\nلا يمكن تنفيذ طلب تمويل جديد في الوقت الحالي\n\n📣 @$text\n\n🕓 يرجى الانتظار حتى انتهاء التمويل الحالي، ثم يمكنك إعادة التقديم مرة أخرى",
'parse_mode' => "markdown"
]);
unset($tmoil["sets"][$from_id]);
setData($db['funding'], 'tmoil', $tmoil);
return;
}
$text = str_replace ("@",null, $text) ;
if(in_array($text, $tmoil["blocks"])) {
bot('sendMessage',[
 'chat_id'=>$chat_id ,
 'text'=>"
⚠️ عذرا ولكن القناة تم حظرها من التمويل
🎟️] معرفها : [@$text]
", 
'parse_mode'=>"markdown",
]);
unset($tmoil["sets"][$from_id]);
setData($db['funding'], 'tmoil', $tmoil);
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
- معلومات الطلب : 📝\n\n- اليوزر : [@$text]✅\n- الكمية : $kmia 🔢\n- السعر : $coi 💰\n", 
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"تأكيد الطلب ✅",'callback_data'=>"ADDMOL|$idM" ]], 
 [['text'=>"• رجوع •",'callback_data'=>"user_funding_main"]], 
 ]
 ])
]);
$tmoil['info']["$idM"] = "$text|$kmia|$coi" ;
$tmoil['chanels']["id_$text"] = $idM;
$tmoil["sets"][$from_id]["to"] = "P2";
setData($db['funding'], 'tmoil', $tmoil);
} else {
bot('sendMessage',[
 'chat_id'=>$chat_id ,
 'text'=>"
البوت ليس مشرف ❌
- تاكد من ان يكون البوت مشرف مع اعطاء الصلاحيات للبوت ثم اعد ارسال اليوزر ", 
'parse_mode'=>"markdown",
]);
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
 'text'=>$start_msg, 
 'parse_mode'=>"HTML",
 'reply_markup'=>json_encode($RSALEH)
]);
exit ;
} 
$getChatMemberReq = json_encode(bot('getChatMember', ['chat_id' => "@$text" , 'user_id' => IDBot]));
$getChatMemberRes = json_decode($getChatMemberReq, true);
if ($getChatMemberRes['result']['status'] == "administrator") {
$kmia=$vZ[1];
$coi=$vZ[2];
$idM = $data_[1];
if($coin >= $coi) {
$rshq["coin"][$from_id] -= $coi;
setData($db['settings'], 'rshq', $rshq);
$date = date("d|m|y:H:i:s");
bot('editMessagetext',[
 'chat_id'=>$chat_id ,
 'message_id' => $message_id, 
 'text'=>"
- تم انشاء الطلب بنجاح : 🗳️\n\n- اليوزر : [@$text] ✅\n- الكمية : $kmia 🔢\n- السعر : $coi 💰\n- التاريخ : $date 🗓️\n\n⚠️) لا تقم بتنزيل البوت [@". bot("getme")->result->username. "] \nمن الادمنية حتى لا يتم الغاء طلبك 🤍\n", 
'parse_mode'=>"markdown",
]);
@mkdir("edid");
@mkdir("edid/@$text");
$tmoil['coin'][$from_id] -= $coi;
$tmoil['chanels']["id_$text"] = $idM;
$tmoil['db']["$idM"]["count"] = $kmia;
$tmoil['db']["chs"][] = $text ;
$tmoil['db']["chsme"][$from_id][] = $text ;
$tmoil['db']["$idM"]["price"] = $coi;
$tmoil['db']["$idM"]["owner"] = $from_id ;
$tmoil['db']["$idM"]["create"] = $date ;
$tmoil['db']["$idM"]["startc"] = 0;
$tmoil['db']["$idM"]["joined_users"] = []; 
$tmoil["sets"][$from_id]["to"] =null ;
setData($db['funding'], 'tmoil', $tmoil);
$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>$start_msg,
 'parse_mode'=>"HTML",
 'reply_markup'=>json_encode($RSALEH)
]);
} else {
bot('sendmessage',[
 'chat_id'=>$chat_id ,
 'message_id' => $message_id, 
 'text'=>"
⁉️] رصيدك لايكفي، 
", 
'parse_mode'=>"markdown",
]);
$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>$start_msg,
 'parse_mode'=>"HTML",
 'reply_markup'=>json_encode($RSALEH)
]);
} 
} else {
bot('sendMessage',[
 'chat_id'=>$chat_id ,
 'text'=>"
- الان اضف هذه البوت @". $helper."مشرف في قناتك او مجموعتك مع اعطاء البوت الصلاحيات\n\n- ثم ارسل يوزر القناة او المجموعة \nبهذا الشكل (@اليوزر) \n\n~ اقرأ الخطوات جيدا ❤\n", 
'parse_mode'=>"markdown",
]);
}
}

if($data_[0] == "getv") {
$chs = $data_[1];
$bv = $chs;
$mt = json_encode(bot('getChatMember', ['chat_id' => "@".$chs , 'user_id' => IDBot]));
$nt = json_decode($mt, true);
$bv = $chs;
if ($nt['result']['status'] == "administrator") {
$getChatMemberReq = file_get_contents("https://api.telegram.org/bot". API_KEY. "/getChatMember?chat_id=@" . $bv . "&user_id=" . $from_id);
$getChatMemberRes = json_decode($getChatMemberReq, true);
if ($getChatMemberRes['result']['status'] != "left" && $getChatMemberRes['result']['status'] == "member" || $getChatMemberRes['result']['status'] == "creator" || $getChatMemberRes['result']['status'] == "administrator") {
$j = @file_get_contents("edid/@$bv/from_id.txt");
$arr = explode("\n", $j);
if(in_array($from_id, $arr)){
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text' =>"تم التحقق من اعاده الاشتراك في القناة ✅", 
'show_alert' =>true
]); 
bot("deleteMessage", [
"chat_id" => $chat_id,
"message_id" => $message_id,
]);
bot('editMessagetext',[
'chat_id'=>$chat_id,
'message_id' => $message_id, 
'text'=>"* لإكمال الاشتراك في القنوات* ✅", 
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"اكمال الاشتراك ✅",'callback_data'=>"joins|1" ]], 
[['text'=>"• رجوع •",'callback_data'=>"user_funding_main" ]], 
]
])
]); 
return false;
}
$coinIshtrak = $rshq["coinNmero"] ?? "5";
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"تم اضافه $coinIshtrak $currency_name الي حسابك ✅",
'show_alert'=>true
]);
file_put_contents("edid/@$bv/from_id.txt", $from_id . "\n", FILE_APPEND);
$rshq["coin"][$from_id] += $coinIshtrak;
setData($db['settings'], 'rshq', $rshq); 
$idM = $tmoil['chanels']["id_$bv"];
$ci = $tmoil['db']["$idM"]["count"];
$vx = $ci - $tmoil['db']["$idM"]["startc"];
$vx = $vx - 1;
$tmoil['db']["$idM"]["startc"] += 1;
$tmoil['db']["$idM"]["joined_users"][] = $from_id;
$tmoil["chids"][$from_id][] = $idM;
setData($db['funding'], 'tmoil', $tmoil);
if($vx == 0){
@unlink("edid/@$bv");
bot('sendMessage',[
'chat_id'=>$tmoil['db']["$idM"]["owner"],
'text'=>"• تم انتهاء تمويلك بنجاح ✅\n\n- اليوزر : [@$bv] \n- العدد المطلوب : $ci \n- العدد المكتمل : $ci \n\n• نتمنى لكم وقتاً سعيداً 🤍",
'parse_mode'=>"markdown",
]); 
bot('sendMessage',[
'chat_id'=>$saleh,
'text'=>"• تم انتهاء تمويلك بنجاح ✅\n\n- اليوزر : [@$bv] \n- العدد المطلوب : $ci \n- العدد المكتمل : $ci \n\n• نتمنى لكم وقتاً سعيداً 🤍",
'parse_mode'=>"markdown",
]); 
$st = array_search($bv, $tmoil['db']["chs"]);
if($st !== false){
unset($tmoil['db']["chs"][$st]);
$tmoil['db']["chs"] = array_values($tmoil['db']["chs"]);
}
$tmoil['db']["complete"][] = $bv;
setData($db['funding'], 'tmoil', $tmoil);
$dirPath = "edid/@$bv";
if(is_dir($dirPath)){
$files = glob(rtrim($dirPath, '/') . '/*');
foreach ($files as $file) {
is_dir($file) ? deleteDirectory($file) : unlink($file);
}
rmdir($dirPath);
}
}
$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
bot('editMessagetext',[
'chat_id'=>$chat_id,
'message_id' => $message_id, 
'text'=>$start_msg, 
'parse_mode'=>"markdown",
'reply_markup'=>json_encode($RSALEH)
]);
} else {
$coinIshtrak = $rshq["coinNmero"] ?? "5";
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"❌ لم يتم الاشتراك في القناة @$bv بعد!\nاشترك اولاً ثم اضغط اشتركت ✅\nستحصل على $coinIshtrak $currency_name",
'show_alert'=>true
]);
}
} else {
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"⚠️ البوت ليس مشرفاً في القناة @$bv",
'show_alert'=>true
]);
}
}

if($data_[0] == "joins") {
if($data_[1] == "1"){
$funding_status = $rshq['funding_status'] ?? "on";
if($funding_status == "off"){
bot('editMessagetext',[
'chat_id'=>$chat_id,
'message_id' => $message_id, 
'text'=>"*نظام التمويل مغلق حاليا ❌*", 
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"• رجوع •",'callback_data'=>"user_funding_main"]],
]
])
]);
return;
}
$skip_channels = $rshq['skip_channels'][$from_id] ?? [];
$found_channel = false;
foreach ($tmoil['db']["chs"] as $chs) {
if(in_array($chs, $skip_channels)){
continue;
}
$idM = $tmoil['chanels']["id_$chs"];
if (in_array($from_id, $tmoil['db']["$idM"]["joined_users"] ?? [])) {
continue;
}
if(!in_array($idM, $tmoil["chids"][$from_id] ?? [])) {
$mt = json_encode(bot('getChatMember', ['chat_id' => "@".$chs , 'user_id' => IDBot]));
$nt = json_decode($mt, true);
$bv = $chs;
if ($nt['result']['status'] == "administrator") {
$getChatMemberReq = file_get_contents("https://api.telegram.org/bot". API_KEY. "/getChatMember?chat_id=@" . $bv . "&user_id=" . $from_id);
$getChatMemberRes = json_decode($getChatMemberReq, true);
if ($getChatMemberRes['result']['status'] == "left" || $getChatMemberRes['result']['status'] == "kicked") {
$getch2 = json_decode(file_get_contents("https://api.telegram.org/bot". API_KEY. "/getChat?chat_id=@$bv"))->result;
$getN = $getch2->title;
if($getN == null) { $getN = "@$bv";}
$coinIshtrak = $rshq["coinNmero"] ?? "5";
bot('editMessagetext',[
'chat_id'=>$chat_id,
'message_id' => $message_id, 
'text'=>"*📮| اشترك في القناة : @$bv\n💎| ستحصل على : $coinIshtrak $currency_name*", 
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"تخطي ♻️",'callback_data'=>"skip_channel|$bv"]],
[['text'=>"اشتركت ✅",'callback_data'=>"getv|$bv" ],['text'=>"ارسـال ابـلاغ ⚠️",'callback_data'=>"sendblock|$bv" ]],
[['text'=>"• رجوع •",'callback_data'=>"user_funding_main" ]]
]
])
]);
$found_channel = true;
return;
} else {
$j = @file_get_contents("edid/@$bv/from_id.txt");
if(!in_array($from_id, explode("\n", $j))){
$coinIshtrak = $rshq["coinNmero"] ?? "5";
file_put_contents("edid/@$bv/from_id.txt", $from_id . "\n", FILE_APPEND);
$rshq["coin"][$from_id] += $coinIshtrak;
setData($db['settings'], 'rshq', $rshq);
$tmoil['db']["$idM"]["startc"] += 1;
$tmoil['db']["$idM"]["joined_users"][] = $from_id;
$tmoil["chids"][$from_id][] = $idM;
setData($db['funding'], 'tmoil', $tmoil);
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"✅ تم اضافه $coinIshtrak $currency_name الي حسابك",
'show_alert'=>true
]);
$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
bot('editMessagetext',[
'chat_id'=>$chat_id,
'message_id' => $message_id, 
'text'=>$start_msg, 
'parse_mode'=>"HTML",
'reply_markup'=>json_encode($RSALEH)
]);
return;
}
}
}
}
}
if(!$found_channel){
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"⛔ لا توجد قنوات متاحة للاشتراك حالياً\nقم بتجميع $currency_name عن طريق رابط الدعوه",
'show_alert'=>true
]);
$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
bot('editMessagetext',[
'chat_id'=>$chat_id,
'message_id' => $message_id, 
'text'=>$start_msg, 
'parse_mode'=>"HTML",
'reply_markup'=>json_encode($RSALEH)
]);
}
}
}

if($data_[0] == "skip_channel"){
$bv = $data_[1];
if(!isset($rshq['skip_channels'][$from_id])){
$rshq['skip_channels'][$from_id] = [];
}
if(!in_array($bv, $rshq['skip_channels'][$from_id])){
$rshq['skip_channels'][$from_id][] = $bv;
setData($db['settings'], 'rshq', $rshq);
}
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"✅ تم تخطي قناة @$bv",
'show_alert'=>true
]);
$funding_status = $rshq['funding_status'] ?? "on";
if($funding_status == "off"){
bot('editMessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"*نظام التمويل مغلق حاليا ❌*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"• رجوع •",'callback_data'=>"user_funding_main"]]]])
]);
return;
}
$skip_channels = $rshq['skip_channels'][$from_id] ?? [];
$found_channel = false;
foreach ($tmoil['db']["chs"] as $chs) {
if(in_array($chs, $skip_channels)){
continue;
}
$idM = $tmoil['chanels']["id_$chs"];
if (in_array($from_id, $tmoil['db']["$idM"]["joined_users"] ?? [])) {
continue;
}
if(!in_array($idM, $tmoil["chids"][$from_id] ?? [])) {
$mt = json_encode(bot('getChatMember', ['chat_id' => "@".$chs , 'user_id' => IDBot]));
$nt = json_decode($mt, true);
$bv = $chs;
if ($nt['result']['status'] == "administrator") {
$getChatMemberReq = file_get_contents("https://api.telegram.org/bot". API_KEY. "/getChatMember?chat_id=@" . $bv . "&user_id=" . $from_id);
$getChatMemberRes = json_decode($getChatMemberReq, true);
if ($getChatMemberRes['result']['status'] == "left" || $getChatMemberRes['result']['status'] == "kicked") {
$getch2 = json_decode(file_get_contents("https://api.telegram.org/bot". API_KEY. "/getChat?chat_id=@$bv"))->result;
$getN = $getch2->title;
if($getN == null) { $getN = "@$bv";}
$coinIshtrak = $rshq["coinNmero"] ?? "5";
bot('editMessagetext',[
'chat_id'=>$chat_id,
'message_id' => $message_id, 
'text'=>"*📮| اشترك في القناة : @$bv\n💎| ستحصل على : $coinIshtrak $currency_name*", 
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"تخطي ♻️",'callback_data'=>"skip_channel|$bv"]],
[['text'=>"اشتركت ✅",'callback_data'=>"getv|$bv" ],['text'=>"ارسـال ابـلاغ ⚠️",'callback_data'=>"sendblock|$bv" ]],
[['text'=>"• رجوع •",'callback_data'=>"user_funding_main" ]]
]
])
]);
$found_channel = true;
return;
} else {
$j = @file_get_contents("edid/@$bv/from_id.txt");
if(!in_array($from_id, explode("\n", $j))){
$coinIshtrak = $rshq["coinNmero"] ?? "5";
file_put_contents("edid/@$bv/from_id.txt", $from_id . "\n", FILE_APPEND);
$rshq["coin"][$from_id] += $coinIshtrak;
setData($db['settings'], 'rshq', $rshq);
$tmoil['db']["$idM"]["startc"] += 1;
$tmoil['db']["$idM"]["joined_users"][] = $from_id;
$tmoil["chids"][$from_id][] = $idM;
setData($db['funding'], 'tmoil', $tmoil);
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"✅ تم اضافه $coinIshtrak $currency_name الي حسابك",
'show_alert'=>true
]);
$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
bot('editMessagetext',[
'chat_id'=>$chat_id,
'message_id' => $message_id, 
'text'=>$start_msg, 
'parse_mode'=>"HTML",
'reply_markup'=>json_encode($RSALEH)
]);
return;
}
}
}
}
}
if(!$found_channel){
bot('editMessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"✅ تم تخطي جميع القنوات المتاحة",
'reply_markup'=>json_encode(['inline_keyboard'=>[[['text'=>"• رجوع •",'callback_data'=>"user_funding_main"]]]])
]);
}
}

foreach ($tmoil["chids"][$from_id] ?? [] as $idM) {
$info = $tmoil['db'][$idM] ?? null;
$channel = null;
if($info) $channel = array_search($idM, $tmoil['chanels']);
if(!$channel) continue;
$get = bot('getChatMember', ['chat_id' => "@$channel", 'user_id' => $from_id]);
$res = $get->result->status ?? 'left';
if($res == "left"){
$coinTaken = $rshq["leave_penalty"] ?? 5;
$rshq["coin"][$from_id] -= $coinTaken;
if ($rshq["coin"][$from_id] < 0) $rshq["coin"][$from_id] = 0;
$index = array_search($idM, $tmoil["chids"][$from_id]);
if($index !== false) unset($tmoil["chids"][$from_id][$index]);
bot('sendMessage',[
'chat_id'=>$from_id,
'text'=>"
📛 لقد قمت بمغادرة قناة [@$channel]
⛔ تم خصم $coinTaken $currency_name من حسابك بسبب المغادرة.
",
'parse_mode'=>"markdown",
]);
setData($db['settings'], 'rshq', $rshq);
setData($db['funding'], 'tmoil', $tmoil);
}
}

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
 'chat_id'=>$saleh ,
 'text'=>"
🍪] ابلاغ جديد عزيزي المطور\n\n🔛] من [$name](tg://user?id=$chat_id) \n👤] معرفه : [@$user] \n🔔] الي القناة : [@$bv] \n", 
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"@$bv",'url'=>"https://t.me/$data_[1]" ]], 
 [['text'=>"ازاله من التمويل 🌀",'callback_data'=>"delete|$bv" ]], 
 ]
 ])
]);
$tmoil['blockers']["$from_id"][] = $data_[1];
setData($db['funding'], 'tmoil', $tmoil); 
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"
📛] القناة مبلغ عليها من قبلك بالفعل
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
if($st !== false){
unset($tmoil['db']["chs"][$st]);
$tmoil['db']["chs"]=array_values($tmoil['db']["chs"]);
}
setData($db['funding'], 'tmoil', $tmoil); 
$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
bot('editMessagetext',[
 'chat_id'=>$chat_id,
 'message_id' => $message_id, 
 'text'=>$start_msg, 
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode($RSALEH)
]);
}

if($data_[0] == "deletereblock") {
$f="@".$data_[1];
$bv = str_replace("@",null, $f) ;
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"
📊] تم ازاله القناة [$f] من التمويل وتم حظرها من التمويل 
",
'show_alert'=>true
]);
$bv = $data_[1];
$st=array_search($bv,$tmoil['db']["chs"]);
if($st !== false){
unset($tmoil['db']["chs"][$st]);
$tmoil['db']["chs"]=array_values($tmoil['db']["chs"]);
}
$tmoil["blocks"][] = $bv;
setData($db['funding'], 'tmoil', $tmoil); 
$start_msg = parse_start_message($start_message, $coin, $currency_name, $share, $tlby, $from_id, $name, $user);
bot('editMessagetext',[
 'chat_id'=>$chat_id,
 'message_id' => $message_id, 
 'text'=>$start_msg, 
 'parse_mode'=>"markdown",
 'reply_markup'=>json_encode($RSALEH)
]);
}

if($data_[0] == "deysx") {
$bv = $data_[1];
bot('editMessagetext',[
 'chat_id'=>$saleh ,
 "message_id" => $message_id, 
 'text'=>"
🍪] قائمه الابلاغ\n\n🔔] الي القناة : [@$bv] \n", 
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
 'inline_keyboard'=>[
 [['text'=>"@$bv",'url'=>"https://t.me/$data_[1]" ]], 
 [['text'=>"ازاله من التمويل 🌀",'callback_data'=>"delete|$bv" ]], 
 ]
 ])
]);
}


if($data == "backup_panel"){
$key = ['inline_keyboard' => []];
$key['inline_keyboard'][] = [['text' => "📦 عمل نسخة احتياطية كاملة", 'callback_data' => "create_full_backup"]];
$key['inline_keyboard'][] = [['text' => "📋 استعادة نسخة احتياطية", 'callback_data' => "restore_backup"]];
$key['inline_keyboard'][] = [['text' => "📁 قائمة النسخ الاحتياطية", 'callback_data' => "list_backups"]];
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "rshqG"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*💾 نظام النسخ الاحتياطي\n\nيمكنك عمل نسخة احتياطية كاملة لجميع بيانات البوت واستعادتها عند الحاجة*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if($data == "create_full_backup"){
$backup_dir = __DIR__ . "/backups/$bot_id/";
if(!file_exists($backup_dir)) mkdir($backup_dir, 0777, true);
$backup_file = $backup_dir . "backup_" . date("Y-m-d_H-i-s") . ".json";
$backup_data = [];
foreach($db as $db_name => $conn){
$result = $conn->query("SELECT * FROM data");
$backup_data[$db_name] = [];
while($row = $result->fetchArray(SQLITE3_ASSOC)){
$backup_data[$db_name][] = $row;
}
}
file_put_contents($backup_file, json_encode($backup_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
$filesize = round(filesize($backup_file) / 1024, 2);
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*✅ تم إنشاء النسخة الاحتياطية بنجاح!\n\n📁 اسم الملف: " . basename($backup_file) . "\n💾 الحجم: $filesize KB\n🕐 التاريخ: " . date("Y-m-d H:i:s") . "*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "📦 العودة للنسخ الاحتياطي", 'callback_data' => "backup_panel"]]]]),
]);
$dev_id = $rshq['developer_id'] ?? $saleh;
bot('sendDocument', [
'chat_id' => $dev_id,
'document' => new CURLFile($backup_file),
'caption' => "📦 *نسخة احتياطية جديدة للبوت*\n🕐 التاريخ: " . date("Y-m-d H:i:s"),
'parse_mode' => "markdown",
]);
}

if($data == "list_backups"){
$backup_dir = __DIR__ . "/backups/$bot_id/";
if(!file_exists($backup_dir)){
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*📭 لا توجد نسخ احتياطية بعد*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "• رجوع •", 'callback_data' => "backup_panel"]]]]),
]);
return;
}
$backups = glob($backup_dir . "*.json");
if(empty($backups)){
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*📭 لا توجد نسخ احتياطية بعد*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "• رجوع •", 'callback_data' => "backup_panel"]]]]),
]);
return;
}
rsort($backups);
$key = ['inline_keyboard' => []];
$count = 0;
foreach($backups as $backup){
if($count >= 10) break;
$backup_name = basename($backup);
$backup_time = str_replace(["backup_", ".json"], "", $backup_name);
$key['inline_keyboard'][] = [['text' => "📄 $backup_time", 'callback_data' => "restore_this_backup|$backup_name"]];
$count++;
}
$key['inline_keyboard'][] = [['text' => "• رجوع •", 'callback_data' => "backup_panel"]];
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*📁 قائمة النسخ الاحتياطية (آخر 10 نسخ)*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode($key),
]);
}

if(explode("|",$data)[0] == "restore_this_backup"){
$backup_name = explode("|",$data)[1];
$backup_file = __DIR__ . "/backups/$bot_id/" . $backup_name;
if(!file_exists($backup_file)){
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*❌ الملف غير موجود*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "• رجوع •", 'callback_data' => "backup_panel"]]]]),
]);
return;
}
$backup_data = json_decode(file_get_contents($backup_file), true);
foreach($backup_data as $db_name => $data){
if(isset($db[$db_name])){
$db[$db_name]->exec("DELETE FROM data");
foreach($data as $row){
$stmt = $db[$db_name]->prepare("INSERT OR REPLACE INTO data (key, value) VALUES (:key, :value)");
$stmt->bindValue(':key', $row['key'], SQLITE3_TEXT);
$stmt->bindValue(':value', $row['value'], SQLITE3_TEXT);
$stmt->execute();
}
}
}
$rshq = getData($db['settings'], 'rshq');
$tmoil = getData($db['funding'], 'tmoil');
$modes = getData($db['settings'], 'modes');
$SALEH = getData($db['settings'], 'saleh');
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*✅ تم استعادة النسخة الاحتياطية بنجاح!\n📁 الملف: $backup_name*\n",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "• رجوع •", 'callback_data' => "backup_panel"]]]]),
]);
}

function LoginDB($num, $deviceInfo) {
$url = "https://odpapp.asiacell.com/api/v1/login?lang=ar";
$phone = preg_replace('/[^0-9]/', '', $num);
if (strpos($phone, '0') === 0) { $phone = substr($phone, 1); }
$payload = json_encode(["captchaCode" => "", "username" => $phone]);
$headers = ['User-Agent: okhttp/5.1.0', 'Connection: Keep-Alive', 'Accept-Encoding: gzip', 'X-ODP-API-KEY: ' . ASIA_API_KEY, 'Cache-Control: no-cache', 'DeviceID: ' . $deviceInfo['DeviceID'], 'X-OS-Version: 13', 'X-Device-Type: [Android][TECNO][TECNO KI7 13][TIRAMISU][GMS][4.3.7:90000323]', 'X-ODP-APP-VERSION: 4.3.7', 'X-FROM-APP: odp', 'X-ODP-CHANNEL: mobile', 'X-SCREEN-TYPE: false', 'Content-Type: application/json; charset=UTF-8'];
$ch = curl_init();
curl_setopt_array($ch, [CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "gzip", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => $payload, CURLOPT_HTTPHEADER => $headers, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]);
$result = curl_exec($ch);
curl_close($ch);
$resultData = json_decode($result, true);
if (isset($resultData['success']) && $resultData['success'] == true && isset($resultData['nextUrl'])) {
$nextUrl = $resultData['nextUrl'];
if (preg_match('/PID=([a-f0-9\-]+)/', $nextUrl, $matches)) { return ['success' => true, 'PID' => $matches[1]]; }
}
return ['success' => false];
}

function pass($es, $io, $deviceInfo) {
$url = "https://odpapp.asiacell.com/api/v1/smsvalidation?lang=ar";
$payload = json_encode(["PID" => $io, "passcode" => $es, "token" => "dnGWiiHJR9Soe4CXjDt3yn:APA91bHwUYmpZ5_48UA9pgB2xXkxEwnerz9MhHAMWRydVri1eVlDykzxPCQe_RxUDUjQqrtNJSuZ5c0KyWqhawJXkyZ7FzulA_GgkUCFCeEcraGfSDZUDuw"]);
$headers = ['User-Agent: okhttp/5.1.0', 'Connection: Keep-Alive', 'Accept-Encoding: gzip', 'X-ODP-API-KEY: ' . ASIA_API_KEY, 'Cache-Control: no-cache', 'DeviceID: ' . $deviceInfo['DeviceID'], 'X-OS-Version: 13', 'X-Device-Type: [Android][TECNO][TECNO KI7 13][TIRAMISU][GMS][4.3.7:90000323]', 'X-ODP-APP-VERSION: 4.3.7', 'X-FROM-APP: odp', 'X-ODP-CHANNEL: mobile', 'X-SCREEN-TYPE: false', 'Content-Type: application/json; charset=UTF-8'];
$ch = curl_init();
curl_setopt_array($ch, [CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "gzip", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => $payload, CURLOPT_HTTPHEADER => $headers, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]);
$result = curl_exec($ch);
curl_close($ch);
$response = json_decode($result, true);
if (isset($response['success']) && $response['success'] == true) { return ['success' => true, 'access_token' => $response['access_token'] ?? '', 'fullname' => $response['fullname'] ?? '']; }
return ['success' => false];
}

function Tran($isp, $amount, $phone, $deviceInfo) {
$url = "https://odpapp.asiacell.com/api/v1/credit-transfer/start?lang=ar";
$receiverPhone = '0' . preg_replace('/[^0-9]/', '', $phone);
$payload = json_encode(["receiverMsisdn" => $receiverPhone, "amount" => (float)$amount]);
$headers = ['User-Agent: okhttp/5.1.0', 'Connection: Keep-Alive', 'Accept-Encoding: gzip', 'X-ODP-API-KEY: ' . ASIA_API_KEY, 'Cache-Control: no-cache', 'DeviceID: ' . $deviceInfo['DeviceID'], 'X-OS-Version: 13', 'X-Device-Type: [Android][TECNO][TECNO KI7 13][TIRAMISU][GMS][4.3.7:90000323]', 'X-ODP-APP-VERSION: 4.3.7', 'X-FROM-APP: odp', 'X-ODP-CHANNEL: mobile', 'X-SCREEN-TYPE: MOBILE', 'Authorization: Bearer ' . $isp, 'Content-Type: application/json; charset=UTF-8'];
$ch = curl_init();
curl_setopt_array($ch, [CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "gzip", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => $payload, CURLOPT_HTTPHEADER => $headers, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]);
$result = curl_exec($ch);
curl_close($ch);
$response = json_decode($result, true);
if (isset($response['success']) && $response['success'] == true) { return ['success' => true, 'PID' => $response['PID'] ?? '']; }
return ['success' => false];
}

function Check($isp, $pid, $es, $deviceInfo) {
$url = "https://odpapp.asiacell.com/api/v1/credit-transfer/do-transfer?lang=ar";
$payload = json_encode(["pid" => $pid, "passcode" => $es]);
$headers = ['User-Agent: okhttp/5.1.0', 'Connection: Keep-Alive', 'Accept-Encoding: gzip', 'X-ODP-API-KEY: ' . ASIA_API_KEY, 'Cache-Control: no-cache', 'DeviceID: ' . $deviceInfo['DeviceID'], 'X-OS-Version: 13', 'X-Device-Type: [Android][TECNO][TECNO KI7 13][TIRAMISU][GMS][4.3.7:90000323]', 'X-ODP-APP-VERSION: 4.3.7', 'X-FROM-APP: odp', 'X-ODP-CHANNEL: mobile', 'X-SCREEN-TYPE: false', 'Authorization: Bearer ' . $isp, 'Content-Type: application/json; charset=UTF-8'];
$ch = curl_init();
curl_setopt_array($ch, [CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "gzip", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => $payload, CURLOPT_HTTPHEADER => $headers, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]);
$result = curl_exec($ch);
curl_close($ch);
$response = json_decode($result, true);
return ['success' => isset($response['success']) ? $response['success'] : false];
}

?>

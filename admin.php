<?php
ob_start();
error_reporting(0);

$bot_info = bot('getMe')->result;
$bot_id = $bot_info->id;
$bot_username = $bot_info->username;
$bot_name = $bot_info->first_name;
$admin_id = $saleh;

if(!file_exists("NAMERO/$bot_id")) mkdir("NAMERO/$bot_id", 0777, true);
$kznn_path = "NAMERO/$bot_id/Namero.db";
$db_vv = "NAMERO/$bot_id/rshq.db";
//$db = new SQLite3($db_vv);

$kznn = new SQLite3($kznn_path);


$kznn->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, username TEXT, first_name TEXT, is_admin INTEGER DEFAULT 0, is_blocked INTEGER DEFAULT 0, joined_at INTEGER)");
$kznn->exec("CREATE TABLE IF NOT EXISTS groups (id INTEGER PRIMARY KEY, title TEXT, joined_at INTEGER)");
$kznn->exec("CREATE TABLE IF NOT EXISTS settings (key TEXT PRIMARY KEY, value TEXT)");
$kznn->exec("CREATE TABLE IF NOT EXISTS forced_channels (id INTEGER PRIMARY KEY, channel_id TEXT, channel_name TEXT, channel_link TEXT, required_count INTEGER DEFAULT 0, current_count INTEGER DEFAULT 0, is_active INTEGER DEFAULT 1, joined_users TEXT DEFAULT '[]', owner_id INTEGER)");
$kznn->exec("CREATE TABLE IF NOT EXISTS blocked_users (user_id INTEGER PRIMARY KEY)");
$kznn->exec("CREATE TABLE IF NOT EXISTS admins (user_id INTEGER PRIMARY KEY)");

function getSetting($kznn, $key, $default = "❌"){
$stmt = $kznn->prepare("SELECT value FROM settings WHERE key = :key");
$stmt->bindValue(':key', $key, SQLITE3_TEXT);
$result = $stmt->execute();
$row = $result->fetchArray();
return $row ? $row['value'] : $default;
}

function setSetting($kznn, $key, $value){
$stmt = $kznn->prepare("INSERT OR REPLACE INTO settings (key, value) VALUES (:key, :value)");
$stmt->bindValue(':key', $key, SQLITE3_TEXT);
$stmt->bindValue(':value', $value, SQLITE3_TEXT);
return $stmt->execute();
}

function isAdmin($kznn, $user_id){
$stmt = $kznn->prepare("SELECT * FROM admins WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$result = $stmt->execute();
return $result->fetchArray() ? true : false;
}

function isBlocked($kznn, $user_id){
$stmt = $kznn->prepare("SELECT * FROM blocked_users WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$result = $stmt->execute();
return $result->fetchArray() ? true : false;
}

function addUser($kznn, $user_id, $username, $first_name){
$stmt = $kznn->prepare("INSERT OR IGNORE INTO users (id, username, first_name, joined_at) VALUES (:id, :username, :first_name, :joined_at)");
$stmt->bindValue(':id', $user_id, SQLITE3_INTEGER);
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$stmt->bindValue(':first_name', $first_name, SQLITE3_TEXT);
$stmt->bindValue(':joined_at', time(), SQLITE3_INTEGER);
return $stmt->execute();
}

function addGroup($kznn, $group_id, $title){
$stmt = $kznn->prepare("INSERT OR IGNORE INTO groups (id, title, joined_at) VALUES (:id, :title, :joined_at)");
$stmt->bindValue(':id', $group_id, SQLITE3_INTEGER);
$stmt->bindValue(':title', $title, SQLITE3_TEXT);
$stmt->bindValue(':joined_at', time(), SQLITE3_INTEGER);
return $stmt->execute();
}

function updateChannelCount($kznn, $channel_id, $user_id){
$stmt = $kznn->prepare("SELECT * FROM forced_channels WHERE channel_id = :channel_id AND is_active = 1");
$stmt->bindValue(':channel_id', $channel_id, SQLITE3_TEXT);
$result = $stmt->execute();
$channel = $result->fetchArray();

if($channel){
$joined_users = json_decode($channel['joined_users'], true);
if(!in_array($user_id, $joined_users)){
$joined_users[] = $user_id;
$new_count = $channel['current_count'] + 1;
$joined_users_json = json_encode($joined_users);

$update = $kznn->prepare("UPDATE forced_channels SET current_count = :current_count, joined_users = :joined_users WHERE channel_id = :channel_id");
$update->bindValue(':current_count', $new_count, SQLITE3_INTEGER);
$update->bindValue(':joined_users', $joined_users_json, SQLITE3_TEXT);
$update->bindValue(':channel_id', $channel_id, SQLITE3_TEXT);
$update->execute();

if($new_count >= $channel['required_count'] && $channel['required_count'] > 0){
$del = $kznn->prepare("DELETE FROM forced_channels WHERE channel_id = :channel_id");
$del->bindValue(':channel_id', $channel_id, SQLITE3_TEXT);
$del->execute();

bot('sendMessage',[
'chat_id' => $channel['owner_id'],
'text' => "• تم اكتمال العدد المطلوب للقناة\n\nالقناة: {$channel['channel_name']}\nالعدد المطلوب: {$channel['required_count']}\n\nتم حذف القناة من قائمة الاشتراك الاجباري تلقائياً"
]);
}
return $new_count;
}
}
return false;
}

function checkSubscription($kznn, $user_id, $channel_id){
$member = bot('getChatMember',['chat_id' => $channel_id, 'user_id' => $user_id]);
if($member->result->status != "left"){
return updateChannelCount($kznn, $channel_id, $user_id);
}
return false;
}

function getForcedChannels($kznn, $only_active = true){
$sql = "SELECT * FROM forced_channels";
if($only_active){
$sql .= " WHERE is_active = 1";
}
$result = $kznn->query($sql);
$channels = [];
while($row = $result->fetchArray()){
$channels[] = $row;
}
return $channels;
}

function encryptBackup($data, $key = null){
if($key === null){
$key = md5(API_KEY);
}
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
$encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
return base64_encode($iv . $encrypted);
}

function decryptBackup($data, $key = null){
if($key === null){
$key = md5(API_KEY);
}
$data = base64_decode($data);
$iv_length = openssl_cipher_iv_length('aes-256-cbc');
$iv = substr($data, 0, $iv_length);
$encrypted = substr($data, $iv_length);
return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}
$owner_id = getSetting($kznn, "owner_id", $admin_id);
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$callback_query = $update->callback_query;

if($message){
$text = $message->text;
$chat_id = $message->chat->id;
$name = $message->from->first_name;
$user = $message->from->username;
$message_id = $message->message_id;
$from_id = $message->from->id;
$type = $message->chat->type;
$forward_from_chat = $message->forward_from_chat;
$document = $message->document;

addUser($kznn, $from_id, $user, $name);

if($type == "group" || $type == "supergroup"){
addGroup($kznn, $chat_id, $message->chat->title);
}

if(isBlocked($kznn, $from_id) && !isAdmin($kznn, $from_id)){
exit; 
}

$bot_status = getSetting($kznn, "bot_status", "✅");
if($bot_status == "❌" && !isAdmin($kznn, $from_id)){
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "البوت موقف من قبل المطور."
]);
exit; 
}
}

if($callback_query){
$data = $callback_query->data;
$chat_id = $callback_query->message->chat->id;
$message_id = $callback_query->message->message_id;
$from_id = $callback_query->from->id;
$user = $callback_query->from->username;
$name = $callback_query->from->first_name;

addUser($kznn, $from_id, $user, $name);

if(isBlocked($kznn, $from_id) && !isAdmin($kznn, $from_id)){
bot('answerCallbackQuery',[
'callback_query_id' => $callback_query->id,
'text' => "أنت محظور من استخدام البوت",
'show_alert' => true
]);
exit; 
}
}

/*
$rshq = getData($db, 'rshq_data', 'rshq');
if(!$rshq) $rshq = [];
$e=explode("|", $data);
$invite_num = null;
if(strpos($text, "/start") === 0){
$after_start = trim(substr($text, 6));
if(is_numeric($after_start)){
$invite_num = (int)$after_start;
} elseif(strpos($after_start, " ") !== false){
$parts = explode(" ", $after_start);
if(is_numeric($parts[0])){
$invite_num = (int)$parts[0];
}
}
}
if($invite_num !== null && $invite_num > 0 && !preg_match("/#Namero#/", $text)) {
$rshq['HACKER'][$from_id] = "I";
$rshq['HACK'][$from_id] = $invite_num;
SETJSON($rshq);
}*/


$stmt = $kznn->prepare("SELECT user_id FROM admins WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $owner_id, SQLITE3_INTEGER);
$result = $stmt->execute();
if(!$result->fetchArray()){
$stmt = $kznn->prepare("INSERT INTO admins (user_id) VALUES (:user_id)");
$stmt->bindValue(':user_id', $owner_id, SQLITE3_INTEGER);
$stmt->execute();
}

$stmt = $kznn->prepare("SELECT COUNT(*) as count FROM users");
$result = $stmt->execute();
$total_users = $result->fetchArray()['count'];

$stmt = $kznn->prepare("SELECT COUNT(*) as count FROM groups");
$result = $stmt->execute();
$total_groups = $result->fetchArray()['count'];

$stmt = $kznn->prepare("SELECT COUNT(*) as count FROM blocked_users");
$result = $stmt->execute();
$total_blocked = $result->fetchArray()['count'];

function GetChat($chat_id){
return bot('getChat',['chat_id' => $chat_id]);
}

function GetChatMember($chat_id, $user_id){
return bot('getChatMember',['chat_id' => $chat_id, 'user_id' => $user_id]);
}

function Slin($a){
$P = GetChat($a)->result;
if($P->username == null){
if($P->invite_link != null){
$d = $P->invite_link;
}else{
$d = bot('exportChatInviteLink',['chat_id' => $a])->result;
}
}else{
$d = "t.me/".$P->username;
}
return $d;
}

$ex = explode("|", $data ?? '');

if($text == "/start"){
if(isAdmin($kznn, $from_id)){
$bot_status = getSetting($kznn, "bot_status", "✅");
$twasl_status = getSetting($kznn, "twasl_status", "❌");
$notify_status = getSetting($kznn, "notify_status", "✅");
$auto_status = getSetting($kznn, "auto_status", "✅");
$duplicate_status = getSetting($kznn, "duplicate_status", "❌");
$filter_status = getSetting($kznn, "filter_status", "❌");
$forced_status = getSetting($kznn, "forced_subscription", "✅");

$keyboard = [
'inline_keyboard' => [
[['text' => "عمل البوت : $bot_status", 'callback_data' => "in|bot"],['text' => " حاله التوجيه : $twasl_status", 'callback_data' => "in|twasl"]], 
[['text' => "قسم الاحصائيات ", 'callback_data' => "status"], ['text' => "النسخ الاحتياطيه", 'callback_data' => "Nsxa"]],
[['text' => "الدخول : $notify_status", 'callback_data' => "in|notify"],['text' => "نقل الملكيه", 'callback_data' => "thoilmlk"],['text' => "تعديل الازرار", 'callback_data' => "zrar"]], 
[['text' => "قسم الحظر", 'callback_data' => "blockks"],['text' => "قسم الادمنيه", 'callback_data' => "admins"]],
[['text' => "الاشتراك الاجباري", 'callback_data' => "ijbare"], ['text' => "الاذاعه", 'callback_data' => "broadcast"]],
[['text' => "• اعدادات البوت •", 'callback_data' => "rshqG"]],
]
];
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "*- اهلا بك عزيزي المطور في اعدادات البوت\n----------------------------*
• تحكم في جميع اوامر البوت من الاسفل 🔰",
'reply_to_message_id'=>$message_id,
'parse_mode' => "markdown",
'reply_markup' => json_encode($keyboard)
]);
}
//   exit;
}

$forced_on = getSetting($kznn, "forced_subscription", "✅");
if($forced_on == "✅" && !isAdmin($kznn, $from_id)){
$channels = getForcedChannels($kznn, true);
$all_joined = true;
$not_joined = [];

foreach($channels as $channel){
$member = GetChatMember($channel['channel_id'], $from_id);
if($member->result->status == "left"){
$all_joined = false;
$not_joined[] = $channel;
} else {
$stmt = $kznn->prepare("SELECT * FROM forced_channels WHERE channel_id = :channel_id AND is_active = 1");
$stmt->bindValue(':channel_id', $channel['channel_id'], SQLITE3_TEXT);
$result = $stmt->execute();
$channel_data = $result->fetchArray();

if($channel_data){
$joined_users = json_decode($channel_data['joined_users'], true);
if(!in_array($from_id, $joined_users)){
$joined_users[] = $from_id;
$new_count = $channel_data['current_count'] + 1;
$joined_users_json = json_encode($joined_users);

$update = $kznn->prepare("UPDATE forced_channels SET current_count = :current_count, joined_users = :joined_users WHERE channel_id = :channel_id");
$update->bindValue(':current_count', $new_count, SQLITE3_INTEGER);
$update->bindValue(':joined_users', $joined_users_json, SQLITE3_TEXT);
$update->bindValue(':channel_id', $channel['channel_id'], SQLITE3_TEXT);
$update->execute();

if($new_count >= $channel_data['required_count'] && $channel_data['required_count'] > 0){
$del = $kznn->prepare("DELETE FROM forced_channels WHERE channel_id = :channel_id");
$del->bindValue(':channel_id', $channel['channel_id'], SQLITE3_TEXT);
$del->execute();

bot('sendMessage',[
'chat_id' => $channel_data['owner_id'],
'text' => "• تم اكتمال العدد المطلوب للقناة\n\nالقناة: {$channel_data['channel_name']}\nالعدد المطلوب: {$channel_data['required_count']}\n\nتم حذف القناة من قائمة الاشتراك الاجباري تلقائياً"
]);
}
}
}
}
}

if(!empty($channels) && !$all_joined){
$inline = [];
foreach($not_joined as $channel){
$inline['inline_keyboard'][] = [['text' => "• " . $channel['channel_name'], 'url' => $channel['channel_link']]];
}
$inline['inline_keyboard'][] = [['text' => "تحقق من الاشتراك", 'callback_data' => "check_subscription"]];

$subscribe_text = getSetting($kznn, "subscribe_text", "- عذراً . {name}\n- اشترك في القنوات التالية اولا .");
$subscribe_text = str_replace("{name}", $name, $subscribe_text);
$subscribe_text = str_replace("{user_id}", $from_id, $subscribe_text);

bot('sendMessage',[
'chat_id' => $chat_id,
'text' => $subscribe_text,
'disable_web_page_preview' => true,
'reply_markup' => json_encode($inline)
]);
exit;
}
}

if($data == "check_subscription"){
$channels = getForcedChannels($kznn, true);
$all_joined = true;
$not_joined = [];

foreach($channels as $channel){
$member = GetChatMember($channel['channel_id'], $from_id);
if($member->result->status == "left"){
$all_joined = false;
$not_joined[] = $channel;
}else{
updateChannelCount($kznn, $channel['channel_id'], $from_id);
}
}

if($all_joined){
$start_text = getSetting($kznn, "start_text", "مرحبا بك في البوت\n ارسل /start");
$start_text = str_replace("{bot_name}", $bot_name, $start_text);
$start_text = str_replace("{user_id}", $from_id, $start_text);
$start_text = str_replace("{name}", $name, $start_text);
bot('editMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => $start_text
]);
}else{
$inline = [];
foreach($not_joined as $channel){
$inline['inline_keyboard'][] = [['text' => "• " . $channel['channel_name'], 'url' => $channel['channel_link']]];
}
$inline['inline_keyboard'][] = [['text' => "تحقق من الاشتراك", 'callback_data' => "check_subscription"]];

$subscribe_text = getSetting($kznn, "subscribe_text", "- عذراً . {name}\n- اشترك في القنوات التالية اولا .");
$subscribe_text = str_replace("{name}", $name, $subscribe_text);

bot('editMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => $subscribe_text,
'disable_web_page_preview' => true,
'reply_markup' => json_encode($inline)
]);
}
exit; 
}

if($data == "setting" && isAdmin($kznn, $from_id)){
$bot_status = getSetting($kznn, "bot_status", "✅");
$twasl_status = getSetting($kznn, "twasl_status", "❌");
$notify_status = getSetting($kznn, "notify_status", "✅");
$auto_status = getSetting($kznn, "auto_status", "✅");
$duplicate_status = getSetting($kznn, "duplicate_status", "❌");
$filter_status = getSetting($kznn, "filter_status", "❌");
$forced_status = getSetting($kznn, "forced_subscription", "✅");

$keyboard = [
'inline_keyboard' => [
[['text' => "عمل البوت : $bot_status", 'callback_data' => "in|bot"],['text' => " حاله التوجيه : $twasl_status", 'callback_data' => "in|twasl"]], 
[['text' => "قسم الاحصائيات ", 'callback_data' => "status"], ['text' => "النسخ الاحتياطيه", 'callback_data' => "Nsxa"]],
[['text' => "الدخول : $notify_status", 'callback_data' => "in|notify"],['text' => "نقل الملكيه", 'callback_data' => "thoilmlk"],['text' => "تعديل الازرار", 'callback_data' => "zrar"]], 
[['text' => "قسم الحظر", 'callback_data' => "blockks"],['text' => "قسم الادمنيه", 'callback_data' => "admins"]],
[['text' => "الاشتراك الاجباري", 'callback_data' => "ijbare"], ['text' => "الاذاعه", 'callback_data' => "broadcast"]],
[['text' => "• اعدادات البوت •", 'callback_data' => "rshqG"]],
]
];
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*- اهلا بك عزيزي المطور في اعدادات البوت\n----------------------------*
• تحكم في جميع اوامر البوت من الاسفل 🔰",
'reply_to_message_id'=>$message_id,
'parse_mode' => "markdown",
'reply_markup' => json_encode($keyboard)
]);
exit;
}

if($ex[0] == "in" && isAdmin($kznn, $from_id)){
$key = $ex[1];
$current = getSetting($kznn, $key."_status", "❌");
$new = ($current == "✅") ? "❌" : "✅";
setSetting($kznn, $key."_status", $new);

$bot_status = getSetting($kznn, "bot_status", "✅");
$twasl_status = getSetting($kznn, "twasl_status", "❌");
$notify_status = getSetting($kznn, "notify_status", "✅");
$auto_status = getSetting($kznn, "auto_status", "✅");
$duplicate_status = getSetting($kznn, "duplicate_status", "❌");
$filter_status = getSetting($kznn, "filter_status", "❌");
$forced_status = getSetting($kznn, "forced_subscription", "✅");

$keyboard = [
'inline_keyboard' => [
[['text' => "عمل البوت : $bot_status", 'callback_data' => "in|bot"],['text' => " حاله التوجيه : $twasl_status", 'callback_data' => "in|twasl"]], 
[['text' => "قسم الاحصائيات ", 'callback_data' => "status"], ['text' => "النسخ الاحتياطيه", 'callback_data' => "Nsxa"]],
[['text' => "الدخول : $notify_status", 'callback_data' => "in|notify"],['text' => "نقل الملكيه", 'callback_data' => "thoilmlk"],['text' => "تعديل الازرار", 'callback_data' => "zrar"]], 
[['text' => "قسم الحظر", 'callback_data' => "blockks"],['text' => "قسم الادمنيه", 'callback_data' => "admins"]],
[['text' => "الاشتراك الاجباري", 'callback_data' => "ijbare"], ['text' => "الاذاعه", 'callback_data' => "broadcast"]],
[['text' => "• اعدادات البوت •", 'callback_data' => "rshqG"]],
]
];
bot('EditMessageReplyMarkup',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'reply_markup' => json_encode($keyboard)
]);
exit;
}

if($data == "ijbare" && isAdmin($kznn, $from_id)){
$channels = $kznn->query("SELECT * FROM forced_channels");
$key = ['inline_keyboard' => []];
while($row = $channels->fetchArray()){
$remaining = $row['required_count'] - $row['current_count'];
$status_text = $row['is_active'] == 1 ? "مفعل" : "معطل";
$key['inline_keyboard'][] = [
['text' => trim($row['channel_name']), 'callback_data' => "edit_channel|" . $row['channel_id']],
['text' => "$remaining", 'callback_data' => "noop"]
];
}
$key['inline_keyboard'][] = [['text' => "اضافه قناة", 'callback_data' => "add_channel"]];
$key['inline_keyboard'][] = [['text' => "الاعدادات", 'callback_data' => "forced_settings"]];
$key['inline_keyboard'][] = [['text' => "• تفعيل النظام : " . getSetting($kznn, "forced_subscription", "✅"), 'callback_data' => "toggle_forced"]];
$key['inline_keyboard'][] = [['text' => "رجوع", 'callback_data' => "setting"]];

bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "- اهلا بك في قسم قنوات الاشتراك الاجباري.",
'reply_markup' => json_encode($key)
]);
exit;
}

if($data == "forced_settings" && isAdmin($kznn, $from_id)){
$subscribe_text = getSetting($kznn, "subscribe_text", "- عذراً . {name}\n- اشترك في القنوات التالية اولا .");
$start_text = getSetting($kznn, "start_text", "مرحبا بك في البوت\nايديك: {user_id}");

$key = [
'inline_keyboard' => [
[['text' => "تعيين رسالة الاشتراك", 'callback_data' => "set_subscribe_text"]],
[['text' => "تعيين رسالة الترحيب", 'callback_data' => "set_start_text"]],
[['text' => "رجوع", 'callback_data' => "ijbare"]],
]
];

bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "اعدادات الاشتراك الاجباري\n\nرسالة الاشتراك:\n$subscribe_text\n\nرسالة الترحيب:\n$start_text",
'reply_markup' => json_encode($key)
]);
exit;
}

if($data == "set_subscribe_text" && isAdmin($kznn, $from_id)){
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "ارسل رسالة الاشتراك الجديدة\n\nيمكنك استخدام:\n{name} - اسم المستخدم\n{user_id} - ايدي المستخدم",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "forced_settings"]]]])
]);
setSetting($kznn, "set_subscribe_mode", $from_id);
exit;
}

if($data == "set_start_text" && isAdmin($kznn, $from_id)){
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "ارسل رسالة الترحيب الجديدة\n\nيمكنك استخدام:\n{bot_name} - اسم البوت\n{name} - اسم المستخدم\n{user_id} - ايدي المستخدم",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "forced_settings"]]]])
]);
setSetting($kznn, "set_start_mode", $from_id);
exit;
}

if($text && getSetting($kznn, "set_subscribe_mode") == $from_id){
setSetting($kznn, "subscribe_text", $text);
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم تعيين رسالة الاشتراك بنجاح",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "forced_settings"]]]])
]);
setSetting($kznn, "set_subscribe_mode", "");
exit;
}

if($text && getSetting($kznn, "set_start_mode") == $from_id){
setSetting($kznn, "start_text", $text);
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم تعيين رسالة الترحيب بنجاح",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "forced_settings"]]]])
]);
setSetting($kznn, "set_start_mode", "");
exit;
}

if($data == "toggle_forced" && isAdmin($kznn, $from_id)){
$current = getSetting($kznn, "forced_subscription", "✅");
$new = ($current == "✅") ? "❌" : "✅";
setSetting($kznn, "forced_subscription", $new);

bot('answerCallbackQuery',[
'callback_query_id' => $callback_query->id,
'text' => "تم " . ($new == "✅" ? "تفعيل" : "تعطيل") . " نظام الاشتراك الاجباري",
'show_alert' => true
]);

$channels = $kznn->query("SELECT * FROM forced_channels");
$key = ['inline_keyboard' => []];
while($row = $channels->fetchArray()){
$remaining = $row['required_count'] - $row['current_count'];
$key['inline_keyboard'][] = [
['text' => trim($row['channel_name']), 'callback_data' => "edit_channel|" . $row['channel_id']],
['text' => "$remaining", 'callback_data' => "noop"]
];
}
$key['inline_keyboard'][] = [['text' => "اضافه قناة", 'callback_data' => "add_channel"]];
$key['inline_keyboard'][] = [['text' => "الاعدادات", 'callback_data' => "forced_settings"]];
$key['inline_keyboard'][] = [['text' => "• تفعيل النظام : " . getSetting($kznn, "forced_subscription", "✅"), 'callback_data' => "toggle_forced"]];
$key['inline_keyboard'][] = [['text' => "رجوع", 'callback_data' => "setting"]];

bot('editMessageReplyMarkup',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'reply_markup' => json_encode($key)
]);
exit;
}

if($data == "add_channel" && isAdmin($kznn, $from_id)){
bot('editMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "- قم برفع البوت ادمن في قناتك ثم قم بأرسل توجيه من القناه الى البوت.",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "ijbare"]]]])
]);
setSetting($kznn, "add_channel_mode", $from_id);
exit;
}

if($forward_from_chat && getSetting($kznn, "add_channel_mode") == $from_id){
$channel_id = $forward_from_chat->id;
$channel_title = $forward_from_chat->title;
$channel_link = "https://t.me/" . ($forward_from_chat->username ?? "");

$check = $kznn->prepare("SELECT * FROM forced_channels WHERE channel_id = :channel_id");
$check->bindValue(':channel_id', $channel_id, SQLITE3_TEXT);
$result = $check->execute();

if(!$result->fetchArray()){
$member = GetChatMember($channel_id, $bot_id);
if($member->result->status == "administrator" || $member->result->status == "creator"){
$stmt = $kznn->prepare("INSERT INTO forced_channels (channel_id, channel_name, channel_link, required_count, current_count, is_active, joined_users, owner_id) VALUES (:channel_id, :channel_name, :channel_link, 0, 0, 1, '[]', :owner_id)");
$stmt->bindValue(':channel_id', $channel_id, SQLITE3_TEXT);
$stmt->bindValue(':channel_name', $channel_title, SQLITE3_TEXT);
$stmt->bindValue(':channel_link', $channel_link, SQLITE3_TEXT);
$stmt->bindValue(':owner_id', $from_id, SQLITE3_INTEGER);
$stmt->execute();

bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم حفظ القناه بنجاح\nيمكنك الان تعديل العدد المطلوب من اعدادات القناة",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "ijbare"]]]])
]);
}else{
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "البوت ليس مشرف بالقناه.",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "ijbare"]]]])
]);
}
}else{
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم اضافه القناه سابقا.",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "ijbare"]]]])
]);
}
setSetting($kznn, "add_channel_mode", "");
exit;
}

if($ex[0] == "edit_channel" && isAdmin($kznn, $from_id)){
$channel_id = $ex[1];
$stmt = $kznn->prepare("SELECT * FROM forced_channels WHERE channel_id = :channel_id");
$stmt->bindValue(':channel_id', $channel_id, SQLITE3_TEXT);
$result = $stmt->execute();
$channel = $result->fetchArray();

if($channel){
$remaining = $channel['required_count'] - $channel['current_count'];
$status_text = $channel['is_active'] == 1 ? "مفعل" : "معطل";

$key = [
'inline_keyboard' => [
[['text' => "تبديل الحالة ($status_text)", 'callback_data' => "toggle_channel_status|$channel_id"]],
[['text' => "تعديل العدد المطلوب", 'callback_data' => "edit_channel_count|$channel_id"]],
[['text' => "حذف القناة", 'callback_data' => "delete_channel|$channel_id"]],
[['text' => "رجوع", 'callback_data' => "ijbare"]],
]
];

bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "معلومات القناة\n\nاسم القناة: {$channel['channel_name']}\nالعدد المطلوب: {$channel['required_count']}\nالعدد الحالي: {$channel['current_count']}\nالمتبقي: $remaining\nالحالة: $status_text",
'reply_markup' => json_encode($key)
]);
}
exit;
}

if($ex[0] == "toggle_channel_status" && isAdmin($kznn, $from_id)){
$channel_id = $ex[1];
$stmt = $kznn->prepare("SELECT is_active FROM forced_channels WHERE channel_id = :channel_id");
$stmt->bindValue(':channel_id', $channel_id, SQLITE3_TEXT);
$result = $stmt->execute();
$channel = $result->fetchArray();

if($channel){
$new_status = $channel['is_active'] == 1 ? 0 : 1;
$update = $kznn->prepare("UPDATE forced_channels SET is_active = :is_active WHERE channel_id = :channel_id");
$update->bindValue(':is_active', $new_status, SQLITE3_INTEGER);
$update->bindValue(':channel_id', $channel_id, SQLITE3_TEXT);
$update->execute();

bot('answerCallbackQuery',[
'callback_query_id' => $callback_query->id,
'text' => "تم " . ($new_status == 1 ? "تفعيل" : "تعطيل") . " القناة",
'show_alert' => true
]);

$stmt2 = $kznn->prepare("SELECT * FROM forced_channels WHERE channel_id = :channel_id");
$stmt2->bindValue(':channel_id', $channel_id, SQLITE3_TEXT);
$result2 = $stmt2->execute();
$channel2 = $result2->fetchArray();

$remaining = $channel2['required_count'] - $channel2['current_count'];
$status_text = $channel2['is_active'] == 1 ? "مفعل" : "معطل";

$key = [
'inline_keyboard' => [
[['text' => "تبديل الحالة ($status_text)", 'callback_data' => "toggle_channel_status|$channel_id"]],
[['text' => "تعديل العدد المطلوب", 'callback_data' => "edit_channel_count|$channel_id"]],
[['text' => "حذف القناة", 'callback_data' => "delete_channel|$channel_id"]],
[['text' => "رجوع", 'callback_data' => "ijbare"]],
]
];

bot('editMessageReplyMarkup',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'reply_markup' => json_encode($key)
]);
}
exit;
}

if($ex[0] == "edit_channel_count" && isAdmin($kznn, $from_id)){
$channel_id = $ex[1];
setSetting($kznn, "edit_channel_id", $channel_id);
setSetting($kznn, "edit_channel_mode", $from_id);

bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "ارسل العدد الجديد المطلوب من المشتركين (بالأرقام فقط)\n0 يعني لا يوجد حد",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "edit_channel|$channel_id"]]]])
]);
exit;
}

if($text && getSetting($kznn, "edit_channel_mode") == $from_id && is_numeric($text)){
$channel_id = getSetting($kznn, "edit_channel_id", "");
$new_count = intval($text);

$update = $kznn->prepare("UPDATE forced_channels SET required_count = :required_count WHERE channel_id = :channel_id");
$update->bindValue(':required_count', $new_count, SQLITE3_INTEGER);
$update->bindValue(':channel_id', $channel_id, SQLITE3_TEXT);
$update->execute();

bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم تعديل العدد المطلوب الى $new_count عضو",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "edit_channel|$channel_id"]]]])
]);

setSetting($kznn, "edit_channel_mode", "");
setSetting($kznn, "edit_channel_id", "");
exit;
}

if($ex[0] == "delete_channel" && isAdmin($kznn, $from_id)){
$channel_id = $ex[1];
$del = $kznn->prepare("DELETE FROM forced_channels WHERE channel_id = :channel_id");
$del->bindValue(':channel_id', $channel_id, SQLITE3_TEXT);
$del->execute();

bot('answerCallbackQuery',[
'callback_query_id' => $callback_query->id,
'text' => "تم حذف القناة بنجاح",
'show_alert' => true
]);

$channels = $kznn->query("SELECT * FROM forced_channels");
$key = ['inline_keyboard' => []];
while($row = $channels->fetchArray()){
$remaining = $row['required_count'] - $row['current_count'];
$key['inline_keyboard'][] = [
['text' => trim($row['channel_name']), 'callback_data' => "edit_channel|" . $row['channel_id']],
['text' => "$remaining", 'callback_data' => "noop"]
];
}
$key['inline_keyboard'][] = [['text' => "اضافه قناة", 'callback_data' => "add_channel"]];
$key['inline_keyboard'][] = [['text' => "الاعدادات", 'callback_data' => "forced_settings"]];
$key['inline_keyboard'][] = [['text' => "• تفعيل النظام : " . getSetting($kznn, "forced_subscription", "✅"), 'callback_data' => "toggle_forced"]];
$key['inline_keyboard'][] = [['text' => "رجوع", 'callback_data' => "setting"]];

bot('editMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "- اهلا بك في قسم قنوات الاشتراك الاجباري.",
'reply_markup' => json_encode($key)
]);
exit;
}

if($data == "admins" && isAdmin($kznn, $from_id) && $from_id == $owner_id){
$admins_list = $kznn->query("SELECT user_id FROM admins");
$key = ['inline_keyboard' => []];
while($row = $admins_list->fetchArray()){
$admin_uid = $row['user_id'];
$link = "tg://openmessage?user_id=$admin_uid";
$key['inline_keyboard'][] = [['text' => "$admin_uid", 'url' => $link], ['text' => "حــذف", 'callback_data' => "deletead:$admin_uid"]];
}
$key['inline_keyboard'][] = [['text' => "اضف ادمن جديد", 'callback_data' => "addadmin"]];
$key['inline_keyboard'][] = [['text' => "رجوع", 'callback_data' => "setting"]];

bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "مرحبا بك في الادمنيه\nيمكنك رفع 7 ادمنيه في البوت او حذفهم\nيمكن للادمنيه تحكم في لوحه البوت مثلك ولا يمكنهم رفع ادمنيه او استلام رسائل الموجهة او سايت او تواصل.",
'reply_markup' => json_encode($key)
]);
exit;
}
$ex = explode(":", $data ?? '');
if($ex[0] == "deletead" && $from_id == $owner_id){
$user_id = $ex[1];
if($user_id != $owner_id){
$stmt = $kznn->prepare("DELETE FROM admins WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$stmt->execute();

bot('answerCallbackQuery',[
'callback_query_id' => $callback_query->id,
'text' => "تم حذف الادمن بنجاح",
'show_alert' => true
]);

$admins_list = $kznn->query("SELECT user_id FROM admins");
$key = ['inline_keyboard' => []];
while($row = $admins_list->fetchArray()){
$admin_uid = $row['user_id'];
$link = "tg://openmessage?user_id=$admin_uid";
$key['inline_keyboard'][] = [['text' => "$admin_uid", 'url' => $link], ['text' => "حــذف", 'callback_data' => "deletead:$admin_uid"]];
}
$key['inline_keyboard'][] = [['text' => "اضف ادمن جديد", 'callback_data' => "addadmin"]];
$key['inline_keyboard'][] = [['text' => "رجوع", 'callback_data' => "setting"]];

bot('editMessageReplyMarkup',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'reply_markup' => json_encode($key)
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id' => $callback_query->id,
'text' => "لا يمكن حذف المالك",
'show_alert' => true
]);
}
exit;
}

if($data == "addadmin" && $from_id == $owner_id){
$admin_count = $kznn->query("SELECT COUNT(*) as count FROM admins")->fetchArray()['count'];
if($admin_count <= 7){
bot('editMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "ارسل الايدي او معرف الشخص الآن.",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "admins"]]]])
]);
setSetting($kznn, "addadmin_mode", $from_id);
}else{
bot('editMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "لايمكنك رفع اكثر من 7 ادمنيه في البوت",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "admins"]]]])
]);
}
exit;
}

if($text && getSetting($kznn, "addadmin_mode") == $from_id && preg_match("/([0-9])/", $text)){
$user_exists = $kznn->prepare("SELECT * FROM users WHERE id = :id");
$user_exists->bindValue(':id', $text, SQLITE3_INTEGER);
$result = $user_exists->execute();
if($result->fetchArray()){
$stmt = $kznn->prepare("INSERT OR IGNORE INTO admins (user_id) VALUES (:user_id)");
$stmt->bindValue(':user_id', $text, SQLITE3_INTEGER);
$stmt->execute();

bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم اضافتة الى الآدمنية.",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "admins"]]]])
]);
}else{
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "العضو غير موجود بالبوت.",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "admins"]]]])
]);
}
setSetting($kznn, "addadmin_mode", "");
exit;
}

if($data == "blockks" && isAdmin($kznn, $from_id)){
$keyboard = [
'inline_keyboard' => [
[['text' => "مسح المحظورين", 'callback_data' => "delblock"]],
[['text' => "حظر شخص", 'callback_data' => "bloccr"], ['text' => "الغاء حظر", 'callback_data' => "unbloc"]],
[['text' => "رجوع", 'callback_data' => "setting"]],
]
];
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "- اهلا بك في قائمه الحظر.\nعدد المحظورين : $total_blocked",
'reply_markup' => json_encode($keyboard)
]);
exit;
}

if($data == "delblock" && isAdmin($kznn, $from_id)){
$kznn->exec("DELETE FROM blocked_users");
bot('answerCallbackQuery',[
'callback_query_id' => $callback_query->id,
'text' => "تم حذف $total_blocked محظورين في البوت",
'show_alert' => true
]);
exit;
}

if($data == "bloccr" && isAdmin($kznn, $from_id)){
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "ارسل ايدي العضو لحظره",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "blockks"]]]])
]);
setSetting($kznn, "block_mode", $from_id);
exit;
}

if($data == "unbloc" && isAdmin($kznn, $from_id)){
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "ارسل ايدي لفك حظره",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "blockks"]]]])
]);
setSetting($kznn, "unblock_mode", $from_id);
exit;
}

if($text && getSetting($kznn, "block_mode") == $from_id && is_numeric($text)){
$user_exists = $kznn->prepare("SELECT * FROM users WHERE id = :id");
$user_exists->bindValue(':id', $text, SQLITE3_INTEGER);
$result = $user_exists->execute();
if($result->fetchArray()){
$stmt = $kznn->prepare("INSERT OR IGNORE INTO blocked_users (user_id) VALUES (:user_id)");
$stmt->bindValue(':user_id', $text, SQLITE3_INTEGER);
$stmt->execute();

bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم حظر العضو بنجاح\n---------------------\nايديه : `$text`",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "الغاء حظر", 'callback_data' => "unblock|$text"]]]])
]);
}else{
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "هذا العضو غير موجود\nايديه : `$text`",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "blockks"]]]])
]);
}
setSetting($kznn, "block_mode", "");
exit;
}

if($text && getSetting($kznn, "unblock_mode") == $from_id && is_numeric($text)){
$stmt = $kznn->prepare("DELETE FROM blocked_users WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $text, SQLITE3_INTEGER);
$stmt->execute();

bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم الغاء حظره بنجاح\n---------------------\nايديه : `$text`",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "حظر", 'callback_data' => "block|$text"], ['text' => "رجوع", 'callback_data' => "blockks"]]]])
]);
setSetting($kznn, "unblock_mode", "");
exit;
}

if($data == "status" && isAdmin($kznn, $from_id)){
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "- اهلا بك في قسم الاحصائيات \n — — — — — — — — — — \n-  عدد المشتركين ( $total_users ) عضو \n- عدد المجموعات ( $total_groups ) مجموعه",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "setting"]]]])
]);
exit;
}

if($data == "Nsxa" && isAdmin($kznn, $from_id)){
$keyboard = [
'inline_keyboard' => [
[['text' => "جلب نسخه احتياطيه", 'callback_data' => "get_backup"]],
[['text' => "رفع نسخه احتياطيه", 'callback_data' => "upload_backup"]],
[['text' => "رجوع", 'callback_data' => "setting"]],
]
];
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "- اهلا بك في قائمه النسخه الاحتياطيه.",
'reply_markup' => json_encode($keyboard)
]);
exit;
}

if($data == "get_backup" && isAdmin($kznn, $from_id)){
$backup_data = [];

$users = $kznn->query("SELECT * FROM users");
while($row = $users->fetchArray()){
$backup_data['users'][] = $row;
}

$groups = $kznn->query("SELECT * FROM groups");
while($row = $groups->fetchArray()){
$backup_data['groups'][] = $row;
}

$settings = $kznn->query("SELECT * FROM settings");
while($row = $settings->fetchArray()){
$backup_data['settings'][] = $row;
}

$channels = $kznn->query("SELECT * FROM forced_channels");
while($row = $channels->fetchArray()){
$backup_data['forced_channels'][] = $row;
}

$admins = $kznn->query("SELECT * FROM admins");
while($row = $admins->fetchArray()){
$backup_data['admins'][] = $row;
}

$blocks = $kznn->query("SELECT * FROM blocked_users");
while($row = $blocks->fetchArray()){
$backup_data['blocked_users'][] = $row;
}

$json_data = json_encode($backup_data, JSON_PRETTY_PRINT);
$encrypted = encryptBackup($json_data);

$filename = "backup_" . time() . ".enc";
file_put_contents($filename, $encrypted);

bot('sendDocument',[
'chat_id' => $chat_id,
'document' => new CURLFile($filename),
'caption' => "النسخة الاحتياطية مشفرة\nلا يمكن فك التشفير بدون المفتاح الخاص"
]);

unlink($filename);

bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "تم جلب النسخه الاحتياطيه بنجاح",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "Nsxa"]]]])
]);
exit;
}

if($data == "upload_backup" && isAdmin($kznn, $from_id)){
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "ارسل ملف النسخة الاحتياطية (ملف .enc فقط)",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "Nsxa"]]]])
]);
setSetting($kznn, "upload_backup_mode", $from_id);
exit;
}

if($document && getSetting($kznn, "upload_backup_mode") == $from_id){
$file_name = $document->file_name;
if(pathinfo($file_name, PATHINFO_EXTENSION) == "enc"){
$file = bot('getFile',['file_id' => $document->file_id]);
$file_path = $file->result->file_path;
$file_url = "https://api.telegram.org/file/bot".API_KEY."/".$file_path;

$encrypted_data = file_get_contents($file_url);
$decrypted = decryptBackup($encrypted_data);

if($decrypted){
$backup_data = json_decode($decrypted, true);

if($backup_data && isset($backup_data['users'])){
$kznn->exec("BEGIN TRANSACTION");

$kznn->exec("DELETE FROM users");
$kznn->exec("DELETE FROM groups");
$kznn->exec("DELETE FROM settings");
$kznn->exec("DELETE FROM forced_channels");
$kznn->exec("DELETE FROM admins");
$kznn->exec("DELETE FROM blocked_users");

foreach($backup_data['users'] as $user){
$stmt = $kznn->prepare("INSERT OR REPLACE INTO users (id, username, first_name, is_admin, is_blocked, joined_at) VALUES (:id, :username, :first_name, :is_admin, :is_blocked, :joined_at)");
$stmt->bindValue(':id', $user['id'], SQLITE3_INTEGER);
$stmt->bindValue(':username', $user['username'], SQLITE3_TEXT);
$stmt->bindValue(':first_name', $user['first_name'], SQLITE3_TEXT);
$stmt->bindValue(':is_admin', $user['is_admin'], SQLITE3_INTEGER);
$stmt->bindValue(':is_blocked', $user['is_blocked'], SQLITE3_INTEGER);
$stmt->bindValue(':joined_at', $user['joined_at'], SQLITE3_INTEGER);
$stmt->execute();
}

foreach($backup_data['groups'] as $group){
$stmt = $kznn->prepare("INSERT OR REPLACE INTO groups (id, title, joined_at) VALUES (:id, :title, :joined_at)");
$stmt->bindValue(':id', $group['id'], SQLITE3_INTEGER);
$stmt->bindValue(':title', $group['title'], SQLITE3_TEXT);
$stmt->bindValue(':joined_at', $group['joined_at'], SQLITE3_INTEGER);
$stmt->execute();
}

foreach($backup_data['settings'] as $setting){
$stmt = $kznn->prepare("INSERT OR REPLACE INTO settings (key, value) VALUES (:key, :value)");
$stmt->bindValue(':key', $setting['key'], SQLITE3_TEXT);
$stmt->bindValue(':value', $setting['value'], SQLITE3_TEXT);
$stmt->execute();
}

foreach($backup_data['forced_channels'] as $channel){
$stmt = $kznn->prepare("INSERT OR REPLACE INTO forced_channels (id, channel_id, channel_name, channel_link, required_count, current_count, is_active, joined_users, owner_id) VALUES (:id, :channel_id, :channel_name, :channel_link, :required_count, :current_count, :is_active, :joined_users, :owner_id)");
$stmt->bindValue(':id', $channel['id'], SQLITE3_INTEGER);
$stmt->bindValue(':channel_id', $channel['channel_id'], SQLITE3_TEXT);
$stmt->bindValue(':channel_name', $channel['channel_name'], SQLITE3_TEXT);
$stmt->bindValue(':channel_link', $channel['channel_link'], SQLITE3_TEXT);
$stmt->bindValue(':required_count', $channel['required_count'], SQLITE3_INTEGER);
$stmt->bindValue(':current_count', $channel['current_count'], SQLITE3_INTEGER);
$stmt->bindValue(':is_active', $channel['is_active'], SQLITE3_INTEGER);
$stmt->bindValue(':joined_users', $channel['joined_users'], SQLITE3_TEXT);
$stmt->bindValue(':owner_id', $channel['owner_id'], SQLITE3_INTEGER);
$stmt->execute();
}

foreach($backup_data['admins'] as $admin){
$stmt = $kznn->prepare("INSERT OR REPLACE INTO admins (user_id) VALUES (:user_id)");
$stmt->bindValue(':user_id', $admin['user_id'], SQLITE3_INTEGER);
$stmt->execute();
}

foreach($backup_data['blocked_users'] as $block){
$stmt = $kznn->prepare("INSERT OR REPLACE INTO blocked_users (user_id) VALUES (:user_id)");
$stmt->bindValue(':user_id', $block['user_id'], SQLITE3_INTEGER);
$stmt->execute();
}

$kznn->exec("COMMIT");

bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم رفع النسخه الاحتياطيه بنجاح",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "Nsxa"]]]])
]);
}else{
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "الملف غير صالح او تالف",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "Nsxa"]]]])
]);
}
}else{
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "فشل فك التشفير الملف تالف او غير صالح",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "Nsxa"]]]])
]);
}
}else{
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "الملف غير صالح يجب رفع ملف .enc فقط",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "Nsxa"]]]])
]);
}
setSetting($kznn, "upload_backup_mode", "");
exit;
}
$ex = explode("|", $data ?? '');
if($data == "broadcast" && isAdmin($kznn, $from_id)){
$keyboard = [
'inline_keyboard' => [
[['text' => "رساله للكل", 'callback_data' => "broad|all"], ['text' => "توجيه للكل", 'callback_data' => "forw|all"]],
[['text' => "رساله للمجموعات", 'callback_data' => "broad|grp"], ['text' => "توجيه للمجموعات", 'callback_data' => "forw|grp"]],
[['text' => "رساله للاعضاء", 'callback_data' => "broad|priv"], ['text' => "توجيه للاعضاء", 'callback_data' => "forw|priv"]],
[['text' => "رجوع", 'callback_data' => "setting"]],
]
];
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "- اوامر الاذاعه الخاصه بالبوت.",
'reply_markup' => json_encode($keyboard)
]);
exit;
}

if($ex[0] == "broad" && isAdmin($kznn, $from_id)){
$type = $ex[1];
$type_name = $type == "all" ? "للكل" : ($type == "priv" ? "للاعضاء" : "للمجموعات");
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "نوع الاذاعه ( رساله للـ $type_name) \nارسل الرساله الان",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "setting"]]]])
]);
setSetting($kznn, "broadcast_type", $type);
setSetting($kznn, "broadcast_mode", $from_id);
exit;
}

if($ex[0] == "forw" && isAdmin($kznn, $from_id)){
$type = $ex[1];
$type_name = $type == "all" ? "للكل" : ($type == "priv" ? "للاعضاء" : "للمجموعات");
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "نوع الاذاعه ( توجيه للـ $type_name) \nارسل الرساله الان",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "setting"]]]])
]);
setSetting($kznn, "forward_type", $type);
setSetting($kznn, "forward_mode", $from_id);
exit;
}

if($message && getSetting($kznn, "broadcast_mode") == $from_id){
$type = getSetting($kznn, "broadcast_type", "all");
$users = [];

if($type == "all" || $type == "priv"){
$query = $kznn->query("SELECT id FROM users");
while($row = $query->fetchArray()){
$users[] = $row['id'];
}
}
if($type == "all" || $type == "grp"){
$query = $kznn->query("SELECT id FROM groups");
while($row = $query->fetchArray()){
$users[] = $row['id'];
}
}

$count = 0;
$failed = 0;

foreach($users as $user_id){
$result = bot('sendMessage',[
'chat_id' => $user_id,
'text' => $text ?: ($caption ?: "رسالة")
]);
if(isset($result->ok) && $result->ok){
$count++;
}else{
$failed++;
}
}

bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم اكتمال عمليه الاذاعه بنجاح\n\nمعلومات الاذاعه :\nتم ارسال الاذاعه الي : $count عضو\nفشل في الارسال الي : $failed عضو"
]);

setSetting($kznn, "broadcast_mode", "");
setSetting($kznn, "broadcast_type", "");
exit;
}

if($message && getSetting($kznn, "forward_mode") == $from_id){
$type = getSetting($kznn, "forward_type", "all");
$users = [];

if($type == "all" || $type == "priv"){
$query = $kznn->query("SELECT id FROM users");
while($row = $query->fetchArray()){
$users[] = $row['id'];
}
}
if($type == "all" || $type == "grp"){
$query = $kznn->query("SELECT id FROM groups");
while($row = $query->fetchArray()){
$users[] = $row['id'];
}
}

$count = 0;
$failed = 0;

foreach($users as $user_id){
$result = bot('forwardMessage',[
'chat_id' => $user_id,
'from_chat_id' => $chat_id,
'message_id' => $message_id
]);
if(isset($result->ok) && $result->ok){
$count++;
}else{
$failed++;
}
}

bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم اكتمال عمليه الاذاعه بنجاح\n\nمعلومات الاذاعه :\nتم ارسال الاذاعه الي : $count عضو\nفشل في الارسال الي : $failed عضو"
]);

setSetting($kznn, "forward_mode", "");
setSetting($kznn, "forward_type", "");
exit;
}

$MakLink = substr(str_shuffle('AbCdEfGhIjKlMnOpQrStU12345689807'),1,13);
if($data == "thoilmlk" && $from_id == $owner_id){
$existing_link = getSetting($kznn, "transfer_link", "");
if(empty($existing_link)){
setSetting($kznn, "transfer_link", $MakLink);
$link = $MakLink;
}else{
$link = $existing_link;
}
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "تم صنع رابط جاهز لتحويل الملكيه ارسله لاي شخص ليتم تحويل الملكيه اليه\n\n- https://t.me/$bot_username?start=$link",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "setting"]]]])
]);
exit;
}

if(preg_match("/start (.+)/", $text ?? '', $matches)){
$code = $matches[1];
$transfer_link = getSetting($kznn, "transfer_link", "");
if($code == $transfer_link && $from_id != $owner_id){
$stmt = $kznn->prepare("INSERT OR REPLACE INTO admins (user_id) VALUES (:user_id)");
$stmt->bindValue(':user_id', $from_id, SQLITE3_INTEGER);
$stmt->execute();

setSetting($kznn, "owner_id", $from_id);
setSetting($kznn, "transfer_link", "");

bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "تم تحويل الملكيه اليك بنجاح"
]);

bot('sendMessage',[
'chat_id' => $owner_id,
'text' => "تم تحويل الملكيه لـ ([$name](tg://user?id=$from_id)) \nايديه : `$from_id`"
]);
}
   // exit;
}

$notify_status = getSetting($kznn, "notify_status", "✅");
if($notify_status == "✅" && $text && $message && $type == "private" && !isAdmin($kznn, $from_id)){
$stmt = $kznn->prepare("SELECT joined_at FROM users WHERE id = :id");
$stmt->bindValue(':id', $from_id, SQLITE3_INTEGER);
$result = $stmt->execute();
$user_data = $result->fetchArray();
if($user_data && (time() - $user_data['joined_at']) < 300){
bot('sendMessage',[
'chat_id' => $owner_id,
'text' => "• تم دخول شخص جديد الى البوت\n\nالاسم: $name\nاليوزر: @" . ($user ?: "لا يوجد") . "\nالايدي: $from_id\nعدد الاعضاء: $total_users"
]);
}
}

$twasl_status = getSetting($kznn, "twasl_status", "❌");
if($twasl_status == "✅" && $message && $type == "private" && !isAdmin($kznn, $from_id) && $text != "/start"){
bot('forwardMessage',[
'chat_id' => $owner_id,
'from_chat_id' => $chat_id,
'message_id' => $message_id
]);
bot('sendMessage',[
'chat_id' => $owner_id,
'text' => "👤 المرسل: $name\n🆔 ايدي: $from_id\n@" . ($user ?: "لا يوجد"),
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "✉️ رد على العضو", 'callback_data' => "reply_user|$from_id"]],
[['text' => "🚫 حظر العضو", 'callback_data' => "block_user|$from_id"]]
]
])
]);
bot('sendMessage',[
'chat_id' => $from_id,
'text' => "✅ تم توجيه رسالتك للادمن"
]);
//   exit;
}

if($ex[0] == "reply_user" && isAdmin($kznn, $from_id)){
$user_id = $ex[1];
setSetting($kznn, "reply_to_user", $user_id);
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "ارسل الرسالة التي تريد ارسالها للعضو",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "setting"]]]])
]);
setSetting($kznn, "reply_mode", $from_id);
exit;
}

if($text && getSetting($kznn, "reply_mode") == $from_id){
$user_id = getSetting($kznn, "reply_to_user", "");
if($user_id){
bot('sendMessage',[
'chat_id' => $user_id,
'text' => "• رد من الادمن:\n\n$text"
]);
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "✅ تم ارسال ردك الى العضو"
]);
setSetting($kznn, "reply_mode", "");
setSetting($kznn, "reply_to_user", "");
}
exit;
}

if($ex[0] == "block_user" && isAdmin($kznn, $from_id)){
$user_id = $ex[1];
$stmt = $kznn->prepare("INSERT OR IGNORE INTO blocked_users (user_id) VALUES (:user_id)");
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$stmt->execute();
bot('answerCallbackQuery',[
'callback_query_id' => $callback_query->id,
'text' => "تم حظر العضو بنجاح",
'show_alert' => true
]);
bot('EditMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "✅ تم حظر العضو"
]);
exit;
}


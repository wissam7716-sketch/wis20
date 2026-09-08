<?php
$update = json_decode(file_get_contents("php://input"));
$message = $update->message ?? null;
$chat_id = $message->chat->id ?? $update->callback_query->message->chat->id;
$message_id = $message->message_id ?? $update->callback_query->message->message_id;
$data = $update->callback_query->data ?? null;
$text = $message->text ?? null;
$from_id = $message->from->id ?? $update->callback_query->from->id;
$username = $message->from->username ?? $update->callback_query->from->username;
$bot_id = bot('getMe')->result->id;
$SALEh_path = "NAMERO/$bot_id/SALEh.json";
if(!file_exists("NAMERO/$bot_id")) mkdir("NAMERO/$bot_id", 0777, true);
$SALEh = file_exists($SALEh_path) ? json_decode(file_get_contents($SALEh_path), true) : [];
function save($array){
global $SALEh_path;
file_put_contents($SALEh_path, json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}
$SALEh['main_buttons_status'] = $SALEh['main_buttons_status'] ?? "✅";
// -- كود حماية الأزرار من الأعضاء --
if ($from_id != $saleh && !isAdmin($kznn, $from_id)) {
    return; // إيقاف الملف فوراً إذا لم يكن الشخص هو المطور أو أدمن
}
// -----------------------------------

if ($data == "zrar") {
$rows = $SALEh['rows'] ?? [];
foreach($rows as $ri => $row){
$has_buttons = false;
foreach($row as $btn_id){
if(isset($SALEh['SALEhs'][$btn_id]) || isset($SALEh['links'][$btn_id])){
$has_buttons = true;
break;
}
}
if(!$has_buttons){
unset($rows[$ri]);
}
}
$rows = array_values($rows);
$SALEh['rows'] = $rows;
save($SALEh);
$reply_markup = [];
foreach ($rows as $i => $row) {
$currentRow = [];
foreach ($row as $btn_id) {
if (isset($SALEh['SALEhs'][$btn_id])) {
$color = $SALEh['SALEhs'][$btn_id]['color'] ?? "default";
if($color == "default"){$color = "primary";}
$emoji = $SALEh['SALEhs'][$btn_id]['emoji'] ?? null;
if($emoji){
$currentRow[] = ['text' => $SALEh['SALEhs'][$btn_id]['name'], 'callback_data' => 'zh|' . $btn_id, 'style' => $color, 'icon_custom_emoji_id' => $emoji];
} else {
$currentRow[] = ['text' => $SALEh['SALEhs'][$btn_id]['name'], 'callback_data' => 'zh|' . $btn_id, 'style' => $color];
}
} elseif (isset($SALEh['links'][$btn_id])) {
$color = $SALEh['links'][$btn_id]['color'] ?? "default";
if($color == "default"){$color = "primary";}
$emoji = $SALEh['links'][$btn_id]['emoji'] ?? null;
if($emoji){
$currentRow[] = ['text' => $SALEh['links'][$btn_id]['name'], 'callback_data' => 'zh|' . $btn_id, 'style' => $color, 'icon_custom_emoji_id' => $emoji];
} else {
$currentRow[] = ['text' => $SALEh['links'][$btn_id]['name'], 'callback_data' => 'zh|' . $btn_id, 'style' => $color];
}
}
}
if(!empty($currentRow)){
$currentRow[] = ['text' => '➕', 'callback_data' => 'addbtn|' . $i];
$reply_markup[] = $currentRow;
}
}
$reply_markup[] = [['text' => '➕ اضافة صف جديد', 'callback_data' => 'addbtn']];
$reply_markup[] = [['text' => "الازرار الاساسية : {$SALEh['main_buttons_status']}", 'callback_data' => "toggle_main_buttons"]];
$reply_markup[] = [['text' => 'رجوع', 'callback_data' => 'setting']];
$reply_markup = json_encode(['inline_keyboard' => $reply_markup]);
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• مرحبا بك في قسم الازرار\n- يمكنك اضافة ازرار جديدة او حذفها",
'parse_mode' => 'markdown',
'reply_markup' => $reply_markup,
]);
$SALEh['n'] = null;
$SALEh['mode'] = null;
save($SALEh);
exit;
}
if ($data == "toggle_main_buttons") {
$SALEh['main_buttons_status'] = ($SALEh['main_buttons_status'] == "✅") ? "❌" : "✅";
save($SALEh);
$rows = $SALEh['rows'] ?? [];
$reply_markup = [];
foreach ($rows as $i => $row) {
$currentRow = [];
foreach ($row as $btn_id) {
if (isset($SALEh['SALEhs'][$btn_id])) {
$color = $SALEh['SALEhs'][$btn_id]['color'] ?? "default";
if($color == "default"){$color = "primary";}
$emoji = $SALEh['SALEhs'][$btn_id]['emoji'] ?? null;
if($emoji){
$currentRow[] = ['text' => $SALEh['SALEhs'][$btn_id]['name'], 'callback_data' => 'zh|' . $btn_id, 'style' => $color, 'icon_custom_emoji_id' => $emoji];
} else {
$currentRow[] = ['text' => $SALEh['SALEhs'][$btn_id]['name'], 'callback_data' => 'zh|' . $btn_id, 'style' => $color];
}
} elseif (isset($SALEh['links'][$btn_id])) {
$color = $SALEh['links'][$btn_id]['color'] ?? "default";
if($color == "default"){$color = "primary";}
$emoji = $SALEh['links'][$btn_id]['emoji'] ?? null;
if($emoji){
$currentRow[] = ['text' => $SALEh['links'][$btn_id]['name'], 'url' => $SALEh['links'][$btn_id]['url'], 'style' => $color, 'icon_custom_emoji_id' => $emoji];
} else {
$currentRow[] = ['text' => $SALEh['links'][$btn_id]['name'], 'url' => $SALEh['links'][$btn_id]['url'], 'style' => $color];
}
}
}
$currentRow[] = ['text' => '➕', 'callback_data' => 'addbtn|' . $i];
$reply_markup[] = $currentRow;
}
$reply_markup[] = [['text' => '➕ اضافة صف جديد', 'callback_data' => 'addbtn']];
$reply_markup[] = [['text' => "الازرار الاساسية : {$SALEh['main_buttons_status']}", 'callback_data' => "toggle_main_buttons"]];
$reply_markup[] = [['text' => 'رجوع', 'callback_data' => 'setting']];
$reply_markup = json_encode(['inline_keyboard' => $reply_markup]);
bot('editMessageReplyMarkup', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'reply_markup' => $reply_markup,
]);
exit;
}
if($text == "مشاهدة الازرار" or $text == 'مشاهده الازرار'){
$tm = "";
foreach ($update->message->reply_to_message->reply_markup->inline_keyboard as $row) {
foreach ($row as $button) {
if (isset($button->text)) {
$r = $button->text;
$dat = $button->callback_data ?? $button->url;
if($button->callback_data){
$dat = "SALEH:". base64_encode($dat);
}
$tm = $tm ."\n • $r -> `$dat`";
}
}
}
bot("sendmessage",[
'chat_id' => $chat_id,
'text' => $tm."\n\n• الكودات الخاصة بالازرار",
'parse_mode' => 'markdown',
'reply_to_message_id' => $message_id,
]);
exit();
}
if (preg_match("/^addbtn(\\|(.+))?$/", $data, $m)) {
$SALEh['mode'] = 'add';
$SALEh['row_index'] = isset($m[2]) ? (int)$m[2] : count($SALEh['rows'] ?? []);
bot('EditMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• ارسل اسم الزر المراد اضافته\n- يمكنك استخدام ايموجي مميز مع النص",
'parse_mode' => 'markdown',
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => 'رجوع', 'callback_data' => 'zrar']]
]
])
]);
save($SALEh);
exit;
}
if ($text != '/start' && $text != null && $SALEh['mode'] == 'add') {
$emoji_id = null;
$clean_text = $text;
if(isset($update->message->entities)){
foreach($update->message->entities as $ent){
if($ent->type == "custom_emoji"){
$emoji_id = $ent->custom_emoji_id;
$offset = $ent->offset;
$length = $ent->length;
$clean_text = mb_substr($text, 0, $offset) . mb_substr($text, $offset + $length);
}
}
}
$clean_text = preg_replace('/[\x{1F300}-\x{1FAFF}]/u', '', $clean_text);
$clean_text = trim($clean_text);
$SALEh['n'] = $clean_text;
if($emoji_id){
$SALEh['n_emoji'] = $emoji_id;
} else {
$SALEh['n_emoji'] = null;
}
$SALEh['mode'] = 'addm';
save($SALEh);
bot('sendMessage', [
'chat_id' => $chat_id,
'text' => "• ارسل الان المحتوى المراد اضافته الى الزر\n\n- يمكنك ارسال نص (يدعم الماركداون)\n- يمكنك ارسال رابط يبدأ بـ http\n- يمكنك ارسال كود كول باك",
'parse_mode' => 'MarkDown',
]);
bot('sendMessage', [
'chat_id' => $chat_id,
'text' => "• يمكنك استخدام الهاشتاجات التالية:\n1. #name : اسم الشخص\n2. #username : معرف المستخدم\n3. #id : ايدي الشخص\n4. #coin : رصيد الشخص\n5. #coin_used : الرصيد المستخدم\n6. #orders_count : عدد طلباتك\n7. #bot_orders : عدد طلبات البوت\n8. #invites : عدد دعواتك\n9. #invite_points : نقاط الدعوة\n10. #invite_link : رابط الدعوة الخاص بك\n11. #top_invites : ترتيب المدعوين\n12. #funding_count : عدد التمويلات النشطة\n13. #funding_channels : قنوات تحت التمويل\n14. #currency : اسم عملة البوت",
]);
exit;
}
if ($text != '/start' && $SALEh['mode'] == 'addm') {
    $code = uniqid();
    $row = $SALEh['row_index'] ?? 0;
    $name = $SALEh['n'];
    $emoji_id = $SALEh['n_emoji'] ?? null;
    
    $processed_content = $text;
    
    if (isset($update->message->entities) && !empty($update->message->entities)) {
        $entities = $update->message->entities;
        usort($entities, function($a, $b) {
            return $b->offset - $a->offset;
        });
        
        foreach ($entities as $ent) {
            if ($ent->type == "custom_emoji") {
                $emoji_id_content = $ent->custom_emoji_id;
                $offset = $ent->offset;
                $length = $ent->length;
                $fallback = mb_substr($processed_content, $offset, $length);
                $tg_emoji_tag = '<tg-emoji emoji-id="' . $emoji_id_content . '">' . $fallback . '</tg-emoji>';
                $processed_content = mb_substr($processed_content, 0, $offset) . 
                                     $tg_emoji_tag . 
                                     mb_substr($processed_content, $offset + $length);
            }
        }
    }
    
    $clean_text = $text;
    if (isset($update->message->entities)) {
        $entities = $update->message->entities;
        usort($entities, function($a, $b) {
            return $b->offset - $a->offset;
        });
        
        foreach ($entities as $ent) {
            if ($ent->type != "custom_emoji") {
                $clean_text = mb_substr($clean_text, 0, $ent->offset) . 
                              mb_substr($clean_text, $ent->offset + $ent->length);
            }
        }
    }
    $clean_text = trim($clean_text);
    
    if (preg_match("#^https?://#", $text)) {
        $SALEh['links'][$code] = [
            'name' => $name,
            'emoji' => $emoji_id,
            'url' => $text,
            'color' => 'default'
        ];
        $SALEh['rows'][$row][] = $code;
        $replyText = "• تم حفظ الزر (رابط)";
        
    } elseif (preg_match("#^SALEH:#", $text)) {
        $callback = base64_decode(str_replace("SALEH:", "", $text));
        $SALEh['SALEhs'][$code] = [
            'name' => $name,
            'emoji' => $emoji_id,
            'mo' => $callback,
            'Type' => 'callback',
            'color' => 'default'
        ];
        $SALEh['rows'][$row][] = $code;
        $replyText = "• تم حفظ الزر (كول باك)";
        
    } else {
        $has_custom_emoji = (strpos($processed_content, '<tg-emoji') !== false);
        
        $SALEh['SALEhs'][$code] = [
            'name' => $name,
            'emoji' => $emoji_id,
            'mo' => $clean_text,
            'mo_html' => $has_custom_emoji ? $processed_content : null,
            'Type' => 'EditMessageText',
            'color' => 'default'
        ];
        $SALEh['rows'][$row][] = $code;
        $replyText = "• تم حفظ الزر (نص)";
    }
    
    $SALEh['n'] = null;
    $SALEh['n_emoji'] = null;
    $SALEh['mode'] = null;
    unset($SALEh['row_index']);
    save($SALEh);
    
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $replyText,
        'parse_mode' => 'MarkDown',
        'reply_markup' => json_encode([
            'inline_keyboard' => [[['text' => 'رجوع', 'callback_data' => 'zrar']]]
        ])
    ]);
    exit;
}
$zhend = explode("|", $data);
if ($zhend[0] == "zh") {
$id = $zhend[1];
if (isset($SALEh['SALEhs'][$id])) {
$btn = $SALEh['SALEhs'][$id];
$name = $btn['name'];
$mo = $btn['mo'];
$type = $btn['Type'];
$current_color = $btn['color'] ?? "default";
$emoji = $btn['emoji'] ?? null;
$color_display = "عادي";
if($current_color == "danger"){$color_display = "احمر";}
if($current_color == "primary"){$color_display = "ازرق";}
if($current_color == "success"){$color_display = "اخضر";}
if($current_color == "default"){$color_display = "عادي";}
$buttons = [];
if ($type == "callback") {
$fro = "كود كول باك";
$buttons[] = [['text' => "🎨 تغيير اللون (الحالي: $color_display)", 'callback_data' => "color_menu|$id"]];
$buttons[] = [['text' => "🗑 مسح الزر", 'callback_data' => "delete|$id"]];
$buttons[] = [['text' => "🔙 رجوع", 'callback_data' => "zrar"]];
} else {
$fro = "محتوى نصي";
$show = [
"EditMessageText" => "تعديل الرسالة",
"sendMessage" => "ارسال الرسالة",
"answercallbackquery" => "همسة"
][$type] ?? "تعديل الرسالة";
$buttons[] = [['text' => "🎨 تغيير اللون (الحالي: $color_display)", 'callback_data' => "color_menu|$id"]];
$buttons[] = [['text' => "📝 طريقة العرض: $show", 'callback_data' => "showtype:$id"]];
$buttons[] = [['text' => "✏️ تعديل المحتوى", 'callback_data' => "editcontent|$id"]];
$buttons[] = [['text' => "🗑 مسح الزر", 'callback_data' => "delete|$id"]];
$buttons[] = [['text' => "🔙 رجوع", 'callback_data' => "zrar"]];
}
bot('editMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• اسم الزر:™[$name] \n\n• نوع الزر: $fro\n\n`$mo`",
'parse_mode' => "markdown",
'disable_web_page_preview' => true,
'reply_markup' => json_encode(['inline_keyboard' => $buttons])
]);
exit;
}
if (isset($SALEh['links'][$id])) {
$name = $SALEh['links'][$id]['name'];
$url = $SALEh['links'][$id]['url'];
$current_color = $SALEh['links'][$id]['color'] ?? "default";
$color_display = "عادي";
if($current_color == "danger"){$color_display = "احمر";}
if($current_color == "primary"){$color_display = "ازرق";}
if($current_color == "success"){$color_display = "اخضر";}
if($current_color == "default"){$color_display = "عادي";}
$buttons = [
[['text' => "🎨 تغيير اللون (الحالي: $color_display)", 'callback_data' => "color_menu_link|$id"]],
[['text' => "🔗 تعديل الرابط", 'callback_data' => "editlink|$id"]],
[['text' => "🗑 مسح الزر", 'callback_data' => "delete|$id"]],
[['text' => "🔙 رجوع", 'callback_data' => "zrar"]]
];
bot('editMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• اسم الزر: [$name] \n\n• نوع الزر: رابط خارجي\n\n`$url`",
'parse_mode' => "markdown",
'disable_web_page_preview' => true,
'reply_markup' => json_encode(['inline_keyboard' => $buttons])
]);
exit;
}
}
if(preg_match("/^color_menu\|(.+)$/", $data, $m)){
$id = $m[1];
$color_options = [
['text' => "🔴 احمر", 'callback_data' => "changecolor|$id|danger"],
['text' => "🔵 ازرق", 'callback_data' => "changecolor|$id|primary"],
['text' => "🟢 اخضر", 'callback_data' => "changecolor|$id|success"],
['text' => "⚪ عادي (بدون لون)", 'callback_data' => "changecolor|$id|default"]
];
bot('editMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• اختر اللون الجديد للزر",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [$color_options, [['text' => "🔙 رجوع", 'callback_data' => "zh|$id"]]]])
]);
exit;
}
if(preg_match("/^color_menu_link\|(.+)$/", $data, $m)){
$id = $m[1];
$color_options = [
['text' => "🔴 احمر", 'callback_data' => "changelinkcolor|$id|danger"],
['text' => "🔵 ازرق", 'callback_data' => "changelinkcolor|$id|primary"],
['text' => "🟢 اخضر", 'callback_data' => "changelinkcolor|$id|success"],
['text' => "⚪ عادي (بدون لون)", 'callback_data' => "changelinkcolor|$id|default"]
];
bot('editMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• اختر اللون الجديد للزر",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => [$color_options, [['text' => "🔙 رجوع", 'callback_data' => "zh|$id"]]]])
]);
exit;
}
if(preg_match("/^changecolor\|(.+)\|(.+)$/", $data, $m)){
$id = $m[1];
$new_color = $m[2];
if(isset($SALEh['SALEhs'][$id])){
$SALEh['SALEhs'][$id]['color'] = $new_color;
save($SALEh);
$color_name = "عادي";
if($new_color == "danger"){$color_name = "احمر";}
if($new_color == "primary"){$color_name = "ازرق";}
if($new_color == "success"){$color_name = "اخضر";}
bot('answerCallbackQuery',['callback_query_id'=>$update->callback_query->id,'text'=>"تم تغيير اللون الى $color_name",'show_alert'=>false]);
bot('editMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• تم تغيير لون الزر الى $color_name بنجاح",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "zh|$id"]]]])
]);
}
exit;
}
if(preg_match("/^changelinkcolor\|(.+)\|(.+)$/", $data, $m)){
$id = $m[1];
$new_color = $m[2];
if(isset($SALEh['links'][$id])){
$SALEh['links'][$id]['color'] = $new_color;
save($SALEh);
$color_name = "عادي";
if($new_color == "danger"){$color_name = "احمر";}
if($new_color == "primary"){$color_name = "ازرق";}
if($new_color == "success"){$color_name = "اخضر";}
bot('answerCallbackQuery',['callback_query_id'=>$update->callback_query->id,'text'=>"تم تغيير اللون الى $color_name",'show_alert'=>false]);
bot('editMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• تم تغيير لون الزر الى $color_name بنجاح",
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "zh|$id"]]]])
]);
}
exit;
}
if(preg_match("/^editcontent\|(.+)$/", $data, $m)){
$id = $m[1];
if(isset($SALEh['SALEhs'][$id])){
$SALEh['mode'] = "editcontent";
$SALEh['edit_id'] = $id;
save($SALEh);
bot('editMessageText',[
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• ارسل المحتوى الجديد للزر\n\nيمكنك استخدام الهاشتاجات:\n#name, #username, #id, #coin",
'parse_mode' => 'markdown',
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "zh|$id"]]]])
]);
}
exit;
}
if($SALEh['mode'] == "editcontent" && $text != null && $text != "/start"){
$id = $SALEh['edit_id'];
if(isset($SALEh['SALEhs'][$id])){
$SALEh['SALEhs'][$id]['mo'] = $text;
$SALEh['mode'] = null;
unset($SALEh['edit_id']);
save($SALEh);
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "• تم تحديث المحتوى بنجاح",
'parse_mode' => 'markdown',
'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "zh|$id"]]]])
]);
}
exit;
}
if (preg_match("#^showtype:(.+)$#", $data, $m)) {
$id = $m[1];
if (!isset($SALEh['SALEhs'][$id])) exit;
$curr = $SALEh['SALEhs'][$id]['Type'];
$options = [
['EditMessageText', 'تعديل الرسالة'],
['sendMessage', 'ارسال الرسالة'],
['answercallbackquery', 'همسة']
];
$markup = [];
foreach ($options as [$code, $label]) {
$check = ($code == $curr) ? "✅ " : "";
$markup[] = [['text' => $check . $label, 'callback_data' => "settype:$code:$id"]];
}
$markup[] = [['text' => "رجوع", 'callback_data' => "zh|$id"]];
bot('editMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• اختر طريقة عرض النص للزر:\n\n{$SALEh['SALEhs'][$id]['name']}",
'parse_mode' => "markdown",
'reply_markup' => json_encode(['inline_keyboard' => $markup])
]);
exit;
}
if (preg_match("#^settype:(EditMessageText|sendMessage|answercallbackquery):(.+)$#", $data, $m)) {
$new = $m[1];
$id = $m[2];
if (!isset($SALEh['SALEhs'][$id])) exit;
$SALEh['SALEhs'][$id]['Type'] = $new;
save($SALEh);
$show = [
"EditMessageText" => "تعديل الرسالة",
"sendMessage" => "ارسال الرسالة",
"answercallbackquery" => "همسة"
][$new];
bot('answerCallbackQuery', [
'callback_query_id' => $update->callback_query->id,
'text' => "تم التغيير الى: $show",
'show_alert' => false
]);
bot('editMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• تم تغيير طريقة عرض الزر:\n{$SALEh['SALEhs'][$id]['name']}",
'parse_mode' => "markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "zh|$id"]]]
])
]);
exit;
}
$edit = explode("|", $data);
if ($edit[0] == "editlink") {
$id = $edit[1];
if (isset($SALEh['links'][$id])) {
$SALEh['mode'] = "editlink";
$SALEh['edit_id'] = $id;
save($SALEh);
bot('editMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• ارسل الرابط الجديد لهذا الزر",
'parse_mode' => 'markdown',
'reply_markup' => json_encode([
'inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "zrar"]]]
])
]);
exit;
}
}
if ($SALEh['mode'] == "editlink" && $text != null && $text != "/start") {
$id = $SALEh['edit_id'];
if (preg_match("#^https?://#", $text)) {
$SALEh['links'][$id]['url'] = $text;
$SALEh['mode'] = null;
unset($SALEh['edit_id']);
save($SALEh);
bot('sendMessage', [
'chat_id' => $chat_id,
'text' => "• تم تحديث الرابط بنجاح",
'parse_mode' => 'markdown',
'reply_markup' => json_encode([
'inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "zrar"]]]
])
]);
} else {
bot('sendMessage', [
'chat_id' => $chat_id,
'text' => "• الرابط غير صالح\nارسل رابط يبدأ بـ http او https",
'parse_mode' => 'markdown'
]);
}
exit;
}
$zdelete = explode("|", $data);
if ($zdelete[0] == "delete") {
$id = $zdelete[1];
$btn_name = "هذا الزر";
if (isset($SALEh['SALEhs'][$id])) {
$btn_name = $SALEh['SALEhs'][$id]['name'];
unset($SALEh['SALEhs'][$id]);
} elseif (isset($SALEh['links'][$id])) {
$btn_name = $SALEh['links'][$id]['name'];
unset($SALEh['links'][$id]);
}
foreach($SALEh['rows'] as $ri => $row){
foreach($row as $bi => $bid){
if($bid == $id){
unset($SALEh['rows'][$ri][$bi]);
$SALEh['rows'][$ri] = array_values($SALEh['rows'][$ri]);
}
}
}
save($SALEh);
bot('editMessageText', [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "• اسم الزر: $btn_name\n\n- تم مسح الزر بنجاح",
'parse_mode' => "markdown",
'disable_web_page_preview' => true,
'reply_markup' => json_encode([
'inline_keyboard' => [[['text' => "رجوع", 'callback_data' => "zrar"]]]
])
]);
exit;
}
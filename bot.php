<?php 
$token = '5958194552:AAHxCPtBdVsib_P3NIQa3kgp6sl967WkZZo';
define('API',$token);
if(!file_exists('EzTG.php')){
    file_put_contents('EzTG.php',file_get_contents('EzTG.php'));
}
echo "<a href='https://api.telegram.org/bot".API."/setwebhook?url=https://".$_SERVER['SERVER_NAME']."".$_SERVER['SCRIPT_NAME']."'>setwebhook</a>";

require 'EzTG.php';
define('YES', '✅');
define('NO', '☑️');
error_reporting(0);
function toggle($type){
    $ssa = json_decode(file_get_contents('set.json'),true);
    if($ssa[$type] == NO){$ssa[$type] = YES;} else { $ssa[$type] = NO;}
    file_put_contents('set.json', json_encode($ssa));
}
if(!file_exists('set.json')){
 $set = ['document'=>NO,'photo'=>NO,'video'=>NO,'video_note'=>NO,'video_note'=>NO,'sticker'=>NO,'links'=>NO,'t_links'=>NO,'contact'=>NO,'fwd'=>NO,'voice'=>NO,'audio'=>NO];
 $set['start'] = '▪️اهلا بك 
- في بوت التواصل ، 🇮🇶
- ارسل رسالتك الان لكي يتم ارسالها الى مطور البوت ، 👋🏻
• وسوف يرد عليك باقرب وقت ، 📢';
 $set['rep'] = '• تم ارسال رسالتك الى مطور البوت بنجاح ، 👋🏻';
 file_put_contents('set.json',json_encode($set));
}
$call = function ($update,$bot){
    $message = $update->message;
    $chat_id = $message->chat->id;
    $text = $message->text;
    $from_id = $message->from->id;
    $message_id = $message->message_id;
    $name = $update->message->from->first_name;
    $ssa = json_decode(file_get_contents('set.json'),true);
    if ($update->callback_query) {
        $from_id = $update->callback_query->from->id;
        $chat_id = $update->callback_query->message->chat->id;
        $message_id = $update->callback_query->message->message_id;
        $data = $update->callback_query->data;
    } 
    $users = explode("\n", file_get_contents('users.txt'));
    $bans = explode("\n", file_get_contents('bans.txt'));
    if ($admin == $chat_id or in_array($chat_id, $ssa['admins'])) {
        if ($text == '/start') {
            $bot->sendMessage(['chat_id'=>$chat_id,'text'=>'✅ بوت التواصل الخاص بك .

▫️ سوف تستلم جميع الرسائل هنا , والرد عليها هنا .
▫️ لمزيد من الاعدادات إرسل /help .

    ▪️ شكراً لتفعيل بوت التواصل @ .
.']);
        }
        if ($text == '/help') {
            $bot->sendMessage(['chat_id'=>$chat_id,'text'=>"◾️إعداد بوت التواصل ⚙️ .\n\n▫️ ↴ يمكنك تغيير إعدادات البوت و تخصيص الإعدادات كم تريد .",'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>'📋قائمة الأوامر','callback_data'=>'cmd'],['text'=>'👥 المشتركين ','callback_data'=>'users']],
                    [['text'=>'👥 المحظورين ','callback_data'=>'bans'],['text'=>'🔧 ازالة الحظر للكل','callback_data'=>'rmbans']],
                    [['text'=>'⚙️ الاعدادات ','callback_data'=>'settings']],
                    [['text'=>'⛔️ الوسائط الممنوعة ','callback_data'=>'locks']],
                ]
            ])]);
        }
        if ($data == 'back') {
            $bot->editMessageText(['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>"◾️إعداد بوت التواصل ⚙️ .\n\n▫️ ↴ يمكنك تغيير إعدادات البوت و تخصيص الإعدادات كم تريد .",'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>'📋قائمة الأوامر','callback_data'=>'cmd'],['text'=>'👥 المشتركين ','callback_data'=>'users']],
                    [['text'=>'👥 المحظورين ','callback_data'=>'bans'],['text'=>'🔧 ازالة الحظر للكل','callback_data'=>'rmbans']],
                    [['text'=>'⚙️ الاعدادات ','callback_data'=>'settings']],
                    [['text'=>'⛔️ الوسائط الممنوعة ','callback_data'=>'locks']],
                ]
            ])]);
            unlink('mode.txt');
            $ssa['mode'] = null;
            file_put_contents('set.json', json_encode($ssa));
        }
        if ($data == 'cmd') {
            $bot->editMessageText(['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>'📋 ↴قائمة اﻷوامر .
⚠️ جميع هذه الإوامر مع الرد على الرسالة .

▫️/ban       = حظر
▫️/unban  = الغاء الحظر
▫️/info       = معلومات المستخدم','reply_markup'=>json_encode([
'inline_keyboard'=>[[['text'=>'🔙 العودة','callback_data'=>'back']]]
])]);
        }
        if ($data == 'users') {
            $bot->answerCallbackQuery(['callback_query_id'=>$update->callback_query->id,'text'=>'👥 عدد مشتركين بوتك ( '.count($users).' ) .','show_alert'=>true]);
        }
        if ($data == 'bans') {
            $bot->answerCallbackQuery(['callback_query_id'=>$update->callback_query->id,'text'=>'▫️ عدد المحظورين ( '.count($bans).' ) .','show_alert'=>true]);
        }
        if ($data == 'rmbans') {
            $bot->answerCallbackQuery(['callback_query_id'=>$update->callback_query->id,'text'=>'✅ تم ازالة الحظر عن : ( '.count($bans).' ) .','show_alert'=>true]);
            unlink('bans.txt');
        }
        if ($data == 'settings') {
            $bot->editMessageText(['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>'⚙️ الاعدادات .

▫️ ↴ يمكنك تغيير رسالة الترحيب او رسالة الرد عند أستلام الرسالة.
-','reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'🔖 رسالة الترحيب ','callback_data'=>'start'],['text'=>'↩️ رسالة الاستلام ','callback_data'=>'rep']],
[['text'=>'*️⃣ اضافه مشرفين ','callback_data'=>'addsudo']]
]
])]);
        }
        if ($data == 'addsudo') {
            $ssa['mode'] = 'addsudo';
            file_put_contents('set.json', json_encode($ssa));
            $bot->editMessageText(['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>'▫️ إرسل توجيه من الشخص الذي تريد اضافته مشرف  .
-','reply_markup'=>json_encode([
'inline_keyboard'=>[[['text'=>'🔙 العودة','callback_data'=>'back']]]
])]);
        }
        if ($ssa['mode'] == 'addsudo' and $message->forward_from) {
            $ssa['admins'][] = $message->forward_from->id;
            $ssa['mode'] = null;
            file_put_contents('set.json', json_encode($ssa));
            $bot->sendMessage(['chat_id'=>$chat_id,'text'=>'✅ تم حفظ '.$message->forward_from->first_name.' كـ مشرف في البوت . 
                الان اصبح بأمكانه تسليم الرسائل وتغيير الاعدادات','reply_markup'=>json_encode([
'inline_keyboard'=>[[['text'=>'🔙 العودة','callback_data'=>'back']]]
])]);
        }
        if ($data == 'start') {
            $bot->editMessageText(['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>'▫️ إرسل رسالة الترحيب التي تريد:
▪️ يمكنك إستخدام الـMarkdown .
-','reply_markup'=>json_encode([
'inline_keyboard'=>[[['text'=>'🔙 العودة','callback_data'=>'back']]]
])]);
$ssa['mode'] = 'start';
            file_put_contents('set.json', json_encode($ssa));
        }
        if ($text and $ssa['mode'] == 'start') {
            
            $bot->sendMessage(['chat_id'=>$chat_id,'text'=>'✅ تم إضافة رسالة ترحيبية إلى بوت التواصل الخاص بك .
▫️↴ مثل على الرسالة .','reply_markup'=>json_encode([
'inline_keyboard'=>[[['text'=>'🔙 العودة','callback_data'=>'back']]]
])]);
            $bot->sendMessage(['chat_id'=>$chat_id,'text'=>$text,'parse_mode'=>'markdown']);
            $ssa['start'] = $text;
            $ssa['mode'] = null;
            file_put_contents('set.json', json_encode($ssa));
        }
        if ($data == 'rep') {
            $bot->editMessageText(['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>'▫️ إرسل رسالة التسليم التي تريد:
▪️ يمكنك إستخدام الـMarkdown .
-','reply_markup'=>json_encode([
'inline_keyboard'=>[[['text'=>'🔙 العودة','callback_data'=>'back']]]
])]);
            $ssa['mode'] = 'rep';
            file_put_contents('set.json', json_encode($ssa));
        }
        if ($text and $ssa['mode'] == 'rep') {
            $ssa['rep'] = $text;
            $ssa['mode'] = null;
            file_put_contents('set.json', json_encode($ssa));
            $bot->sendMessage(['chat_id'=>$chat_id,'text'=>'✅ تم إضافة (رسالة تسليم ) إلى بوت التواصل الخاص بك .
▫️↴ مثل على رسالة التسليم .','reply_markup'=>json_encode([
'inline_keyboard'=>[[['text'=>'🔙 العودة','callback_data'=>'back']]]
])]);
            $bot->sendMessage(['chat_id'=>$chat_id,'text'=>$text,'parse_mode'=>'markdown']);
        }
        if ($data == 'locks') {
            $bot->editMessageText(['chat_id'=>$chat_id,'message_id'=>$message_id,'text'=>'◾️الوسائط الممنوع إرسالها لك  🚫.

〽️ ملاحظة:
✅   =  تعني ( مفعل  - يمنع إرسالها لك)
☑️   =  تعني ( غير مفعل - مسموح إرسالها لك)
-','reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'🏞 الصور ','callback_data'=>'hi'],['text'=>$ssa['photo'],'callback_data'=>'lock#photo']],
[['text'=>'🔊 الموسيقى ','callback_data'=>'hi'],['text'=>$ssa['audio'],'callback_data'=>'lock#audio']],
[['text'=>'🔗 الملفات ','callback_data'=>'hi'],['text'=>$ssa['document'],'callback_data'=>'lock#document']],
[['text'=>'🌁 الملصقات ','callback_data'=>'hi'],['text'=>$ssa['sticker'],'callback_data'=>'lock#sticker']],
[['text'=>'🎥 الفيديو ','callback_data'=>'hi'],['text'=>$ssa['video'],'callback_data'=>'lock#video']],
[['text'=>'🎵 الصوتيات ','callback_data'=>'hi'],['text'=>$ssa['voice'],'callback_data'=>'lock#voice']],
[['text'=>'📞 جهة اتصال','callback_data'=>'hi'],['text'=>$ssa['contact'],'callback_data'=>'lock#contact']],
[['text'=>'🔄 اعادة توجيه ','callback_data'=>'hi'],['text'=>$ssa['fwd'],'callback_data'=>'lock#fwd']],
[['text'=>'⛓ جميع الروابط  ','callback_data'=>'hi'],['text'=>$ssa['links'],'callback_data'=>'lock#links']],
[['text'=>'💎 روابط التيليجرام  ','callback_data'=>'hi'],['text'=>$ssa['t_links'],'callback_data'=>'lock#t_links']],
[['text'=>'🔙 العودة','callback_data'=>'back']]
]
])]);
        }
        $lock = explode('#', $data);
        if ($lock[0] == 'lock') {
            toggle($lock[1]);
            $bot->editMessageReplyMarkup([
                'chat_id'=>$chat_id,'message_id'=>$message_id,
                'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'🏞 الصور ','callback_data'=>'hi'],['text'=>$ssa['photo'],'callback_data'=>'lock#photo']],
[['text'=>'🔊 الموسيقى ','callback_data'=>'hi'],['text'=>$ssa['audio'],'callback_data'=>'lock#audio']],
[['text'=>'🔗 الملفات ','callback_data'=>'hi'],['text'=>$ssa['document'],'callback_data'=>'lock#document']],
[['text'=>'🌁 الملصقات ','callback_data'=>'hi'],['text'=>$ssa['sticker'],'callback_data'=>'lock#sticker']],
[['text'=>'🎥 الفيديو ','callback_data'=>'hi'],['text'=>$ssa['video'],'callback_data'=>'lock#video']],
[['text'=>'🎵 الصوتيات ','callback_data'=>'hi'],['text'=>$ssa['voice'],'callback_data'=>'lock#voice']],
[['text'=>'📞 جهة اتصال','callback_data'=>'hi'],['text'=>$ssa['contact'],'callback_data'=>'lock#contact']],
[['text'=>'🔄 اعادة توجيه ','callback_data'=>'hi'],['text'=>$ssa['fwd'],'callback_data'=>'lock#fwd']],
[['text'=>'⛓ جميع الروابط  ','callback_data'=>'hi'],['text'=>$ssa['links'],'callback_data'=>'lock#links']],
[['text'=>'💎 روابط التيليجرام  ','callback_data'=>'hi'],['text'=>$ssa['t_links'],'callback_data'=>'lock#t_links']],
[['text'=>'🔙 العودة','callback_data'=>'back']]
]
])
            ]);
        }
        if ($message->reply_to_message) {
            $r = $message->reply_to_message;
            if ($text == '/info') {
                $bot->sendMessage(['chat_id'=>$chat_id,'text'=>"ℹ️| الايدي : ".$r->forward_from->id."\n📍| المعرف : @".$r->forward_from->username]);
            } elseif ($text == '/ban') {
                $bot->sendMessage(['chat_id'=>$chat_id,'text'=>'تم حظر الشخص من البوت ⛔️']);
                file_put_contents('bans.txt', $r->forward_from->id."\n",FILE_APPEND);
            } elseif ($text == '/unban') {
                $bot->sendMessage(['chat_id'=>$chat_id,'text'=>'تم الغاء حظر الشخص من البوت ✅']);
                $rc = str_replace($r->forward_from->id."\n", '', file_get_contents('bans.txt'));
                file_put_contents('bans.txt', $rc);
            } else {
                if ($text) {
                    $bot->sendMessage(['chat_id'=>$r->forward_from->id,'text'=>$text]);
                }
                if ($message->photo) {
                    $bot->sendPhoto(['chat_id'=>$r->forward_from->id,'photo'=>$message->photo[1]->file_id]);
                }
                if ($message->video) {
                    $bot->sendVideo(['chat_id'=>$r->forward_from->id,'video'=>$message->video->file_id]);
                }
                if ($message->sticker) {
                    $bot->sendSticker(['chat_id'=>$r->forward_from->id,'sticker'=>$message->sticker->file_id]);
                }
                if ($message->document) {
                    $bot->sendDocument(['chat_id'=>$r->forward_from->id,'document'=>$message->document->file_id]);
                }
                if ($message->voice) {
                    $bot->sendVoice(['chat_id'=>$r->forward_from->id,'voice'=>$message->voice->file_id]);
                }
                if ($message->audio) {
                    $bot->sendAudio(['chat_id'=>$r->forward_from->id,'audio'=>$message->audio->file_id]);
                }
            }
        }

    } else {
        if ($message->chat->type == 'private') {
            if (!in_array($from_id, $users)) {
                file_put_contents('users.txt', $from_id."\n",FILE_APPEND);
            }
            if ($text == '/start') {
                $bot->sendMessage(['chat_id'=>$chat_id,'text'=>$ssa['start']."\n\n[- اظغط هنا وتابع جديدنا 💠 ](https://t.me/ctteam)",'parse_mode'=>'markdown']);
            } else {
                if(!in_array($chat_id,$bans)){
                if ($message->photo) {
                    if ($ssa['photo'] == YES) {
                        $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال هذا النوع من الوسائط ']);
                    } else {
                        $bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id]);
                    }
                }
                if ($message->video) {
                    if ($ssa['video'] == YES) {
                        $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال هذا النوع من الوسائط ']);
                    } else {
                        $bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id]);
                    }
                }
                if ($message->voice) {
                    if ($ssa['voice'] == YES) {
                        $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال هذا النوع من الوسائط ']);
                    } else {
                        $bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id]);
                    }
                }
                if ($message->audio) {
                    if ($ssa['audio'] == YES) {
                        $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال هذا النوع من الوسائط ']);
                    } else {
                        $bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id]);
                    }
                }

                if ($message->video_note) {
                    if ($ssa['video_note'] == YES) {
                        $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال هذا النوع من الوسائط ']);
                    } else {
                        $bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id]);
                    }
                }

                if ($message->sticker) {
                    if ($ssa['sticker'] == YES) {
                        $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال هذا النوع من الوسائط ']);
                    } else {
                        $bot->sendMessage(['chat_id'=>$admin,'text'=>"❇️ الملصق مرسل من : [$name](tg://user?id=$chat_id)",'parse_mode'=>'markdown','reply_to_message_id'=>$bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id])->message_id]);
                    }
                }
                if (preg_match('/^(.*)([Hh]ttp|[Hh]ttps|t.me)(.*)|([Hh]ttp|[Hh]ttps|t.me)(.*)|(.*)([Hh]ttp|[Hh]ttps|t.me)|(.*)[Tt]elegram.me(.*)|[Tt]elegram.me(.*)|(.*)[Tt]elegram.me|(.*)[Tt].me(.*)|[Tt].me(.*)|(.*)[Tt].me|(.*)telesco.me|telesco.me(.*)/i',$text)) {
                    if ($ssa['t_links'] == YES) {
                        $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال روابط ']);
                    } elseif($ssa['t_links'] == NO) {
                        $bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id]);
                    }
                }
                if (preg_match('/^(.*)([Hh]ttp|[Hh]ttps)(.*)/i',$text)) {
                    if ($ssa['links'] == YES) {
                        $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال روابط ']);
                    } else {
                        $bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id]);
                    }
                }
                if ($message->forward_from or $message->forward_from_chat) {
                    if ($ssa['fwd'] == YES) {
                        $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال هذا النوع من الوسائط ']);
                    } else {
                        $bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id]);
                    }
                }
                if ($message->document) {
                    if ($ssa['document'] == YES) {
                        $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال هذا النوع من الوسائط ']);
                    } else {
                        $bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id]);
                    }
                }
                if ($message->contact) {
                    if ($ssa['contact'] == YES) {
                        $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال هذا النوع من الوسائط ']);
                    } else {
                        $bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id]);
                    }
                }
                elseif($text) {
                   
                    $bot->forwardMessage(['chat_id'=>$admin,'from_chat_id'=>$chat_id,'message_id'=>$message_id]);
                    
                }
                $bot->sendMessage(['parse_mode'=>'markdown','reply_to_message_id'=>$message_id,'chat_id'=>$chat_id,'text'=>$ssa['rep']]);
            } else {
                $bot->sendMessage(['chat_id'=>$chat_id,'text'=>' ❌ | عذراً لا يمكنك ارسال شيء  ']);
            }
        }
    }
}
};
$EzTG = new EzTG(['token'=>API,'callback'=>$call,'secure_callbacks'=>true]);


//$EzTG= new EzTG(array('token' => API, 'callback' => $call, 'objects' => false, 'allow_only_telegram' => true, 'throw_telegram_errors' => true, 'magic_json_payload' => false)); //don't enable magic_json_payload if u want telegramz response


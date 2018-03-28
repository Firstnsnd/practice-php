<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-27
 * Time: 下午5:26
 */
require_once 'config.php';
require 'wechat.class.php';
$options=[
    'token'=>TOKEN,
    'appid'=>APPID,
    'appsecret'=>APPSECRET,
    'dubug'=>true,
];
$wechatObj = new WeChat($options);
if (isset($_GET["echostr"])) {
    $wechatObj->valid();
}
//echo $wechatObj->getToken();
//测试打印的数据
//var_dump($wechatObj->getRec()->getReceiveDate());
$wechatObj->getRec();        //获取发来的消息数据
//$wechatObj->text("你好，我是微信机器人，来自自动回复!")->reply();        //回复内容
$imageInfo=$wechatObj->getRecPic();
$wechatObj->image($imageInfo['mediaid'])->reply();
// 上传图片素材(yes)
$data = ['@img/w110.jpg'];
$info = $wechatObj->uploadTmp('image',$data);
//如果运行正确，将获得返回数据
//{ ["type"]=> string(5) "image" ["media_id"]=> string(64) "R_hwAih90QbedV9SyKJy210uOI27uRKZvrNRMBcCSrXNV6wI3rk83cjUePgmcPGe" ["created_at"]=> int(1476193867) }

//上传音频素材(yes)
$data = ['@audio/cut.mp3'];
$info = $wechatObj->uploadTmp('voice',$data);
// { ["type"]=> string(5) "voice" ["media_id"]=> string(64) "3aQ3GdVnjPEXCSEtYuW8udXP4JajBWyllM95APV5H5pqjDoa1ffPAAIjDVG2uBmU" ["created_at"]=> int(1476194919) }

//上传缩略图(yes)
$data = ['@img/tx.jpg'];
$info = $wechatObj->uploadTmp('thumb',$data);
// { ["type"]=> string(5) "thumb" ["thumb_media_id"]=> string(64) "-aTLKtqCt-dGHYPAFXfd2wZUMboDU65QyAwb88whlAGcG2cy8ufo1f4a1p9iDmW3" ["created_at"]=> int(1476195230) }

//上传视频(yes)
$data = ['@mp4/test.mp4'];
$info = $wechatObj->uploadTmp('video',$data);
// { ["type"]=> string(5) "video" ["media_id"]=> string(64) "pDgBd31gaIA--SjKkqqZbgZkOhvQOjGY0JFkU-CWWvBtTp2ssoigSq1KKftHQCuD" ["created_at"]=> int(1476195642) }

// 获取素材(yes),通过给定的mediaid获取
$mediaid = "R_hwAih90QbedV9SyKJy210uOI27uRKZvrNRMBcCSrXNV6wI3rk83cjUePgmcPGe";
$mediaid = "3aQ3GdVnjPEXCSEtYuW8udXP4JajBWyllM95APV5H5pqjDoa1ffPAAIjDVG2uBmU";
$mediaid = "-aTLKtqCt-dGHYPAFXfd2wZUMboDU65QyAwb88whlAGcG2cy8ufo1f4a1p9iDmW3";
$mediaid = "pDgBd31gaIA--SjKkqqZbgZkOhvQOjGY0JFkU-CWWvBtTp2ssoigSq1KKftHQCuD";
$result = $wechatObj->getTmp($mediaid);

//添加图片
$data = ['@img/w110.jpg'];
$info = $wechatObj->addMaterial('image',$data);
// array(1) { ["url"]=> string(124) "http://mmbiz.qpic.cn/mmbiz_jpg/eNkf5QIHGdw3bUTQbbehP2ibemFcnFR13y9Xp6VAVpiaia96YX4fw2QMFGx15XUAYQg8QHEtUK3lG5lKrSicrQkiaWA/0" }

//添加音频
$data = ['media'=>'@audio/cut.mp3'];
$info = $wechatObj->addMaterial('video',$data);
// array(1) { ["media_id"]=> string(43) "oCmCA6JW8AUym2t9uhqzeFd28BpCHYsj5fQZGoaVuDA" }

//添加缩略图
$data = ['media'=>'@img/tx.jpg'];
$info = $wechatObj->addMaterial('thumb',$data);
//array(2) { ["media_id"]=> string(43) "oCmCA6JW8AUym2t9uhqzeIzNHOLe7GNsO2fvhAsuUtI" ["url"]=> string(133) "http://mmbiz.qpic.cn/mmbiz_jpg/eNkf5QIHGdw3bUTQbbehP2ibemFcnFR13nWKJfLusYNl1RkbibesFqLP13gD87u1sDbnmuaEfWCp4nYR8grtsnAw/0?wx_fmt=jpeg" }

//添加视频(需做视频描述说明)
$data = ['media'=>'@mp4/test.mp4'];
$desc = ['title'=>'shiyanlou','introduction'=>'woshi ce shi'];
$info = $wechatObj->addMaterial('video',$data,true,$desc);
// array(1) { ["media_id"]=> string(43) "oCmCA6JW8AUym2t9uhqzeKtiYQzppXBMyn6U2k2IMmU" }

// 添加图文
$data = ['articles'=>
    [
        [
            'title'=>'test',
            'thumb_media_id'=>'oCmCA6JW8AUym2t9uhqzeIzNHOLe7GNsO2fvhAsuUtI',
            'author'=>'fuli',
            'digest'=>'dddfdsfds',
            'show_cover_pic'=>'1',
            'content'=>'fdssssssssgaaaaaaaaaaaaeg',
            'content_source_url'=>'http://www.shiyanlou.com'
        ]
    ]
];
$info = $wechatObj->addMaterial('news',$data);
// { ["media_id"]=> string(43) "oCmCA6JW8AUym2t9uhqzeEHdfvJ_Z0MUoqUjOWWEOrQ" }

// 永久素材数
$info = $wechatObj->getLongCount();

//echo $info;
// 删除素材
$info = $wechatObj->delMaterial('oCmCA6JW8AUym2t9uhqzeFd28BpCHYsj5fQZGoaVuDA');
// 修改永久图文
$data = [
    'articles'=>
        [
            'title'=>'testbyfuli',
            'thumb_media_id'=>'oCmCA6JW8AUym2t9uhqzeIzNHOLe7GNsO2fvhAsuUtI',
            'author'=>'fuli',
            'digest'=>'dddfdsfds',
            'show_cover_pic'=>'1',
            'content'=>'fdssssssssgaaaaaaaaaaaaeg',
            'content_source_url'=>'http://www.baidu.com'
        ]
];
$info = $wechatObj->updateNews('oCmCA6JW8AUym2t9uhqzeEHdfvJ_Z0MUoqUjOWWEOrQ',0,$data);
//菜单
$menu = [
    'button'=>[
        [
            'name'=>'实验楼',
            'sub_button'=>[
                [
                    'type'=>'view',
                    'name'=>'主页',
                    'url'=>'http://www.shiyanlou.com'
                ],
                [
                    'type'=>'click',
                    'name'=>'点我啊',
                    'key'=>'clickme'
                ],
                [
                    'type'=>'click',
                    'name'=>'点歌',
                    'key'=>'diange'
                ],
                [
                    'name'=>'我的位置',
                    'type'=>'location_select',
                    'key'=>'mylocation'
                ]
            ]
        ],
        [
            'name'=>'扫码',
            'sub_button'=>[
                [
                    'type'=>'scancode_waitmsg',
                    'name'=>'扫我获取',
                    'key'=>'scammsg'
                ],
                [
                    'type'=>'scancode_push',
                    'name'=>'扫我进入',
                    'key'=>'scaninto'
                ],
                [
                    'type'=>'media_id',
                    'name'=>'看图',
                    'media_id'=>'oCmCA6JW8AUym2t9uhqzeIzNHOLe7GNsO2fvhAsuUtI'
                ],
                [
                    'type'=>'media_id',
                    'name'=>'图文信息',
                    'media_id'=>'oCmCA6JW8AUym2t9uhqzeEHdfvJ_Z0MUoqUjOWWEOrQ'
                ],
                [
                    'type'=>'media_id',
                    'name'=>'电影',
                    'media_id'=>'oCmCA6JW8AUym2t9uhqzeKtiYQzppXBMyn6U2k2IMmU'
                ]
            ]
        ],
        [
            'name'=>'拍照',
            'sub_button'=>[
                [
                    'type'=>'pic_sysphoto',
                    'name'=>'系统拍照',
                    'key'=>'photosys'
                ],
                [
                    'type'=>'pic_photo_or_album',
                    'name'=>'选择方式',
                    'key'=>'photosel'
                ],
                [
                    'type'=>'pic_weixin',
                    'name'=>'相册选择',
                    'key'=>'photoweixin'
                ]
            ]
        ]
    ]
];
$info = $wechatObj->createMenu($menu);    //创建自定义菜单
$info = $wechatObj->delMenu();        //删除菜单
$info = $wechatObj->getMenuInfo();    //菜单信息

$info = $wechatObj->getUserList(); //获取用户列表
$openid = 'oLA-5v9JKdKz_Unir3urFleTlVj4';
$info = $wechatObj->getUserInfo($openid);  //获取用户信息
$info = $wechatObj->setUserName($openid,'fuli');  //获取用户信息
$info = $wechatObj->userTagCreate(['tag'=>['name'=>'实验楼']]);
$info = $wechatObj->userTagGet();    //获取公众号已创建的标签
$data = ['tag'=>['id'=>104,'name'=>'实验楼+1']];    //编辑某个标签
$info = $wechatObj->userTagEdit($data);
$data = ['tag'=>['id'=>104]];        //删除一个标签
$info = $wechatObj->userTagDelete($data);
var_dump($wechatObj->errCode);
var_dump($wechatObj->errMsg);
var_dump($info);

$msgType = $wechatObj->getRec()->getRecType();
switch ($msgType) {        //判断消息的类型
    case 'text':        //如果是文本信息
        $content = $wechatObj->getRecContent();        //获取文本内容
        switch ($content) {
            case 'ip':        //如果用户发送的内容是 ‘ip’，则获取微信服务器的全部ip地址
                $ip = $wechatObj->getServerIp();
                $ipstr = implode("\r\n",$ip);
                $wechatObj->text("微信服务器IP：\r\n".$ipstr)->reply();        //回复内容
                break;
            case '呵呵':        //内容是‘呵呵’
                $wechatObj->text("Are U kidding me？")->reply();        //回复内容
                break;
            case 'help':    //内容是‘help’
                $wechatObj->text("微信公众号使用帮助：\r\n 1.回复'ip',查看全部微信服务器IP地址 \r\n 2.回复'呵呵','调戏微信' \r\n 3.回复'你是谁',详细了解我 \r\n 4.回复'关于',关于信息 \r\n 5.回复任意内容(文字，语音，图片)，回复任意内容(文字，语音，图片) \r\n 6.------TODO-----")->reply();
                break;
            case '你是谁':
                $wechatObj->text("呵呵，你猜啊！")->reply();    //回复内容
                break;
            case '点歌':        //发送内容点歌
                $music = [
                    'title'=>'测试歌曲',
                    'desc'=>'这是我用(sui)心(bian)为你点播的一首歌',
                    'url'=>'http://music.163.com/#/program?id=7940893',        //歌曲链接
                    'hqurl'=>'http://music.163.com/#/program?id=7490893',    //高音质链接，wifi下优先
                    'thumbid'=>'oCmCA6JW8AUym2t9uhqzeIzNHOLe7GNsO2fvhAsuUtI'        //封面缩略图
                ];
                $wechatObj->music($music)->reply();        //回复音乐消息
                break;
            case '关于':        //关于
                $wechatObj->text("我是微信机器人，Powered by Lifue-本条消息来自火星")->reply();
                break;
            default:
                $wechatObj->text($content."(小孩子不要乱发消息哦)")->reply();
                break;
        }
        break;
    case 'image':        //如果用户发送的是图像信息
        $imageInfo = $wechatObj->getRecPic();        //获取图像信息
        $wechatObj->image($imageInfo)->reply();        //回复图片消息
        break;
    case 'voice':        //若用户发送的是语音消息
        $voiceInfo = $wechatObj->getRecVoice();        //获取语音信息
        // $wechatObj->text('不要给我发语音，我听不懂')->reply();
        $wechatObj->voice($voiceInfo)->reply();        //回复语音消息
        break;
    case 'shortvideo':        //如果用户发送的是短视频
        // $videoInfo = $wechatObj->getRecVideo();
        $videoInfo['title'] = '这是一个测试用的视频文件！';
        $videoInfo['description'] = '这是测试时用的一个视频文件，仅用于测试公众号内容回复！！';
        $videoInfo['mediaid'] = 'oCmCA6JW8AUym2t9uhqzeKtiYQzppXBMyn6U2k2IMmU';
        // $wechatObj->text('不要给我发短视频，我分分钟几百万上下，没有时间看！')->reply();
        $wechatObj->video($videoInfo)->reply();        //回复视频消息
        break;
    case 'event':        //若消息类型是事件推送
        $eventInfo = $wechatObj->getRecEvent();        //获取事件信息
        switch ($eventInfo['event']) {
            case 'CLICK':        //若是点击事件
                if ($eventInfo['key'] == 'diange') {        //时间的key值
                    $music = [
                        'title'=>'测试歌曲',
                        'desc'=>'这是我用(sui)心(bian)为你点播的一首歌',
                        'url'=>'http://music.163.com/#/program?id=7944993',
                        'hqurl'=>'http://music.163.com/#/program?id=7490893',
                        'thumbid'=>'oCmCA6JW8AUym2t9uhqzeIzNHOLe7GNsO2fvhAsuUtI'
                    ];
                    $wechatObj->music($music)->reply();        //回复音乐消息
                } else {
                    $wechatObj->text('我开个玩笑而已，你还真敢点我啊！')->reply();        //回复文本消息
                }
                break;
            case 'subscribe':        //若事件类型是：用户关注事件，发送欢迎消息
                $wechatObj->text('欢迎欢迎，热烈欢迎！回复 "help" 查看帮助信息！')->reply();
                break;
            case 'scancode_waitmsg':        //若事件类型是：扫码等待消息
                $info = $wechatObj->getScanInfo();        //获取扫码结果
                $wechatObj->text('扫描方式：扫我有喜('.$info['type'].'),扫描结果：'.$info['result'])->reply();        //回复扫码的结果
                break;
            case 'VIEW':        //如果是点击链接，回复success即可
                $wechatObj->text('success')->reply();
                break;
            case 'pic_sysphoto':        //调用系统拍照事件
                $wechatObj->text('调用系统拍照！')->reply();
                break;
            default:        //其他事件类型，回复消息
                $wechatObj->text('休息，一会儿，马上回来！')->reply();
                break;
        }
        break;
    case 'location':        //若事件类型是上报地理位置
        $locinfo = $wechatObj->getLocation();        //获取地理位置信息
        $wechatObj->text("你的位置信息：\r\n 经纬度：(".$locinfo['latitude'].",".$locinfo['longitude'].") \r\n 地名:".$locinfo['label']."\r\n 你的位置已暴露，注意人身安全！")->reply();        //将地理位置回复给用户
        break;
    default:        //其他消息，自动回复
        $wechatObj->text('我迷路了，待会儿再说')->reply();
        break;
}
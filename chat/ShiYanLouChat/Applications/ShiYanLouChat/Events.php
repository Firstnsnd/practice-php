<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    // public static function onConnect($client_id) {
    //     // 向当前client_id发送数据 
    //     Gateway::sendToClient($client_id, "Hello $client_id");
    //     // 向所有人发送
    //     Gateway::sendToAll("$client_id login");
    // }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $message) {
      // debug
      echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:".json_encode($_SESSION)." onMessage:".$message."\n";
      $message_data = json_decode($message,true);
      if (!$message_data) {
        return;
      }
      switch ($message_data['type']) {
        case 'pong':
          return;

        // 客户端登录 message格式: {type:login, name:xx, room_id:1} ，添加到客户端，广播给所有客户端xx进入聊天室
        case 'login':
          if (!isset($message_data['room_id'])) {
            throw new \Exception("room_id:{$message_data['room_id']} not set.ClientIP:{$_SERVER['REMOTE_ADDR']} message:$message", 1);
          }
          $room_id = $message_data['room_id'];
          $client_name = $message_data['client_name'];
          $_SESSION['room_id'] = $room_id;
          $_SESSION['client_name'] = $client_name;
          // 获取房间内所有用户列表 
          $clients_list = Gateway::getClientSessionsByGroup($room_id);
          foreach ($clients_list as $tem_client_id => $item) {
            $clients_list[$tem_client_id] = $item['client_name'];
          }
          $clients_list[$client_id] = $client_name;
          $new_message = [
                          'type'=>$message_data['type'], 
                          'client_id'=>$client_id, 
                          'client_name'=>htmlspecialchars($client_name), 
                          'time'=>date('Y-m-d H:i:s')
                          ];
          Gateway::sendToGroup($room_id,json_encode($new_message));
          Gateway::joinGroup($client_id,$room_id);

          $new_message['client_list'] = $clients_list;
          Gateway::sendToCurrentClient(json_encode($new_message));
          return;

        // 客户端发言 message: {type:say, to_client_id:xx, content:xx}
        case 'say':
          if (!isset($_SESSION['room_id'])) {
            return;
          }
          $room_id = $_SESSION['room_id'];
          $client_name = $_SESSION['client_name'];
          if ($message_data['to_client_id'] != "all") {
            $new_message = [
                      'type'=>'say',
                      'from_client_id'=>$client_id, 
                      'from_client_name' =>$client_name,
                      'to_client_id'=>$message_data['to_client_id'],
                      'content'=>"<b>对你说: </b>".nl2br(htmlspecialchars($message_data['content'])),
                      'time'=>date('Y-m-d H:i:s'),];
            Gateway::sendToClient($message_data['to_client_id'],json_encode($new_message));
            $new_message['content'] = "<b>你对".htmlspecialchars($message_data['to_client_name'])."说: </b>".nl2br(htmlspecialchars($message_data['content']));
          } else {
            $new_message = [
                    'type'=>'say', 
                    'from_client_id'=>$client_id,
                    'from_client_name' =>$client_name,
                    'to_client_id'=>'all',
                    'content'=>nl2br(htmlspecialchars($message_data['content'])),
                    'time'=>date('Y-m-d H:i:s'),
                    ];
            Gateway::leaveGroup($client_id,$room_id);
            Gateway::sendToGroup($room_id,json_encode($new_message));
            Gateway::joinGroup($client_id,$room_id);
          }
          $new_message['from_client_id'] = 'mine';
          Gateway::sendToCurrentClient(json_encode($new_message));
          return;
      }
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id) {
       // debug
       echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id onClose:''\n";
       if (isset($_SESSION['room_id'])) {
         $room_id = $_SESSION['room_id'];
         $new_message = ['type'=>'logout', 'from_client_id'=>$client_id, 'from_client_name'=>$_SESSION['client_name'], 'time'=>date('Y-m-d H:i:s')];
         Gateway::sendToGroup($room_id,json_encode($new_message));
       }
   }
}

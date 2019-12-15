<?php
class Chat {
    private $usr1;
    private $usr2;
    private $messages;

    public function __construct($usr1, $usr2){
        $this->usr1 = $usr1;
        $this->usr2 = $usr2;
        $this->messages = array();
    }

    public function add_message($message){
        array_push($this->messages, $message);
    }
}

function parse_messages($messages, $usrid){
    $chat_list = array();
    foreach($messages as $message){

        $sid = intval($message['SenderId']);
        $rid = intval($message['ReceiverId']);

        if($sid != $usrid){
            if(!isset($chat_list[$sid]))  $chat_list[$sid] = new Chat($usrid, $sid);
            $chat_list[$sid]->add_message($message);
        }

        else if($rid != $usrid){
            if(!isset($chat_list[$rid]))  $chat_list[$rid] = new Chat($usrid, $rid);
            $chat_list[$rid]->add_message($message);
        }

    }
    return $chat_list;
}
?>
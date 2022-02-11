<?php
class TeleBotLib {
    public $url = "https://api.telegram.org/bot";
    public $token = "";
    public function __construct($token = null) {
        $this->setToken($token);
    }
    public function setToken($token = null) {
        $this->token = ($token !== null) ? $token : 'setDefaultKey';
        $this->url .= $this->token; 
    }
    
    public function send($command, $data=array()){
        $url = $this->url.'/'.$command;
        if(count($data)){
            $postdata = http_build_query($data);
            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-Type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );
            $context  = stream_context_create($opts);
            $result = file_get_contents($url, false, $context);
        }else{
            $result = file_get_contents($url);
        }
        return json_decode($result);
    }
    
    public function sendMessage($chatId, $text, $parseMode = "html") {
        $postData = array(
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => $parseMode
        );
        $result = $this->send("sendmessage", $postData);
        return $result;
    }
    
    public function sendDocument($chatId, $text, $documentURL) {
        $postData = array(
            'chat_id' => $chatId,
            'document' => $documentURL,
            'caption' => $text,
            'parse_mode' => 'html'
        );
        $result = $this->send("senddocument", $postData);
        return $result;
    }
    
    public function editMessage($chatId, $messageId, $text) {
        $postData = array(
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
            'parse_mode' => "html"
        );
        $result = $this->send("editmessagetext", $postData);
        return $result;
    }
    
    public function editMessageCaption($chatId, $messageId, $caption) {
        $postData = array(
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'caption' => $caption,
            'parse_mode' => "html"
        );
        $result = $this->send("editmessagecaption", $postData);
        return $result;
    }
    public function pinChatMessage($chatId, $messageId) {
        $postData = array(
            'chat_id' => $chatId,
            'message_id' => $messageId,
        );
        $result = $this->send("pinchatmessage", $postData);
        return $result;
    }
    public function getUpdates() {
        $result = $this->send("getUpdates");
        return $result;
    }
    public function findChatId() {
        $chatId = "";
        $results = $this->getUpdates();
        if(isset($results->result[0]->message->chat->id)){
            $chatId = $results->result[0]->message->chat->id;
        }
        return $chatId;
    }
}
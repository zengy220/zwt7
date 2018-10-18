<?php
define("TOKEN", "zwt2017");        //�������token
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {     //��֤΢��
    $wechatObj->valid();
}else{                     //�ظ���Ϣ
    $wechatObj->responseMsg();
}
class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    //�ظ���Ϣ
    public function responseMsg()
  {
    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
    if (!empty($postStr)){
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $RX_TYPE = trim($postObj->MsgType);
		$keyword = trim($postObj->Content);
        switch ($RX_TYPE)
        {
            case "text":
			if(!empty($keyword)){
				if($keyword=='��'){
					
				}
				
			}
		    $resultStr = $this->receiveText($postObj);
			break;  
            case "image":
                $resultStr = $this->receiveImage($postObj);
                break;
            case "location":
                $resultStr = $this->receiveLocation($postObj);
                break;
            case "voice":
                $resultStr = $this->receiveVoice($postObj);
                break;
            case "video":
                $resultStr = $this->receiveVideo($postObj);
                break;
            case "link":
                $resultStr = $this->receiveLink($postObj);
                break;
            case "event":
                $resultStr = $this->receiveEvent($postObj);
                break;
            default:
                $resultStr = "unknow msg type: ".$RX_TYPE;
                break;
        }
        echo $resultStr;
    }else {
        echo "";
        exit;
    }
  }
    
    //�����ı���Ϣ
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        $url = "http://api100.duapp.com/movie/?appkey=DIY_miaomiao&name=".$keyword;
        $output = file_get_contents($url,$keyword);
        $contentStr = json_decode($output, true);
        if (is_array($contentStr)){
            $resultStr = $this->transmitNews($object, $contentStr);
        }else{
            $resultStr = $this->transmitText($object, $contentStr);
        }
        return $resultStr;
    }
    
    //�����¼�����ע��
    private function receiveEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "���ע����";    //��ע��ظ�����
                break;
            case "unsubscribe":
                $contentStr = "";
                break;
            case "CLICK":
                $contentStr =  $this->receiveClick($object);    //����¼�
                break;
            default:
                $contentStr = "receive a new event: ".$object->Event;
                break;
        }
        
        return $contentStr;
    }
    
    //����ͼƬ
    private function receiveImage($object)
    {
        $contentStr = "�㷢�͵���ͼƬ����ַΪ��".$object->PicUrl;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
    
    
    //��������
    private function receiveVoice($object)
    {
        $contentStr = "�㷢�͵���������ý��IDΪ��".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
    
    //������Ƶ
    private function receiveVideo($object)
    {
        $contentStr = "�㷢�͵�����Ƶ��ý��IDΪ��".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
    
    //λ����Ϣ
    private function receiveLocation($object)
    {
        $contentStr = "�㷢�͵���λ�ã�γ��Ϊ��".$object->Location_X."������Ϊ��".$object->Location_Y."�����ż���Ϊ��".$object->Scale."��λ��Ϊ��".$object->Label;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
    
    //������Ϣ
    private function receiveLink($object)
    {
        $contentStr = "�㷢�͵������ӣ�����Ϊ��".$object->Title."������Ϊ��".$object->Description."�����ӵ�ַΪ��".$object->Url;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
    
    
   //����˵���Ϣ
    private function receiveClick($object)
    {
         switch ($object->EventKey)
         {
             case "1":
             $contentStr = "è�佴����DIY��װ��
����רҵ���Ƹ��ԡ����������װ������װ�ȣ��г���T�������£����̿㡿 
��ͼӡ�Ƽ��ɣ�������ܰ�ɰ���TA��
���¿�ֱ������΢��";
             break;
             
             case "2":
             $contentStr = "�����˲˵�: ".$object->EventKey;
             break;
             
             case "3":
             $contentStr = "��ɵ��";
             break;
             
             default:
             $contentStr = "�����˲˵�: ".$object->EventKey;
             break;
         }
        
        
        //���ֻظ�
        if (is_array($contentStr)){
            $resultStr = $this->transmitNews($object, $contentStr);
        }else{
            $resultStr = $this->transmitText($object, $contentStr);
        }
        return  $resultStr;
    }
    
    //�ظ��ı���Ϣ
    private function transmitText($object, $content)
    {
		
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $resultStr;
    }    
    
    
    
    
    //�ظ�ͼ��
    private function transmitNews($object, $arr_item)
    {
        if(!is_array($arr_item))
            return;
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
     </item>";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
       $newsTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[news]]></MsgType>
        <Content><![CDATA[]]></Content>
        <ArticleCount>%s</ArticleCount>
        <Articles>
        $item_str</Articles>
        </xml>";
        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
        return $resultStr;
    }
    
    
    //������Ϣ
    private function transmitMusic($object, $musicArray, $flag = 0)
    {
        $itemTpl = "<Music>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <MusicUrl><![CDATA[%s]]></MusicUrl>
        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
        </Music>";
        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[music]]></MsgType>
        $item_str
        <FuncFlag>%d</FuncFlag>
        </xml>"; 
       $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $flag);
        return $resultStr;
    }
}
?>
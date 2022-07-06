<?php
    // error_reporting(0);
    $s = "\n";

    //Data Ghodan
    $telegramchatidghodan = 771055954;
    $walletGhodan         = "0xAD037328c44eeb7A8D5AAd04479BF9214A755677"; 
    $walletGhodan2        = "0xbcf3d8d7120a6c6de05db39455636ebe7735b170"; 

    uhuy:
    cekcube($walletGhodan, $telegramchatidghodan);
    cekcube($walletGhodan2, $telegramchatidghodan);

    // Try execute bot, in 10 munite
    echo $s."> Sleep (10 menit / 600 Detik) : ".$s;
    for ($x=600 ; $x>=0 ; $x--){
        echo "\r  ".$x." ";
        sleep(1);
    }
    // sleep(1800);
    echo $s;
    goto uhuy;

    function cekcube($address, $teleid){
        global $s;

        //Cek Transaction
        echo $s."> CHECK TRX | ".$address;
        do {

            $urlklay    = "https://api-cypress-v2.scope.klaytn.com/v2/accounts/".$address;
            $getklay    = file_get_contents($urlklay);
            $dataklay   = json_decode($getklay, true);

            //Parsing Data TRX
            $code   = $dataklay["code"];
            $status = $dataklay["success"];
            $trx    = $dataklay["result"];

        } while ($code!="0" && $mess!=true);
        // print_r($getcek[0]);
        // exit;

        
        //Data Send to Bot Tekegram
        if ($trx == null){
            $cektrx = "Null";
        } else {
            $cektrx = "Not Empty";
        }

        if ($trx!=null){
            //Post Data TRX to Jsonview Online
            $trxdetail  = json_encode($trx, JSON_PRETTY_PRINT);
            $upjson     = upjson($trxdetail);
            $linkjson   = $upjson["location"][0];
            //Message for send to telegram 
            $datamess   = "[ NOTIF ] Cek Trx Klaytn".$s.$s."> Wallet : ".$address.$s."> Detail Trx : ".$cektrx.$s."> Note : Buka link dibawah ini untuk detail trx".$s.$s.$linkjson.$s.$s."~ Sleep 10 Menit ~";//.$s.$s."Notif kembali Cek dalam 30 menit";
        } else {
            //Message for send to telegram 
            $datamess   = "[ NOTIF ] Cek Trx Klaytn".$s.$s."> Wallet : ".$address.$s."> Detail Trx : ".$cektrx.$s.$s."~ Sleep 10 Menit ~";
        }

        echo $s."  - Send to telegram id : ".$teleid;

            //Send Message from bot to user
            sendmess($datamess, $teleid);

    }


// ------------------------------------------------------------------------------------------------------------------------ //

        function get($url, $ua, $prx = "N", $headerresp = "N"){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);

            //Check Use or No Proxy
            if ($prx == 'Y'){
                //Proxy Web by proxyrack.net
                $username = 'maltzurra;country=SG';
                $password = '0f6d83-8eb4d9-ed63ab-d62add-86dff2';
                $PROXY_RACK_PORT = 222;
                $PROXY_RACK_DNS = 'megaproxy.rotating.proxyrack.net';
                
                //Add curl Proxy Web
                curl_setopt($ch, CURLOPT_PROXYPORT, $PROXY_RACK_PORT);
                curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
                curl_setopt($ch, CURLOPT_PROXY, $PROXY_RACK_DNS);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $username.':'.$password);
            }

            if ($headerresp=="Y"){
                curl_setopt($ch, CURLOPT_HEADERFUNCTION,
                    function ($curl, $header) use (&$headers) {
                        $len = strlen($header);
                        $header = explode(':', $header, 2);
                        if (count($header) < 2) // ignore invalid headers
                            return $len;
                        $headers[strtolower(trim($header[0]))][] = trim($header[1]);
                        return $len;
                        }
                    );
                }
            
            $result = curl_exec($ch);
            curl_close($ch);

            //Array dari Result Http Request (POST) dan Respon Header
            $rest = array(
                $result,
            );

            if ($headerresp=="Y"){
                array_push($rest, $headers); //Add header (cookie) di array
            }

            return $rest;
        }

        function upjson($jsondcd){
            $head = array(
                "Content-Type: application/json",
            );
            $urljson    = "https://jsonblob.com/api/jsonBlob";
            $postjson   = postjson($urljson, $jsondcd, $head, "N");
            
            return $postjson[1];
        }

        function post($url, $data, $ua, $cek="Y"){
            //Proxy Web by proxyrack.net
            $username = 'maltzurra';
            $password = '0f6d83-8eb4d9-ed63ab-d62add-86dff2';
            $PROXY_RACK_PORT = 222;
            $PROXY_RACK_DNS = 'megaproxy.rotating.proxyrack.net';
        
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
        
            //Check Use or No Proxy
            if ($cek == 'Y'){
            //Curl Proxy Web    
                //curl_setopt($ch, CURLOPT_PROXY, $proxy);
                curl_setopt($ch, CURLOPT_PROXYPORT, $PROXY_RACK_PORT);
                curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
                curl_setopt($ch, CURLOPT_PROXY, $PROXY_RACK_DNS);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $username.':'.$password);
            }
        
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        
        }

        function sendmess($msg, $idtele) {
            // Set your Bot ID and Chat ID.
            $telegrambot='5458510412:AAE5WLfRvUkYzctVW-2SCqcVzlxToSjPvao';

            $url='https://api.telegram.org/bot'.$telegrambot.'/sendMessage';$data=array('chat_id'=>$idtele,'text'=>$msg);
            $options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
            $context=stream_context_create($options);
            $result=file_get_contents($url,false,$context);
            return $result;
        }

        function postjson($url, $data, $ua, $cek="Y"){
            //Proxy Web by proxyrack.net
            $username = 'maltzurra';
            $password = '0f6d83-8eb4d9-ed63ab-d62add-86dff2';
            $PROXY_RACK_PORT = 222;
            $PROXY_RACK_DNS = 'megaproxy.rotating.proxyrack.net';
        
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
        
            //Check Use or No Proxy
            if ($cek == 'Y'){
            //Curl Proxy Web    
                //curl_setopt($ch, CURLOPT_PROXY, $proxy);
                curl_setopt($ch, CURLOPT_PROXYPORT, $PROXY_RACK_PORT);
                curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
                curl_setopt($ch, CURLOPT_PROXY, $PROXY_RACK_DNS);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $username.':'.$password);
            }
        
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            function ($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;
                $headers[strtolower(trim($header[0]))][] = trim($header[1]);
                return $len;
                }
            );
            $result = curl_exec($ch);
            curl_close($ch);

            $res = array(
                $result,
                $headers,
            );

            return $res;
        
        }
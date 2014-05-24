<?php

/**
 * Wrapper class for Twitter API.
 *
 * @author ZoomIt <http://digitalzoomstudio.net>
 * @created April, 2013 
 * @license Do-whateva-ya-want-with-it
*/ 



class TwitterAPI{
    private $token = '';
    private $token_secret = '';
    private $consumer_key = '';
    private $consumer_secret = '';
    
    private $host = 'api.twitter.com';
    private $method = 'GET';
    private $path = '/1.1/statuses/user_timeline.json'; // api call path
    
    function __construct($token, $token_secret, $consumer_key, $consumer_secret){
        $this->token = $token;
        $this->token_secret = $token_secret;
        $this->consumer_key = $consumer_key;
        $this->consumer_secret = $consumer_secret;
    }
    
    function set_path($arg){
        $this->path = $arg;
    }
    function do_query($query){
        
        
        $filename = dirname(__FILE__).'/cacher.txt';
        $cached = false;
        $cacher = '';
        $ci = -1;//==cached i
        $json = '';
        
        if(strpos($this->path, '1.1')===true && $this->token == ''){
            return 'token not set..';
        }
        
        if (file_exists($filename)){
            $file = file_get_contents($filename, true);
        }
        
        if($file!==false){
            $cacher = $file;
        }
        if($cacher==''){
            $cacher=array();
        }else{
            $cacher = unserialize($cacher);
        }
        //print_r($cacher);
        
        for($i=0;$i<count($cacher);$i++){
            if ($cacher[$i]['query'] == $query){
                if ($_SERVER['REQUEST_TIME'] - $cacher[$i]['time'] < 3600) {
                    //echo 'found cache';
                    //if()
                    $ci = $i;
                    $json = $cacher[$i]['output'];
                    $cached = true;
                    break;
                }else{
                    //==lets delete this item if it is old
                    unset($cacher[$i]);
                }
            }
        }
        
        
        
        if($cached==false){
        //echo 'ceva'; echo $url;
        //echo $this->token; echo ' ';echo $this->token_secret; echo ' '; echo $this->consumer_ley; echo ' '; echo $this->consumer_secret;
        $oauth = array(
            'oauth_consumer_key' => $this->consumer_key,
            'oauth_token' => $this->token,
            'oauth_nonce' => (string)mt_rand(), // a stronger nonce is recommended
            'oauth_timestamp' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_version' => '1.0'
        );
        
        
        $oauth = array_map("rawurlencode", $oauth); // must be encoded before sorting
        $query = array_map("rawurlencode", $query);



        $arr = array_merge($oauth, $query); // combine the values THEN sort

        asort($arr); // secondary sort (value)
        ksort($arr); // primary sort (key)

        // http_build_query automatically encodes, but our parameters
        // are already encoded, and must be by this point, so we undo
        // the encoding step
        $querystring = urldecode(http_build_query($arr, '', '&'));

        $url = "https://".$this->host.$this->path."";

        // mash everything together for the text to hash
        $base_string = $this->method."&".rawurlencode($url)."&".rawurlencode($querystring);

        // same with the key
        $key = rawurlencode($this->consumer_secret)."&".rawurlencode($this->token_secret);

        // generate the hash
        $signature = rawurlencode(base64_encode(hash_hmac('sha1', $base_string, $key, true)));

        // this time we're using a normal GET query, and we're only encoding the query params
        // (without the oauth params)
        $url .= "?".http_build_query($query);
        $url=str_replace("&amp;","&",$url); //Patch by @Frewuill

        $oauth['oauth_signature'] = $signature; // don't want to abandon all that work!
        ksort($oauth); // probably not necessary, but twitter's demo does it

        // also not necessary, but twitter's demo does this too
        function add_quotes($str) { return '"'.$str.'"'; }
        $oauth = array_map("add_quotes", $oauth);

        // this is the full value of the Authorization line
        $auth = "OAuth " . urldecode(http_build_query($oauth, '', ', '));

        // if you're doing post, you need to skip the GET building above
        // and instead supply query parameters to CURLOPT_POSTFIELDS
        $options = array( CURLOPT_HTTPHEADER => array("Authorization: $auth"),
                          //CURLOPT_POSTFIELDS => $postfields,
                          CURLOPT_HEADER => false,
                          CURLOPT_URL => $url,
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_SSL_VERIFYPEER => false);

        // do our business
        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        curl_close($feed);
        
            
            $cache_aux = array(
                'output' => $json
                ,'query' => $query
                ,'time' => $_SERVER['REQUEST_TIME']
            );


            array_push($cacher, $cache_aux);
            //=lets do some reversing so recent ones are first
            $cacher = array_reverse($cacher);

            $content = serialize($cacher);
            if (file_exists($filename)){
                
            }else{
                $handle = fopen($filename, 'w');
            }
            
            
                if (is_writable($filename)) {

                    // In our example we're opening $filename in append mode.
                    // The file pointer is at the bottom of the file hence
                    // that's where $somecontent will go when we fwrite() it.
                    if (!$handle = fopen($filename, 'w')) {
                         echo "Cannot open file ($filename)";
                         exit;
                    }

                    // Write $somecontent to our opened file.
                    if(strpos($content, '"errors":')===false){
                    if (fwrite($handle, $content) === FALSE) {
                        echo "Cannot write to file ($filename)";
                        exit;
                    }
                    }

                    fclose($handle);

                } else {
                    echo "The file $filename is not writable";
                }
        
        }

        $twitter_data = json_decode($json);
        
        
        
        return $twitter_data;
    }
}






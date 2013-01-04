<?php  
  error_reporting(E_ALL & ~E_NOTICE);
  $app_id = "127488900729513";
  $app_secret = "f2b25c9e83a233e89104202f8ad98df3";
  $my_url = "https://www.quetevalga.com/fb_concursos/"; // mainly, redirect to this page
  $perms_str = "publish_stream";
   
  $code = $_REQUEST["code"];
   
  if(empty($code)) {
      $auth_url = "http://www.facebook.com/dialog/oauth?client_id="
      . $app_id . "&redirect_uri=" . urlencode($my_url)
      . "&scope=" . $perms_str;
      echo("<script>top.location.href='" . $auth_url . "'</script>");
  }
   
  $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
  . $app_id . "&redirect_uri=" . urlencode($my_url)
  . "&client_secret=" . $app_secret
  . "&code=" . $code;
  $response = file_get_contents($token_url);
  $p = null;
  parse_str($response, $p);
  $access_token = $p['access_token'];
  $graph_url= "https://graph.facebook.com/me/photos?"
           . "access_token=" .$access_token;
  
  //Hiper params
  $params = array();      
  
  $params['message'] = "Mira la foto que me tomaron en Quetevalga.com";
  $params['source'] = "@" . realpath("./img/cms/proximamente.jpg");
     
  // Start the Graph API call
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$graph_url);
   
  /*
      Next option is only used for 
      user from a local (WAMP) 
      machine. This should be removed
      when used on a live server!
      refer:https://github.com/facebook/php-sdk/issues/7
  */
  //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
   
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
  $result = curl_exec($ch);
  $decoded = json_decode($result, true);
  curl_close($ch);
  if(is_array($decoded) && isset($decoded['id'])) {
      /*
          Picture is uploaded successfully:
          1) show success message
          2) optionally, delete image from our server
      */
      $msg = "Image uploaded successfully: {$decoded['id']}";
      echo $msg;
  }
  
?>
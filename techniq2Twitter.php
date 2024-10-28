<?php
$home="zz";
/*
Plugin Name: techniq2Twitter
Plugin URI: http://techniq.mx/plugins/
Description: Actualiza twitter usando niq.mx(apoyando al acortador mexicano). Es una pequeña adaptación del plugin Twitter updater w/ TinyURL de Victoria Chan y Jonathan Dingman.
Version: 0.31
Author: Daniel Niquet
Author URI: http://techniq.mx
*/
function vc_doTwitterAPIPost($twit, $twitterURI) {
	$host = 'twitter.com';
	$port = 80;
	$fp = fsockopen($host, $port, $err_num, $err_msg, 10);

	//check if user login details have been entered on admin page
	$thisLoginDetails = get_option('twitterlogin_encrypted');

	if($thisLoginDetails != '')
	{
		if (!$fp) {
			echo "$err_msg ($err_num)<br>\n";
		} else {
			echo $string;
			fputs($fp, "POST $twitterURI HTTP/1.1\r\n");
			fputs($fp, "Authorization: Basic ".$thisLoginDetails."\r\n");
			fputs($fp, "User-Agent: ".$agent."\n");
			fputs($fp, "Host: $host\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
			fputs($fp, "Content-length: ".strlen($twit)."\n");
			fputs($fp, "Connection: close\n\n");
			fputs($fp, $twit);
			for ($i = 1; $i < 10; $i++){$reply = fgets($fp, 256);}
			fclose($fp);
		}
		return $response;
	} else {
		//user has not entered details.. Do nothing? Don't wanna mess up the post saving..
		return '';
	}
}

function getUrl($url){
    return json_decode(file_get_contents('http://niq.mx/niqUrl/?url='.urldecode($url)))->url;
}
function niq_2Twitt($post_ID)  {
   $twitterURI = "/statuses/update.xml";
   $thisposttitle = $_POST['post_title'];
   $thispostlink = get_permalink($post_ID);
   $status = get_post_status($post_ID);
   $sentence = '';
   
   
	if($status == 'publish' && $_POST['hidden_post_status']=='draft'){
			if(get_option('newpost-published-update') == '1'){
				$sentence = get_option('newpost-published-text');
				if(get_option('newpost-published-showlink') == '1'){
					$thisposttitle = $thisposttitle . ' ( ' . getUrl($thispostlink) . ' )';
				}
				$sentence = str_replace ( '#title#', $thisposttitle, $sentence);
			}
	}
	
	if($sentence != ''){
		$sendToTwitter = vc_doTwitterAPIPost('status='.$sentence, $twitterURI);
	}
  
   return $post_ID;
}
// ADMIN PANEL
function niq_addAdminOption() {
    if (function_exists('add_management_page')) {
		 add_management_page('techniq2Twitter', 'techniq2Twitter', 8, __FILE__, 'niq_AttachPage');
    }
 }

function niq_AttachPage() {
    include(dirname(__FILE__).'/techniq2Twitter_manage.php');
}


//HOOKIES
add_action ( 'save_post', 'niq_2Twitt');
add_action('admin_menu', 'niq_addAdminOption');

?>

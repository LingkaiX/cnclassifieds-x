<?php
function chinese_excerpt($text,$lenth=286) {
	if(is_single()){
		return $text;
	}
    return mb_strimwidth($text,0,$lenth,'...','utf-8'); //6 prefix, en * 1, ch * 2
}
add_filter('the_excerpt', 'chinese_excerpt');

function my_awesome_func( $data ) {
	$to = "lingkai.xu@gmail.com";
	$subject = "My subject";
	$txt = "Hello world!";
	$headers = "From: yoo@auads.com.au" . "\r\n" .
	"CC: xlk910728@gmail.com";
	mail($to,$subject,$txt,$headers);

	return  $data['id'].'fgsdgfsde';
  }

  add_action( 'rest_api_init', function () {
	register_rest_route( 'myplugin/v1', '/author/(?P<id>\d+)', array(
	  'methods' => 'GET',
	  'callback' => 'my_awesome_func',
	) );
  } );


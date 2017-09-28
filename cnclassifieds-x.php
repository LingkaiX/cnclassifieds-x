<?php
/**
 * Plugin Name: cnclassifieds-x
 * Description: Used with cnclassifieds theme
 * Version: 1.0.0
 * Author: Simon Xu
 * License: GPL2
 */
function send_mail_to_business( $data ) {
	$to = "lingkai.xu@gmail.com";
	$subject = "My subject";
	$txt = "Hello world!";
    $headers = "From: service@auads.com.au";
    //. "\r\n" . "CC: visiontimes.mel@gmail.com";
	mail($to,$subject,$txt,$headers);

	return  $data['id'].'fgsdgfsde';
  }

  add_action( 'rest_api_init', function () {
	register_rest_route( 'cnx/v1', '/mailtobusiness/(?P<id>\w+)', array(
	  'methods' => 'GET',
	  'callback' => 'my_awesome_func',
	) );
  } );


<?php
/**
 * Plugin Name: cnclassifieds-x
 * Description: Used with cnclassifieds theme
 * Version: 1.0.0
 * Author: Simon Xu
 * License: GPL2
 */

//create database table cnx-mail
global $wpdb;
$table_name = $wpdb->prefix . "cnx_mail"; 
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE $table_name (
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	sendtime datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	name varchar(255) NOT NULL,
	mail varchar(255) NOT NULL,
	phone varchar(45) NOT NULL,
	enquiry text NOT NULL,
	sendto bigint(20) NOT NULL,
	PRIMARY KEY  (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

$wpdb->query("alter table wp_places_locator modify column phone varchar(255)");
 //api: send mail to business
function send_mail_to_business( $request ) {
	$uname=$request['name']?$request['name']:'';
	$umail=$request['mail']?$request['mail']:'';
	$uphone=$request['phone']?$request['phone']:'';
	$uenquiry=$request['enquiry']?$request['enquiry']:'';
	//return $uname.'+'.$umail.'+'.$uphone.'+'.$uenquiry.'+'.$request['id'];
	//check recieved data
	if(empty($uname)||empty($umail)||empty($uenquiry))
		return new WP_Error( 'valid request', 'valid parameter(s)', array( 'status' => 404 ));
	//check if business has a mail
	$bid=(int)$request['id'];
	if(!get_post_status($bid))
		return new WP_Error( 'valid request', 'no post', array( 'status' => 404 ));
	$bmail=get_post_meta($bid,'email-to-business',true);
	if(!$bmail)
		return new WP_Error( 'valid request', 'no mail', array( 'status' => 404 ));
	//store into database
	global $wpdb;
	$table_name = $wpdb->prefix . "cnx_mail"; 
	$wpdb->insert( 
		$table_name, 
		array( 
			'sendtime' => current_time( 'mysql' ), 
			'name' => $uname, 
			'mail' => $umail, 
			'phone' => $uphone,
			'enquiry' => $uenquiry,
			'sendto' => $bid,
		) 
	 );	
	//send mail
	$to = $bmail;
	$subject = "来自分类广告网（auads.com.au)的客户请求";
	$txt = "姓名：".$uname."\r\n邮箱：".$umail."\r\n";
	if($uphone) $txt=$txt."联系电话：".$uphone."\r\n";
	$txt=$txt."内容：".$uenquiry."\r\n";
	$txt=$txt."\r\n请勿回复此邮件";
	$headers = "From: service@auads.com.au";
  //. "\r\n" . "CC: visiontimes.mel@gmail.com";
	$result=mail($to,$subject,$txt,$headers);

	return  $result;
  }

  add_action( 'rest_api_init', function () {
	register_rest_route( 'cnx/v1', '/mailtobusiness/(?P<id>\d+)', array(
	  'methods' => 'POST',
	  'callback' => 'send_mail_to_business',
	) );
  } );


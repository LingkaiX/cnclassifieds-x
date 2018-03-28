<?php
function my_custom_post_goodman() {
  $labels = array(
    'name'                  => _x( 'Goodmen', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Goodman', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'          => '明星商家'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => '我们网站的电影信息',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
    'menu_icon'     => 'dashicons-money',
    'has_archive'   => false
  );
  register_post_type( 'goodman', $args );
}
add_action( 'init', 'my_custom_post_goodman' );
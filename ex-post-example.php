<?php
//For exmaple
// Register Custom Post Type
function articles_post_type() {

	$labels = array(
		'name'                  => _x( 'Articles', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Article', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Articles', 'text_domain' ),
		'name_admin_bar'        => __( 'Article', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Article', 'text_domain' ),
		'description'           => __( 'Site articles.', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
		//'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 10,
		'menu_icon'             => 'dashicons-editor-quote',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
	);
	register_post_type( 'articles', $args );

}
add_action( 'init', 'articles_post_type', 0 );

//分类
// Register Custom Taxonomy
function custom_taxonomy() {
    
        $labels = array(
            'name'                       => _x( 'ex-taxo-1s', 'Taxonomy General Name', 'text_domain' ),
            'singular_name'              => _x( 'ex-taxo-1', 'Taxonomy Singular Name', 'text_domain' ),
            'menu_name'                  => __( 'ex-taxo-1m', 'text_domain' ),
            'all_items'                  => __( 'All Items', 'text_domain' ),
            'parent_item'                => __( 'Parent Item', 'text_domain' ),
            'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
            'new_item_name'              => __( 'New Item Name', 'text_domain' ),
            'add_new_item'               => __( 'Add New Item', 'text_domain' ),
            'edit_item'                  => __( 'Edit Item', 'text_domain' ),
            'update_item'                => __( 'Update Item', 'text_domain' ),
            'view_item'                  => __( 'View Item', 'text_domain' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
            'popular_items'              => __( 'Popular Items', 'text_domain' ),
            'search_items'               => __( 'Search Items', 'text_domain' ),
            'not_found'                  => __( 'Not Found', 'text_domain' ),
            'no_terms'                   => __( 'No items', 'text_domain' ),
            'items_list'                 => __( 'Items list', 'text_domain' ),
            'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
        );
        $rewrite = array(
            'slug'                       => '',
            'with_front'                 => true,
            'hierarchical'               => true,
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'rewrite'                    => $rewrite,
            'show_in_rest'               => true,
        );
        register_taxonomy( 'ex-taxo-1', array( 'articles' ), $args );
    
    }
    add_action( 'init', 'custom_taxonomy', 0 );

    //add_term_meta (11, 'key1', '1234');

    //Add meta to articles
    add_action( 'add_meta_boxes', 'movie_director' );
    function movie_director() {
        add_meta_box(
            'movie_director',
            '电影导演',
            'movie_director_meta_box',
            'articles',
            'normal',
            'high',
            array(
                'slug'                      => 's1',
                's2'                 => "true",
                's3'               => 's3',
            )
        );
    }

    function movie_director_meta_box($post) {
        wp_nonce_field( 'movie_director_meta_box', 'movie_director_meta_box_nonce' );
        $value = get_post_meta( $post->ID, '_movie_director', true );
        
            ?>
        
            <label for="movie_director"></label>
            <input type="text" id="movie_director111" name="movie_director" value="<?php echo esc_attr( $value ); ?>" placeholder="输入导演名儿" >
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    jQuery('#movie_director111 input').datepicker({ });
                });
            </script> 
            <?php
    }
    add_action( 'save_post', 'movie_director_save_meta_box' );
    function movie_director_save_meta_box($post_id){
    
        // 安全检查
        // 检查是否发送了一次性隐藏表单内容（判断是否为第三者模拟提交）
        if ( ! isset( $_POST['movie_director_meta_box_nonce'] ) ) {
            return;
        }
        // 判断隐藏表单的值与之前是否相同
        if ( ! wp_verify_nonce( $_POST['movie_director_meta_box_nonce'], 'movie_director_meta_box' ) ) {
            return;
        }
        // 判断该用户是否有权限
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    
        // 判断 Meta Box 是否为空
        if ( ! isset( $_POST['movie_director'] ) ) {
            return;
        }
    
        $movie_director = sanitize_text_field( $_POST['movie_director'] );
        update_post_meta( $post_id, '_movie_director', $movie_director );
    
    }

    //
    add_action("manage_articles_posts_custom_column",  "movie_custom_columns",10,2);
    //manage_${post_type}_posts_columns filter
    add_filter("manage_articles_posts_columns", "movie_edit_columns");
    function movie_custom_columns($column,$post_id){
        switch ($column) {
            case "movie_director":
                echo get_post_meta( $post_id, '_movie_director', true );
                break;
        }
    }
    function movie_edit_columns($columns){
    
        //$columns['movie_director'] = '导演';
    
        return array_merge($columns,array('movie_director'=>'导演！'));
    }


<?php
//替代Geo My Wp插件，用于后台插入数据到wp_places_locator
//没有创建表格的功能
global $wpdb;
$wpdb->query("alter table wp_places_locator modify column phone varchar(255)");

//Add meta to articles
add_action( 'add_meta_boxes', 'cncinfo_ex_box' );
function cncinfo_ex_box() {
    add_meta_box(
        'cncinfo',
        '分类信息',
        'add_cncinfo_ex_box',
        'post',
        //'articles',
        'normal',
        'high'
    );
}

function add_cncinfo_ex_box($post) {
    //add nonce
    wp_nonce_field( 'cncinfo_ex_box', 'cncinfo_ex_box_nonce' );
    //get existing cncinfo 
    global $wpdb;
    $mypost = $wpdb->get_row( "SELECT * FROM wp_places_locator where post_id=".$post->ID );
        ?>
    
        <input type="text" id="cncinfo-address" name="cncinfo-address" value="<?php echo $mypost==null?'':$mypost->address ?>" placeholder="商家地址（必须选择一个下面列出的地址）" style="width:100%;" autocomplete="off">
        <input type="text" id="cncinfo-phone" name="cncinfo-phone" value="<?php echo $mypost==null?'':$mypost->phone ?>" placeholder="电话/手机（最多255个字符）" style="width:100%;">
        <input type="text" id="cncinfo-email" name="cncinfo-email" value="<?php echo $mypost==null?'':$mypost->email ?>" placeholder="邮箱（最多255个字符）" style="width:100%;">
        <input type="text" id="cncinfo-website" name="cncinfo-website" value="<?php echo $mypost==null?'':$mypost->website ?>" placeholder="网站（只能填一个网址，网址必须以'http://' 或 'https://' 或 '//'开头）" style="width:100%;">
        <input type="hidden" id="cncinfo-lat" name="cncinfo-lat" value="<?php echo $mypost==null?'':$mypost->lat ?>">
        <input type="hidden" id="cncinfo-long" name="cncinfo-long" value="<?php echo $mypost==null?'':$mypost->long ?>">
        <input type="hidden" id="cncinfo-formatted_address" name="cncinfo-formatted_address" value="<?php echo $mypost==null?'':$mypost->formatted_address ?>">
        <input type="hidden" id="cncinfo-country" name="cncinfo-country" value="<?php echo $mypost==null?'':$mypost->country ?>">
        <input type="hidden" id="cncinfo-country_long" name="cncinfo-country_long" value="<?php echo $mypost==null?'':$mypost->country_long ?>">
        <input type="hidden" id="cncinfo-zipcode" name="cncinfo-zipcode" value="<?php echo $mypost==null?'':$mypost->zipcode ?>">
        <input type="hidden" id="cncinfo-state" name="cncinfo-state" value="<?php echo $mypost==null?'':$mypost->state ?>">
        <input type="hidden" id="cncinfo-state_long" name="cncinfo-state_long" value="<?php echo $mypost==null?'':$mypost->state_long ?>">
        <input type="hidden" id="cncinfo-city" name="cncinfo-city" value="<?php echo $mypost==null?'':$mypost->city ?>">
        <input type="hidden" id="cncinfo-street" name="cncinfo-street" value="<?php echo $mypost==null?'':$mypost->street ?>">
        <input type="hidden" id="cncinfo-street_name" name="cncinfo-street_name" value="<?php echo $mypost==null?'':$mypost->street_name ?>">
        <input type="hidden" id="cncinfo-street_number" name="cncinfo-street_number" value="<?php echo $mypost==null?'':$mypost->street_number ?>">
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQWClP6rOf55if8uN7jXIs_K2gheMECSw&libraries=places&region=AU&language=en-us" defer></script>
        <script type="text/javascript">
        //from geo my wp plugin
        function _findInfo(result, type) {
            for (var i = 0; i < result.address_components.length; i++) {
                var component = result.address_components[i];
                if (component.types.indexOf(type) !=-1) {
                    return component.short_name;
                }
            }
            return "";
        }
        function _findInfoLong(result, type) {
            for (var i = 0; i < result.address_components.length; i++) {
                var component = result.address_components[i];
                if (component.types.indexOf(type) !=-1) {
                    return component.long_name;
                }
            }
            return "";
        }
        jQuery(document).ready(function($){

            var input = (document.getElementById('cncinfo-address'));
            var autocomplete = new google.maps.places.Autocomplete(input,{componentRestrictions:{country: "AU"}});
            autocomplete.addListener('place_changed', function() {
                //console.log(autocomplete.getPlace());
                input.value= autocomplete.getPlace().formatted_address;
                document.getElementById('cncinfo-address').value=autocomplete.getPlace().formatted_address;
                document.getElementById('cncinfo-lat').value=autocomplete.getPlace().geometry.location.lat();
                document.getElementById('cncinfo-long').value=autocomplete.getPlace().geometry.location.lng();
                document.getElementById('cncinfo-formatted_address').value=autocomplete.getPlace().formatted_address;

                document.getElementById('cncinfo-country').value=_findInfo(autocomplete.getPlace(), 'country');
                document.getElementById('cncinfo-country_long').value=_findInfoLong(autocomplete.getPlace(), 'country');
                document.getElementById('cncinfo-zipcode').value=_findInfoLong(autocomplete.getPlace(), 'postal_code');
                document.getElementById('cncinfo-state').value=_findInfo(autocomplete.getPlace(), 'administrative_area_level_1');
                document.getElementById('cncinfo-state_long').value=_findInfoLong(autocomplete.getPlace(), 'administrative_area_level_1');
                document.getElementById('cncinfo-city').value=_findInfoLong(autocomplete.getPlace(), 'administrative_area_level_2');
                document.getElementById('cncinfo-street').value=autocomplete.getPlace().name;
                    //_findInfoLong(autocomplete.getPlace(), 'street_number')+" "+_findInfoLong(autocomplete.getPlace(), 'route');
                document.getElementById('cncinfo-street_name').value=_findInfoLong(autocomplete.getPlace(), 'route');
                document.getElementById('cncinfo-street_number').value=_findInfoLong(autocomplete.getPlace(), 'street_number');
            });
        });
        </script> 
        <?php
}
add_action( 'save_post', 'save_cncinfo_ex_box',10, 2 );
function save_cncinfo_ex_box($post_id, $post){
    if ( wp_is_post_revision( $post_id ) ) return;
    // 安全检查
    // 检查是否发送了一次性隐藏表单内容（判断是否为第三者模拟提交）
    if ( ! isset( $_POST['cncinfo_ex_box_nonce'] ) ) {
        return;
    }
    // 判断隐藏表单的值与之前是否相同
    if ( ! wp_verify_nonce( $_POST['cncinfo_ex_box_nonce'], 'cncinfo_ex_box' ) ) {
        return;
    }
    // 判断该用户是否有权限
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    //$movie_director = sanitize_text_field( $_POST['movie_director'] );
    global $wpdb;
    if($wpdb->get_row( "SELECT * FROM wp_places_locator where post_id=".$post_id )){
        $wpdb->update(
            'wp_places_locator', 
            array(
                'address' => $_POST['cncinfo-address'],
                'lat' => $_POST['cncinfo-lat'],
                'long' => $_POST['cncinfo-long'],
                'formatted_address' => $_POST['cncinfo-formatted_address'],
                'country' => $_POST['cncinfo-country'],
                'country_long' => $_POST['cncinfo-country_long'],
                'zipcode' => $_POST['cncinfo-zipcode'],
                'state' => $_POST['cncinfo-state'],
                'state_long' => $_POST['cncinfo-state_long'],
                'city' => $_POST['cncinfo-city'],
                'street' => $_POST['cncinfo-street'], //actually this is palce name $post->ID
                'street_name' => $_POST['cncinfo-street_name'],
                'street_number' => $_POST['cncinfo-street_number'],
                'post_status' => $post->post_status,
                'post_type' => $post->post_type,
                'post_title' => $post->post_title,
                'phone' => $_POST['cncinfo-phone'],
                'email' => $_POST['cncinfo-email'],
                'website' => $_POST['cncinfo-website']
            ), 
            array( 'post_id' => $post_id )
        );
    }else{
        $wpdb->insert( 
            'wp_places_locator', 
            array( 
                'address' => $_POST['cncinfo-address'],
                'lat' => $_POST['cncinfo-lat'],
                'long' => $_POST['cncinfo-long'],
                'formatted_address' => $_POST['cncinfo-formatted_address'],
                'country' => $_POST['cncinfo-country'],
                'country_long' => $_POST['cncinfo-country_long'],
                'zipcode' => $_POST['cncinfo-zipcode'],
                'state' => $_POST['cncinfo-state'],
                'state_long' => $_POST['cncinfo-state_long'],
                'city' => $_POST['cncinfo-city'],
                'street' => $_POST['cncinfo-street'], //actually this is palce name $post->ID
                'street_name' => $_POST['cncinfo-street_name'],
                'street_number' => $_POST['cncinfo-street_number'],
                'post_status' => $post->post_status,
                'post_type' => $post->post_type,
                'post_title' => $post->post_title,
                'phone' => $_POST['cncinfo-phone'],
                'email' => $_POST['cncinfo-email'],
                'website' => $_POST['cncinfo-website'],
                'post_id' => $post_id
            )
        );
    }
}

//Add '定位' column to post list
add_filter("manage_posts_columns", "add_cnc_location_column");
function add_cnc_location_column($columns){
    return array_merge($columns,array('cnc_location'=>'定位'));
}
add_action("manage_posts_custom_column",  "display_cnc_location_column",10,2);
function display_cnc_location_column($column,$post_id){
    global $wpdb;
    $mypost = $wpdb->get_row( "SELECT * FROM wp_places_locator where post_id=".$post_id );
    switch ($column) {
        case "cnc_location":
            if($mypost==null||$mypost->lat=="0.000000"||$mypost->long=="0.000000")
                echo '<span style="color:red">no</span>';
            else echo '<span style="color:green">yes</span>';
            break;
    }
}

<?php
/*
 * Plugin Name: Full Width Responsive Slider Wp
 * Plugin URI:https://www.i13websolution.com/wordpress-full-width-slider-plugin.html
 * Author URI:https://www.i13websolution.com
 * Description:This is beautiful responsive full width slider plugin.Add any number of images. your full width slider will be ready within few min. 
 * Author:I Thirteen Web Solution 
 * Version:1.0
 * Text Domain:full-width-responsive-slider-wp
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; 

add_filter ( 'widget_text', 'do_shortcode' );
add_action ( 'admin_menu', 'fwrsw_responsive_full_width_slider_add_admin_menu' );

register_activation_hook ( __FILE__, 'fwrsw_full_width_slider_wp_install' );
add_action ( 'wp_enqueue_scripts', 'fwrsw_full_width_slider__load_styles_and_js' );
add_shortcode ( 'fwrsw_print_responsive_full_width_slider_wp', 'fwrsw_print_responsive_full_width_slider_wp_func' );
add_action ( 'admin_notices', 'fwrsw_responsive_full_width_slider__admin_notices' );
add_action('plugins_loaded', 'fwrsw_lang_for_responsive_full_width_slider');

function fwrsw_lang_for_responsive_full_width_slider() {
            
            load_plugin_textdomain( 'full-width-responsive-slider-wp', false, basename( dirname( __FILE__ ) ) . '/languages/' );
    }

function fwrsw_save_image_remote($url,$saveto){
    
    $raw = wp_remote_retrieve_body( wp_remote_get( $url ) );
    
    if(file_exists($saveto)){
        @unlink($saveto);
    }
    $fp = @fopen($saveto,'x');
    @fwrite($fp, $raw);
    @fclose($fp);
}


function fwrsw_i13_get_http_response_code_gallery($url) {
    $headers = @get_headers($url);
    return @substr($headers[0], 9, 3);
}



function fwrsw_responsive_full_width_slider__admin_notices() {
    
	if (is_plugin_active ( 'full-width-responsive-slider-wp/full-width-responsive-slider-wp.php' )) {
		
		$uploads = wp_upload_dir ();
		$baseDir = $uploads ['basedir'];
		$baseDir = str_replace ( "\\", "/", $baseDir );
		$pathToImagesFolder = $baseDir . '/full-width-responsive-slider-wp';
		
		if (file_exists ( $pathToImagesFolder ) and is_dir ( $pathToImagesFolder )) {
			
			if (! is_writable ( $pathToImagesFolder )) {
				echo "<div class='updated'><p>Full width slider is active but does not have write permission on</p><p><b>" . $pathToImagesFolder . "</b> directory.Please allow write permission.</p></div> ";
			}
		} else {
			
			wp_mkdir_p ( $pathToImagesFolder );
			if (! file_exists ( $pathToImagesFolder ) and ! is_dir ( $pathToImagesFolder )) {
				echo "<div class='updated'><p>Full Width Slider is active but plugin does not have permission to create directory</p><p><b>" . $pathToImagesFolder . "</b> .Please create full-width-responsive-slider-wp directory inside upload directory and allow write permission.</p></div> ";
			}
		}
	}
}


function fwrsw_responsive_full_width_slider__add_admin_init() {
    
        
	$url = plugin_dir_url ( __FILE__ );
	
	wp_enqueue_style( 'admincss', plugins_url('/css/admincss.css', __FILE__) );
	wp_enqueue_style( 'full-width-slider-wp', plugins_url('/css/full-width-slider-wp.css', __FILE__) );
	wp_enqueue_style( 'full-width-responsive-slider-entypo', plugins_url('/icons/full-width-responsive-slider-entypo.css', __FILE__) );
        wp_enqueue_script('jquery');         
        wp_enqueue_script("jquery-ui-core");
        wp_enqueue_script('full-width-responsive-slider-wp-hammer',plugins_url('/js/full-width-responsive-slider-wp-hammer.js', __FILE__));
        wp_enqueue_script('full-width-responsive-slider-wp-slider',plugins_url('/js/full-width-responsive-slider-wp-slider.js', __FILE__));
        wp_enqueue_script('jquery.validate',plugins_url('/js/jquery.validate.js', __FILE__));
       
	
	
	fwrsw_responsive_full_width_slider__admin_scripts_init();
}

function fwrsw_full_width_slider__load_styles_and_js() {
	if (! is_admin ()) {
		
		wp_enqueue_style ( 'full-width-slider-wp', plugins_url ( '/css/full-width-slider-wp.css', __FILE__ ) );
		wp_enqueue_style ( 'full-width-responsive-slider-entypo', plugins_url ( '/icons/full-width-responsive-slider-entypo.css', __FILE__ ) );
		wp_enqueue_script ( 'jquery' );
		wp_enqueue_script ( 'full-width-responsive-slider-wp-hammer', plugins_url ( '/js/full-width-responsive-slider-wp-hammer.js', __FILE__ ) );
		wp_enqueue_script ( 'full-width-responsive-slider-wp-slider', plugins_url ( '/js/full-width-responsive-slider-wp-slider.js', __FILE__ ) );
		
		
           }
}
function fwrsw_full_width_slider_wp_install() {
    
	global $wpdb;
	$table_name = $wpdb->prefix . "e_fw_slider";
	$table_name2 = $wpdb->prefix . "e_fw_slider_settings";
	
        $charset_collate = $wpdb->get_charset_collate();
        
	$sql = "CREATE TABLE " . $table_name . " (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `image_name` varchar(500) NOT NULL,
        `title` varchar(200) NOT NULL,
        `image_description` text  DEFAULT NULL ,
        `HdnMediaSelection` varchar(300)  NOT NULL,
        `createdon` datetime NOT NULL, 
        `slider_id` int(11) NOT NULL DEFAULT '1',
         PRIMARY KEY (`id`)
        ) $charset_collate ";

        
	require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta ( $sql );

        //delete_option('fwrsw_full_width_settings');
        $fwrsw_full_width_settings=array('transition_speed' => '1000',
            'slider_Speed' => 1000,
            'ease' =>'ease-out',
            'height' =>500,
            'height_tablets' =>400,
            'height_sphone' =>300,
            'slider_Drag' =>1,
            'slider_Dots' => 1,
            'slider_Dots_prev'=>1,
            'slider_Arrows' => 1,
            'auto_slide' => 0,
            'auto_slide_interval' => 5000,
           
        );

        if( !get_option( 'fwrsw_full_width_settings' ) ) {

            update_option('fwrsw_full_width_settings',$fwrsw_full_width_settings);
        } 
        
	$uploads = wp_upload_dir ();
	$baseDir = $uploads ['basedir'];
	$baseDir = str_replace ( "\\", "/", $baseDir );
	$pathToImagesFolder = $baseDir . '/full-width-responsive-slider-wp';
	wp_mkdir_p ( $pathToImagesFolder );
        
       
        
        
}
function fwrsw_responsive_full_width_slider_add_admin_menu() {
    
	$hook_suffix = add_menu_page ( __( 'Full Width Slider','full-width-responsive-slider-wp') , __ ( 'Full Width Slider','full-width-responsive-slider-wp' ), 'administrator', 'responsive_full_width_slider_wp', 'fwrsw_responsive_full_width_slider_wp_admin_options_func' );
	$hook_suffix=add_submenu_page ( 'responsive_full_width_slider_wp', __ ( 'Slider Settings','full-width-responsive-slider-wp' ), __ ( 'Slider Settings','full-width-responsive-slider-wp' ), 'administrator', 'responsive_full_width_slider_wp', 'fwrsw_responsive_full_width_slider_wp_admin_options_func' );
	$hook_suffix_image=add_submenu_page ( 'responsive_full_width_slider_wp', __ ( 'Manage Images','full-width-responsive-slider-wp' ), __ ( 'Manage Images','full-width-responsive-slider-wp' ), 'administrator', 'responsive_full_width_slider_wp_media_management', 'fwrsw_responsive_full_width_slider_wp_media_management_func' );
	$hook_suffix_prev=add_submenu_page ( 'responsive_full_width_slider_wp', __ ( 'Preview Slider','full-width-responsive-slider-wp' ), __ ( 'Preview Slider','full-width-responsive-slider-wp' ), 'administrator', 'responsive_full_width_slider_wp_media_preview', 'fwrsw_responsive_full_width_slider_wp_media_preview_func' );
	
	add_action( 'load-' . $hook_suffix , 'fwrsw_responsive_full_width_slider__add_admin_init' );
	add_action( 'load-' . $hook_suffix_image , 'fwrsw_responsive_full_width_slider__add_admin_init' );
	add_action( 'load-' . $hook_suffix_prev , 'fwrsw_responsive_full_width_slider__add_admin_init' );
        
        fwrsw_responsive_full_width_slider__admin_scripts_init();
	
}


function fwrsw_responsive_full_width_slider_wp_admin_options_func(){



        if(isset($_POST['btnsave'])){

            if ( !check_admin_referer( 'action_image_add_edit','add_edit_image_nonce')){

                  wp_die('Security check fail'); 
              }

                
            $slider_Speed=sanitize_text_field($_POST['slider_Speed']); 
            $slider_Speed=intval($slider_Speed); 
           
            $height=sanitize_text_field($_POST['height']); 
            $height=intval($height); 
           
            $height_tablets=sanitize_text_field($_POST['height_tablets']); 
            $height_tablets=intval($height_tablets); 
           
            $height_sphone=sanitize_text_field($_POST['height_sphone']); 
            $height_sphone=intval($height_sphone); 
           
            
            $ease=sanitize_text_field($_POST['ease']); 
            $slider_Drag=intval(sanitize_text_field($_POST['slider_Drag'])); 
            $slider_Dots=intval(sanitize_text_field($_POST['slider_Dots'])); 
            $slider_Dots_prev=intval(sanitize_text_field($_POST['slider_Dots_prev'])); 
            $slider_Arrows=intval(sanitize_text_field($_POST['slider_Arrows'])); 
            $auto_slide=intval(sanitize_text_field($_POST['auto_slide'])); 
            $auto_slide_interval=sanitize_text_field($_POST['auto_slide_interval']); 
            $auto_slide_interval=intval($auto_slide_interval); 
           
           
        
            
            
            
            
            $options=array();
            $options['slider_Speed']           =$slider_Speed;
            $options['height']                 =$height;
            $options['height_tablets']         =$height_tablets;
            $options['height_sphone']          =$height_sphone;
            $options['slider_Drag']            =$slider_Drag;
            $options['ease']                   =$ease;
            $options['slider_Dots']            =$slider_Dots;
            $options['slider_Dots_prev']       =$slider_Dots_prev;
            $options['slider_Arrows']          =$slider_Arrows;
            $options['auto_slide']             =$auto_slide;
            $options['auto_slide_interval']    =$auto_slide_interval;
            
            
            $settings=update_option('fwrsw_full_width_settings',$options); 
            $fwrsw_full_width_slider_msg=array();
            $fwrsw_full_width_slider_msg['type']='succ';
            $fwrsw_full_width_slider_msg['message']=__("Settings saved successfully",'full-width-responsive-slider-wp');
            update_option('fwrsw_full_width_slider_msg', $fwrsw_full_width_slider_msg);



        }  
        $settings=get_option('fwrsw_full_width_settings');
        
        

    ?>      
    <div style="width: 100%;">  
        <div style="float:left;width:100%;">
            <div class="wrap">
                 <table><tr><td><a href="https://twitter.com/FreeAdsPost" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @FreeAdsPost</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
                        <td>
                            <a target="_blank" title="Donate" href="http://i13websolution.com/donate-wordpress_image_thumbnail.php">
                                <img id="help us for free plugin" height="30" width="90" src="<?php echo plugins_url( 'images/paypaldonate.jpg', __FILE__ );?>" border="0" alt="help us for free plugin" title="help us for free plugin">
                                </a>
                            </td>
                        </tr>
                    </table>
                    <div style="clear:both">
                       <span><h3 style="color: blue;"><a target="_blank" href="https://www.i13websolution.com/wordpress-full-width-slider-plugin.html">UPGRADE TO PRO VERSION</a></h3></span>
                   </div> 
                <?php
                    $messages=get_option('fwrsw_full_width_slider_msg'); 
                    $type='';
                    $message='';
                    if(isset($messages['type']) and $messages['type']!=""){

                        $type=$messages['type'];
                        $message=$messages['message'];

                    }  


                    if($type=='err'){ echo "<div class='errMsg'>"; echo $message; echo "</div>";}
                    else if($type=='succ'){ echo "<div class='succMsg'>"; echo $message; echo "</div>";}


                    update_option('fwrsw_full_width_slider_msg', array());     
                ?>      


                <h2><?php echo __("Slider Settings",'full-width-responsive-slider-wp');?></h2>
                <div id="poststuff">   
                    <div id="post-body" class="metabox-holder columns-2">
                        <div id="post-body-content" >
                                <form method="post" action="" id="scrollersettiings" name="scrollersettiings" >
                                    <div class="stuffbox" id="namediv" style="width:100%;">
                                        <h3><label for="link_name"><?php echo __("Settings",'full-width-responsive-slider-wp');?></label></h3>
                                        <table cellspacing="0" class="form-list" cellpadding="10">
                                            <tbody>
                                              
                                                <tr>
                                                    <td class="label">
                                                        <label for="slider_Speed"><?php echo __("Slider Speed",'full-width-responsive-slider-wp');?> <span class="required">*</span></label>
                                                    </td>
                                                    <td class="value">
                                                        <input id="slider_Speed" value="<?php echo intval($settings['slider_Speed']); ?>" name="slider_Speed"  class="input-text" type="text">           
                                                        <div style="clear:both"></div>
                                                        <div></div> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">
                                                        <label for="height"><?php echo __("Slider Height",'full-width-responsive-slider-wp');?> <span class="required">*</span></label>
                                                    </td>
                                                    <td class="value">
                                                        <input id="height" value="<?php echo intval($settings['height']); ?>" name="height"  class="input-text" type="text">           
                                                        <div style="clear:both"></div>
                                                        <div></div> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">
                                                        <label for="height_tablets"><?php echo __("Slider Height Tablets",'full-width-responsive-slider-wp');?> <span class="required">*</span></label>
                                                    </td>
                                                    <td class="value">
                                                        <input id="height_tablets" value="<?php echo intval($settings['height_tablets']); ?>" name="height_tablets"  class="input-text" type="text">           
                                                        <div style="clear:both"></div>
                                                        <div></div> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">
                                                        <label for="height_sphone"><?php echo __("Slider Height Smartphone",'full-width-responsive-slider-wp');?> <span class="required">*</span></label>
                                                    </td>
                                                    <td class="value">
                                                        <input id="height_sphone" value="<?php echo intval($settings['height_sphone']); ?>" name="height_sphone"  class="input-text" type="text">           
                                                        <div style="clear:both"></div>
                                                        <div></div> 
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="label">
                                                        <label for="ease"><?php echo __("Ease Effect",'full-width-responsive-slider-wp');?>  <span class="required">*</span></label>
                                                    </td>
                                                    <td class="value">
                                                        <select id="ease" name="ease" class="select">
                                                            <option value=""><?php echo __("Select",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if($settings['ease']=='ease'):?> selected="selected" <?php endif;?>  value="ease" ><?php echo __("ease",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if($settings['ease']=='linear'):?> selected="selected" <?php endif;?>  value="linear" ><?php echo __("linear",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if($settings['ease']=='ease-in'):?> selected="selected" <?php endif;?>  value="ease-in" ><?php echo __("ease-in",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if($settings['ease']=='ease-out'):?> selected="selected" <?php endif;?>  value="ease-out" ><?php echo __("ease-out",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if($settings['ease']=='ease-in-out'):?> selected="selected" <?php endif;?>  value="ease-in-out" ><?php echo __("ease-in-out",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if($settings['ease']=='cubic-bezier(.16,.92,0,.8)'):?> selected="selected" <?php endif;?>  value="cubic-bezier(.16,.92,0,.8)" ><?php echo __("cubic-bezier",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if($settings['ease']=='fade'):?> selected="selected" <?php endif;?>  value="fade" ><?php echo __("fade",'full-width-responsive-slider-wp');?></option>
                                                            
                                                        </select>            
                                                        <div style="clear:both"></div>
                                                        <div></div>
                                                    </td>
                                                </tr> 
                                                <tr>
                                                    <td class="label">
                                                        <label for="slider_Drag"><?php echo __("Allow drag in slider",'full-width-responsive-slider-wp');?>  <span class="required">*</span></label>
                                                    </td>
                                                    <td class="value">
                                                        <select id="slider_Drag" name="slider_Drag" class="select">
                                                            <option value=""><?php echo __("Select",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if(intval($settings['slider_Drag'])==1):?> selected="selected" <?php endif;?>  value="1" ><?php echo __("Yes",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if(intval($settings['slider_Drag'])==0):?> selected="selected" <?php endif;?>  value="0"><?php echo __("No",'full-width-responsive-slider-wp');?></option>
                                                        </select>            
                                                        <div style="clear:both"></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">
                                                        <label for="slider_Dots"><?php echo __("Show Slider Pagination",'full-width-responsive-slider-wp');?>  <span class="required">*</span></label>
                                                    </td>
                                                    <td class="value">
                                                        <select id="slider_Dots" name="slider_Dots" class="select">
                                                            <option value=""><?php echo __("Select",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if(intval($settings['slider_Dots'])==1):?> selected="selected" <?php endif;?>  value="1" ><?php echo __("Yes",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if(intval($settings['slider_Dots'])==0):?> selected="selected" <?php endif;?>  value="0"><?php echo __("No",'full-width-responsive-slider-wp');?></option>
                                                        </select>            
                                                        <div style="clear:both"></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">
                                                        <label for="slider_Dots_prev"><?php echo __("Show Preview On Hover Pagination",'full-width-responsive-slider-wp');?>  <span class="required">*</span></label>
                                                    </td>
                                                    <td class="value">
                                                        <select id="slider_Dots_prev" name="slider_Dots_prev" class="select">
                                                            <option value=""><?php echo __("Select",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if(intval($settings['slider_Dots_prev'])==1):?> selected="selected" <?php endif;?>  value="1" ><?php echo __("Yes",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if(intval($settings['slider_Dots_prev'])==0):?> selected="selected" <?php endif;?>  value="0"><?php echo __("No",'full-width-responsive-slider-wp');?></option>
                                                        </select>            
                                                        <div style="clear:both"></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">
                                                        <label for="slider_Arrows"><?php echo __("Show Arrows",'full-width-responsive-slider-wp');?>  <span class="required">*</span></label>
                                                    </td>
                                                    <td class="value">
                                                        <select id="slider_Arrows" name="slider_Arrows" class="select">
                                                            <option value=""><?php echo __("Select",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if(intval($settings['slider_Arrows'])==1):?> selected="selected" <?php endif;?>  value="1" ><?php echo __("Yes",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if(intval($settings['slider_Arrows'])==0):?> selected="selected" <?php endif;?>  value="0"><?php echo __("No",'full-width-responsive-slider-wp');?></option>
                                                        </select>            
                                                        <div style="clear:both"></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">
                                                        <label for="auto_slide"><?php echo __("Auto Slide",'full-width-responsive-slider-wp');?>  <span class="required">*</span></label>
                                                    </td>
                                                    <td class="value">
                                                        <select id="auto_slide" name="auto_slide" class="select">
                                                            <option value=""><?php echo __("Select",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if(intval($settings['auto_slide'])==1):?> selected="selected" <?php endif;?>  value="1" ><?php echo __("Yes",'full-width-responsive-slider-wp');?></option>
                                                            <option <?php if(intval($settings['auto_slide'])==0):?> selected="selected" <?php endif;?>  value="0"><?php echo __("No",'full-width-responsive-slider-wp');?></option>
                                                        </select>            
                                                        <div style="clear:both"></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                                <tr id="auto_slide_interval_" style="display:none">
                                                    <td class="label">
                                                        <label for="auto_slide_interval"><?php echo __("Auto Slide Intrval",'full-width-responsive-slider-wp');?> <span class="required">*</span></label>
                                                    </td>
                                                    <td class="value">
                                                        <input id="auto_slide_interval" value="<?php echo intval($settings['auto_slide_interval']); ?>" name="auto_slide_interval"  class="input-text" type="text">            
                                                        <div style="clear:both;padding-top:5px">Interval in milliseconds</div>
                                                        <div style="clear:both;padding-top:5px"></div>
                                                    </td>
                                                </tr>
                                                 
                                                <tr>
                                                    <td class="label">
                                                        
                                                        <?php wp_nonce_field('action_image_add_edit','add_edit_image_nonce'); ?>
                                                        <input type="submit"  name="btnsave" id="btnsave" value="<?php echo __("Save Changes",'full-width-responsive-slider-wp');?>" class="button-primary">    

                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>                                    
                                    </div>

                                </form>
                                <script type="text/javascript">

                                    var $n = jQuery.noConflict();  
                                    
                                    $n("#auto_slide").change(function(){
                                                   
                                       if(parseInt(this.value)==1){
                                           
                                          $n("#auto_slide_interval_").show();
                                       }
                                       else{
                                           
                                           $n("#auto_slide_interval_").hide();
                                       }
                                       
                                    });
                                    
                                    $n("#auto_slide").trigger('change');
                                    
                                    $n(document).ready(function() {

                                            $n("#scrollersettiings").validate({
                                                    rules: {
                                                         
                                                        slider_Speed: {
                                                            required:true,
                                                            number:true,
                                                            maxlength:10
                                                        },
                                                        height: {
                                                            required:true,
                                                            number:true,
                                                            maxlength:4
                                                        },
                                                        height_tablets: {
                                                            required:true,
                                                            number:true,
                                                            maxlength:4
                                                        },
                                                        height_sphone: {
                                                            required:true,
                                                            number:true,
                                                            maxlength:4
                                                        },
                                                        ease:{
                                                            
                                                            required:true
                                                        },
                                                        slider_Drag: {
                                                            required:true
                                                        
                                                        },
                                                        slider_Dots: {
                                                            required:true, 
                                                        },
                                                        slider_Dots_prev: {
                                                            required:true, 
                                                        },
                                                        slider_Arrows:{
                                                            required:true 
                                                        },
                                                        auto_slide:{
                                                            required:true
                                                          
                                                        },
                                                        auto_slide_interval:{
                                                            
                                                            number:true,
                                                             required: {
                                                                    depends: function(element) {
                                                                      
                                                                      if(parseInt($n("#auto_slide").val())==1){
                                                                          
                                                                          return true;
                                                                      }
                                                                      else{
                                                                          
                                                                          return false;
                                                                      }
                                                                      
                                                                    }
                                                              }
                                                        }
                                                        

                                                    },
                                                    errorClass: "image_error",
                                                    errorPlacement: function(error, element) {
                                                        error.appendTo( element.next().next());
                                                    } 


                                            })
                                    });

                                </script> 

                            </div>
                            <div id="postbox-container-1" class="postbox-container" > 

                            <div class="postbox"> 
                                <h3 class="hndle"><span></span>Access All Themes In One Price</h3> 
                                <div class="inside">
                                    <center><a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_0_1_10" target="_blank"><img border="0" src="<?php echo plugins_url( 'images/300x250.gif', __FILE__ );?>" width="250" height="250"></a></center>

                                    <div style="margin:10px 5px">

                                    </div>
                                </div></div>
                            <div class="postbox"> 
                                <h3 class="hndle"><span></span>Ultimate Social Media Plugin. Now share content across social media platforms easily with Ultimate Social Media Plugin</h3> 

                                <div class="inside">
                                     <center><a href="http://www.shareasale.com/r.cfm?b=594704&u=675922&m=25608&urllink=&afftrack=" target="_blank"><img src="<?php echo plugins_url( 'images/300x250.png', __FILE__ );?>" width="250" height="250" border="0"></a></center>
                                    <div style="margin:10px 5px">
                                    </div>
                                </div></div>
                            
                             <div class="postbox"> 
                                <h3 class="hndle"><span></span><?php echo __('Speed Test For Your WP','responsive-filterable-portfolio');?></h3> 
                                <div class="inside">
                                    <center><a href="http://shareasale.com/r.cfm?b=875645&amp;u=675922&amp;m=41388&amp;urllink=&amp;afftrack=" target="_blank">
                                            <img src="<?php echo plugins_url( 'images/300x250-wp-eng.png', __FILE__ );?>" width="250" height="250" border="0">
                                        </a></center>
                                    <div style="margin:10px 5px">
                                    </div>
                                </div></div>

                        </div> 
                       <div class="clear"></div>
                    </div>                                              

                </div>  
            </div>      
        </div>



        <div class="clear"></div></div>  
    <?php
    } 
    

function fwrsw_responsive_full_width_slider_wp_media_management_func() {
    
	$action = 'gridview';
	global $wpdb;
	
	if (isset ( $_GET ['action'] ) and $_GET ['action'] != '') {
		
		$action = trim ( sanitize_text_field($_GET ['action'] ));
                
                if(isset($_GET['order_by'])){
        
                    if(sanitize_sql_orderby($_GET['order_by'])){
                        $order_by=trim($_GET['order_by']); 
                    }
                    else{
                        
                        $order_by=' id ';
                    }
                 }

                 if(isset($_GET['order_pos'])){

                    $order_pos=trim(sanitize_text_field($_GET['order_pos'])); 
                 }

                 $search_term_='';
                 if(isset($_GET['search_term'])){

                    $search_term_='&search_term='.urlencode(sanitize_text_field($_GET['search_term']));
                 }
	}
        
         $search_term_='';
        if(isset($_GET['search_term'])){

           $search_term_='&search_term='.urlencode(sanitize_text_field($_GET['search_term']));
        }
	?>

        <?php
	if (strtolower ( $action ) == strtolower ( 'gridview' )) {
		
		$wpcurrentdir = dirname ( __FILE__ );
		$wpcurrentdir = str_replace ( "\\", "/", $wpcurrentdir );
		
		$uploads = wp_upload_dir ();
		$baseurl = $uploads ['baseurl'];
		$baseurl .= '/full-width-responsive-slider-wp/';
		?> 
            <div class="wrap">
                
                 <table><tr><td><a href="https://twitter.com/FreeAdsPost" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @FreeAdsPost</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
                        <td>
                            <a target="_blank" title="Donate" href="http://i13websolution.com/donate-wordpress_image_thumbnail.php">
                                <img id="help us for free plugin" height="30" width="90" src="<?php echo plugins_url( 'images/paypaldonate.jpg', __FILE__ );?>" border="0" alt="help us for free plugin" title="help us for free plugin">
                                </a>
                            </td>
                        </tr>
                    </table>
                    <div style="clear:both">
                       <span><h3 style="color: blue;"><a target="_blank" href="https://www.i13websolution.com/wordpress-full-width-slider-plugin.html">UPGRADE TO PRO VERSION</a></h3></span>
                   </div> 
		<style type="text/css">
                .pagination {
                        clear: both;
                        padding: 20px 0;
                        position: relative;
                        font-size: 11px;
                        line-height: 13px;
                }

                .pagination span, .pagination a {
                        display: block;
                        float: left;
                        margin: 2px 2px 2px 0;
                        padding: 6px 9px 5px 9px;
                        text-decoration: none;
                        width: auto;
                        color: #fff;
                        background: #555;
                }

                .pagination a:hover {
                        color: #fff;
                        background: #3279BB;
                }

                .pagination .current {
                        padding: 6px 9px 5px 9px;
                        background: #3279BB;
                        color: #fff;
                }
                </style>
		<!--[if !IE]><!-->
		<style type="text/css">
                    @media only screen and (max-width: 800px) {
                            /* Force table to not be like tables anymore */
                            #no-more-tables table, #no-more-tables thead, #no-more-tables tbody,
                                    #no-more-tables th, #no-more-tables td, #no-more-tables tr {
                                    display: block;
                            }

                            /* Hide table headers (but not display: none;, for accessibility) */
                            #no-more-tables thead tr {
                                    position: absolute;
                                    top: -9999px;
                                    left: -9999px;
                            }
                            #no-more-tables tr {
                                    border: 1px solid #ccc;
                            }
                            #no-more-tables td {
                                    /* Behave  like a "row" */
                                    border: none;
                                    border-bottom: 1px solid #eee;
                                    position: relative;
                                    padding-left: 50%;
                                    white-space: normal;
                                    text-align: left;
                            }
                            #no-more-tables td:before {
                                    /* Now like a table header */
                                    position: absolute;
                                    /* Top/left values mimic padding */
                                    top: 6px;
                                    left: 6px;
                                    width: 45%;
                                    padding-right: 10px;
                                    white-space: nowrap;
                                    text-align: left;
                                    font-weight: bold;
                            }

                            /*
                                            Label the data
                                            */
                            #no-more-tables td:before {
                                    content: attr(data-title);
                            }
                    }
                    </style>
		<!--<![endif]-->

                <?php
		$messages = get_option ( 'fwrsw_full_width_slider_msg' );
		$type = '';
		$message = '';
		if (isset ( $messages ['type'] ) and $messages ['type'] != "") {
			
			$type = $messages ['type'];
			$message = $messages ['message'];
		}
		
		if ($type == 'err') {
			echo "<div class='errMsg'>";
			echo $message;
			echo "</div>";
		} else if ($type == 'succ') {
			echo "<div class='succMsg'>";
			echo $message;
			echo "</div>";
		}
		
		update_option ( 'fwrsw_full_width_slider_msg', array () );
		?>

                  <div id="poststuff" >
                    <div id="post-body" class="metabox-holder columns-2">
                        <div style="" id="post-body-content" >
				<div class="icon32 icon32-posts-post" id="icon-edit">
					<br>
				</div>
				<h2>
					<?php echo __('Images','full-width-responsive-slider-wp');?><a class="button add-new-h2" href="admin.php?page=responsive_full_width_slider_wp_media_management&action=addedit"><?php echo __('Add New','full-width-responsive-slider-wp');?></a>
				</h2>
				<br />

				<form method="POST"
					action="admin.php?page=responsive_full_width_slider_wp_media_management&action=deleteselected"
					id="posts-filter" onkeypress="return event.keyCode != 13;">
					<div class="alignleft actions">
						<select name="action_upper" id="action_upper">
							<option selected="selected" value="-1"><?php echo __('Bulk Actions','full-width-responsive-slider-wp');?></option>
							<option value="delete"><?php echo __('delete','full-width-responsive-slider-wp');?></option>
						</select> <input type="submit" value="<?php echo __('Apply','full-width-responsive-slider-wp');?>"
							class="button-secondary action" id="deleteselected"
							name="deleteselected" onclick="return confirmDelete_bulk();">
					</div>
                                      <?php
                                        

                                             $setacrionpage='admin.php?page=responsive_full_width_slider_wp_media_management';

                                             if(isset($_GET['order_by']) and $_GET['order_by']!=""){
                                               $setacrionpage.='&order_by='.sanitize_text_field($_GET['order_by']);   
                                             }

                                             if(isset($_GET['order_pos']) and $_GET['order_pos']!=""){
                                              $setacrionpage.='&order_pos='.sanitize_text_field($_GET['order_pos']);   
                                             }

                                             $seval="";
                                             if(isset($_GET['search_term']) and $_GET['search_term']!=""){
                                              $seval=trim(sanitize_text_field($_GET['search_term']));   
                                             }

                                         ?>
					<br class="clear">
                                                    <?php
							global $wpdb;
                                                        $settings=get_option('fwrsw_full_width_settings'); 
							
							if (! is_array ( $settings )) {
								
								$fwrsw_full_width_slider_msg = array ();
								$fwrsw_full_width_slider_msg ['type'] = 'err';
								$fwrsw_full_width_slider_msg ['message'] = __('No such full width slider found.','full-width-responsive-slider-wp');
								update_option ( 'fwrsw_full_width_slider_msg', $fwrsw_full_width_slider_msg );
								$location = 'admin.php?page=responsive_full_width_slider_wp';
								echo "<script type='text/javascript'> location.href='$location';</script>";
								exit ();
							}
							
                                                        
                                                        $order_by='id';
                                                        $order_pos="asc";

                                                        if(isset($_GET['order_by']) and sanitize_sql_orderby($_GET['order_by'])!==false){

                                                           $order_by=trim($_GET['order_by']); 
                                                        }

                                                        if(isset($_GET['order_pos'])){

                                                           $order_pos=trim(sanitize_text_field($_GET['order_pos'])); 
                                                        }
                                                         $search_term='';
                                                        if(isset($_GET['search_term'])){

                                                           $search_term= sanitize_text_field($_GET['search_term']);
                                                        }

                                                        $query = "SELECT * FROM " . $wpdb->prefix . "e_fw_slider ";
                                                        if($search_term!=''){
                                                           $query.=" where id like '%$search_term%' or title like '%$search_term%' "; 
                                                        }

                                                        $order_by=sanitize_text_field($order_by);
                                                        $order_pos=sanitize_text_field($order_pos);

                                                        $query.=" order by $order_by $order_pos";
                                                        

                                                        $rows = $wpdb->get_results ( $query ,'ARRAY_A' );
                                                        $rowCount = sizeof ( $rows );
                                                                       
							?>
                                            
                                            <div style="padding-top:5px;padding-bottom:5px">
                                                <b><?php echo __( 'Search','full-width-responsive-slider-wp');?> : </b>
                                                  <input type="text" value="<?php echo $seval;?>" id="search_term" name="search_term">&nbsp;
                                                  <input type='button'  value='<?php echo __( 'Search','full-width-responsive-slider-wp');?>' name='searchusrsubmit' class='button-primary' id='searchusrsubmit' onclick="SearchredirectTO();" >&nbsp;
                                                  <input type='button'  value='<?php echo __( 'Reset Search','full-width-responsive-slider-wp');?>' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" >
                                            </div>  
                                            <script type="text/javascript" >
                                               var $n = jQuery.noConflict();   
                                                $n('#search_term').on("keyup", function(e) {
                                                       if (e.which == 13) {
                                                  
                                                           SearchredirectTO();
                                                       }
                                                  });   
                                             function SearchredirectTO(){
                                               var redirectto='<?php echo $setacrionpage; ?>';
                                               var searchval=jQuery('#search_term').val();
                                               redirectto=redirectto+'&search_term='+jQuery.trim(encodeURIComponent(searchval));  
                                               window.location.href=redirectto;
                                             }
                                            function ResetSearch(){

                                                 var redirectto='<?php echo $setacrionpage; ?>';
                                                 window.location.href=redirectto;
                                                 exit;
                                            }
                                            </script>            
                                             <div id="no-more-tables">
						<table cellspacing="0" id="gridTbl" class="table-bordered table-striped table-condensed cf wp-list-table widefat">
							<thead>
								<tr>
									<th class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
									 <?php if($order_by=="id" and $order_pos=="asc"):?>
                                                                               
                                                                            <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Id','full-width-responsive-slider-wp');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                                                            <?php else:?>
                                                                                <?php if($order_by=="id"):?>
                                                                            <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','full-width-responsive-slider-wp');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                                                                <?php else:?>
                                                                                    <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','full-width-responsive-slider-wp');?></a></th>
                                                                                <?php endif;?>    
                                                                            <?php endif;?>  
                                                                        
                                                                        <?php if($order_by=="title" and $order_pos=="asc"):?>

                                                                             <th><a href="<?php echo $setacrionpage;?>&order_by=title&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Title','full-width-responsive-slider-wp');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                                                        <?php else:?>
                                                                            <?php if($order_by=="title"):?>
                                                                        <th><a href="<?php echo $setacrionpage;?>&order_by=title&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Title','full-width-responsive-slider-wp');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                                                            <?php else:?>
                                                                                <th><a href="<?php echo $setacrionpage;?>&order_by=title&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Title','full-width-responsive-slider-wp');?></a></th>
                                                                            <?php endif;?>    
                                                                        <?php endif;?>  
									<th><span></span></th>
									 
								            
                                                                           
									  <?php if($order_by=="createdon" and $order_pos=="asc"):?>
                                                                               
                                                                            <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Published On','full-width-responsive-slider-wp');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                                                            <?php else:?>
                                                                                <?php if($order_by=="createdon"):?>
                                                                            <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Published On','full-width-responsive-slider-wp');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                                                                <?php else:?>
                                                                                    <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Published On','full-width-responsive-slider-wp');?></a></th>
                                                                                <?php endif;?>    
                                                                            <?php endif;?>  
								                         
									
									<th><span><?php echo __('Edit','full-width-responsive-slider-wp');?></span></th>
									<th><span><?php echo __('Delete','full-width-responsive-slider-wp');?></span></th>
								</tr>
							</thead>

							<tbody id="the-list">
                                                            <?php
								if (count ( $rows ) > 0) {
									
									global $wp_rewrite;
									$rows_per_page = 15;
									
									$current = (isset($_GET ['paged'])) ? intval(sanitize_text_field($_GET ['paged'])) : 1;
									$pagination_args = array (
											'base' => @add_query_arg ( 'paged', '%#%' ),
											'format' => '',
											'total' => ceil ( sizeof ( $rows ) / $rows_per_page ),
											'current' => $current,
											'show_all' => false,
											'type' => 'plain' 
									);
									
									$start = ($current - 1) * $rows_per_page;
									$end = $start + $rows_per_page;
									$end = (sizeof ( $rows ) < $end) ? sizeof ( $rows ) : $end;
									$delRecNonce = wp_create_nonce('delete_image');
									for($i = $start; $i < $end; ++ $i) {
										
										$row = $rows [$i];
										
										$id = $row ['id'];
										$editlink = "admin.php?page=responsive_full_width_slider_wp_media_management&action=addedit&id=$id";
										$deletelink = "admin.php?page=responsive_full_width_slider_wp_media_management&action=delete&id=$id&nonce=$delRecNonce";
										
										$outputimgmain = $baseurl . $row ['image_name'].'?rand='.  rand(0, 5000);
										?>
                                                                        <tr valign="top">
                                                                            <td class="alignCenter check-column" data-title="Select Record"><input
                                                                                    type="checkbox" value="<?php echo $row['id'] ?>"
                                                                                    name="thumbnails[]"></td>
                                                                            <td data-title="<?php echo __('Id','full-width-responsive-slider-wp');?>" class="alignCenter"><?php echo intval($row['id']); ?></td>
                                                                            <td data-title="<?php echo __('Title','full-width-responsive-slider-wp');?>" class="alignCenter">
                                                                               <div>
                                                                                            <strong><?php echo esc_html($row['title']); ?></strong>
                                                                                    </div>
                                                                            </td>
                                                                            <td class="alignCenter"><img src="<?php echo esc_url($outputimgmain); ?>" style="width: 100px" height="100px" /></td>
                                                                            
                                                                            <td data-title="<?php echo __('Published On','full-width-responsive-slider-wp');?>" class="alignCenter"><?php echo esc_html($row['createdon']); ?></td>
                                                                            <td data-title="<?php echo __('Edit','full-width-responsive-slider-wp');?>" class="alignCenter"><strong><a href='<?php echo esc_url($editlink); ?>' title="<?php echo __('Edit','full-width-responsive-slider-wp');?>"><?php echo __('Edit','full-width-responsive-slider-wp');?></a></strong></td>
                                                                            <td data-title="<?php echo __('Delete','full-width-responsive-slider-wp');?>" class="alignCenter"><strong><a href='<?php echo esc_url($deletelink); ?>' onclick="return confirmDelete();" title="<?php echo __('Delete','full-width-responsive-slider-wp');?>"><?php echo __('Delete','full-width-responsive-slider-wp');?></a> </strong></td>
                                                                    </tr>
                                                                    <?php
                                                                            }
                                                                    } else {
                                                                            ?>
                                                                    <tr valign="top" class=""
                                                                            id="">
                                                                            <td colspan="9" data-title="<?php echo __('No Records','full-width-responsive-slider-wp');?>" align="center"><strong><?php echo __('No Images','full-width-responsive-slider-wp');?></strong></td>
                                                                    </tr>
                                                                 <?php
								}
								?>      
                                                        </tbody>
						</table>
					</div>
                                         <?php
                                            if (sizeof ( $rows ) > 0) {
                                                    echo "<div class='pagination' style='padding-top:10px'>";
                                                    echo paginate_links ( $pagination_args );
                                                    echo "</div>";
                                            }
                                            ?>
                                         <br />
					<div class="alignleft actions">
						<select name="action" id="action_bottom">
							<option selected="selected" value="-1"><?php echo __('Bulk Actions','full-width-responsive-slider-wp');?></option>
							<option value="delete"><?php echo __('Delete','full-width-responsive-slider-wp');?></option>
						</select> 
                                               <?php wp_nonce_field('action_settings_mass_delete', 'mass_delete_nonce'); ?>
                                                <input type="submit" value="<?php echo __('Apply','full-width-responsive-slider-wp');?>"
							class="button-secondary action" id="deleteselected"
							name="deleteselected" onclick="return confirmDelete_bulk();">
					</div>

				</form>
				<script type="text/JavaScript">

                                        function  confirmDelete_bulk(){
                                                        var topval=document.getElementById("action_bottom").value;
                                                        var bottomVal=document.getElementById("action_upper").value;

                                                        if(topval=='delete' || bottomVal=='delete'){


                                                            var agree=confirm("<?php echo __('Are you sure you want to delete selected image ?','full-width-responsive-slider-wp');?>");
                                                            if (agree)
                                                                return true ;
                                                            else
                                                                return false;
                                                        }
                                                 }

                                        function  confirmDelete(){
                                         var agree=confirm("<?php echo __('Are you sure you want to delete this image ?','full-width-responsive-slider-wp');?>");
                                         if (agree)
                                             return true ;
                                        else
                                            return false;
                                        }
                             </script>
                        </div>
                        <div id="postbox-container-1" class="postbox-container" > 

                            <div class="postbox"> 
                                <h3 class="hndle"><span></span>Access All Themes In One Price</h3> 
                                <div class="inside">
                                    <center><a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_0_1_10" target="_blank"><img border="0" src="<?php echo plugins_url( 'images/300x250.gif', __FILE__ );?>" width="250" height="250"></a></center>

                                    <div style="margin:10px 5px">

                                    </div>
                                </div></div>
                            <div class="postbox"> 
                                <h3 class="hndle"><span></span>Backup, Copy, Clone, Move or Restore your WordPress website with Backup Breeze, Support Dropbox, Amazon S3, Google Drive, FTP</h3> 

                                <div class="inside">
                                    <center><a href="http://www.shareasale.com/r.cfm?b=594678&u=675922&m=25608&urllink=&afftrack=" title="Backup, Copy, Clone, Move or Restore your WordPress website with Backup Breeze" target="_blank"><img src="<?php echo plugins_url( 'images/img__backup.jpg', __FILE__ );?>" width="250" height="250" border="0"></a></center>
                                    <div style="margin:10px 5px">
                                    </div>
                                </div></div>

                        </div>
                        <br class="clear">
			</div>
			<div style="clear: both;"></div>
                    <?php $url = plugin_dir_url(__FILE__); ?>


                </div>
		<h3><?php echo __('To print this full width slider into WordPress Post/Page use below code','full-width-responsive-slider-wp');?></h3>
		<input type="text"
			value='[fwrsw_print_responsive_full_width_slider_wp] '
			style="width: 400px; height: 30px"
			onclick="this.focus(); this.select()" />
		<div class="clear"></div>
		<h3><?php echo __('To print this full width slider into WordPress theme/template PHP files use below code','full-width-responsive-slider-wp');?></h3>
                <?php
		$shortcode = '[fwrsw_print_responsive_full_width_slider_wp]';
		?>
                <input type="text"
			value="&lt;?php echo do_shortcode('<?php echo htmlentities($shortcode, ENT_QUOTES); ?>'); ?&gt;"
			style="width: 400px; height: 30px"
			onclick="this.focus(); this.select()" />
            </div>    
		<div class="clear"></div>
    <?php
                
	} else if (strtolower ( $action ) == strtolower ( 'addedit' )) {
		$url = plugin_dir_url ( __FILE__ );
		$vNonce = wp_create_nonce('vNonce');
		
		if (isset ( $_POST ['btnsave'] )) {
			
                       if (!check_admin_referer('action_image_add_edit', 'add_edit_image_nonce')) {

                            wp_die('Security check fail');
                        }
			$uploads = wp_upload_dir ();
			$baseDir = $uploads ['basedir'];
			$baseDir = str_replace ( "\\", "/", $baseDir );
			$pathToImagesFolder = $baseDir . '/full-width-responsive-slider-wp';
			
                            
                        $HdnMediaSelection = trim ( sanitize_text_field($_POST ['HdnMediaSelection_image'] ));
			$title = trim ( sanitize_text_field($_POST ['title'] )) ;
			$image_description = (trim ( sanitize_textarea_field($_POST ['image_description'] )));
			
               	
			
			$title = str_replace("'","’",$title);
			$title = str_replace('"', '&quot;', $title);
			
			
			
			
			$location = "admin.php?page=responsive_full_width_slider_wp_media_management";
				// edit save
			if (isset ( $_POST ['imageid'] )) {
				
				try {
						
						$imgidEdit=intval(sanitize_text_field($_POST ['imageid']));
						if (trim ( $_POST ['HdnMediaSelection_image'] ) != '') {
                                                        
                                                        $query = "SELECT * FROM " . $wpdb->prefix . "e_fw_slider WHERE id=$imgidEdit";
                                                        $myrow = $wpdb->get_row($query);
                                                        
                                                        
                                                          if (is_object($myrow)) {

                                                            $image_name = $myrow->image_name;
                                                            $imagetoDel = $pathToImagesFolder . '/' . $image_name;
                                                            $pInfo2 = pathinfo($imagetoDel);
                                                            $ext = $pInfo2 ['extension'];
                                                            @unlink($imagetoDel);
                                                            
                                                        }
                                                        
                                                    
							$pInfo = pathinfo ( $HdnMediaSelection );
							$ext = $pInfo ['extension'];
							$imagename = uniqid("img_").".". $ext;
							$imageUploadTo = $pathToImagesFolder . '/' . $imagename;
                                                        
                                                        @copy ( $HdnMediaSelection, $imageUploadTo );
                                                        if(!file_exists($imageUploadTo)){
                                                         fwrsw_save_image_remote($HdnMediaSelection,$imageUploadTo);
                                                        }
                                                        
                                                        
						}
							
						$query = "update " . $wpdb->prefix . "e_fw_slider
						set title='$title',image_name='$imagename',image_description='$image_description',
						HdnMediaSelection='$HdnMediaSelection' where id=$imgidEdit";
							
						//echo $query;die;
						$wpdb->query ( $query );
							
                                                $fwrsw_full_width_slider_msg = array ();
						$fwrsw_full_width_slider_msg ['type'] = 'succ';
						$fwrsw_full_width_slider_msg ['message'] = __('Image updated successfully.','full-width-responsive-slider-wp');
						update_option ( 'fwrsw_full_width_slider_msg', $fwrsw_full_width_slider_msg );
                                                
					} catch ( Exception $e ) {
							
						$fwrsw_full_width_slider_msg = array ();
										$fwrsw_full_width_slider_msg ['type'] = 'err';
										$fwrsw_full_width_slider_msg ['message'] = __('Error while adding image','full-width-responsive-slider-wp');
						update_option ( 'fwrsw_full_width_slider_msg', $fwrsw_full_width_slider_msg );
						}

				
				
			} else {
				
				$createdOn = date ( 'Y-m-d h:i:s' );
                                if (function_exists ( 'date_i18n' )) {

                                        $createdOn = date_i18n ( 'Y-m-d' . ' ' . get_option ( 'time_format' ), false, false );
                                        if (get_option ( 'time_format' ) == 'H:i')
                                                $createdOn = date ( 'Y-m-d H:i:s', strtotime ( $createdOn ) );
                                        else
                                                $createdOn = date ( 'Y-m-d h:i:s', strtotime ( $createdOn ) );
                                }
				
				try {
					
					if (trim ( $_POST ['HdnMediaSelection_image'] ) != '') {
						$pInfo = pathinfo ( $HdnMediaSelection );
						$ext = $pInfo ['extension'];
						$imagename = uniqid("img_").".". $ext;
						$imageUploadTo = $pathToImagesFolder . '/' . $imagename;
						
                                                @copy ( $HdnMediaSelection, $imageUploadTo );
                                                if(!file_exists($imageUploadTo)){
                                                 fwrsw_save_image_remote($HdnMediaSelection,$imageUploadTo);
                                                }
					}
					
					$query = "INSERT INTO " . $wpdb->prefix . "e_fw_slider 
                                		(title,image_name,image_description,HdnMediaSelection,createdon) 
                                                VALUES ('$title','$imagename','$image_description','$HdnMediaSelection',  '$createdOn')";

					
					$wpdb->query ( $query );
					
					$fwrsw_full_width_slider_msg = array ();
					$fwrsw_full_width_slider_msg ['type'] = 'succ';
					$fwrsw_full_width_slider_msg ['message'] = __('New image added successfully.','full-width-responsive-slider-wp');
					update_option ( 'fwrsw_full_width_slider_msg', $fwrsw_full_width_slider_msg );
				} catch ( Exception $e ) {
					
					$fwrsw_full_width_slider_msg = array ();
					$fwrsw_full_width_slider_msg ['type'] = 'err';
					$fwrsw_full_width_slider_msg ['message'] = __('Error while adding image','full-width-responsive-slider-wp');
					update_option ( 'fwrsw_full_width_slider_msg', $fwrsw_full_width_slider_msg );
				}
				
				
			}
                       
                          
                       
                   
                   

                    
                    echo "<script type='text/javascript'> location.href='$location';</script>";
                    exit ();
                   
                   
		} else {
			
			$uploads = wp_upload_dir ();
			$baseurl = $uploads ['baseurl'];
			$baseurl .= '/full-width-responsive-slider-wp/';
			?>
         <div style="float: left; width: 100%;">
	       <div class="wrap">
                
                 <table><tr><td><a href="https://twitter.com/FreeAdsPost" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @FreeAdsPost</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
                        <td>
                            <a target="_blank" title="Donate" href="http://i13websolution.com/donate-wordpress_image_thumbnail.php">
                                <img id="help us for free plugin" height="30" width="90" src="<?php echo plugins_url( 'images/paypaldonate.jpg', __FILE__ );?>" border="0" alt="help us for free plugin" title="help us for free plugin">
                                </a>
                            </td>
                        </tr>
                    </table>
                    <div style="clear:both">
                       <span><h3 style="color: blue;"><a target="_blank" href="https://www.i13websolution.com/wordpress-full-width-slider-plugin.html">UPGRADE TO PRO VERSION</a></h3></span>
                   </div>    
	    	<?php
		    	if (isset ( $_GET ['id'] ) and $_GET ['id'] > 0) {
				
				$id = intval(sanitize_text_field($_GET ['id']));
				$query = "SELECT * FROM " . $wpdb->prefix . "e_fw_slider WHERE id=$id";
				
				$myrow = $wpdb->get_row ( $query );
				
				if (is_object ( $myrow )) {
				
                
					$title =  esc_html($myrow->title);
					$image_name = esc_html($myrow->image_name);
					$image_description = sanitize_textarea_field($myrow->image_description);
					$slider_id = sanitize_text_field($myrow->slider_id);
                                        $HdnMediaSelection_image=esc_html($myrow->HdnMediaSelection);
					
					
					
				}
				?>
	         <h2><?php echo __('Update Image','full-width-responsive-slider-wp');?></h2><?php
			} else {
				
				$title = '';
                                $image_name = '';
                                $image_description = '';
                                $HdnMediaSelection_image='';
                               
                                
				?>
                 <h2><?php echo __('Add Image','full-width-responsive-slider-wp');?></h2>
                   <?php } ?>
                   <br />
					<div id="poststuff">
						<div id="post-body" class="metabox-holder columns-2">
							<div id="post-body-content">
                                                            
                                                                    
                                                                   <form method="post" action="" id="addimage_" name="addimage_" enctype="multipart/form-data" >
                                                                    
                                                                    	 <div class="stuffbox" id="image_info" style="width: 100%;">
										<h3>
											<label for="link_name"><?php echo __('Image Information','full-width-responsive-slider-wp');?></label>
										</h3>
										<div class="inside" id="fileuploaddiv">
                                                                                <?php if ($image_name != "") { ?>
                                                                                        <div>
												<b><?php echo __('Current Image','full-width-responsive-slider-wp');?> : </b>
												<br/>
												<img id="img_disp_img" name="img_disp_img"
													src="<?php echo esc_url($baseurl . $image_name); ?>" />
											</div>
                                                                                <?php }else{ ?>      
                                                                                            <img
												src="<?php echo plugins_url('/images/no-image-selected.png', __FILE__); ?>"
												id="img_disp_img" name="img_disp_img" />
                                                           
                                                                                     <?php } ?>
                                                                                         <img
												src="<?php echo plugins_url('/images/ajax-loader.gif', __FILE__); ?>"
												style="display: none" id="loading_img" name="loading_img" />
											<div style="clear: both"></div>
											<div></div>
											<div class="uploader">
												
												<div style="clear: both; margin-top: 15px;"></div>
                                                                                                        <a
													href="javascript:;" class="niks_media" id="myMediaUploader_image"><b><?php echo __('Click Here to upload Image','full-width-responsive-slider-wp');?></b></a>
                                                                                                    <br /> <br />
												<div>
                                                                                                 <input id="HdnMediaSelection_image" name="HdnMediaSelection_image" type="hidden" value="<?php echo $HdnMediaSelection_image;?>" />
												</div>
												<div style="clear: both"></div>
												<div></div>
												<div style="clear: both"></div>

												<br />
											</div>
                                                                                </div>
                                                                            
                                                                            <script>
                                                                                 //uploading files variable
                                                                                 var $n = jQuery.noConflict();
                                                                                  var custom_file_frame;
                                                                                  $n("#myMediaUploader_image").click(function(event) {
                                                                                    event.preventDefault();
                                                                                            //If the frame already exists, reopen it
                                                                                   if (typeof (custom_file_frame) !== "undefined") {
                                                                                    custom_file_frame.close();
                                                                                    }

                                                                                    //Create WP media frame.
                                                                                    custom_file_frame = wp.media.frames.customHeader = wp.media({
                                                                                    //Title of media manager frame
                                                                                    title: "WP Media Uploader",
                                                                                            library: {
                                                                                            type: 'image'
                                                                                            },
                                                                                            button: {
                                                                                            //Button text
                                                                                            text: "Set Image"
                                                                                            },
                                                                                            //Do not allow multiple files, if you want multiple, set true
                                                                                            multiple: false
                                                                                    });
                                                                                            //callback for selected image
                                                                                            custom_file_frame.on('select', function() {

                                                                                        var attachment = custom_file_frame.state().get('selection').first().toJSON();
                                                                                        var validExtensions = new Array();
                                                                                        validExtensions[1] = 'jpg';
                                                                                        validExtensions[2] = 'jpeg';
                                                                                        validExtensions[3] = 'png';
                                                                                        validExtensions[4] = 'gif';
                                                                                       
                                                                                        var inarr = parseInt($n.inArray(attachment.subtype, validExtensions));
                                                                                          if (inarr > 0 && attachment.type.toLowerCase() == 'image'){

                                                                                            var titleTouse = "";
                                                                                            var imageDescriptionTouse = "";
                                                                                             if ($n.trim(attachment.title) != ''){

                                                                                                 titleTouse = $n.trim(attachment.title);
                                                                                            }
                                                                                            else if ($n.trim(attachment.caption) != ''){

                                                                                                titleTouse = $n.trim(attachment.caption);
                                                                                            }

                                                                                            if ($n.trim(attachment.description) != ''){

                                                                                               imageDescriptionTouse = $n.trim(attachment.description);
                                                                                            }
                                                                                            else if ($n.trim(attachment.caption) != ''){

                                                                                            imageDescriptionTouse = $n.trim(attachment.caption);
                                                                                            }

                                                                                            $n("#addimage_ #title").val(titleTouse);
                                                                                          
                                                                                            if (attachment.id != ''){

                                                                                                      $n("#HdnMediaSelection_image").val(attachment.url);
                                                                                                      $n("#img_disp_img").attr('src', attachment.url);

                                                                                                }

                                                                                            }
                                                                                            else{

                                                                                              alert("<?php echo __('Invalid image selection.','full-width-responsive-slider-wp');?>");
                                                                                            }
                                                                                            //do something with attachment variable, for example attachment.filename
                                                                                            //Object:
                                                                                            //attachment.alt - image alt
                                                                                            //attachment.author - author id
                                                                                            //attachment.caption
                                                                                            //attachment.dateFormatted - date of image uploaded
                                                                                            //attachment.description
                                                                                            //attachment.editLink - edit link of media
                                                                                            //attachment.filename
                                                                                            //attachment.height
                                                                                            //attachment.icon - don't know WTF?))
                                                                                            //attachment.id - id of attachment
                                                                                            //attachment.link - public link of attachment, for example ""http://site.com/?attachment_id=115""
                                                                                            //attachment.menuOrder
                                                                                            //attachment.mime - mime type, for example image/jpeg"
                                                                                            //attachment.name - name of attachment file, for example "my-image"
                                                                                            //attachment.status - usual is "inherit"
                                                                                            //attachment.subtype - "jpeg" if is "jpg"
                                                                                            //attachment.title
                                                                                            //attachment.type - "image"
                                                                                            //attachment.uploadedTo
                                                                                            //attachment.url - http url of image, for example "http://site.com/wp-content/uploads/2012/12/my-image.jpg"
                                                                                            //attachment.width
                                                                                            });
                                                                                            //Open modal
                                                                                            custom_file_frame.open();
                                                                                      });
                                                                                    
                                                                                 </script>
                                                                        </div>
                                                                
                                                                        <div class="stuffbox" id="namediv" style="width: 100%">
										<h3>
											<label for="link_name"><?php echo __('Image Title','full-width-responsive-slider-wp');?> 
											</label>
										</h3>
										<div class="inside">
											<div>
												<input type="text" id="title" size="30" name="title" value="<?php echo $title; ?>">
											</div>
											<div style="clear: both"></div>
											<div></div>
											<div style="clear: both"></div>
										</div>
									</div>
									
                                                                       
                                                                       <div class="stuffbox" id="namediv" style="width:100%">
                                                                            <h3><label for="link_name"><?php echo __('Description','full-width-responsive-slider-wp'); ?></label></h3>
                                                                            <div class="inside">
                                                                                <textarea cols="90" style="width:100%" rows="6" id="image_description" name="image_description"><?php echo $image_description; ?></textarea>
                                                                                <div style="clear:both"></div>
                                                                                <div></div>
                                                                                <div style="clear:both"></div>
                                                                                <p><?php _e('Two three lines summary','full-width-responsive-slider-wp'); ?></p>
                                                                            </div>
                                                                        </div>

									
                                                                        <?php if (isset($_GET['id']) and intval(sanitize_text_field($_GET['id'])) > 0) { ?> 
										 <input type="hidden" name="imageid" id="imageid" value="<?php echo intval(sanitize_text_field($_GET['id'])); ?>">
                                                                         <?php
										}
										?>
                                                                            <?php wp_nonce_field('action_image_add_edit', 'add_edit_image_nonce'); ?>      
                                                                            <input type="submit"
										onclick="" name="btnsave" id="btnsave" value="<?php echo __('Save Changes','full-width-responsive-slider-wp');?>"
										class="button-primary">&nbsp;&nbsp;<input type="button"
										name="cancle" id="cancle" value="<?php echo __('Cancel','full-width-responsive-slider-wp');?>"
										class="button-primary"
										onclick="location.href = 'admin.php?page=responsive_full_width_slider_wp_media_management'">

								</form>
                                                                   
								<script type="text/javascript">

                                                                    var $n = jQuery.noConflict();
                                                                    $n(document).ready(function() {

                                                                     $n.validator.setDefaults({ 
                                                                         ignore: [],
                                                                         // any other default options and/or rules
                                                                     });

                                                                     
                                                                         
                                                                         
                                                                           $n("#addimage_").validate({
                                                                            rules: {
                                                                             HdnMediaSelection_image:{
                                                                               required:true  
                                                                             },
                                                                             title:{
                                                                               maxlength:200  
                                                                             }
                                                                             
                                                                           
                                                                             
                                                                            
                                                                            
                                                                           
                                                                            },
                                                                             errorClass: "image_error",
                                                                             errorPlacement: function(error, element) {
                                                                             error.appendTo(element.parent().next().next());
                                                                             }, messages: {
                                                                                 HdnMediaSelection: "Please select slider image.",

                                                                             }

                                                                         })
                                                                           
                                                                           
                                                                         
                                                                     });
                                                                     
                                                                   
                                                                 </script>

							</div>
                                                        <div id="postbox-container-1" class="postbox-container" > 
					
					          <div class="postbox"> 
					              <h3 class="hndle"><span></span>Access All Themes In One Price</h3> 
					              <div class="inside">
					                  <center><a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_0_1_10" target="_blank"><img border="0" src="<?php echo plugins_url( 'images/300x250.gif', __FILE__ );?>" width="250" height="250"></a></center>
					
					                  <div style="margin:10px 5px">
					
					                  </div>
					              </div></div>
					          <div class="postbox"> 
					              <h3 class="hndle"><span></span>Best WordPress Themes</h3> 
					              
					              <div class="inside">
                                                          <center><a atarget="_blank" href="https://mythemeshop.com/?ref=nik_gandhi007"><img src="<?php echo plugins_url( 'images/300x250.png', __FILE__ );?>" width="250" height="250" border="0"></a></center>
					                  <div style="margin:10px 5px">
					                  </div>
					              </div></div>
					
					      </div> 
						</div>
					</div>
				</div>
			</div>
<?php
		}
	} else if (strtolower ( $action ) == strtolower ( 'delete' )) {
		
             $retrieved_nonce = '';

              if(isset($_GET['nonce']) and $_GET['nonce']!=''){

                  $retrieved_nonce=$_GET['nonce'];

              }
              if (!wp_verify_nonce($retrieved_nonce, 'delete_image' ) ){


                  wp_die('Security check fail'); 
              }

		$uploads = wp_upload_dir ();
		$baseDir = $uploads ['basedir'];
		$baseDir = str_replace ( "\\", "/", $baseDir );
		$pathToImagesFolder = $baseDir . '/full-width-responsive-slider-wp';
		
		
		
		$location = "admin.php?page=responsive_full_width_slider_wp_media_management";
		$deleteId = (int) intval(sanitize_text_field($_GET ['id']));
		
		try {
			
			$query = "SELECT * FROM " . $wpdb->prefix . "e_fw_slider WHERE id=$deleteId ";
			$myrow = $wpdb->get_row ( $query );
			
			if (is_object ( $myrow )) {
				
                             
				$image_name = $myrow->image_name;
				$wpcurrentdir = dirname ( __FILE__ );
				$wpcurrentdir = str_replace ( "\\", "/", $wpcurrentdir );
				$imagetoDel = $pathToImagesFolder . '/' . $image_name;
                                $pInfo = pathinfo ( $myrow->HdnMediaSelection );
                                $pInfo2 = pathinfo ( $imagetoDel );
                                $ext = $pInfo2 ['extension'];
						
				@unlink ( $imagetoDel );
                           	
				$query = "delete from  " . $wpdb->prefix . "e_fw_slider where id=$deleteId  ";
				$wpdb->query ( $query );
				
				$fwrsw_full_width_slider_msg = array ();
				$fwrsw_full_width_slider_msg ['type'] = 'succ';
				$fwrsw_full_width_slider_msg ['message'] =  __('Image deleted successfully.','full-width-responsive-slider-wp');
				update_option ( 'fwrsw_full_width_slider_msg', $fwrsw_full_width_slider_msg );
			}
		} catch ( Exception $e ) {
			
			$fwrsw_full_width_slider_msg = array ();
			$fwrsw_full_width_slider_msg ['type'] = 'err';
			$fwrsw_full_width_slider_msg ['message'] =  __('Error while deleting image.','full-width-responsive-slider-wp');
			update_option ( 'fwrsw_full_width_slider_msg', $fwrsw_full_width_slider_msg );
		}
		
		echo "<script type='text/javascript'> location.href='$location';</script>";
		exit ();
	} else if (strtolower ( $action ) == strtolower ( 'deleteselected' )) {
		
                if(!check_admin_referer('action_settings_mass_delete','mass_delete_nonce')){

                        wp_die('Security check fail'); 
                  }

		
		$location = "admin.php?page=responsive_full_width_slider_wp_media_management";
		
		if (isset ( $_POST ) and isset ( $_POST ['deleteselected'] ) and (sanitize_text_field($_POST ['action']) == 'delete' or sanitize_text_field($_POST ['action_upper']) == 'delete')) {
			
			$uploads = wp_upload_dir ();
			$baseDir = $uploads ['basedir'];
			$baseDir = str_replace ( "\\", "/", $baseDir );
			$pathToImagesFolder = $baseDir . '/full-width-responsive-slider-wp';
			
			if (sizeof ( $_POST ['thumbnails'] ) > 0) {
				
                                
				$deleteto = $_POST ['thumbnails'];
				
				try {
					
					foreach ( $deleteto as $img ) {
						
                                                $img=intval($img);
						$query = "SELECT * FROM " . $wpdb->prefix . "e_fw_slider WHERE id=$img";
						$myrow = $wpdb->get_row ( $query );
                                                
                                             
						
						if (is_object ( $myrow )) {
							
							$image_name = $myrow->image_name ;
							$wpcurrentdir = dirname ( __FILE__ );
							$wpcurrentdir = str_replace ( "\\", "/", $wpcurrentdir );
							$imagetoDel = $pathToImagesFolder . '/' . $image_name;
							
                                                        $pInfo = pathinfo ( $myrow->HdnMediaSelection );
                                                        $pInfo2 = pathinfo ( $imagetoDel );
                                                        $ext = $pInfo2 ['extension'];
							
                                                        @unlink ( $imagetoDel );
                                                    
							
							$query = "delete from  " . $wpdb->prefix . "e_fw_slider where id=$img ";
							$wpdb->query ( $query );
							
							$fwrsw_full_width_slider_msg = array ();
							$fwrsw_full_width_slider_msg ['type'] = 'succ';
							$fwrsw_full_width_slider_msg ['message'] = __('selected images deleted successfully.','full-width-responsive-slider-wp');
							update_option ( 'fwrsw_full_width_slider_msg', $fwrsw_full_width_slider_msg );
						}
					}
				} catch ( Exception $e ) {
					
					$fwrsw_full_width_slider_msg = array ();
					$fwrsw_full_width_slider_msg ['type'] = 'err';
					$fwrsw_full_width_slider_msg ['message'] = __('Error while deleting images.','full-width-responsive-slider-wp');
					update_option ( 'fwrsw_full_width_slider_msg', $fwrsw_full_width_slider_msg );
				}
				
				echo "<script type='text/javascript'> location.href='$location';</script>";
				exit ();
			} else {
				
				echo "<script type='text/javascript'> location.href='$location';</script>";
				exit ();
			}
		} else {
			
			echo "<script type='text/javascript'> location.href='$location';</script>";
			exit ();
		}
	}
}


function fwrsw_responsive_full_width_slider_wp_media_preview_func(){

        global $wpdb;
        $settings=get_option('fwrsw_full_width_settings');    
        $slider_id_print=1;
        $wpcurrentdir=dirname(__FILE__);
        $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
        $url = plugin_dir_url(__FILE__);
        
        $uploads = wp_upload_dir ();
        $baseDir = $uploads ['basedir'];
        $baseDir = str_replace ( "\\", "/", $baseDir );
        $pathToImagesFolder = $baseDir . '/full-width-responsive-slider-wp';

        $baseurl=$uploads['baseurl'];
        $baseurl.='/full-width-responsive-slider-wp/';
        $rand=uniqid('fwrsw_');
        
        ob_start();
    ?><!-- fwrsw_print_responsive_full_width_slider_wp_func --><div class='o-sliderContainer hasShadow pbSliderWrap<?php echo $slider_id_print;?>' id="pbSliderWrap<?php echo $rand;?>" style="margin-top:0;">
        <div class='o-slider' id='pbSlider<?php echo $rand;?>'>
            <?php
                global $wpdb;
                $query="SELECT * FROM ".$wpdb->prefix."e_fw_slider  order by createdon desc";
                $rows=$wpdb->get_results($query,'ARRAY_A');

                  if(count($rows) > 0){
                      
                      foreach($rows as $row){

                                                        
                                        $imagename=$row['image_name'];
                                        $imageUploadTo=$pathToImagesFolder.'/'.$imagename;
                                        $imageUploadTo=str_replace("\\","/",$imageUploadTo);
                                        $pathinfo=pathinfo($imageUploadTo);
                                        $filenamewithoutextension=$pathinfo['filename'];
                                       
                                        
                                        $outputimg = esc_url($baseurl.$imagename);
                                        $title = esc_html($row['title']);
                                        $image_description = esc_html($row['image_description']);

                                           




                                    ?>         
                                     <div class="o-slider--item" data-image="<?php echo $outputimg;?>">
                                        <div class="o-slider-textWrap">
                                          <?php if(trim($title)!=''):?>  
                                             <span class="o-slider-title"><?php echo $title;?></span>
                                             <span class="a-divider"></span>
                                          <?php endif;?>   
                                           
                                          <?php if(trim($image_description)!=''):?>  
                                              <p class="o-slider-paragraph"><?php echo $image_description;?> </p>
                                           <?php endif;?>   
                                        </div>
                                      </div>

                                    <?php } ?>  

                    <?php }?>   
        </div>
    </div>
    <script type="text/javascript">

        $j= jQuery.noConflict();
        $j(document).ready(function() {


                 
               $j('#pbSlider<?php echo $rand;?>').pbTouchSlider({
                    slider_Wrap: '#pbSliderWrap<?php echo $rand;?>',
                    auto_slide:<?php echo (intval($settings['auto_slide']))==1?'true':'false' ?>,
                    auto_slide_interval:<?php echo intval($settings['auto_slide_interval']) ?>,
                    slider_Item_Width : 100,
                    slider_Threshold: 25,
                    slider_Speed:<?php echo intval($settings['slider_Speed']) ?>,
                    slider_Ease:'<?php echo $settings['ease']; ?>',
                    slider_Drag : <?php echo (intval($settings['slider_Drag']))==1?'true':'false' ?>,
                    slider_Arrows: {
                      enabled : <?php echo (intval($settings['slider_Arrows']))==1?'true':'false' ?>
                    },
                    slider_Dots: {
                      class :'.o-slider-pagination',
                      enabled : <?php echo (intval($settings['slider_Dots']))==1?'true':'false' ?>,
                      preview : <?php echo (intval($settings['slider_Dots_prev']))==1?'true':'false' ?>
                    },
                    slider_Breakpoints: {
                        default: {
                            height: <?php echo intval($settings['height']) ?>
                        },
                        tablet: {
                            height: <?php echo intval($settings['height_tablets']) ?>,
                            media: 1024
                        },
                        smartphone: {
                            height: <?php echo intval($settings['height_sphone']) ?>,
                            media: 768
                        }
                    }
                  });  


        });


    </script><!-- end fwrsw_print_responsive_full_width_slider_wp_func --><?php

    $output = ob_get_clean();
        echo $output;
  }
    

    
function fwrsw_print_responsive_full_width_slider_wp_func($atts){

        global $wpdb;
        $settings=get_option('fwrsw_full_width_settings');    
        $slider_id_print=1;
        $wpcurrentdir=dirname(__FILE__);
        $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
        $url = plugin_dir_url(__FILE__);
        
        $uploads = wp_upload_dir ();
        $baseDir = $uploads ['basedir'];
        $baseDir = str_replace ( "\\", "/", $baseDir );
        $pathToImagesFolder = $baseDir . '/full-width-responsive-slider-wp';

        $baseurl=$uploads['baseurl'];
        $baseurl.='/full-width-responsive-slider-wp/';
        $rand=uniqid('fwrsw_');
        
        ob_start();
    ?><!-- fwrsw_print_responsive_full_width_slider_wp_func --><div class='o-sliderContainer hasShadow pbSliderWrap<?php echo $slider_id_print;?>' id="pbSliderWrap<?php echo $rand;?>" style="margin-top:0;">
        <div class='o-slider' id='pbSlider<?php echo $rand;?>'>
            <?php
                global $wpdb;
                $query="SELECT * FROM ".$wpdb->prefix."e_fw_slider  order by createdon desc";
                $rows=$wpdb->get_results($query,'ARRAY_A');

                  if(count($rows) > 0){
                      
                      foreach($rows as $row){

                                                        
                                        $imagename=$row['image_name'];
                                        $imageUploadTo=$pathToImagesFolder.'/'.$imagename;
                                        $imageUploadTo=str_replace("\\","/",$imageUploadTo);
                                        $pathinfo=pathinfo($imageUploadTo);
                                        $filenamewithoutextension=$pathinfo['filename'];
                                     
                                        $outputimg = esc_url($baseurl.$imagename);
                                        $title = esc_html($row['title']);
                                        $image_description = esc_html($row['image_description']);

                                           




                                    ?>         
                                     <div class="o-slider--item" data-image="<?php echo $outputimg;?>">
                                        <div class="o-slider-textWrap">
                                          <?php if(trim($title)!=''):?>  
                                             <span class="o-slider-title"><?php echo $title;?></span>
                                             <span class="a-divider"></span>
                                          <?php endif;?>   
                                          
                                          <?php if(trim($image_description)!=''):?>  
                                              <p class="o-slider-paragraph"><?php echo $image_description;?> </p>
                                           <?php endif;?>   
                                        </div>
                                      </div>

                                    <?php } ?>  

                    <?php }?>   
        </div>
    </div>
    <script type="text/javascript">

        $j= jQuery.noConflict();
        $j(document).ready(function() {


                 
               $j('#pbSlider<?php echo $rand;?>').pbTouchSlider({
                    slider_Wrap: '#pbSliderWrap<?php echo $rand;?>',
                    auto_slide:<?php echo (intval($settings['auto_slide']))==1?'true':'false' ?>,
                    auto_slide_interval:<?php echo intval($settings['auto_slide_interval']) ?>,
                    slider_Item_Width : 100,
                    slider_Threshold: 25,
                    slider_Speed:<?php echo intval($settings['slider_Speed']) ?>,
                    slider_Ease:'<?php echo $settings['ease']; ?>',
                    slider_Drag : <?php echo (intval($settings['slider_Drag']))==1?'true':'false' ?>,
                    slider_Arrows: {
                      enabled : <?php echo (intval($settings['slider_Arrows']))==1?'true':'false' ?>
                    },
                    slider_Dots: {
                      class :'.o-slider-pagination',
                      enabled : <?php echo (intval($settings['slider_Dots']))==1?'true':'false' ?>,
                      preview : <?php echo (intval($settings['slider_Dots_prev']))==1?'true':'false' ?>
                    },
                    slider_Breakpoints: {
                        default: {
                            height: <?php echo intval($settings['height']) ?>
                        },
                        tablet: {
                            height: <?php echo intval($settings['height_tablets']) ?>,
                            media: 1024
                        },
                        smartphone: {
                            height: <?php echo intval($settings['height_sphone']) ?>,
                            media: 768
                        }
                    }
                  });  


        });


    </script><!-- end fwrsw_print_responsive_full_width_slider_wp_func --><?php
        $output = ob_get_clean();
        return $output;
}
    

function fwrsw_e_gallery_get_wp_version() {
	global $wp_version;
	return $wp_version;
}

// also we will add an option function that will check for plugin admin page or not
function fwrsw_responsive_gallery__is_plugin_page() {
	$server_uri = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	
	foreach ( array ('responsive_full_width_slider_wp_media_management','responsive_full_width_slider_wp'
	) as $allowURI ) {
		if (stristr ( $server_uri, $allowURI ))
			return true;
	}
	return false;
}

// add media WP scripts
function fwrsw_responsive_full_width_slider__admin_scripts_init() {
    
	if (fwrsw_responsive_gallery__is_plugin_page ()) {
		// double check for WordPress version and function exists
		if (function_exists ( 'wp_enqueue_media' ) && version_compare ( fwrsw_e_gallery_get_wp_version (), '3.5', '>=' )) {
			// call for new media manager
			wp_enqueue_media ();
		}
		wp_enqueue_style ( 'media' );
                 
                
	}
}

   function fwrsw_remove_extra_p_tags($content){

        if(strpos($content, 'fwrsw_print_responsive_full_width_slider_wp_func')!==false){
        
            
            $pattern = "/<!-- fwrsw_print_responsive_full_width_slider_wp_func -->(.*)<!-- end fwrsw_print_responsive_full_width_slider_wp_func -->/Uis"; 
            $content = preg_replace_callback($pattern, function($matches) {


               $altered = str_replace("<p>","",$matches[1]);
               $altered = str_replace("</p>","",$altered);
              
                $altered=str_replace("&#038;","&",$altered);
                $altered=str_replace("&#8221;",'"',$altered);
              

              return @str_replace($matches[1], $altered, $matches[0]);
            }, $content);

              
            
        }
        
        $content = str_replace("<p><!-- fwrsw_print_responsive_full_width_slider_wp_func -->","<!-- fwrsw_print_responsive_full_width_slider_wp_func -->",$content);
        $content = str_replace("<!-- end fwrsw_print_responsive_full_width_slider_wp_func --></p>","<!-- end fwrsw_print_responsive_full_width_slider_wp_func -->",$content);
        
        
        return $content;
  }

  add_filter('widget_text_content', 'fwrsw_remove_extra_p_tags', 999);
  add_filter('the_content', 'fwrsw_remove_extra_p_tags', 999);
?>
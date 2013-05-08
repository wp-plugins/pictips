<?php
/*
Plugin Name: PicTips
Plugin URI: http://8mediacentral.com/developments/
Description: Provides a shortcode for adding images as ToolTips
Author: 8MediaCentral
Version: 2.0
Author URI: http://8MediaCentral.com
*/

//class definition
if(!class_exists("pictips")){

    class pictips{


        //constructor
        function pictips(){    
                //need fix for wpautop 

            global $shortcode_tags;

  

                add_action('init', array(&$this , 'register_pictips_scripts'));
                add_action('init', array(&$this ,  'pictips_button'));
                add_action('wp_footer', array(&$this , 'print_pictips_scripts'));
                add_action('wp_enqueue_scripts', array(&$this , 'load_pictips_stylesheets'));
                add_action('admin_enqueue_scripts', array(&$this , 'load_pictips_admin_styles'));
                //add_filter('the_content', array(&$this, 'pre_process_shortcode'), 60);
                add_filter('the_content', array(&$this, 'pre_process_shortcode'), 60);


                

                //load the settings file
                @require_once('php/pictips-settings.php');
                //load the any custom styles
                @require_once('php/pictips-custom-styles-main.php');
        }


        /*
        * bad fix for <p> tag insertion
        */
        function pre_process_shortcode($content) {
            global $shortcode_tags;

            // Backup current registered shortcodes and clear them all out
            $orig_shortcode_tags = $shortcode_tags;
            $shortcode_tags = array();


            add_shortcode('pictip', array(&$this , 'pictip'));  

            // Do the shortcode (only the one above is registered)
            $content = do_shortcode($content);

            // Put the original shortcodes back
            $shortcode_tags = $orig_shortcode_tags;

            return $content;
        }



        

        /*
        * shortcode function
        */
        function pictip($atts, $content = null){
            //only add scripts and css if shortcode has been rendered
            global $pictip_called;
            $pictip_called = true;

            $rand_key = uniqid();
            extract(shortcode_atts(array(  
                "src" => 'http://8MediaCentral.com',
                "title" => 'No Title',
                "style" => 'normalstyle'
            ), $atts));  
            $content = str_replace("\r\n", '', $content);
            //<div class ="pictips" id = "pictip6" data-id= "6" data-src = "img/pt3.png" data-style = "normalstyle" title = "pictips test" width="100"
            $rtn =  str_replace("\r\n", '', '<div class ="pictips" id = "pictip' . $rand_key . '" data-id= "' . $rand_key . '" data-src = "' . $src . '" data-style = "' . $style . '" title = "'. trim($title) .'" width="100">' . $content . '</div>');
            
            return $rtn;
        }

        /*
        * register scripts
        */
        function register_pictips_scripts() {
            wp_register_script('jquery', "http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js");
            wp_register_script('pictips-script', plugins_url('js/pictips-script.js', __FILE__), array('jquery', 'jquery-special'), '1.0', true);
            wp_register_script('jquery-special', "http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js");

        }


        /*
        * print scripts
        */
        function print_pictips_scripts() {
            global $pictip_called;
            //only load scripts if shortcode handler has been called
            if ( $pictip_called ){
                wp_print_scripts('jquery');
                wp_print_scripts('jquery-special');
                wp_print_scripts('pictips-script');            
            }    
        }


        /*
        * load stylesheets
        */
        function load_pictips_stylesheets(){
            wp_register_style( 'pictips-styles', plugins_url('css/pictips-styles.css', __FILE__) );
            wp_enqueue_style( 'pictips-styles' );           
        }

        /*
        * add text editor buttons
        */
        function register_pictips_button( $buttons ) {
           array_push( $buttons, "|", "pictips" );
           return $buttons;
        }

        /*
        * add the mce plugin
        */
        function add_pictips_mce_plugin( $plugin_array ) {
           $plugin_array['pictips'] = plugins_url( 'js/pictips-mce-plugin.js' , __FILE__ );
           return $plugin_array;
        }


        /*
        * the pictips button
        */
        function pictips_button() {
           if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
              return;
           }
           if ( get_user_option('rich_editing') == 'true' ) {
              add_filter( 'mce_external_plugins', array(&$this, 'add_pictips_mce_plugin') );
              add_filter( 'mce_buttons', array(&$this, 'register_pictips_button') );
              //add meta data
              add_action ('add_meta_boxes' , array(&$this, 'load_valid_pictips_styles') );
           }
        }


        /*
        * load the admin styles
        */
        function load_pictips_admin_styles() {
            wp_register_style( 'pictips-post-styles', plugins_url('css/pictips-post-styles.css', __FILE__) );
            wp_enqueue_style( 'pictips-post-styles' );
        }

        /*
        * pass the pictips styles as dom elements
        */
        function load_valid_pictips_styles() {
            //apply filters - get all the styles registered
            if(function_exists('apply_filters')){
                $styles = apply_filters ('filter_installed_pictips_styles', array());
                $styles_csv = implode(",", $styles);    
            }
            
            echo "<div id = 'pictips-valid-styles' data-styles = '".$styles_csv."'></div>";
        }






    } //end class definition


}

$pictips_init = new pictips();


?>
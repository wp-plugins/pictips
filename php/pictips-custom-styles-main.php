<?php
/*
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
*  
*/

define("CUSTOM_PICTIPS_STYLES_LOCATION_MAIN", "/css/custom-pictips-styles.css");


//class definition
if(!class_exists("pictips_custom_styles_main")){



    class pictips_custom_styles_main{


        //constructor
        function pictips_custom_styles_main(){    

          if(function_exists('add_filter')){
            add_filter('filter_installed_pictips_styles', array( &$this, 'filter_installed_styles'));
          }    
          if(function_exists('add_action')){
            add_action('wp_enqueue_scripts', array(&$this , 'load_custom_pictips_stylesheets'));
          }

        }

        function filter_installed_styles($data){
          $styles_to_add = $this->get_styles_for_file(CUSTOM_PICTIPS_STYLES_LOCATION_MAIN);
          $data = array_merge($data, $styles_to_add);
          //print_r($data);
          return $data;
        }



        /*
        * get styles for a given file_name
        */
        function get_styles_for_file($file_name){
          try{
            $constant_location = dirname(dirname(__FILE__));
            $contents = file_get_contents($constant_location . $file_name);
            $results = $this->get_styles_for_input($contents);            
          } catch (Exception $e){
            //do nothing
          }      
          return $results;    
        }


        /*
        * get styles for a given input stream
        */

        function get_styles_for_input($line){
          //echo $line;
          //if (preg_match_all("/\.(.*){([^\S]*)/", $line, $matches)) {
          if (preg_match_all("/\.([.^\S]*)/", $line, $matches)) {
              return $matches[1];
            }
        }

        /*
        * load the custom stylesheets
        */
        function load_custom_pictips_stylesheets(){
            wp_register_style( 'custom-pictips-styles', plugins_url('css/custom-pictips-styles.css', dirname(__FILE__)) );
            wp_enqueue_style( 'custom-pictips-styles' );
        }

    } //end class definition


}

$pictips_custom_styles_main_init = new pictips_custom_styles_main();



?>
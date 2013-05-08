<?php
/*
* EightMC - Settings File
* Settings API helper class
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
*  
*/

//replace eightmc with pluginname
//eightmc -> plugin_name
//eightmc_ -> plugin_name_
//eightmc- -> plugin-name-

DEFINE('EIGHTMC_PICTIPS_TEXTDOMAIN', 'pictips');
DEFINE('EIGHTMC_PICTIPS_READDOCUMENTATION_URL', 'http://8mediacentral.com/developments/plugins/pictips/');
DEFINE('EIGHTMC_PICTIPS_SUPPORTFORUMS_URL', 'http://wordpress.org/support/plugin/pictips');
DEFINE('EIGHTMC_PICTIPS_WEBSITE_URL', 'http://8mediacentral.com/developments/plugins/pictips/');
DEFINE('EIGHTMC_PICTIPS_PREMIUM_URL', 'http://8mediacentral.com/developments/plugins/pictips/');
DEFINE('EIGHTMC_PICTIPS_ADDON_URL', 'http://8mediacentral.com/developments/plugins/pictips/');




class eightmc_settings {


     //constructor
    function eightmc_settings() {
        global $plugin_settings;

        //attempt to load premium file (not used for lite)
        @include_once('premium-settings.php');
        
        //initiliaze variables
        $plugin_settings  = $this->plugin_initialize_options_array();  

        //add actions
        if (function_exists('add_action')) {
          add_action('admin_init', array( &$this, 'plugin_admin_init'));
          add_action('admin_menu', array( &$this, 'plugin_admin_add_page'));
        }    

        if(function_exists('add_filter')){
          add_filter('plugin_installed_addons', array( &$this, 'filter_installed_addons'));
        }    
          
    }

     /**
     * enqueue the stylesheets
     */ 
    function plugin_options_enqueue_scripts() {  
      /*
        wp_register_script( 'eightmc-script', plugins_url( '/js/eightmc-script.js' , dirname(__FILE__) ) , array('jquery','media-upload','thickbox') );  
        wp_enqueue_script('jquery');  
        wp_enqueue_script('thickbox');  
        wp_enqueue_style('thickbox');  
        wp_enqueue_script('media-upload');  
        wp_enqueue_script('eightmc-script');  
      */
          
    } 


     /**
     * return the settings
     */ 
    function plugin_initialize_options_array(){
          
          $group = __( "pictipsPlugin", EIGHTMC_PICTIPS_TEXTDOMAIN); // define group
          $page_name = __( "pictips_display", EIGHTMC_PICTIPS_TEXTDOMAIN); // eg media/discussion/reading or custom   
          $title = __( "PicTips", EIGHTMC_PICTIPS_TEXTDOMAIN);  // admin page title 
          $intro_text = __( "PicTips has no admin configurable settings in this version, future versions will contain configuarable settings.", EIGHTMC_PICTIPS_TEXTDOMAIN); // text displayed below title
          $nav_title = __( "PicTips", EIGHTMC_PICTIPS_TEXTDOMAIN); // name of page in context menu
  
           
          /*  SECTIONS ARRAY
             * title: the title of the section
             * description: description of the section
             * fields: a array of field items key => array of options
              FIELD ARRAY OPTIONS
              * label: field label.
              * description: the field description displayed adjacent to the field. 
              * suffix: eg px, em, diplayed in italics adjacent to the field
              * default_value: default value of field when empty
              * dropdown: a drop down function, specify the drop down parameter name 
              * function: optional function to render field
              * onchange: option javascript call on dropdown change (currently only for dropdown items)
              * callback: optional function to validate field
              * field_class: the class to be assigned to the field
          */


          $sections = array(
             'section_name_one' => array(
                'title' => "PicTips Options",
                'description' => __( "PicTips allows you to use customised styles with addon packs - find out how on <a href=".EIGHTMC_PICTIPS_WEBSITE_URL." target = '_blank'>our website</a>.", EIGHTMC_PICTIPS_TEXTDOMAIN),
                'fields' => array( 
                  'field_one_key' => array (
                      'label' => " ",
                      'description' => __( "", EIGHTMC_PICTIPS_TEXTDOMAIN),
                      'default_value' => " ",
                      'dropdown' => "dd_nooption",
                      'function' => 'hidden_field_renderer',
                      'onchange' => '',
                      'callback' => '',
                      'field_class' => "",
                      ),            
                    ),
                
                  ),
              
              );
          



           //Various Dropdown Options
          $dropdown_options = array (
              'dd_text_colour' => array (
                  '#f00' => __( "Red", 'pictips') ,
                  '#0f0' => __( "Green", 'pictips'),
                  '#00f' => __( "Blue", 'pictips'),
                  '#fff' => __( "White", 'pictips'),
                  '#000' => __( "Black", 'pictips'),
                  '#aaa' => __( "Gray", 'pictips'),
                  ),
              'dd_background_colour' => array (
                  'none' => __( "Transparent (None)", 'pictips') ,
                  '#f00' => __( "Red", 'pictips') ,
                  '#0f0' => __( "Green", 'pictips'),
                  '#00f' => __( "Blue", 'pictips'),
                  '#fff' => __( "White", 'pictips'),
                  '#000' => __( "Black", 'pictips'),
                  '#aaa' => __( "Gray", 'pictips'),
                  ),
              'dd_position' => array (
                  'tl' => __( "Top Left", 'pictips'),
                  'tc' => __( "Top Middle", 'pictips'),
                  'tr' => __( "Top Right", 'pictips'),
                  'cl' => __( "Middle Left", 'pictips'),
                  'cc' => __( "Middle", 'pictips'),
                  'cr' => __( "Middle Right", 'pictips'),
                  'bl' => __( "Bottom Left", 'pictips'),
                  'bc' => __( "Bottom Middle", 'pictips'),
                  'br' => __( "Bottom Right", 'pictips'),
                  'rp' => __( "Tile X and Y", 'pictips'),
                  ),
              'dd_boolean' => array (
                  'true' => __( "Enabled", 'pictips'),
                  'false' => __( "Disabled", 'pictips'),
                  ),
              'dd_onoff' => array (
                  'on' => __( "On", 'pictips'),
                  'off' => __( "Off", 'pictips'),
                  ),
              'dd_nooption' => array (
                  'na' => __( "na", 'pictips'),
                  ),
              );


          $vars = array(
                'group' => $group,
                'page_name' => $page_name,
                'title' => $title,
                'intro_text' => $intro_text,
                'nav_title' => $nav_title,
                'sections' => $sections,
                'dropdown_options' => $dropdown_options,
              );


          return $vars;

    }




     
    /**
     * add this page to the Settings tab in the admin panel
     */ 
    function plugin_admin_add_page() {
      global $plugin_settings, $page_name;
      $page_name = add_options_page($plugin_settings['title'], $plugin_settings['nav_title'], 'manage_options', $plugin_settings['page_name'], array( &$this,'plugin_options_page'));

      // Using registered $page handle to hook script load
      add_action('admin_print_scripts-' . $page_name, array( &$this, 'plugin_options_enqueue_scripts'));
    }
     

    /**
     * load the options page
     */ 
    function plugin_options_page() {
      global $plugin_settings;
      printf('</pre>
      <div class = "wrap">
      <div id="icon-options-general" class="icon32"><br /></div>
      <h2>%s</h2>
      <p>%s</p>',$plugin_settings['title'],$plugin_settings['intro_text']);
      echo "<div class = 'eightmc-box-left' >";
      echo "<form action='options.php' method='post'>";

       settings_fields($plugin_settings['group']);
       $this->plugin_do_settings_sections($plugin_settings['page_name']);
       printf('<br/><br/>&nbsp;<input type="submit" name="Submit" value="%s" /></form>
              <pre>
              ',__('Save Changes'));
       echo "</div>  <!-- end eightmc-box-left -->";
       echo "<div class = 'eightmc-box-right'>";
       $this->plugin_side_boxes();
       echo "</div> <!-- end eightmc-box-right -->";
       echo "</div> <!-- end wrap -->";

    }

    /**
    * custom settings section
    */
    function plugin_do_settings_sections( $page ) {
      global $wp_settings_sections, $wp_settings_fields;

      if ( ! isset( $wp_settings_sections ) || !isset( $wp_settings_sections[$page] ) )
        return;

      foreach ( (array) $wp_settings_sections[$page] as $section ) {
        echo "<div class = 'postbox'>";
        if ( $section['title'] ){
          echo "<h3 class ='section-title'>{$section['title']}</h3>\n";
        }
          
        echo "<div class = 'setting-content'>";
        if ( $section['callback'] )
          call_user_func( $section['callback'], $section );

        if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) )
          continue;
        echo '<table class="form-table">';
        do_settings_fields( $page, $section['id'] );
        echo '</table>';
        echo "</div> <!-- end setting-content -->"; //end setting-content
        echo "</div> <!-- end postbox -->"; //end postbox
      }
    }

    
    /**
     * add the settings
     */ 
    function plugin_admin_init(){
      global $plugin_settings;
      foreach ($plugin_settings['sections'] AS $section_key=>$section_value) :
        add_settings_section($section_key, $section_value['title'], array( &$this, 'plugin_section_text'), $plugin_settings['page_name'], $section_value);
        foreach ($section_value['fields'] AS $field_key=>$field_value) :
          $function = (!empty($field_value['dropdown'])) ? array( &$this, 'plugin_setting_dropdown' ) : array( &$this, 'plugin_setting_string' );
          $function = (!empty($field_value['function'])) ? array( &$this,  $field_value['function'] ) : $function;
          $callback = (!empty($field_value['callback'])) ? array( &$this,  $field_value['callback'] ) : NULL;
          add_settings_field($plugin_settings['group'].'_'.$field_key, $field_value['label'], $function, $plugin_settings['page_name'], $section_key,array_merge($field_value,array('name' => $plugin_settings['group'].'_'.$field_key)));
          register_setting($plugin_settings['group'], $plugin_settings['group'].'_'.$field_key,$callback);
          endforeach;
        endforeach;
    }
     
     /**
     * add options to wordpress options API for the Plugin
     * initialize these options
     */
     function pictips_add_options(){      
      global $plugin_settings;

      foreach ($plugin_settings['sections'] AS $section_key=>$section_value) :
        foreach ($section_value['fields'] AS $field_key=>$field_value) :
          add_option($plugin_settings['group'].'_'.$field_key, array("text_string" => $field_value['default_value']));
          endforeach;
        endforeach; 

      //update options for versions etc.
      //update_option('plugin_version', PLUGIN_VERSION);
 
    }

    /**
     * remove options from wordpress options API 
     */
    function pictips_remove_options(){
      global $plugin_settings;

      /* delete options if  */
      /*
      foreach ($plugin_settings["sections"] AS $section_key=>$section_value) :
        foreach ($section_value['fields'] AS $field_key=>$field_value) :
          delete_option($plugin_settings['group'].'_'.$field_key);
          endforeach;
        endforeach; 
      */

      //delete options  
      //delete_option('plugin_version');

    }

    /**
    * print section text
    */
    function plugin_section_text($value = NULL) {
      global $plugin_settings;

      printf("%s",$plugin_settings['sections'][$value['id']]['description']);
    }
     

    /**
    * Renderer for a standard string option
    */  
    function plugin_setting_string($value = NULL) {
      $options = get_option($value['name']);

      //special case for 0 string use asci &#48;
      $default_value = (!empty ($value['default_value'])) ? $value['default_value'] : "&#48;";
      printf('<input id="%s" type="text" name="%1$s[text_string]" class="%2$s" value="%3$s" size="40" /> %4$s %5$s',
        $value['name'],
        (!empty ($value['field_class'])) ? $value['field_class'] : NULL,
        (!empty ($options['text_string'])) ? $options['text_string'] : $default_value,
        (!empty ($value['suffix'])) ? $value['suffix'] : NULL,
        (!empty ($value['description'])) ? sprintf("<em>%s</em>",$value['description']) : NULL);
    }
     

     /**
     * Renderer for a dropdown option
     */
    function plugin_setting_dropdown($value = NULL) {
      global $plugin_settings;
      $options = get_option($value['name']);
      $default_value = (!empty ($value['default_value'])) ? $value['default_value'] : NULL;
      $onchange = (!empty ($value['onchange'])) ? $value['onchange'] : NULL;
      $current_value = ($options['text_string']) ? $options['text_string'] : $default_value;
        $chooseFrom = "";
        $choices = $plugin_settings['dropdown_options'][$value['dropdown']];
      foreach($choices AS $key=>$option) :
        $chooseFrom .= sprintf('<option value="%s" %s>%s</option>',
          $key,($current_value == $key ) ? ' selected="selected"' : NULL,$option);
        endforeach;
        printf('
    <select id="%s" name="%1$s[text_string]" class="%2$s" onchange="%3$s" >%4$s</select>
    %5$s',$value['name'], (!empty ($value['field_class'])) ? $value['field_class'] : NULL, $onchange, $chooseFrom,
      (!empty ($value['description'])) ? sprintf("<em>%s</em>",$value['description']) : NULL);
    }


    /**
     * Renderer for font dropdown option
     */
    function plugin_font_dropdown($value = NULL) {
      global $plugin_settings;
      $options = get_option($value['name']);
      $default_value = (!empty ($value['default_value'])) ? $value['default_value'] : NULL;
      $onchange = (!empty ($value['onchange'])) ? $value['onchange'] : NULL;
      $current_value = ($options['text_string']) ? $options['text_string'] : $default_value;
        $chooseFrom = "";
        $choices = $plugin_settings['font_list'];
      foreach($choices AS $key=>$option) :
        $chooseFrom .= sprintf('<option value="%s" id="%4$s" licence_url="%2$s" %3$s>%4$s</option>',
          $key,  $option['licence_file'], ($current_value == $key ) ? ' selected="selected"' : NULL, $option['font_name']);
        if($current_value == $key ){
          //set current licence file url for selected item
          $licence_file_url = $option['licence_file'];
        }
        endforeach;
        printf('
    <select id="%s" name="%1$s[text_string]" class="%2$s" onchange="%3$s" >%4$s</select>
    %5$s   (<a id="licence_url" href="%6$s" target="_blank">Click to view font licence</a>)',$value['name'], (!empty ($value['field_class'])) ? $value['field_class'] : NULL, $onchange, $chooseFrom,
      (!empty ($value['description'])) ? sprintf("<em>%s</em>",$value['description']) : NULL, $licence_file_url);
    }



      /**
      * Renderer for a section
      */
      function field_renderer_example() {  
          global $plugin_settings;

          //set the preview url to that of the rendering proxy
          $preview_url = "http://url";
             ?>  
          <div id="live_matwatermark_preview" style="min-height: 100px;">  
              <img style="max-width:100%;" src="<?php echo esc_url( $preview_url ); ?>" />  
          </div>
          <?php  
      } 

      /**
      * Renderer for a text area
      */
      function plugin_setting_textarea($value = NULL) {
      $options = get_option($value['name']);

      //flush rewrite_rules if settings-updated == true
      $settings_updated = $_GET['settings-updated'];
      if($settings_updated=="true"){
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
      }

      //special case for 0 string use asci &#48;
      $default_value = (!empty ($value['default_value'])) ? $value['default_value'] : "&#48;";
      printf('<textarea id="%s"  name="%1$s[text_string]" class="%2$s" value="%3$s" rows="6" cols="120"> %3$s </textarea><br/> %4$s %5$s',
        $value['name'],
        (!empty ($value['field_class'])) ? $value['field_class'] : NULL,
        (!empty ($options['text_string'])) ? $options['text_string'] : $default_value,
        (!empty ($value['suffix'])) ? $value['suffix'] : NULL,
        (!empty ($value['description'])) ? sprintf("<em>%s</em>",$value['description']) : NULL);
      }


      /**
      * Renderer for a hidden field
      */
      function hidden_field_renderer($value = NULL) {
      $options = get_option($value['name']);



      //special case for 0 string use asci &#48;
      $default_value = (!empty ($value['default_value'])) ? $value['default_value'] : "&#48;";
      printf('<input type="hidden" id="%s"  name="%1$s[text_string]" class="%2$s" value="%3$s"> %3$s </input><br/> %4$s %5$s',
        $value['name'],
        (!empty ($value['field_class'])) ? $value['field_class'] : NULL,
        (!empty ($options['text_string'])) ? $options['text_string'] : $default_value,
        (!empty ($value['suffix'])) ? $value['suffix'] : NULL,
        (!empty ($value['description'])) ? sprintf("<em>%s</em>",$value['description']) : NULL);
    }





    /*
    * validation for image transparency -example
    */
    function validate_transparency_value($input){
      global $plugin_settings;

      //get current value to reset to
      $current_value = $this->get_option_from_wp('watermark_transparency');
      $input_string = (!empty ($input['text_string'])) ? $input['text_string'] : NULL;
      if(is_null($input_string)){
        //input is 0 - as expected
        return $input;
      }elseif(!is_numeric($input_string)){
        add_settings_error( 'watermark_transparency', 'int_not_valid', 'Transparency must be a value between 0 and 100' );
        return $current_value;
      }  elseif(intval($input_string)<0){
        add_settings_error( 'watermark_transparency', 'int_too_small', 'Transparency cannot be less than 0' );
        return $current_value;
      } elseif(intval($input_string)>100){
        add_settings_error( 'watermark_transparency', 'int_too_large', 'Transparency cannot be greater than 100' );
        return $current_value;
      } else {
        return $input;
      }
      
    }




    /*
    * return the current value that option is specified in the wp options table
    */

    function get_option_value_from_wp($option_name){
      global $plugin_settings;
      
      $real_option_value_array = $this->get_option_from_wp($option_name);
      $real_option_value_text_string  = $real_option_value_array['text_value'];
      return $real_option_value_text_string;
    }

    function get_option_from_wp($option_name){
      global $plugin_settings;

      //the real option name is prefixed with the group name
      $real_option_name = $plugin_settings['group'] . "_" . $option_name;
      $real_option_value_array = get_option($real_option_name);
      return $real_option_value_array;
    }

    /**
     * reset an option to the original value
     */
     function plugin_reset_option($option_name){
      
      global $plugin_settings;
      foreach ($plugin_settings["sections"] AS $section_key=>$section_value) :
        foreach ($section_value['fields'] AS $field_key=>$field_value) :
          if($field_key==$option_name){
            update_option($plugin_settings['group'].'_'.$field_key, array("text_string" => $field_value['default_value']));
          }
          
          endforeach;
        endforeach; 
        
    }


    /**
    * displays the side boxes 
    */
    function plugin_side_boxes(){
        $this->plugin_support_box();
        $this->plugin_info_box();
        $this->plugin_test_box();
    }

    /**
    * display support side box
    */

    function plugin_support_box(){
      ?>
        <div class = 'postbox'>
          <h3 class ='section-title'>Support</h3>          
          <div class = 'setting-content'>
            Need help with the plugin?<br/><br/>
            Try the following:<br/>
            <ul>
              <li><a href = '<?php echo EIGHTMC_PICTIPS_READDOCUMENTATION_URL; ?>' target = '_blank'>Read the documentation</a></li>
              <li><a href = '<?php echo EIGHTMC_PICTIPS_SUPPORTFORUMS_URL; ?>' target = '_blank'>Check the support forums</a></li>
              <li><a href = '<?php echo EIGHTMC_PICTIPS_WEBSITE_URL; ?>' target = '_blank'>Visit the website</a></li>
            </ul>
          </div> 
        </div> 
      <?php
    }

    /**
    * display support side box
    */
    function plugin_info_box(){
      ?>
        <div class = 'postbox'>
          <h3 class ='section-title'>Unleash the power of this plugin</h3>          
          <div class = 'setting-content'>
            Want even more from the plugin?<br/><br/>
            Get an addon pack for:<br/>
            <ul>
              <li><span class = 'green-text'>&#10004; </span> Even more styles for PicTips</li>
              <li><span class = 'green-text'>&#10004; </span> Premium support for PicTips</li>
            </ul>
            <a href = '<?php echo EIGHTMC_PICTIPS_PREMIUM_URL; ?>' target = '_blank'>Find Out More</a>
          </div> 
        </div> 
      <?php
    }

    /**
    * display support side box
    */
    function plugin_test_box(){
      ?>
        <div class = 'postbox'>
          <h3 class ='section-title'>Add-On Packs</h3>          
          <div class = 'setting-content'>
            Add-on packs installed:<br/><br/>
            <ul>
            <?php
              $var = apply_filters ('plugin_installed_addons', array());
              //get an array of the installed add ons
              if(count($var) == 0){
                echo "You currently have no installed add ons";
              } else {
                foreach ($var as $addon_name){
                  echo "<li><span class = 'green-text'>&#10004; </span>" . $addon_name . "</li>";
                } 
              }
              if(function_exists('admin_url'))
                $install_addon_url = admin_url('plugin-install.php?tab=upload');
            ?>
          </ul>
            <a href = '<?php echo EIGHTMC_PICTIPS_ADDON_URL; ?>' target = '_blank'>Find Out More</a><br/>
            <a href = '<?php echo $install_addon_url; ?>'> Install Addons Now</a>
          </div> 
        </div> 
      <?php
    }


    function filter_installed_addons($data){
      //no addons
      return $data;
    }

    


 
//end class
}
 
$plugin_settings_init = new eightmc_settings();
?>
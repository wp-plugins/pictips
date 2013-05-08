/**
*   Copyright 2013 8MediaCentral, All Rights Reserved
*
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/


 //tiny MCE extension

  jQuery(document).ready(function($) {
   tinymce.create('tinymce.plugins.pictips', {
      init : function(ed, url) {
         ed.addButton('pictips', {
            title : 'Add a PicTip',
            image : url+'/../img/pictipsbutton.png',
            onclick : function() {
               

               //selected node
               node = ed.selection.getNode(); 
               if(node!=null){
                  pictip_text_current = tinymce.activeEditor.selection.getContent();
                  pictip_text_html = tinymce.activeEditor.selection.getContent({format : 'html'});
               }

               //get valid styles
               styles = new Array();
               styles_elems = $('#pictips-valid-styles');
               if(styles_elems){
                  styles_data = styles_elems.attr('data-styles');
                  if(styles_data!=""){
                    styles = styles_data.split(',');
                  }
               }

               //if the pictips-options-dialog is already in the DOM remove it
               $("#pictips-options-dialog").remove();
               $(document.body).append('<div id="pictips-options-dialog" title="PicTips Options">' +
                    '<p class="validateTips">All PicTips information is required.</p>' +
                    '<form>' +
                    '<fieldset>' +
                      '<label><span>Text</span>' +
                      '<input type="text" name="pictip_text" id="pictip_text" value ="" placeholder = "Enter the text to link to the display PicTip on" class="text ui-widget-content ui-corner-all" /></label><br/>' +
                      '<label><span>Image URL</span>' +
                      '<input type="text" name="pictip_url" id="pictip_url" value ="" placeholder = "http://" class="text ui-widget-content ui-corner-all" /></label><br/>' +
                      '<label><span>Title</span>' +
                      '<input type="text" name="pictip_title" id="pictip_title" value ="" placeholder = "Enter a title for your PicTip"   class="text ui-widget-content ui-corner-all" /></label><br/>' +
                      '<label><span>Style</span>' +
                      '<select name = "pictip_style_select" id = "pictip_style_select" ></select></label><br/>' +
                    '</fieldset>' +
                    '</form>' +
                    '</div>');

                var bValid = true;
                var pictip_text = $( "#pictip_text" ),
                    pictip_url = $( "#pictip_url" ),
                    pictip_title = $( "#pictip_title" ),
                    allFields = $( [] ).add( pictip_text ).add( pictip_url ).add( pictip_title ),
                    pictip_style = $( "#pictip_style_select" ),
                    tips = $( ".validateTips" );
                


                if(pictip_text_current!=""){
                  pictip_text.val(pictip_text_current);
                }

                if(styles.length>0){
                  console.log(styles);
                  $.each(styles, function(key, text) {
                      $('#pictip_style_select').append( new Option(text,text) );
                  });
                }
        

               $("#pictips-options-dialog").dialog({ 
                  width: 480,
                  height: 'auto',
                  modal: true,
                  dialogClass: 'wp-dialog',
                  zIndex: 300000 ,
                  buttons: {
                    "OK": function() {
                      //todo - validate

                      allFields.removeClass( "ui-state-error" );
                      if(pictip_text.val()!=""){
                            ed.execCommand('mceInsertContent', false, '[pictip src="'+pictip_url.val()+'" title = "'+pictip_title.val()+'" style = "'+pictip_style.val()+'"]'+pictip_text.val()+'[/pictip]');
                      } else {
                            ed.execCommand('mceInsertContent', false, '[pictip src="'+pictip_url.val()+'" title = "'+pictip_title.val()+'" style = "'+pictip_style.val()+'"]'+pictip_text_current+'[/pictip]');
                      }
                      $( this ).dialog( "close" );
                      //sync 
                    },
                    Cancel: function() {
                      ed.execCommand('mceInsertContent', false, pictip_text_html);
                      $( this ).dialog( "close" );
                    }
                  }


               });

            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "PicTips",
            author : '8MediaCentral',
            authorurl : 'http://www.8MediaCentral.com',
            infourl : 'http://8mediacentral.com/developments/',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('pictips', tinymce.plugins.pictips);
});




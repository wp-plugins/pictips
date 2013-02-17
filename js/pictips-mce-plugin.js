/**
*   Copyright 2013 8MediaCentral, All Rights Reserved
*
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/


 //tiny MCE extension

  (function() {
   tinymce.create('tinymce.plugins.pictips', {
      init : function(ed, url) {
         ed.addButton('pictips', {
            title : 'Add a PicTip',
            image : url+'/../img/pictipsbutton.png',
            onclick : function() {
               
               var pictip_text = "";
               var pictip_text_html = "";
               
               //selected node
               node = ed.selection.getNode(); 
               if(node!=null){
                  pictip_text = tinymce.activeEditor.selection.getContent();
                  pictip_text_html = tinymce.activeEditor.selection.getContent({format : 'html'});
               }

               if(pictip_text == null || pictip_text == ""){
                  var pictip_text = prompt("Enter text to add a PicTip to", "My Text");
                  //sync
                  pictip_text_html = pictip_text;
               }
               var pictip_url = "";
               pictip_url = prompt("Enter Image URL for your PicTip", "http://");

               var pictip_title = "";
               if(pictip_text != ""){
                  pictip_title = prompt("Enter a title for your PicTip", pictip_text + " PicTip");
               }
               


               if (pictip_text != null && pictip_text != '' && pictip_url != null && pictip_url != '' && pictip_title != null && pictip_title != ''){
                     ed.execCommand('mceInsertContent', false, '[pictip src="'+pictip_url+'" title = "'+pictip_title+'"]'+pictip_text_html+'[/pictip]');
               } else {
                     alert ("Please enter valid text, url and title for the PicTip")
                     ed.execCommand('mceInsertContent', false, pictip_text_html);
               }
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
})();




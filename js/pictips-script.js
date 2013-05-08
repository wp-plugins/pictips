/**
*   Copyright 2013 8MediaCentral, All Rights Reserved
*
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
jQuery(document).ready(function($) {


function RenderPictips(){
  $( ".pictips" ).each(function( index ) {
     RenderPictip($(this).attr('id'));
	});
}

function RenderPictip(tipid){
  var anchor = $('#'+tipid);
  //remove title attr
  anchor.removeAttr('title');
  var pictip_id =  anchor.attr('data-id');
  var pictip_src = anchor.attr('data-src');
  var style = anchor.attr('data-style')
  var bubble = AppendBubble(pictip_src, pictip_id);
  AddStyle(style);
  var pictip_img_element = $('#pictips-src' + pictip_id);


  //preload the image and swap in when done
  var img = new Image();
  img.src = pictip_src;
  $(img).load(function() {
      pictip_img_element.prop('src', pictip_src);
  });

   
  

  ResizeBubbleElement(bubble, pictip_img_element);

  
  
  anchor.hover ( 
        function(){
          PositionBubble(bubble, anchor, pictip_id, style)
          bubble.show();
        }, 
        function(){
          bubble.hide();
        });
  
}


//add the styles so these can be accessed later
function AddStyle(style){
  var style_html = "<div class = '"+style+"'>&nbsp;</div>";

  $(document.body).append(style_html);
}



function ResizeBubbleElement(element_to_resize, element_to_resize_to){
   //when the image has loaded reziee
   
   element_to_resize_to.load(function(){
    height = this.height;
    width = this.width;

    element_to_resize.height(height);
    element_to_resize.width(width);
  });
 

}

//apend the bubble so we can position it later, return the element
function AppendBubble(pictip_src, id){
 loading_image_src = UrlOfPicTipsDir('js/pictips-script.js') + "img/imageloading.png";

 var bubble_id = id;
 var bubble_html = "";
 bubble_html += "<div class='picTipBubble' id='bubble"+bubble_id+"'>";
 bubble_html += "     <div class='tip' id='bubbletip"+bubble_id+"'></div>";
 bubble_html += "     <div class='tipindent' id='bubbletipindent"+bubble_id+"'></div>";
 bubble_html += "     <img src='"+loading_image_src+"' id='pictips-src"+bubble_id+"' alt = 'alt tag'>";
 bubble_html += "</div>";
 $(document.body).append(bubble_html);



 return $("#bubble"+bubble_id);
}



function UrlOfPicTipsDir ( root_file ) {
 
    var scriptElements = document.getElementsByTagName('script');
    var i, element, file_name;
 
        for( i = 0; element = scriptElements[i]; i++ ) {
 
            file_name = element.src;
 
            if( file_name.indexOf( root_file ) >= 0 ) {
                var pictips_dir = file_name.substring( 0, file_name.indexOf( root_file ) );
 
            }
        }
    return pictips_dir;
}

//position a bubble over an anchor element, hide it and add a hover event to display it
function PositionBubble(bubble, anchor, id, style){
   bubble.show();
   var bubble_position = BestBubblePosition(anchor, bubble);

   if(bubble_position=="none"){
      //set default position
      bubble_position = "bottom";
   }
   
   //todo feed
   var style = $( "." + style );

   var background_color = style.css("background-color");
   var border_color = style.css("border-top-color");
   var border_width = style.css("border-top-width");
   var border_style = style.css("border-top-style");
   var padding = style.css("padding-top");
   //this is correct - margin-top used for border radius until MZ/MS can sort themselves out
   var border_radius = style.css("margin-top");


   //get the border width in pixels
   var patt=/[0-9]*/g;
   var border_width_int=patt.exec(border_width);



   bubble.css("background-color", background_color);
   bubble.css("border-color", border_color);
   bubble.css("border-width", border_width);
   bubble.css("border-style", border_style);
   bubble.css("padding", padding);
   bubble.css("border-radius", border_radius);
   bubble.css("-moz-border-radius", border_radius);
   bubble.css("-webkit-border-radius:", border_radius);
   

   bubble_tip_border = 9+ parseInt(border_width_int);
   $( "#bubbletip" + id ).css("border-width", bubble_tip_border+"px");


  
   if(bubble_position=="bottom"){ 
      $( "#bubbletip" + id ).css("border-color", "transparent transparent " + border_color + " transparent"); 
      $( "#bubbletipindent" + id ).css("border-color", "transparent  transparent " + background_color + " transparent"); 

      $("#bubble" + id).position({
        my: "left top",
        at: "left bottom+10",
        of: "#" + anchor.attr('id'),
        collision: 'none'
      });

      $( "#bubbletip"+id ).position({
        my: "left bottom",
        at: "left+15 top+" + border_width + "",
        of: "#bubble" + id
      });

      $( "#bubbletipindent" + id ).position({
        my: "center bottom",
        at: "center bottom",
        of: "#bubbletip" + id
      });  
    } else if(bubble_position=="top") { 
     $( "#bubbletip" + id ).css("border-color", "" + border_color + " transparent transparent transparent"); 
     $( "#bubbletipindent" + id ).css("border-color", "" + background_color + " transparent transparent transparent"); 

      $( "#bubble" + id).position({
        my: "right bottom",
        at: "center top-10",
        of: "#" + anchor.attr('id'),
        collision: 'none'
      });

      $( "#bubbletip" + id ).position({
        my: "right top",
        at: "right-10 bottom-" + border_width + "",
        of: "#bubble" + id
      });

      $( "#bubbletipindent" + id ).position({
        my: "center top",
        at: "center top",
        of: "#bubbletip" + id
      });  
    } if(bubble_position=="right"){  
        $( "#bubbletip" + id ).css("border-color", "transparent " + border_color + " transparent transparent"); 
        $( "#bubbletipindent" + id ).css("border-color", "transparent " + background_color + " transparent transparent"); 


        $( "#bubble" + id).position({
          my: "left center",
          at: "right+10 center",
          of: "#" + anchor.attr('id'),
          collision: 'none'
        });

        $( "#bubbletip" + id ).position({
          my: "right center",
          at: "left+" + border_width + " center",
          of: "#bubble" + id
        });

        $( "#bubbletipindent" + id ).position({
          my: "right center",
          at: "right center",
          of: "#bubbletip" + id
        });  
      } if(bubble_position=="left"){  
        $( "#bubbletip" + id ).css("border-color", "transparent transparent transparent " + border_color + ""); 
        $( "#bubbletipindent" + id ).css("border-color", "transparent transparent transparent " + background_color + ""); 


        $( "#bubble" + id).position({
          my: "right center",
          at: "left-10 center",
          of: "#" + anchor.attr('id'),
          collision: 'none'
        });

        $( "#bubbletip" + id ).position({
          my: "left center",
          at: "right-" + border_width + " center",
          of: "#bubble" + id
        });

        $( "#bubbletipindent" + id ).position({
          my: "left center",
          at: "left center",
          of: "#bubbletip" + id
        });  
      }

    //then initially hide the bubble
    bubble.hide();


}


//given an element work out where there is the most space - above or below
//@deprecated
function WheresMostSpace(element){
  //approx position in window
  var leftSpace = element.offset().left - $(window).scrollLeft();
  var topSpace = element.offset().top - $(window).scrollTop();
  var rightSpace =  $(window).width() - leftSpace - element.width();
  var bottomSpace = $(window).height() - topSpace - element.height();

  if(bottomSpace<topSpace){
    return "top";
  } else {
    return "bottom";
  }
}

//works out where the bubble will fit best, returns first fitting position  of top, bottom  left and right else none
function BestBubblePosition(element, bubble){
  //approx position in window
  var leftSpace = element.offset().left - $(window).scrollLeft();
  var topSpace = element.offset().top - $(window).scrollTop();
  var rightSpace =  $(window).width() - leftSpace - element.width();
  var bottomSpace = $(window).height() - topSpace - element.height();

  var bubbleWidth = bubble.width();
  var bubbleHeight = bubble.height();

  
  if((topSpace*0.9)>bubbleHeight && leftSpace > (bubbleWidth*0.9)  && rightSpace > (bubbleWidth*0.2)){
      //try top - must fit top and 90% of left and 20% of right
      return "top";
  } else if ( (bottomSpace*0.9) > bubbleHeight && leftSpace > (bubbleWidth*0.2) && rightSpace > (bubbleWidth*0.9)){
    //try bottom - must fit bottom and 20% of left and 90% of right
      return "bottom";
  } else if ( (leftSpace*0.9) >bubbleWidth && topSpace > (bubbleHeight*0.5) && bottomSpace > (bubbleHeight*0.5)){
    //try left - must fit left and 50% of top and 50% of bottom
      return "left";
  }  else if ( (rightSpace*0.9)>bubbleWidth && topSpace > (bubbleHeight*0.5) && bottomSpace > (bubbleHeight*0.5)){
     //try right - must fit right and 50% of top and 50% of bottom
      return "right"
  }    else {
    //else return none
    return "none";
  }

}


   RenderPictips();
});





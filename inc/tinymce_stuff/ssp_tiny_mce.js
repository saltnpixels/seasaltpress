//when changing page template on editor page i can add a centered column so it looks more liek front end
jQuery(document).ready( function($){ 
    $('#page_template').on('change', setwrapper);
    
      
    setTimeout(setwrapper, 300);
    
    function setwrapper(event){
	    if($('#page_template').val() == 'default'){
		 $("#content_ifr").contents().find("#tinymce").addClass('content-column');
		}
		else{
			$("#content_ifr").contents().find("#tinymce").removeClass('content-column');
		}
	}
	
	
/*
	//add my styles from my cutom field?
	var styles = $('#pods-form-ui-pods-meta-extra-styles-and-javascript').text();
	alert(styles);
	setTimeout(function() { 
     $("#content_ifr").contents().find("html>head").append(styles);
    
		}, 300);
	
*/
 });
 
 
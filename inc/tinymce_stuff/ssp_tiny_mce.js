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
	
	
 });
 
 
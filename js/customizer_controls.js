/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
jQuery(document).ready( function($){ 
    
 
var api = wp.customize;
    

			
	 $(wp.customize.control('top_layout').selector).on('change', 'select', function() { 
		 
		 switch($(this).val()){
	
	   case 'nav-right':
	   
	   api.instance('manual_layout').set('[logo] <div id="mobilize"> [primary_nav] </div>');
	   
	   break;
	   
	   
	   
	   case 'nav-left':
	   
	   api.instance('manual_layout').set('<div id="mobilize"> [primary_nav] </div> [logo]');
	   
	   break;
	   
	   
	   
	   case 'nav-centered':
	   
	   api.instance('manual_layout').set('<div class="center-text aligncenter">[logo]</div> \n <div class="center-items" id="mobilize"> [primary_nav] </div>');
	   
	   break;
	   
	   
	   case 'dashboard-nav':
	   
	   api.instance('manual_layout').set('<div class="dashboard-menu" id="mobilize"> [primary_nav] </div> [logo]');
	   
	   break;




    
    
     default:
	   
	   api.instance('manual_layout').set('<div id="mobilize"> [primary_nav] </div>  [logo]');
	   
	   break;
	   
	 
	 }
    

	
	});

});

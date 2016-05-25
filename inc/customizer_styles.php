

<style>
		
	.site-top{ 
	
		background: <?php echo get_theme_mod('site_top_bg', '#969696'); ?>;
		height: <?php echo get_theme_mod('site_top_height', '100'); ?>px;
		}
		
	

	.site-top .site-logo{ max-width: <?php echo get_theme_mod('logo_width', '300px'); ?>; }
	
	#page .dashboard-menu #mobilize, #mobilize{ min-width: <?php echo get_theme_mod('dashboard_width', '200px'); ?>; }
	

	
	.site-top li .site-logo{ width: auto; padding: inherit; }
				
				
  .dashboard-menu #mobilize{
	  padding-top: <?php echo (get_theme_mod('site_top_height', '100') + 20); ?>px;
  }		
  
 

  .dashboard-menu + .archive-header, .dashboard-menu ~ #primary, .dashboard-menu ~ .wrap, .dashboard-menu ~ .entry-header{
	margin-left:  <?php echo get_theme_mod('dashboard_width', '200px'); ?>;
	}



</style>

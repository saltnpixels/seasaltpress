<?php



/*--------------------------------------------------------------
# add shortcode to text widgets
--------------------------------------------------------------*/
add_filter('widget_text', 'do_shortcode');

/*--------------------------------------------------------------
# allowing svg upload for logo in customizer
--------------------------------------------------------------*/

//quickpress add svg as logo allowed in uploader
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');



/*--------------------------------------------------------------
# This allows for a logo or any shortcode in middle of nav items
--------------------------------------------------------------*/
//just add [logo] to menu item description or [seachform]
function shortcode_menu_description( $item_output, $item ) {
    if ( !empty($item->description)) {
         $output = do_shortcode($item->description);  
         if ( $output != $item->description )
               $item_output = $output;   
        }
    return $item_output;
}
add_filter("walker_nav_menu_start_el", "shortcode_menu_description" , 10 , 2);


//to do not using?
function curl_get_contents($url)
{
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $data = curl_exec($ch);

  if(curl_errno($ch)){
    echo 'Curl error: ' . curl_error($ch);
}

  curl_close($ch);
  return $data;
}

/*--------------------------------------------------------------
# Shortcodes
--------------------------------------------------------------*/

/*
 * [searchform]
*/
add_shortcode('searchform', 'search_form_shortcode');
function search_form_shortcode(){
	return get_search_form(false);
}

/*
 * [logo] 
 * outputs logo in link in either h1 or p
*/
function logo(){
	
	//get theme logo or text if none uploaded
	if ( get_theme_mod( 'custom_logo' ) ) :
				
				$logo_id = get_theme_mod( 'custom_logo' );
				//$image = wp_get_attachment_image_src( $logo_id , 'full' );
				$image = get_attached_file($logo_id);
			//$logo = $image[0];
			 $logo = $image;
			//if its a svg logo output contents so we can style with css
			$logo = preg_match('/\.(svg)(?:[\?\#].*)?$/i', $logo, $matches) ? 
				'<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' .
				file_get_contents($logo) .				
				
				'<span>Saltn<strong>Pixels</strong></span></a>'
				 : '
				<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">
				<img src="' . $logo .'" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" /></a>';
			
			
			 else : //no theme mod
			 
			 	$logo = '
			 	<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name') .'
					</a>
					';
 
			endif; //if theme mod 
			
			if(is_front_page()){
				return '<div class="site-logo"><h1>' . $logo . '</h1></div>';
			}
			
			else{
			return '<div class="site-logo"><p>' . $logo . '</p></div>';
			}
			
}
add_shortcode('logo', 'logo');


/*
 * [year]
*/
function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');


/*
 * [primary nav]
 * outputs primary nav. used in customizer
*/
function primary_nav(){
		
/*
		$dashboard_back = '';
		if( get_theme_mod('dashboard_back') == 'yes'){
			$dashboard_back  = '<div class="dashboard-back"></div>';
		}
*/
	return '
	<nav id="site-navigation" class="main-navigation" role="navigation">'	 .
			wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'site-menu', 'echo' => false, 'container' => '' ) ) . '
		</nav><!-- #site-navigation -->';
	
}

add_shortcode('primary_nav', 'primary_nav');



/*
 * [site_description]
*/
function site_description(){
	return '<p class="site-description">' . get_bloginfo( 'description') . '</p>';
}
add_shortcode('site_description', 'site_description');



/*--------------------------------------------------------------
# editor styles to add to mce editor
--------------------------------------------------------------*/

function quickpress_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );

}
add_action( 'admin_init', 'quickpress_add_editor_styles' );




/*--------------------------------------------------------------
# override comment section 
--------------------------------------------------------------*/

//using callback to change just html utput on a comment
//html5 comment
function snp_comments_callback($comment, $args, $depth){
 
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					</div><!-- .comment-author -->
				</footer><!-- .comment-meta -->
  
				
				<div class="comment-content">
					<?php printf( __( '%s <span class="says">says:</span>' ), sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) ) ); ?>
					
					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
					<?php endif; ?>
					
					<?php comment_text(); ?>
					
						<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>'
					) ) );
					?>
				
				</div><!-- .comment-content -->

				
				
					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php
									/* translators: 1: comment date, 2: comment time */
									printf( __( '%1$s <span>at %2$s </span>' ), get_comment_date( '', $comment ), get_comment_time() );
								?>
							</time>
						</a>
						<?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .comment-metadata -->
				
				
			</article><!-- .comment-body -->
			<?php
}




/*--------------------------------------------------------------
# dealing with subscribers on the site
--------------------------------------------------------------*/

## function to check users role

function check_user_role( $role, $user_id = null ) {
 
    if ( is_numeric( $user_id ) )
	$user = get_userdata( $user_id );
    else
        $user = wp_get_current_user();
 
    if ( empty( $user ) )
	return false;
 
    return in_array( $role, (array) $user->roles );
}


##filters to redirect subscribers and not show admin bar
//to do change to current_user_can

// disable admin bar. most ppl dont want subscribers getting anywhere
function disable_admin_bar() { 
	if( check_user_role('subscriber') )
		add_filter('show_admin_bar', '__return_false');	
}
add_action( 'after_setup_theme', 'disable_admin_bar' );
 
 
 /**
 * Redirect back to homepage and not allow access to 
 * WP admin for Subscribers.
 */
function redirect_admin(){
	if( check_user_role('subscriber') ){
		wp_redirect( site_url() );
		exit;		
	}
}
add_action( 'admin_init', 'redirect_admin' );



/*--------------------------------------------------------------
# remove rss from post type
--------------------------------------------------------------*/

function ja_disable_cpt_feed( $query ) {
	if ( $query->is_feed() && ( in_array( 'invoice', (array) $query->get( 'post_type' ) ) || in_array( 'snp_portfolio', (array) $query->get( 'post_type' ) ) ) ) {
		die( 'Feed disabled' );
	}
	
	if( $query->is_main_query() && $query->is_search()){
   	//var_dump($query);
	}
}
add_action( 'pre_get_posts', 'ja_disable_cpt_feed' );





/*--------------------------------------------------------------
# form stuff
--------------------------------------------------------------*/
//https://gist.github.com/mannieschumpert/8334811#file-gistfile3-php
// filter the Gravity Forms button type to be a button not an input
add_filter( 'gform_submit_button', 'form_submit_button', 10, 2 );
function form_submit_button( $button, $form ) {
   
    $button = str_replace( "input", "button", $button );
    $button = str_replace( "/", "", $button );
    $button .= " <span>{$form['button']['text']}<i class='fa fa-paper-plane'></i></span></button>"; //change the text or icon here
    return $button;
}
  


//creates invoice pass word. needed to access an invoice single post.
//safe cause only I admin, fill out this form.
//this form creates a new invoice post and send the info to client.
add_filter( 'gform_field_value_invoice_pass', 'my_custom_population_function' );
function my_custom_population_function( $value ) {
    return wp_generate_password(16, false, false); 
}

//creating invoice id after post is created
add_filter( 'gform_field_value_invoice_id', 'create_invoice_id' );
function create_invoice_id($value){
	
	//get last invoice number
	$invoice_id = 0;
	$invoice = new WP_Query(array(
        'post_status' => 'publish',
        'post_type' => 'invoice',
        'posts_per_page' => '1'
        ));

    if ( $invoice->have_posts() ) : 
     while ( $invoice->have_posts() ) : $invoice->the_post(); 
		$invoice_id = get_post_meta(get_the_ID(), 'invoice_id', true);
	 endwhile; 
	  
	  else:
	  $invoice_id = 1000;
     endif;
 wp_reset_postdata(); 

return $invoice_id + 1;
	
	
}




//updating invoice after paymnet. either set to paid. or at least show payment type and it notifies me
add_action( 'gform_after_submission_3', 'update_invoice', 10, 2 );
add_action( 'gform_after_submission_4', 'update_invoice', 10, 2 );
function update_invoice($entry, $form){
	
	global $post; //getting embedded form post id
	
	$invoice = $post->ID;
	$payment_type = $entry['1'];  //get payment type from form
	
	
	if($payment_type == 'stripe'){
		update_post_meta($invoice, 'paid', 'paid');
		update_post_meta($invoice, 'paid_date', time());
	}
	
	update_post_meta($invoice, 'payment_type', $payment_type);	
	
	
}


/*--------------------------------------------------------------
# styling the list on invoices
--------------------------------------------------------------*/
add_filter('gform_merge_tag_filter', 'snp_add_table_markup', 25, 4);
function snp_add_table_markup($value, $merge_tag, $options, $field){
  // only modify for forms that have the list field named hourly list
	if($field["label"] == "Hourly-List"){
   	
		$newvalue = $value;
		
		$find  = '<thead>';
		$replace = '<thead style="text-align: left;">';
		$newvalue = str_replace($find, $replace, $newvalue);
		
		$find  = '<tr><th>';
		$replace = '<tr><th style="padding-right: 30px;  padding-bottom: 5px;">';
		$newvalue = str_replace($find, $replace, $newvalue);
		
		$find  = '<td>';
		$replace = '<td style="padding-right: 30px; border-bottom: 1px dashed #eee; border-right: 1px dashed #eee;">';
		$newvalue = str_replace($find, $replace, $newvalue);
		
		
			
		
		
		return $newvalue;
		}
		
		return $value;
}
		
		
		
		
		
		


//testing ajax in my demo!
function snp_ajax(){ 
  
  //checking the nonce. will die if it is no good.
   check_ajax_referer('ajax_nonce', 'nonce');


//now we can get the data we passed via $_POST[]. make sure it isnt empty first.
if(! empty( $_POST['data_to_pass'] ) ){
   $my_paragraphs_text = esc_html($_POST['data_to_pass']);
}

//if the textarea equals a certain value we will send back a different string
if($my_paragraphs_text == 'saltnpixels is so cool'){
   $ajax_response = array('data_from_backend' => 'YES IT IS!!');
}
else{
   $ajax_response = array('data_from_backend' => "These are not the droids you're looking for…");
}

 echo json_encode( $ajax_response );  //always echo an array encoded in json 
die();

}

add_action( 'wp_ajax_nopriv_snp_ajax', 'snp_ajax' );
add_action( 'wp_ajax_snp_ajax', 'snp_ajax' );










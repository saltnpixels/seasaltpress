<?php
/**
 * Template part for displaying posts.
 * to show excerpts on the index page follow content-search
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sea_salt_press
 */
 

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		    
			<?php	get_template_part('template-parts/content', 'header'); ?>
				
	
		<div class="entry-content gutters">
	  <?php if(has_post_thumbnail()): ?>
				<div class="featured-image"> <?php the_post_thumbnail();?> </div>
		<?php				
			endif;
			
			?>
	<div class="module flex">
		
		<?php if( get_post_meta(get_the_ID(), 'paid', true) == 'paid'): ?>
		
		<div class="col center-text">
			<h1><?php the_title(); ?></h1>
			<p>Invoice Number: <?php echo get_post_meta(get_the_ID(), 'invoice_id', true); ?></p>
			<h2>This invoice has already been paid for. Thank you.</h2>

		</div>
		
		
		
		
		<?php else: //not paid for  ?>
		
		
		<div class="col">
			<h1><?php the_title(); ?></h1>
			<p>Invoice Number: #<?php echo get_post_meta(get_the_ID(), 'invoice_id', true); ?><br />
			   Client: <?php echo get_post_meta(get_the_ID(), 'clients_name', true); ?><br />
			   Date Issued: <?php echo get_post_meta(get_the_ID(), 'date_issued', true); ?><br /><br />
				<strong class="h2">Total: $<?php echo get_post_meta(get_the_ID(), 'total', true); ?></strong></p>
				
				
				<p>You can pay online, or with a check or cash. <br/>
					If your paying by check or cash, just submit so a record can be made on your payment method.</p>
		</div>
		
		<?php
			
			$total =  get_post_meta(get_the_ID(), 'total', true);
			$email = get_post_meta(get_the_ID(), 'clients_email', true);
			$payment_rate = get_post_meta(get_the_ID(), 'payment_rate', true);
			?>
		
		
		<div class="col">
<?php			if( $payment_rate == 'flat' || $payment_rate == 'hourly' || $payment == ''){ ?>
			<?php echo gravity_form( 3, false, false, false, array('project_name'=> get_the_title(get_the_ID() ), 'total'=>$total), true);  
				}
				else{ 
					//instead get recurring
					echo gravity_form( 4, false, false, false, array('project_name'=> get_the_title(get_the_ID() ), 'total'=>$total), true);
					}
				?>
		</div>
		
		
	</div>
	
	<?php endif; ?>
	
		<?php
					the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'snp' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
	
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'snp' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

	
</article><!-- #post-## -->

<?php
	/*
		This template part is responsible for showing the header of all single posts and pages
		it can be displayed outside the loop if you have a sidebar and want the heading above.
	
	*/
?>

<?php

global $post;
	
switch(get_post_type()):

case 'post': ?>

<header class="entry-header center-text dark-header">
	<div class="wrap flex">
		<div class="col">
			<h1 class="entry-title">
				<?php
						echo get_the_title($post->ID);
						?>
			</h1>	
			<div class="entry-meta">
				<?php snp_posted_on(); ?>
				<div class="cat-info"><?php snp_entry_footer(); ?></div>
			</div><!-- .entry-meta --></div>
		
	</div>
</header><!-- .entry-header -->

<?php break; 



case 'invoice': ?>

<header class="entry-header center-text">
	<div class="wrap flex">
		<div class="col">
			<h1 class="entry-title">
				Inovice #<?php echo get_post_meta(get_the_ID(), 'invoice_id', true); ?>
			</h1>	
		</div>
		
	</div>
</header><!-- .entry-header -->

<?php break; ?>



<?php case 'attachment': ?>

	<header class="entry-header center-text">
		<div class="wrap flex">
			<div class="col">
					<h1><?php echo get_the_title( $post->ID); ?></h1>
			</div>
		</div>
	</header><!-- .entry-header -->

<?php break; ?>


<?php case 'page': ?>

	<header class="page-header center-text">
		<div class="wrap flex">
			<div class="col">
					<h1><?php echo get_the_title( $post->ID); ?></h1>
			</div>
		</div>
	</header><!-- .entry-header -->

<?php break; ?>



<?php default: ?>

<header class="entry-header">
	<div class="wrap flex">
		<div class="col">
		<h1 class="entry-title">
				<?php
						echo get_the_title($post->ID);
						?>
			</h1>
	<p>You have created a new post type. </p>
	<p>You will need to edit content-header.php under template parts and add a new section for headers for this post type.</p>
	</div>
 </div>
</header>

<?php 
	
	break;
	endswitch;
	?>
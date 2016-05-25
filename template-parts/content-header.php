<?php
	/*
		This template part is responsible for showing the header of all single posts and pages
		it is displayed outside the loop.
		It can be in th eloop but then your header wont be above article and sidebar, but inline with it.
		
		on a page without sidebar it can be in the loop but to keep it all looking the same I kept it out
	*/
?>

<?php
	
switch(get_post_type()):

case 'post': ?>

<header class="entry-header center-text">
	<div class="wrap">
		<div class="col-full">
			<h1 class="entry-title">
				<?php
						echo get_the_title();
						?>
			</h1>	
			<div class="entry-meta">
				<?php seasaltpress_posted_on(); ?>
			</div><!-- .entry-meta --></div>
	</div>
		

</header><!-- .entry-header -->

<?php break; ?>



<?php case 'page': ?>

	<header class="entry-header center-text">
		<div class="wrap">
			<div class="col-full">
					<h1><?php echo get_the_title( $post->ID); ?></h1>
			</div>
		</div>
	</header><!-- .entry-header -->

<?php break; ?>



<?php default: ?>

<header>
	<p>You have created a new post type. </p>
	<p>You will need to edit content-header.php under template parts and add a new section for headers for this post type.</p>
</header>

<?php 
	
	break;
	endswitch;
	?>
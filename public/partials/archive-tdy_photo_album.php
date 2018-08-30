<?php 

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$loop = new WP_Query( array( 'post_type' => 'tdy_photo_album',
	        'posts_per_page' => 10,
	        'paged'          => $paged )
	);

	get_header();
?>

	<main role="main" aria-label="Content" class="tdy_photo_album">

		<nav class="pagination">
        <?php tdy_pa_pagination_bar( $loop ); ?>
    </nav>

    <h1> Photo Albums </h1>

		<?php 
			if($loop->have_posts()) : while($loop->have_posts()) : $loop->the_post(); 

			$meta_data = get_post_meta(get_the_ID());

			$date = $meta_data['_tdy_pa_date_meta'][0];
		  $location = $meta_data['_tdy_pa_location_meta'][0];

		  $photosObjectArray = json_decode($meta_data['_tdy_pa_photos_meta'][0]);
		  $photosSrcArray = array_map(function($o) { return $o->src; }, $photosObjectArray);		  

			?>

		<!-- section -->
			<div class="tdy_photo_gallery">
				<div class="tdy_wrapper">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<h3><?php echo $location; ?></h3>
					<h4><?php echo $date; ?></h4>
					<div class="album">
					<?php 
					foreach ($photosSrcArray as $src) {
					?>
						<div class="photo link">
						<img class="mimage" src="<?php echo $src; ?>">
						<a class="fa fa-search" href="<?php echo $src; ?>"></a>
						</div>
					<?php
					}
					?>
					</div>
				</div> 
			</div>	



			<?php endwhile; endif; ?>

			<?php wp_reset_postdata(); ?>

			<nav class="pagination">
        <?php tdy_pa_pagination_bar( $loop ); ?>
    </nav>

	</main>

<?php get_footer(); ?>

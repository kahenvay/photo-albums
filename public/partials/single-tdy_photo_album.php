<?php 
	get_header(); 

	// Retrieves the stored value from the database

	$meta_data = get_post_meta(get_the_ID());

	$date = $meta_data['_tdy_pa_date_meta'][0];
  $location = $meta_data['_tdy_pa_location_meta'][0];

  $photosObjectArray = json_decode($meta_data['_tdy_pa_photos_meta'][0]);
  $photosSrcArray = array_map(function($o) { return $o->src; }, $photosObjectArray);

?>

	<main role="main" aria-label="Content" class="tdy_photo_album">
		<!-- section -->
			<section class="tdy_photo_gallery">
				<div class="tdy_wrapper">
					<h1><?php the_title(); ?></h1>
					<h2><?php echo $location; ?></h2>
					<h3><?php echo $date; ?></h3>
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
		</section>	
	</main>

<?php get_footer(); ?>

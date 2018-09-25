<?php 

function tdy_pa_main_callback( $attributes, $content ) {

	if ($attributes && $attributes['selectedAlbumId']) {
		$meta_data = get_post_meta($attributes['selectedAlbumId']);
		$title = get_the_title( $meta_data );

		if ($meta_data && $meta_data['_tdy_pa_date_meta'][0]) {
			$date = $meta_data['_tdy_pa_date_meta'][0];
		} else {
			$date = '';
		}
		if ($meta_data && $meta_data['_tdy_pa_location_meta'][0]) {
			$location = $meta_data['_tdy_pa_location_meta'][0];
		} else {
			$location = '';
		}

		if ($meta_data && $meta_data['_tdy_pa_photos_meta'][0]) {
			$photosObjectArray = json_decode($meta_data['_tdy_pa_photos_meta'][0]);
		  $photosSrcArray = array_map(function($o) { return $o->src; }, $photosObjectArray);

		  $photos = '';

		  foreach ($photosSrcArray as $src) {
				$photos .= '	<div class="photo link"> '.
				'	<img class="mimage" src=" ' . $src . '"> '.
				'	<a class="fa fa-search" href=" ' . $src . '"></a> '.
				'	</div> ';
			}
		} else {
			$photos = '';
		}
	} else {
		$title = '';
		$location = '';
		$date = '';
		$photos = '';
	}

	

  $return =	' <main role="main" aria-label="Content" class="tdy_photo_album"> '.
							'	<!-- section --> '.
							'	<section class="tdy_photo_album tdy_photo_gallery"> '.
							'<div class="tdy_wrapper">' .
								'	<h1> ' . $title . ' </h1> '.
								'	<h2> ' . $location . '</h2> '.
								'	<h3> ' . $date . '</h3> '.
								'	<div class="album"> '.
									$photos .
							'	</div>  '.
							' </div> '.
							'	</section>	'.
						'</main> ';

	return $return;
}
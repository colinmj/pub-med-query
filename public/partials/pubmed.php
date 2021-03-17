<?php

$args = array(
	'post_type' => 'researcher',
	'posts_per_page' => -1
);

$query = new WP_Query( $args );

?>

<div class="pmq-container">

	<h2>Articles</h2>

	<section class="pub-med-wrapper">

		<div class="pub-med-filter">


			<select name="authors" id="researcher-select">
				<option value="placeholder">Select Author</option>
				<?php while( $query->have_posts() ) : $query->the_post();  ?>
					<option value="<?php echo get_post_field( 'post_name', get_the_ID() );  ?>"><?php the_title() ?></option>
				<?php endwhile; wp_reset_query(); ?>
			</select>



			<a class="filter-articles" href="#">Filter</a>
			

		</div>

		<div id="pub-med-container"></div>

		<a class="" id="load-more" href="#">Load More</a>

	</section>


</div>
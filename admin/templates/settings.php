<div class="wrap">
	<h2>Pub Med Query</h2>

	<form action="options.php" method="post">
		<?php 

		settings_fields( 'pmq_options' );
		do_settings_sections( 'pub_med_query' ); ?>

		<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
	</form>
</div>

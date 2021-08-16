<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://brewers.test
 * @since      1.0.0
 *
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/admin/partials
 */
?>
<?php wp_nonce_field( 'brewer_post_nonce_action', 'brewer_post_nonce' ); ?>
<div class="brewer-info-box">

	<div class="brewer-info-box__field first-field">
		<div class="brewer-info-box__label">
			<label for="brewer_name"><?php echo esc_html( 'Brewery Name' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewer_name" name="brewer_name" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_name', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field -->

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewery_type"><?php echo esc_html( 'Type' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewery_type" name="brewery_type" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewery_type', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field -->   

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewer_street"><?php echo esc_html( 'Street' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewer_street" name="brewer_street" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_street', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field -->

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewer_street"><?php echo esc_html( 'Street' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewer_street" name="brewer_street" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_street', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field -->    

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewer_city"><?php echo esc_html( 'City' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewer_city" name="brewer_city" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_city', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field --> 

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewer_state"><?php echo esc_html( 'State' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewer_state" name="brewer_state" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_state', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field --> 

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewer_postal_code"><?php echo esc_html( 'Postal Code' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewer_postal_code" name="brewer_postal_code" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_postal_code', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field --> 

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewer_country"><?php echo esc_html( 'Country' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewer_country" name="brewer_country" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_country', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field -->                

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewer_longitude"><?php echo esc_html( 'Longitude' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewer_longitude" name="brewer_longitude" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_longitude', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field -->     

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewer_latitude"><?php echo esc_html( 'Latitude' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewer_latitude" name="brewer_latitude" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_latitude', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field -->  

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewer_phone_number"><?php echo esc_html( 'Phone Number' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewer_phone_number" name="brewer_phone_number" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_phone_number', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field -->

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewer_website_url"><?php echo esc_html( 'Website URL' ); ?></label>
		</div>
		<div class="brewer-info-box__input brewer-info-box__input-url">
			<div class="brewer-info-box__input-wrap">
				<span class="dashicons dashicons-admin-site"></span>
				<input type="url" class="brewer-text-fields" id="brewer_website_url" name="brewer_website_url" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_website_url', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field -->   

	<div class="brewer-info-box__field">
		<div class="brewer-info-box__label">
			<label for="brewer_updated_at"><?php echo esc_html( 'Updated at' ); ?></label>
		</div>
		<div class="brewer-info-box__input">
			<div class="brewer-info-box__input-wrap">
				<input type="text" class="brewer-text-fields" id="brewer_updated_at" name="brewer_updated_at" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'brewer_updated_at', true ) ); ?>" />
			</div>
		</div>
	</div>
	<!-- .brewer-info-box__field -->      

</div>

<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://brewers.test
 * @since      1.0.0
 *
 * @package    Brewers_List_Api
 * @subpackage Brewers_List_Api/public/partials
 */
get_header();
?>

<main id="site-content" role="main">

	<?php
	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			include 'loop-template.php';

		}
	}

	?>

</main><!-- #site-content -->

<?php get_footer(); ?>

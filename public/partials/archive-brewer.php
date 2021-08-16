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

$description = get_the_archive_description();
?>

<main id="site-content" role="main">

	<?php if ( have_posts() ) : ?>
		<header class="page-header alignwide">
			<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			<?php if ( $description ) : ?>
				<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
			<?php endif; ?>
		</header><!-- .page-header -->

		<div class="brewer-post-wrap alignwide">

			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<?php include 'loop-template.php'; ?>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>

		<?php require_once 'pagination.php'; ?>
</main><!-- #site-content -->

<?php get_footer(); ?>

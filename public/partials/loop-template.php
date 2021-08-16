<?php

	$brewer_name         = get_post_meta( get_the_ID(), 'brewer_name', true );
	$brewery_type        = get_post_meta( get_the_ID(), 'brewery_type', true );
	$brewer_street       = get_post_meta( get_the_ID(), 'brewer_street', true ) ? get_post_meta( get_the_ID(), 'brewer_street', true ) . ', ' : '';
	$brewer_city         = get_post_meta( get_the_ID(), 'brewer_city', true ) ? get_post_meta( get_the_ID(), 'brewer_city', true ) . ', ' : '';
	$brewer_state        = get_post_meta( get_the_ID(), 'brewer_state', true ) ? get_post_meta( get_the_ID(), 'brewer_state', true ) . ', ' : '';
	$brewer_country      = get_post_meta( get_the_ID(), 'brewer_country', true );
	$brewer_postal_code  = get_post_meta( get_the_ID(), 'brewer_postal_code', true ) ? ' ' . get_post_meta( get_the_ID(), 'brewer_postal_code', true ) : '';
	$brewer_longitude    = get_post_meta( get_the_ID(), 'brewer_longitude', true );
	$brewer_latitude     = get_post_meta( get_the_ID(), 'brewer_latitude', true );
	$brewer_phone_number = get_post_meta( get_the_ID(), 'brewer_phone_number', true );
	$brewer_website_url  = get_post_meta( get_the_ID(), 'brewer_website_url', true );
	$brewer_updated_at   = get_post_meta( get_the_ID(), 'brewer_updated_at', true );

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header alignwide">
			<?php if ( is_single() ) : ?>
				<?php if ( $brewer_name ) : ?>
					<h1 class="entry-title"><?php echo esc_html( $brewer_name ); ?></h1>
				<?php else : ?>
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<?php endif; ?>
			<?php else : ?>
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>"><?php echo esc_html( $brewer_name ); ?></a>
				</h2>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content alignwide">

				<?php if ( $brewery_type ) : ?>
					<div class="b-info-wrap">
						<h5><span class="dashicons dashicons-coffee"></span> <?php echo esc_html( 'Type :' ); ?></h5>
						<span class="b-meta-content b-type"><?php echo esc_html( $brewery_type ); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( $brewer_street || $brewer_city || $brewer_state || $brewer_postal_code || $brewer_country ) : ?>
					<div class="b-info-wrap">
						<h5><span class="dashicons dashicons-location"></span> <?php echo esc_html( 'Address :' ); ?></h5>
						<span class="b-meta-content">
							<a href="https://www.google.com/maps/search/?api=1&query=<?php echo esc_html( $brewer_street . $brewer_city . $brewer_state . $brewer_country ); ?>" target="_blank">
								<?php echo esc_html( $brewer_street . $brewer_city . $brewer_state . $brewer_country . $brewer_postal_code ); ?>
							</a>

						</span>
					</div>
				<?php endif; ?>

				<?php if ( $brewer_phone_number ) : ?>
					<div class="b-info-wrap">
						<h5><span class="dashicons dashicons-phone"></span> <?php echo esc_html( 'Phone :' ); ?></h5>
						<span class="b-meta-content">
							<a href="tel:+<?php echo esc_attr( $brewer_phone_number ); ?>"><?php echo esc_html( $brewer_phone_number ); ?></a>
						</span>
					</div>
				<?php endif; ?>

				<?php if ( $brewer_website_url ) : ?>
					<div class="b-info-wrap">
						<h5><span class="dashicons dashicons-admin-links"></span> <?php echo esc_html( 'Website :' ); ?></h5>
						<span class="b-meta-content">
							<a href="<?php echo esc_url( $brewer_website_url ); ?>" target="_blank"><?php echo esc_html( $brewer_website_url ); ?></a>
						</span>
					</div>
				<?php endif; ?>

				<?php if ( $brewer_updated_at ) : ?>
					<div class="b-info-wrap screen-reader-text">
						<p class="b-updated">
							<em><strong><?php echo esc_html( 'Updated at :' ); ?></strong>
								<?php echo esc_html( $brewer_updated_at ); ?>
							</em>
						</p>
					</div>
				<?php endif; ?>

		</div><!-- .entry-content -->

	</article><!-- #post-<?php the_ID(); ?> -->

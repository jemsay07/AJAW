<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AJAW
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('ajaw-post'); ?> >
	<div class="ajaw-wrap-content">
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h2 class="entry-title">', '</h2>' );
			else :
				the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php
					ajaw_posted_on();
					ajaw_posted_by();
					?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php ajaw_post_thumbnail(); ?>

		<div class="entry-summary">
			<?php
			/*the_content( sprintf(
				wp_kses(
					//translators: %s: Name of current post. Only visible to screen readers 
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ajaw' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );*/
			the_excerpt();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ajaw' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-summary -->

		<footer class="entry-footer">
			<?php ajaw_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

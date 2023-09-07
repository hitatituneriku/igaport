<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package igaport
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php if (have_posts()) : ?>

		<header class="page-header">
			<?php
			the_archive_title('<h1 class="page-title">', '</h1>');
			the_archive_description('<div class="archive-description">', '</div>');
			?>
		</header><!-- .page-header -->

	<?php
		/* Start the Loop */
		while (have_posts()) :
			the_post();

			/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
			get_template_part('template-parts/content', get_post_type());

		endwhile;

		the_posts_navigation();

	else :

		get_template_part('template-parts/content', 'none');

	endif;
	?>

	<ul>
		<?php $args = array(
			'numberposts' => 5,
			'post_type' => 'portfolio',
		);
		$customPosts = get_posts($args);
		if ($customPosts) : foreach ($customPosts as $post) : setup_postdata($post);
		?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; ?>
		<?php else : //記事が無い場合 
		?>
			<p>Sorry, no posts matched your criteria.</p>
		<?php endif;
		wp_reset_postdata(); //クエリのリセット 
		?>
	</ul>

</main><!-- #main -->

<?php
get_sidebar();
get_footer();

<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package igaport
 */

?>
<footer id="colophon" class="site-footer">
	<div class="site-info">
		<span>The source code for this site is <a href="https://github.com/hitatituneriku/igaport" target="_blank">"here"</a></span>
			<br>
		<a href="<?php echo esc_url(__('https://wordpress.org/', 'igaport')); ?>">
			<?php
			/* translators: %s: CMS name, i.e. WordPress. */
			printf(esc_html__('Proudly powered by %s', 'igaport'), 'WordPress');
			?>
		</a>
		<span class="sep"> | </span>
		<?php
		/* translators: 1: Theme name, 2: Theme author. */
		printf(esc_html__('Theme: %1$s by %2$s.', 'igaport'), 'igaport', '<a href="http://underscores.me/">Underscores.me</a>');
		?>
		<div class="copy-right">
			<i class='bx bx-copyright'></i><span>2023 Igarashi</span>
		</div>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
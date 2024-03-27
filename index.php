<?php

/**
 * The main template file
 * @package igaport
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="card">
		<select name="sort-select" id="sort-select">
			<option selected value="level-low-sort">難易度の低い順</option>
			<option value="level-high-sort">難易度の高い順</option>
		</select>
		<ul class="card__wrapper" id="post-list">
			<!-- function.phpでPostListsを記述 -->
		</ul>
	</section>
</main><!-- #main -->
<script>
	
</script>
<?php
get_footer();
?>
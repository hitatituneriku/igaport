<?php

/**
 * igaport functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package igaport
 */

add_action('init', function () {
	register_post_type('portfolio', [
		'label' => 'ポートフォリオ',
		'public' => true,
		'menu_position' => 2,
		'menu_icon' => 'dashicons-welcome-write-blog',
		'supports' => ['thumbnail', 'title', 'editor', 'custom-fields'],
		'show_in_rest' => true,
	]);
});

/** CSS 読み込み */
function my_enqueue_styles()
{
	wp_enqueue_style('reset', get_template_directory_uri() . '/css/html5reset-1.6.1.css', array());
	wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css', array('reset'), filemtime( get_theme_file_path('css/style.css')));
	wp_enqueue_style('boxIcon', 'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css',array('reset'));

	if (is_page('Contact')) {
		wp_enqueue_style('bootstrap', "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css");
	}
}
add_action('wp_enqueue_scripts', 'my_enqueue_styles');

/**
 * Javascript 読み込み
 */
function igaport_scripts()
{
	wp_style_add_data('igaport-style', 'rtl', 'replace');

	wp_enqueue_script('igaport-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
	wp_enqueue_script('my-script', get_template_directory_uri() . '/js/my-script.js', array(), filemtime( get_theme_file_path('js/my-script.js')));

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'igaport_scripts');

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

function igaport_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on igaport, use a find and replace
		* to change 'igaport' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('igaport', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'igaport'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'igaport_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'igaport_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function igaport_content_width()
{
	$GLOBALS['content_width'] = apply_filters('igaport_content_width', 640);
}
add_action('after_setup_theme', 'igaport_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function igaport_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'igaport'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'igaport'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'igaport_widgets_init');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}


add_action('wp_ajax_custom_sort_posts', 'custom_sort_posts');
add_action('wp_ajax_nopriv_custom_sort_posts', 'custom_sort_posts');

function custom_sort_posts()
{
	$selectedOption = $_POST['sort_option'];
	$order = ($selectedOption === 'level-high-sort') ? 'DESC' : 'ASC';

	$args = [
		'post_type' => 'portfolio',
		'posts_per_page' => 5,
		'orderby' => 'meta_value_num',
		'meta_key' => 'level',
		'order' => $order,
	];

	$news_query = new WP_Query($args);

	if ($news_query->have_posts()) :
		while ($news_query->have_posts()) :
			$news_query->the_post();
			$post_link = get_post_meta(get_the_ID(), 'PortfolioLink', true);
			$git_link = get_post_meta(get_the_ID(), 'GitLink', true);
			$meter_class = 'meter__' . get_post_meta(get_the_ID(), 'level', true);
?>
			<!-- ここにhtml -->
			<li class="card__item">
				<a href="<?php echo $post_link; ?>" id="CardLink" target="_blank" rel="noopener noreferrer" class="card__link">
					<figure class="card__img">
						<h2 class="card__title">
							<?php the_title(); ?>
						</h2>
						<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="サムネをここに表示">
					</figure>
					<article class="card__body">
						<div class="card__body_item">
							<span class="text-s">難易度</span>
							<figure class="meter">
								<!-- 難易度をクラスで指定 -->
								<div id="MeterLevel" class="meter__bar <?php echo $meter_class; ?>"></div>
							</figure>
						</div>
						<div class="card__body_item">
							<p>
								<?php the_content(); ?>
							</p>
						</div>
					</article>
				</a>
					<a href="<?php echo $git_link; ?>" id="GitLink" target="_blank" rel="noopener noreferrer" class="card__git_link">
						<img src="<?php echo get_template_directory_uri() . '/img/github-480.png' ?>" alt="GitHubアイコンをここに表示">
					</a>
			</li>
<?php
		endwhile;
	else :
		echo '<p>投稿はまだありません。</p>';
	endif;

	wp_reset_postdata();
	$output = ob_get_clean();
	echo $output;
	wp_die();
}

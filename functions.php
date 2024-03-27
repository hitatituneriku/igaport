<?php

/**
 * igaportの機能と定義
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
	]);
});

/** CSSを読み込み */
function my_enqueue_styles()
{
	wp_enqueue_style('reset', get_template_directory_uri() . '/css/html5reset-1.6.1.css', array());
	wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css', array('reset'), filemtime(get_theme_file_path('css/style.css')));
	wp_enqueue_style('boxIcon', 'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css', array('reset'));

	if (is_page('Contact')) {
		wp_enqueue_style('bootstrap', "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css");
	}
}
add_action('wp_enqueue_scripts', 'my_enqueue_styles');

/**
 * JavaScriptを読み込み
 */
function igaport_scripts()
{
	wp_style_add_data('igaport-style', 'rtl', 'replace');

	wp_enqueue_script('igaport-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
	wp_enqueue_script('my-script', get_template_directory_uri() . '/js/my-script.js', array(), filemtime(get_theme_file_path('js/my-script.js')));

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'igaport_scripts');

if (!defined('_S_VERSION')) {
	// テーマのバージョン番号をリリースごとに置き換えます。
	define('_S_VERSION', '1.0.0');
}

/**
 * テーマのデフォルトを設定し、さまざまなWordPress機能のサポートを登録します。
 *
 * この関数はafter_setup_themeフックにフックされており、initフックよりも前に実行されます。
 * initフックはサムネイルのサポートなど一部の機能には遅すぎるためです。
 */
function igaport_setup()
{
	load_theme_textdomain('igaport', get_template_directory() . '/languages');

	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	register_nav_menus(
		array(
			'normal' => esc_html__('プライマリ', 'igaport'),
			'hamburger' => 'ハンバーガーメニュー',
		)
	);

	add_theme_support('html5');
	add_theme_support('custom-background', array('default-color' => 'ffffff', 'default-image' => ''));
	add_theme_support('customize-selective-refresh-widgets');

	add_theme_support('custom-logo', array('height' => 250, 'width' => 250, 'flex-width' => true, 'flex-height' => true));
}
add_action('after_setup_theme', 'igaport_setup');


function igaport_content_width()
{
	$GLOBALS['content_width'] = apply_filters('igaport_content_width', 640);
}
add_action('after_setup_theme', 'igaport_content_width', 0);

function igaport_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('サイドバー', 'igaport'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('ウィジェットをここに追加してください。', 'igaport'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'igaport_widgets_init');

require get_template_directory() . '/inc/custom-header.php';

require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/template-functions.php';

require get_template_directory() . '/inc/customizer.php';

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
			<!-- ここにHTMLを挿入 -->
			<li class="card__item">
				<a href="<?php echo $post_link; ?>" id="CardLink" target="_blank" rel="noopener noreferrer" class="card__link">
					<figure class="card__img">
						<h2 class="card__title">
							<?php the_title(); ?>
						</h2>
						<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="サムネイルをここに表示">
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

// javascriptへ変数をわたす
function enqueue_my_script()
{
	// Ajax URL
	wp_localize_script('my-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
	wp_enqueue_script('my-script', get_template_directory_uri() . '/js/my-script.js', array('jquery'), '1.0', true);
	//index.phpのあるファイルパスを取得
	$data_to_js = array(
		'template_directory_uri' => get_template_directory_uri()
	);

	// JavaScriptファイルにデータをローカライズする
	wp_localize_script('my-script', 'my_script_vars', $data_to_js);
}
add_action('wp_enqueue_scripts', 'enqueue_my_script');

function menu_ajax_action() {
					// 登録したメニューの位置を取得
					$registered_menu_locations = get_registered_nav_menus();

					// すべてのメニュー位置に対して処理を実行
					foreach ($registered_menu_locations as $location => $description) {
						// メニューが選択された場合の処理
						if (has_nav_menu($location)) {
							wp_nav_menu(array(
								'theme_location' => $location,
								'container' => 'nav',
								'container_class' => 'menu-' . $location . '-container', // メニュー位置に基づいたクラスを指定
								'menu_class' => 'menu-' . $location . '-list', // メニュー位置に基づいたクラスを指定
							));
						}
					}
}
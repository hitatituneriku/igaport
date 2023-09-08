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
	var selectElement = document.getElementById('sort-select');
	var postListElement = document.getElementById('post-list');

	//レスポンシブ用にウィンドウの幅を取得
	var windowWidth = window.innerWidth;

	function updatePostList() {
		var selectedOption = selectElement.value;

		// Ajaxリクエストを送信して新しいデータを取得
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				// 取得したデータをpostListElementに設定
				postListElement.innerHTML = xhr.responseText;

				if (windowWidth <= 600) {
                var elementCardGitIcons = document.querySelectorAll('#GitLink');
                elementCardGitIcons.forEach(function(elementCardGitIcon) {
                    elementCardGitIcon.style.display = 'none';
                });
			}};
		};

	// Ajaxリクエストを設定して送信
	xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send('action=custom_sort_posts&sort_option=' + selectedOption);
	};

	//プルダウンボタンクリック時にPostを更新
	selectElement.addEventListener('change', function() {
		updatePostList();
	});

	// 初回読み込み時にも実行
	updatePostList();
</script>
<?php
get_footer();
?>
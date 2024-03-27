var selectElement = document.getElementById('sort-select');
var postListElement = document.getElementById('post-list');

//レスポンシブ用にウィンドウの幅を取得
var windowWidth = window.innerWidth;

function updatePostList() {
    var selectedOption = selectElement.value;

    // Ajaxリクエストを送信して新しいデータを取得
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // 取得したデータをpostListElementに設定
            postListElement.innerHTML = xhr.responseText;

            if (windowWidth <= 600) {
                var elementCardGitIcons = document.querySelectorAll('#GitLink');
                elementCardGitIcons.forEach(function (elementCardGitIcon) {
                    elementCardGitIcon.style.display = 'none';
                });
            }
        };
    };

    // Ajaxリクエストを設定して送信
    xhr.open('POST', ajax_object.ajax_url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('action=custom_sort_posts&sort_option=' + selectedOption);
};

//プルダウンボタンクリック時にPostを更新
selectElement.addEventListener('change', function () {
    updatePostList();
});

// 初回読み込み時にも実行
updatePostList();


// ボタン要素を取得
var button = document.getElementById("imageButton");

// ボタンがクリックされたときの処理
button.addEventListener("click", function () {
    // 画像要素を取得
    var image = button.querySelector("img");

    //imageのパスを取得
    var templateDirectoryURI = my_script_vars.template_directory_uri;
    var originImageUrl = templateDirectoryURI + '/img/origin_hamburger.png';
    var blueImageUrl = templateDirectoryURI + '/img/blue_hamburger.png';

    // 画像のsrc属性を切り替える
    if (image.src.endsWith("blue_hamburger.png")) {
        image.src = originImageUrl;
    } else {
        image.src = blueImageUrl;
    }

    // Ajaxリクエストを送信
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // レスポンスを受け取り、menuContent要素に表示
            document.getElementById("menuContent").innerHTML = xhr.responseText;
        }
    };

    // Ajaxリクエストを設定して送信
    xhr.open('POST', ajax_object.ajax_url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('menu_ajax_action'); 
});

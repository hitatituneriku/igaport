/**
 * ファイル navigation.js.
 *
 * 小さな画面用のナビゲーションメニューの切り替えと、
 * ドロップダウンメニューの TAB キーによるナビゲーションサポートを処理します。
 */
( function() {
	const siteNavigation = document.getElementById( 'site-navigation' );

	// ナビゲーションが存在しない場合は早期にリターンします。
	if ( ! siteNavigation ) {
		return;
	}

	const button = siteNavigation.getElementsByTagName( 'button' )[ 0 ];

	// ボタンが存在しない場合は早期にリターンします。
	if ( 'undefined' === typeof button ) {
		return;
	}

	const menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];

	// メニューが存在しない場合は、メニュートグルボタンを非表示にして早期にリターンします。
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( ! menu.classList.contains( 'nav-menu' ) ) {
		menu.classList.add( 'nav-menu' );
	}

	// ボタンがクリックされるたびに、.toggled クラスと aria-expanded 値を切り替えます。
	button.addEventListener( 'click', function() {
		siteNavigation.classList.toggle( 'toggled' );

		if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
			button.setAttribute( 'aria-expanded', 'false' );
		} else {
			button.setAttribute( 'aria-expanded', 'true' );
		}
	} );

	// ユーザーがナビゲーションの外部をクリックした場合、.toggled クラスを削除し、aria-expanded を false に設定します。
	document.addEventListener( 'click', function( event ) {
		const isClickInside = siteNavigation.contains( event.target );

		if ( ! isClickInside ) {
			siteNavigation.classList.remove( 'toggled' );
			button.setAttribute( 'aria-expanded', 'false' );
		}
	} );

	// メニュー内のすべてのリンク要素を取得します。
	const links = menu.getElementsByTagName( 'a' );

	// 子要素を持つリンク要素を含むすべてのリンク要素を取得します。
	const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

	// メニューリンクがフォーカスまたはフォーカスが外れるたびにフォーカスを切り替えます。
	for ( const link of links ) {
		link.addEventListener( 'focus', toggleFocus, true );
		link.addEventListener( 'blur', toggleFocus, true );
	}

	// 子要素を持つリンク要素がタッチイベントを受け取るたびにフォーカスを切り替えます。
	for ( const link of linksWithChildren ) {
		link.addEventListener( 'touchstart', toggleFocus, false );
	}

	/**
	 * 要素に .focus クラスを設定または削除します。
	 */
	function toggleFocus() {
		if ( event.type === 'focus' || event.type === 'blur' ) {
			let self = this;
			// 現在のリンクの祖先要素を .nav-menu に到達するまで上に移動します。
			while ( ! self.classList.contains( 'nav-menu' ) ) {
				// li 要素の場合、.focus クラスを切り替えます。
				if ( 'li' === self.tagName.toLowerCase() ) {
					self.classList.toggle( 'focus' );
				}
				self = self.parentNode;
			}
		}

		if ( event.type === 'touchstart' ) {
			const menuItem = this.parentNode;
			event.preventDefault();
			for ( const link of menuItem.parentNode.children ) {
				if ( menuItem !== link ) {
					link.classList.remove( 'focus' );
				}
			}
			menuItem.classList.toggle( 'focus' );
		}
	}
}() );

<?php
// 固定ページの中身を出力する関数（スラッグで指定）
function display_page_content_by_slug($slug) {
  $page = get_page_by_path($slug);
  if ($page) {
    $content = apply_filters('the_content', $page->post_content);
    echo $content;
  }
}

// CSSファイルを読み込む関数
function my_theme_enqueue_styles() {
  // テーマの基本スタイル
  wp_enqueue_style(
    'main-style',
    get_stylesheet_uri()
  );

  // header.css を読み込む
  wp_enqueue_style(
    'header-style',
    get_template_directory_uri() . '/header/header.css',
    array(),
    '1.0.0',
    'all'
  );

  // footer.css を読み込む
  wp_enqueue_style(
    'footer-style',
    get_template_directory_uri() . '/footer/footer.css',
    array(),
    '1.0.0',
    'all'
  );
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');


/**
 * ========================================
 * 1. 基本的なナビゲーションメニューショートコード
 * ========================================
 * 使用例: [nav_menu menu="global-nav"]
 */

function display_nav_menu_shortcode($atts) {
    // ショートコードの属性を設定（デフォルト値を含む）
    $atts = shortcode_atts(array(
        'menu' => 'global-nav',              // メニュー名（スラッグ）
        'theme_location' => '',              // テーマロケーション
        'container' => 'nav',                // コンテナタグ
        'container_class' => 'main-navigation', // コンテナのクラス
        'container_id' => '',                // コンテナのID
        'menu_class' => 'nav-menu',          // ul要素のクラス
        'menu_id' => '',                     // ul要素のID
        'depth' => 0,                        // 階層の深さ（0=無制限）
        'fallback_cb' => 'wp_page_menu',     // フォールバック関数
        'before' => '',                      // リンク前のテキスト
        'after' => '',                       // リンク後のテキスト
        'link_before' => '',                 // リンクテキスト前
        'link_after' => '',                  // リンクテキスト後
        'echo' => false                      // 出力せずに返す
    ), $atts, 'nav_menu');

    // wp_nav_menu()の引数を作成
    $menu_args = array(
        'menu' => $atts['menu'],
        'container' => $atts['container'],
        'container_class' => $atts['container_class'],
        'menu_class' => $atts['menu_class'],
        'depth' => intval($atts['depth']),
        'fallback_cb' => $atts['fallback_cb'],
        'before' => $atts['before'],
        'after' => $atts['after'],
        'link_before' => $atts['link_before'],
        'link_after' => $atts['link_after'],
        'echo' => false // 常にfalseにして文字列として取得
    );

    // オプション属性の条件付き追加
    if (!empty($atts['theme_location'])) {
        $menu_args['theme_location'] = $atts['theme_location'];
    }

    if (!empty($atts['container_id'])) {
        $menu_args['container_id'] = $atts['container_id'];
    }

    if (!empty($atts['menu_id'])) {
        $menu_args['menu_id'] = $atts['menu_id'];
    }

    // メニューを出力
    $menu_output = wp_nav_menu($menu_args);

    // エラーハンドリング：メニューが存在しない場合
    if (empty($menu_output)) {
        return '<!-- ナビゲーションメニュー "' . esc_html($atts['menu']) . '" が見つかりません -->';
    }

    return $menu_output;
}
add_shortcode('nav_menu', 'display_nav_menu_shortcode');
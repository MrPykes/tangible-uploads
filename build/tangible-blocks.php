<?php

function allow_html_uploads($mimes)
{
    $mimes['html'] = 'text/html';
    return $mimes;
}
add_filter('upload_mimes', 'allow_html_uploads');

function tangible_block_assets()
{
    wp_register_script(
        'tangible-block',
        plugins_url('index.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-block-editor'),
        filemtime(plugin_dir_path(__FILE__) . 'index.js')
    );

    register_block_type('cgb/tangible-block', array(
        'editor_script' => 'tangible-block',
    ));
}
add_action('init', 'tangible_block_assets');

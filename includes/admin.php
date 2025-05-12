<?php

function enqueue_admin_table_list()
{

    wp_enqueue_style(
        'tangible-admin-table-list',
        plugin_dir_url(__DIR__) . 'assets/css/table-list.css',
        [],
        time() // Use filemtime() instead for production
    );

    wp_enqueue_script(
        'tangible-admin-micromodal',
        'https://unpkg.com/micromodal/dist/micromodal.min.js',
        [], // dependencies
        time(),     // use filemtime() for production
        true        // load in footer
    );

    wp_enqueue_script(
        'tangible-admin-modal',
        plugin_dir_url(__DIR__) . 'assets/js/modal.js',
        ['tangible-admin-micromodal'], // dependencies
        time(),     // use filemtime() for production
        true        // load in footer
    );
}

add_action('admin_enqueue_scripts', 'enqueue_admin_table_list');
// Hook into admin_menu to add the menu item
add_action('admin_menu', 'tangible_uploads_admin_menu');

function tangible_uploads_admin_menu()
{
    add_submenu_page(
        'options-general.php',           // Parent slug (under Settings)
        'Tangible Uploads',              // Page title
        'Tangible Uploads',              // Menu title
        'manage_options',                // Capability
        'tangible-uploads',              // Menu slug
        'tangible_uploads_page_callback' // Callback function
    );
}

function tangible_uploads_page_callback()
{
    // Get current tab
    $tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'manage';

    // Render tabs
    echo '<div class="wrap">';
    echo '<h1>Tangible Uploads</h1>';
    echo '<h2 class="nav-tab-wrapper">';

    $tabs = [
        'docs'   => 'Documentation',
        'manage' => 'Manage Content',
        'settings' => 'Settings',
    ];

    foreach ($tabs as $key => $name) {
        $active = ($tab === $key) ? 'nav-tab-active' : '';
        echo '<a href="?page=tangible-uploads&tab=' . $key . '" class="nav-tab ' . $active . '">' . $name . '</a>';
    }
    echo '</h2>';

    // Load content based on tab
    switch ($tab) {
        case 'docs':
            echo '<p>Documentation content goes here.</p>';
            break;
        case 'manage':
            $list_file = plugin_dir_path(__FILE__) . 'list.php';
            if (file_exists($list_file)) {
                include_once $list_file;
                $file_upload_table = new File_Upload_Table();
                $file_upload_table->prepare_items();
                $file_upload_table->display();
                // include_once  plugin_dir_path(__FILE__) . 'modal.php';
            } else {
                error_log('List file not found at: ' . $list_file);
                echo '<p><strong>Error:</strong> List file not found. ' .  $list_file . '</p>';
            }
            break;
        case 'settings':
            echo '<p>Settings content goes here.</p>';
            break;
    }

    echo '</div>';
}
// Inject modal HTML into admin footer
add_action('admin_footer', function () {
?>
    <button data-micromodal-trigger="modal-1" class="button button-primary">Open Modal</button>

    <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">Micromodal Test</h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                    <p>This is a test modal in the WP admin area.</p>
                </main>
                <footer class="modal__footer">
                    <button class="modal__btn" data-micromodal-close>Close</button>
                </footer>
            </div>
        </div>
    </div>

    <style>
        .modal {
            font-family: Arial, sans-serif;
        }
    </style>
<?php
});

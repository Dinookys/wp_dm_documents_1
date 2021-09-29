<?php 

add_filter('page_template', function($template){
    global $post;

    if (has_shortcode($post->post_content, 'dm-documents') && isset($_GET['details']) && isset($_GET['print'])) {
        return DM_DOCUMENTS_DIR . 'templates/print.php';
    }

    return $template;
});
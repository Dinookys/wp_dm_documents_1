<?php 

function dm_create_breadcrumbs_HTML($objects = [], $firstbreadcrumb = 'Lista', $return = false) {
    global $wp;
    $current_url = home_url($wp->request);
    $html = '';

    if($objects) {

        $total = count($objects) - 1;

        $html .= '<nav class="dm-breadcrumbs" >';
        $html .= '<a href="'. $current_url .'" >'. $firstbreadcrumb .'</a> // ';

        foreach($objects as $key => $ob) {
            if($key < $total) {
                $url = $current_url . '?dmcat=' . $ob->ID;
                $html .= '<a href="'. $url .'" >'. $ob->titulo .'</a> // ';
            } else {
                $html .= '<span>'. $ob->titulo .'</span>';
            }
        }
        $html .= '</nav>';
    }    

    if($return) {
        return $html;
    }

    echo $html;

}
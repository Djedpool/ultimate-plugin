<?php

$args = array(
    'post_type' => 'testimonial',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'meta_query' => array(
       array(
           'key' => '_ultimate_testimonial_key',
           'value' => 's:8:"approved";i:1;s:8:"featured";i:1;',
           'compare' => 'LIKE'
       )
    )
);

$query = new WP_Query($args);
$i = 1;
if ($query->have_posts()) :
    echo '<div class="ul-slider--wrapper"><div class="ul-slider--container"><div class="ul-slider--view"><ul>';
    while ($query->have_posts()) :
        $query->the_post();
        $name = get_post_meta(get_the_ID(), '_ultimate_testimonial_key', true)['name'] ?? '';

        echo '<li class="ul-slider--view__slides'.($i === 1 ? ' is-active' : '').'"><p class="testimonial-quote">"'.get_the_content().'"</p><p class="testimonial-author">~ '.$name.' ~</p></li>';
    endwhile;
    echo '</ul></div><div class="ul-slider--arrows"><span class="arrow ul-slider--arrows__left">&#x3c</span><span class="arrow ul-slider--arrows__right">&#x3e</span></div></div></div>';
    $i++;
endif;
wp_reset_postdata();
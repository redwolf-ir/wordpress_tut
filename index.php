<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php get_header(); ?>
    <title>RedWolF</title>
</head>
<body>
    <?php

    while (have_posts()) {
        the_post(); ?>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p><?php the_content(); ?></p>

    <?php }
    ?>

    <?php 
        $homepageIdioms = new WP_Query(array(
            'posts_per_page' => 3,
            'post_type' => 'event',
        ));

        while($homepageIdioms->have_posts()) {
            $homepageIdioms->the_post(); ?>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php }
    ?>

<?php get_footer(); ?>
</body>
</html>
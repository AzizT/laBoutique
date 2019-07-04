<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<!-- lang="fr" -->
<!-- cette ligne est désormais obsolète, remplacée  par celle ci dessous -->
<!-- <?php language_attributes(); ?> -->

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php bloginfo('name'); ?></title>
    <!-- permet d' ecrire le titre via le site WP -->
    <?php wp_head(); ?>
    <!-- permet de charger des fichiers indispensables a WP...ici, elle va notamment afficher la barre de navigation noire de WP en haut de page -->

    <!-- link fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- cdn bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <!-- mon cdn -->
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.css">
    <!-- fonction WP qui remplace css(/style.css)... et retourne l' URL du theme portfolio -->
</head>

<body>


</body>

</html>
<?php

$router->get('', array('PagesController', 'home'));

$router->get('home', array('PagesController', 'home'));

$router->get('about', array('PagesController', 'about'));



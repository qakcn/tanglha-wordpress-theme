<?php

if ( ! isset( $content_width ) ) $content_width = 936;

if($timezone = get_option('timezone_string')) {
    date_default_timezone_set($timezone);
}


/* Load splitted function files */
require 'functions/setup.functions.php';
require 'functions/customizer.functions.php';
require 'functions/layout.functions.php';


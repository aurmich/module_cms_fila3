<?php

// Test file to check available methods in FullCalendarWidget
require_once __DIR__ . '/vendor/autoload.php';

$methods = get_class_methods('\Saade\FilamentFullCalendar\Widgets\FullCalendarWidget');
var_dump($methods);

<?php
include_once 'classes/application.php';

Application::init('includes/config.php');
echo Application::run();

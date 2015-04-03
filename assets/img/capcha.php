<?php

	session_start();
	$_SESSION['capcha'] = substr(uniqid(), 7);

	$image = new Imagick();
	$image->newImage(200, 80, new ImagickPixel('grey'), 'png');

	$draw = new ImagickDraw();
	$draw->setFillColor('green');
	$draw->setFontSize('34');
	// $draw->setFontWeight('1');
	// $pixel = new ImagickPixel( 'gray' );
	// $x = rand(0, 100);
	// $y = rand(0, 40);

	for ($i=0; $i < 6; $i++) { 
		$x = rand(5, 10);
		$y = rand(30, 40);
		$x += rand(20, 30) * $i;
		$y+= rand(1, 10) * $i;
		$angle = rand(-45, 45);
		$color = 'rgb('.rand(0, 255).', '. rand(0, 255). ', '. rand(0, 255).')';
		$draw->setFillColor($color);
		$image->annotateImage($draw, $x, $y, $angle, $_SESSION['capcha'][$i]);
	}

	$image->blurImage(100, 1.25);

	echo $image;
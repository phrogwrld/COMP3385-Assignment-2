<?php

spl_autoload_register(function ($className) {
	// Get the filepath of the class.
	$filepath = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

	// echo $filepath . '<br>';

	// Remove the namespace from the filepath.
	if (strpos($className, 'App\Framework\\') === 0) {
		$filepath = str_replace('App' . DIRECTORY_SEPARATOR, '', $filepath);
	}

	// echo $filepath . '<br>';

	// If the file exists, require it.
	if (file_exists($filepath)) {
		require_once $filepath;
	} else {
		trigger_error('The class `' . $className . '` does not exist.', E_USER_ERROR);
		exit();
	}
});

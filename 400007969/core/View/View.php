<?php

namespace App\Core\View;

use App\Core\Mimikyu;
use App\Core\View\TemplateEngine;

class View {
	public static function render(string $viewName, $data = []) {
		$templateEngine = new TemplateEngine($viewName, Mimikyu::$app->getParserManager());

		$content = $templateEngine->render($data);

		eval('?> ' . $content . ' <?php'); // Oops
	}
}

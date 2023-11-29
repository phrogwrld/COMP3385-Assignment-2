<?php

namespace App\Framework\View;

use App\Framework\Mimikyu;
use App\Framework\View\TemplateEngine;

class View {
	public static function render(string $viewName, $data = []) {
		$templateEngine = new TemplateEngine($viewName, Mimikyu::$app->getParserManager());

		$content = $templateEngine->render($data);

		eval('?> ' . $content . ' <?php'); // Oops
	}
}

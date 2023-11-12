<?php

namespace App\Core\View\Parsers;

use App\Core\View\Parsers\IParser;

class ContentParser implements IParser {
	public function parse(string $content, $data = []): string {
		// Regular expression to match '{{{ $variable }}}' pattern
		$pattern = '/\{\{\{\s*\$(\w+)\s*\}\}\}/';

		preg_match_all($pattern, $content, $matches);

		if (!empty($matches[1])) {
			foreach ($matches[1] as $key => $item) {
				$search = $matches[0][$key];
				$variable = $matches[1][$key];

				// Check if the variable exists in the provided $data array
				if (isset($data[$variable])) {
					$replacement = htmlentities($data[$variable]);
					$content = str_replace($search, $replacement, $content);
				}
			}
		}

		return $content;
	}
}

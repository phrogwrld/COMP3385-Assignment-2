<?php

namespace App\Core\View\Parsers;

class ForParser implements IParser {
	public function parse(string $content, $data = []): string {
		$replacements = [
			'@for' => ['~@for\((.*?)\)$~im', '<?php for($1): ?>'],
			'@endfor' => ['~@endfor$~im', '<?php endfor; ?>'],
		];

		foreach ($replacements as $directive => $pattern) {
			$content = preg_replace($pattern[0], $pattern[1], $content);
		}

		return $content;
	}
}

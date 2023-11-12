<?php

namespace App\Core\View\Parsers;

class ForEachParser implements IParser {
	public function parse(string $content, $data = []): string {
		$replacements = [
			'@foreach' => ['~@foreach\((.*?)\)$~im', '<?php foreach($1): ?>'],
			'@endforeach' => ['~@endforeach$~im', '<?php endforeach; ?>'],
		];

		foreach ($replacements as $directive => $pattern) {
			$content = preg_replace($pattern[0], $pattern[1], $content);
		}

		return $content;
	}
}

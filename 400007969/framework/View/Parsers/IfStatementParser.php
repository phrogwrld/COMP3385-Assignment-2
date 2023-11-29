<?php

namespace App\Framework\View\Parsers;

class IfStatementParser implements IParser {
	public function parse(string $content, $data = []): string {
		$replacements = [
			'@if' => ['~@if\((.+?)\)\s*$~im', '<?php if($1): ?>'],
			'@elif' => ['~@elif\((.+?)\)\s*$~im', '<?php elseif($1): ?>'],
			'@else' => ['~@else~im', '<?php else: ?>'],
			'@endif' => ['~@endif~im', '<?php endif; ?>'],
		];

		foreach ($replacements as $directive => $pattern) {
			$content = preg_replace($pattern[0], $pattern[1], $content);
		}

		return $content;
	}
}

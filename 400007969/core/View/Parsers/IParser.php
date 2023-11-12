<?php

namespace App\Core\View\Parsers;

interface IParser {
	public function parse(string $content, $data = []): string;
}

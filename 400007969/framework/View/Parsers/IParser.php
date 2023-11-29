<?php

namespace App\Framework\View\Parsers;

interface IParser {
	public function parse(string $content, $data = []): string;
}

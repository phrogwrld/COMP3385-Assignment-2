<?php

namespace App\Framework\View;

use App\Framework\View\Parsers\IParser;

class TemplateEngine implements IParser {
	/**
	 * The path to the template file.
	 *
	 * @var string
	 */
	private string $template;

	/**
	 * The template engine parsers.
	 *
	 * @var array
	 */
	private array $parsers;

	private ParserManager $parserManager;

	/**
	 * Constructor.
	 *
	 * @param string $template The path to the template file.
	 * @param string $cache The path to the cache file.
	 * @param IParser $parser The template engine parser.
	 */
	public function __construct(string $template, ParserManager $parserManager) {
		$this->template = $template;

		$this->parserManager = $parserManager;
		$this->parsers = $this->parserManager->getParsers();
	}

	/**
	 * Render the template.
	 *
	 * @param array $data The data to pass to the template.
	 * @return string
	 */
	public function render(array $data = []): string {
		if (!file_exists($this->template)) {
			throw new TemplateEngineException("Template file does not exist: $this->template");
		}

		$content = file_get_contents($this->template);

		// ob_start();

		foreach ($this->parsers as $parser) {
			if ($parser instanceof IParser) {
				$content = $parser->parse($content, $data);
			}
		}

		$content = $this->parse($content, $data);

		// $content = ob_get_contents();

		// ob_end_clean();

		return $content;
	}

	/**
	 * Set the template file.
	 *
	 * @param string $template The path to the template file.
	 * @return void
	 */
	public function setTemplate(string $template): void {
		$this->template = $template;
	}

	public function parse(string $content, $data = []): string {
		preg_match_all('~{{\s*(.+?)\s*}}~is', $content, $match);

		if (!empty($match[1])) {
			foreach ($match[1] as $key => $item) {
				$content = str_replace($match[0][$key], '<?= ' . $match[1][$key] . ' ?>', $content);
			}
		}

		return $content;
	}
}

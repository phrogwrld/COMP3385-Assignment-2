<?php

namespace App\Helpers;

enum Role: string {
	case ResearchGroupManager = 'Research Group Manager';
	case ResearchStudyManager = 'Research Study Manager';
	case Researcher = 'Researcher';

	public static function fromString(string $roleString): self {
		switch ($roleString) {
			case 'Research Group Manager':
				return self::ResearchGroupManager;
			case 'Research Study Manager':
				return self::ResearchStudyManager;
			case 'Researcher':
				return self::Researcher;
			default:
				throw new \InvalidArgumentException('Unknown role string: ' . $roleString);
		}
	}
}

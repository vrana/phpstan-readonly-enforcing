<?php declare(strict_types=1);

namespace Sal\PhpstanReadonlyEnforcing\Test\Dummy\EdgeCases;

final class MissingType
{
	private $a;

	public function __construct(
		private $b,
	)
	{
        $this->a = $this->b;
	}
}

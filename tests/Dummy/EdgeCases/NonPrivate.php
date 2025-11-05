<?php declare(strict_types=1);

namespace Sal\PhpstanReadonlyEnforcing\Test\Dummy\EdgeCases;

final class NonPrivate
{
	public int $a;
	protected int $b;

	public function __construct(
        public int $c,
        protected int $d,
        private int $e,
	)
	{
        $this->a = $this->c;
        $this->b = $this->d;
	}
}

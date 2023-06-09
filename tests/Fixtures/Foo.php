<?php declare(strict_types = 1);

namespace Tests\Fixtures;

class Foo
{

	public function bar(): string
	{
		return 'baz';
	}

	public function baz(mixed $r): mixed
	{
		return $r;
	}

}

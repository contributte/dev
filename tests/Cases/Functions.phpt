<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte\Tester\Toolkit;
use Tester\Assert;
use Tests\Fixtures\Foo;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(function (): void {
	$cb = callback(new Foo(), 'bar');
	Assert::equal('baz', $cb());

	$cb = callback(new Foo(), 'baz');
	Assert::equal('foobar', $cb('foobar'));
});

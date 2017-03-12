<?php

namespace Tests;

/**
 * Test: functions.php
 */

use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class Foo
{

	/**
	 * @return string
	 */
	public function bar()
	{
		return 'baz';
	}

	/**
	 * @param mixed $r
	 * @return mixed
	 */
	public function baz($r)
	{
		return $r;
	}

}

test(function () {
	$cb = callback(new Foo, 'bar');
	Assert::equal('baz', $cb());

	$cb = callback(new Foo, 'baz');
	Assert::equal('foobar', $cb('foobar'));
});

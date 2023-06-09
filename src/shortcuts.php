<?php declare(strict_types = 1);

use Contributte\Dev\Dev;

if (!function_exists('d')) {

	function d(): void
	{
		Dev::d(...func_get_args());
	}

}

if (!function_exists('dd')) {

	function dd(): void
	{
		Dev::dd(...func_get_args());
	}

}

if (!function_exists('ed')) {

	/**
	 * @param scalar $value
	 */
	function ed(mixed $value): void
	{
		Dev::ed($value);
	}

}

if (!function_exists('fd')) {

	/**
	 * @param array<mixed|mixed[]> $values
	 */
	function fd(array $values): void
	{
		Dev::fd($values);
	}

}

if (!function_exists('fdd')) {

	/**
	 * @param mixed[] $values
	 */
	function fdd(mixed $values): void
	{
		Dev::fdd($values);
	}

}

if (!function_exists('td')) {

	/**
	 * @param mixed[] $values
	 */
	function td(mixed $values): void
	{
		Dev::td($values);
	}

}

if (!function_exists('tdd')) {

	/**
	 * @param mixed[] $values
	 */
	function tdd(mixed $values): void
	{
		Dev::tdd($values);
	}

}

if (!function_exists('bd')) {

	function bd(mixed $var, string|null $title = null): mixed
	{
		return Dev::bd($var, $title);
	}

}

if (!function_exists('wc')) {

	function wc(int $level = 1, bool $return = false, bool $fullTrace = false): mixed
	{
		return Dev::wc($level, $return, $fullTrace);
	}

}

if (!function_exists('fwc')) {

	function fwc(int $level = 3, bool $return = false): void
	{
		Dev::fwc($level, $return);
	}

}

if (!function_exists('ss')) {

	function ss(string $code): void
	{
		Dev::ss($code);
	}

}

if (!function_exists('e')) {

	function e(): void
	{
		Dev::e();
	}

}

if (!function_exists('l')) {

	function l(string $message): void
	{
		Dev::l($message);
	}

}

if (!function_exists('log')) {

	function log(string $message): void
	{
		Dev::log($message);
	}

}

if (!function_exists('erd')) {

	function erd(): void
	{
		Dev::erd(...func_get_args());
	}

}

if (!function_exists('c')) {

	function c(object $instance): object
	{
		return Dev::c($instance);
	}

}

if (!function_exists('cl')) {

	function cl(object $instance): object
	{
		return Dev::cl($instance);
	}

}

if (!function_exists('callback')) {

	/**
	 * @return array{object, string}
	 */
	function callback(object $obj, string $method): array
	{
		return Dev::callback($obj, $method);
	}

}

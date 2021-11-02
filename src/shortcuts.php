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
	function ed($value): void
	{
		Dev::ed($value);
	}
}

if (!function_exists('fd')) {
	function fd($values): void
	{
		Dev::fd($values);
	}
}

if (!function_exists('fdd')) {
	function fdd($values): void
	{
		Dev::fdd($values);
	}
}

if (!function_exists('td')) {

	function td($values): void
	{
		Dev::td($values);
	}
}

if (!function_exists('tdd')) {
	function tdd($values): void
	{
		Dev::tdd($values);
	}
}

if (!function_exists('bd')) {
	function bd($var, $title = null)
	{
		return Dev::bd($var, $title);
	}
}

if (!function_exists('wc')) {
	function wc(int $level = 1, bool $return = false, bool $fullTrace = false)
	{
		return Dev::wc($level, $return, $fullTrace);
	}
}

if (!function_exists('fwc')) {
	function fwc($level = 3, $return = false): void
	{
		Dev::fwc($level, $return);
	}
}

if (!function_exists('ss')) {
	function ss($code)
	{
		Dev::ss($code);
	}
}

if (!function_exists('e')) {
	function e()
	{
		Dev::e();
	}
}

if (!function_exists('l')) {
	function l(string $message)
	{
		Dev::l($message);
	}
}
if (!function_exists('log')) {
	function log(string $message)
	{
		Dev::log($message);
	}
}

if (!function_exists('erd')) {
	function erd()
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
	function cl(object $instance)
	{
		return Dev::cl($instance);
	}
}

if (!function_exists('callback')) {
	function callback($obj, $method): array
	{
		return Dev::callback($obj, $method);
	}
}

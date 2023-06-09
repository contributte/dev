<?php declare(strict_types = 1);

namespace Contributte\Dev;

use Nette\StaticClass;
use Nette\Utils\Json;
use RuntimeException;
use Tracy\Debugger;
use Tracy\Helpers;
use Traversable;

class Dev
{

	use StaticClass;

	/**
	 * Dump;
	 */
	public static function d(): void
	{
		foreach (func_get_args() as $var) {
			dump($var);
		}
	}

	/**
	 * Dump; die;
	 */
	public static function dd(): void
	{
		self::d(...func_get_args());
		die;
	}

	/**
	 * echo;die
	 *
	 * @param scalar $value
	 */
	public static function ed(mixed $value): void
	{
		echo $value;
		die;
	}

	/**
	 * Foreach dump;
	 *
	 * @param array<mixed|mixed[]> $values
	 */
	public static function fd(array $values): void
	{
		foreach ($values as $value) {
			if ($value instanceof Traversable) {
				$value = iterator_to_array($value);
			}

			dump($value);
			echo "<hr style='border:0px;border-top:1px solid #DDD;height:0px;'>";
		}
	}

	/**
	 * Foreach dump;die;
	 *
	 * @param mixed[] $values
	 */
	public static function fdd(array $values): void
	{
		self::fd($values);
		die;
	}

	/**
	 * Table dump;
	 *
	 * @param mixed[] $values
	 */
	public static function td(array $values): void
	{
		echo "<table border=1 style='border-color:#DDD;border-collapse:collapse; font-family:Courier New; color:#222; font-size:13px' cellspacing=0 cellpadding=5>";
		$th = false;
		foreach ($values as $value) {
			if (!$th) {
				echo '<tr>';
				foreach ((array) $value as $key2 => $value2) {
					echo '<th>' . $key2 . '</th>';
				}

				echo '</tr>';
			}

			$th = true;

			echo '<tr>';
			foreach ((array) $value as $key2 => $value2) {
				echo '<td>' . $value2 . '</td>';
			}

			echo '</tr>';
		}

		echo '</table>';
	}

	/**
	 * Table dump;die;
	 *
	 * @param mixed[] $values
	 */
	public static function tdd(array $values): void
	{
		self::td($values);
		die;
	}

	/**
	 * Bar dump shortcut.
	 */
	public static function bd(mixed $var, ?string $title = null): mixed
	{
		$trace = debug_backtrace();
		$traceTitle = (isset($trace[1]['class']) ? htmlspecialchars($trace[1]['class']) . '->' : null) .
			htmlspecialchars($trace[1]['function']) . '():';

		if ($title === null) {
			foreach (func_get_args() as $arg) {
				Debugger::barDump($arg, $traceTitle);
			}

			return $var;
		}

		return Debugger::barDump($var, $title);
	}

	/**
	 * Function prints from where were method/function called
	 */
	public static function wc(int $level = 1, bool $return = false, bool $fullTrace = false): mixed
	{
		$o = fn ($t) => (isset($t->class) ? htmlspecialchars($t->class) . '->' : null) . htmlspecialchars($t->function) . '()';
		$f = fn ($t) => isset($t->file) ? '(' . Helpers::editorLink($t->file, $t->line ?? null) . ')' : null;

		$trace = debug_backtrace();
		$target = (object) $trace[$level];
		$caller = (object) $trace[$level + 1];
		$message = null;

		if ($fullTrace) {
			array_shift($trace);
			foreach ($trace as $call) {
				$message .= $o((object) $call) . " \n";
			}
		} else {
			$message = $o($target) . ' called from ' . $o($caller) . $f($caller);
		}

		if ($return) {
			return strip_tags((string) $message);
		}

		echo "<pre class='nette-dump'>" . nl2br((string) $message) . '</pre>';

		return null;
	}

	/**
	 * Function prints from where were method/function called
	 */
	public static function fwc(int $level = 3, bool $return = false): void
	{
		self::wc($level, $return, true);
	}

	/**
	 * Convert script into shortcut; exit;
	 */
	public static function ss(string $code): void
	{
		$array = [
			"\t" => "\\t",
			"\n" => "\\n",
		];

		echo strtr($code, $array);
		exit;
	}

	/**
	 * Show debug bar
	 */
	public static function e(): void
	{
		throw new RuntimeException('debug');
	}

	/**
	 * Log message (alias for log)
	 */
	public static function l(string $message): void
	{
		self::log($message);
	}

	/**
	 * Log message
	 */
	public static function log(string $message): void
	{
		$message = array_map(fn ($message) => !is_scalar($message) ? Json::encode($message) : $message, func_get_args());

		Debugger::log(implode(', ', $message));
	}

	/**
	 * Show debug bar and dump $arg
	 */
	public static function erd(): void
	{
		$e = new RuntimeException();
		fd(func_get_args());
		echo '<hr />';
		fd($e->getTrace());
		echo '<hr />';
	}

	/**
	 * PHP workaround for direct usage of created class
	 *
	 * <code>
	 * // echo (new Person)->name; // does not work in PHP
	 * echo c(new Person)->name;
	 * </code>
	 */
	public static function c(object $instance): object
	{
		return $instance;
	}

	/**
	 * PHP workaround for direct usage of cloned instances
	 *
	 * <code>
	 * echo cl($startTime)->modify('+1 day')->format('Y-m-d');
	 * </code>
	 */
	public static function cl(object $instance): object
	{
		return clone $instance;
	}

	/**
	 * PHP callback workaround
	 *
	 * @return array{object, string}
	 */
	public static function callback(object $obj, string $method): array
	{
		return [$obj, $method];
	}

}

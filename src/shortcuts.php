<?php declare(strict_types = 1);

use Nette\Utils\Json;
use Tracy\Debugger;
use Tracy\Helpers;

if (!function_exists('d')) {
	/**
	 * Dump;
	 *
	 * @shortens
	 * @params mixed
	 * @return void
	 */
	function d()
	{
		foreach (func_get_args() as $var) {
			dump($var);
		}
	}
}

if (!function_exists('dd')) {
	/**
	 * Dump; die;
	 *
	 * @shortens
	 * @params mixed
	 * @return void
	 */
	function dd()
	{
		foreach (func_get_args() as $var) {
			dump($var);
		}
		die;
	}
}

if (!function_exists('ed')) {
	/**
	 * echo;die
	 *
	 * @param mixed $value
	 * @return void
	 */
	function ed($value)
	{
		echo $value;
		die;
	}
}

if (!function_exists('fd')) {
	/**
	 * Foreach dump;
	 *
	 * @param mixed $values
	 * @return void
	 */
	function fd($values)
	{
		foreach ($values as $key => $value) {
			if (!is_array($value) && !is_scalar($value)) {
				$value = iterator_to_array($value);
			}

			dump($value);
			echo "<hr style='border:0px;border-top:1px solid #DDD;height:0px;'>";
		}
	}
}

if (!function_exists('fdd')) {
	/**
	 * Foreach dump;die;
	 *
	 * @param mixed $values
	 * @return void
	 */
	function fdd($values)
	{
		fd($values);
		die;
	}
}

if (!function_exists('td')) {
	/**
	 * Table dump;
	 *
	 * @param mixed $values
	 * @return void
	 */
	function td($values)
	{
		echo "<table border=1 style='border-color:#DDD;border-collapse:collapse; font-family:Courier New; color:#222; font-size:13px' cellspacing=0 cellpadding=5>";
		$th = false;
		foreach ($values as $key => $value) {
			if (!$th) {
				echo '<tr>';
				foreach ($value as $key2 => $value2) {
					echo '<th>' . $key2 . '</th>';
				}

				echo '</tr>';
			}

			$th = true;

			echo '<tr>';
			foreach ($value as $key2 => $value2) {
				echo '<td>' . $value2 . '</td>';
			}

			echo '</tr>';
		}

		echo '</table>';
	}
}

if (!function_exists('tdd')) {
	/**
	 * Table dump;die;
	 *
	 * @param mixed $values
	 * @return void
	 */
	function tdd($values)
	{
		td($values);
		die;
	}
}

if (!function_exists('bd')) {
	/**
	 * Bar dump shortcut.
	 *
	 * @param mixed $var
	 * @param string $title
	 * @return mixed
	 */
	function bd($var, $title = null)
	{
		$trace = debug_backtrace();
		$traceTitle = (isset($trace[1]['class']) ? htmlspecialchars($trace[1]['class']) . '->' : null) .
			htmlspecialchars($trace[1]['function']) . '():' . $trace[0]['line'];

		if (!is_scalar($title) && $title !== null) {
			foreach (func_get_args() as $arg) {
				Debugger::barDump($arg, $traceTitle);
			}

			return $var;
		}

		return Debugger::barDump($var, $title ?: $traceTitle);
	}
}

if (!function_exists('wc')) {
	/**
	 * Function prints from where were method/function called
	 *
	 * @param int $level
	 * @param bool $return
	 * @param bool $fullTrace
	 * @return void|mixed
	 */
	function wc($level = 1, $return = false, $fullTrace = false)
	{
		$o = function ($t) {
			return (isset($t->class) ? htmlspecialchars($t->class) . '->' : null) . htmlspecialchars($t->function) . '()';
		};
		$f = function ($t) {
			return isset($t->file) ? '(' . Helpers::editorLink($t->file, $t->line) . ')' : null;
		};

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
			return strip_tags($message);
		}

		echo "<pre class='nette-dump'>" . nl2br($message) . '</pre>';
	}
}

if (!function_exists('fwc')) {
	/**
	 * Function prints from where were method/function called
	 *
	 * @param int $level
	 * @param bool $return
	 * @return void
	 */
	function fwc($level = 3, $return = false)
	{
		wc($level, $return, true);
	}
}

if (!function_exists('ss')) {
	/**
	 * Convert script into shortcut; exit;
	 *
	 * @param mixed $code
	 * @return void
	 */
	function ss($code)
	{
		$array = [
			"\t" => "\\t",
			"\n" => "\\n",
		];

		echo strtr($code, $array);
		exit();
	}
}

if (!function_exists('e')) {
	/**
	 * Show debug bar
	 *
	 * @return void
	 * @throws Exception
	 */
	function e()
	{
		throw new Exception('debug');
	}
}

if (!function_exists('l')) {
	/**
	 * Log message
	 *
	 * @param string $message
	 * @return void
	 */
	function l($message)
	{
		$message = array_map(function ($message) {
			return !is_scalar($message) ? Json::encode($message) : $message;
		}, func_get_args());

		Debugger::log(implode(', ', $message));
	}
}

if (!function_exists('erd')) {
	/**
	 * Show debug bar and dump $arg
	 *
	 * @return void
	 */
	function erd()
	{
		$e = new RuntimeException;
		fd(func_get_args());
		echo '<hr />';
		fd($e->getTrace());
		echo '<hr />';
	}
}

if (!function_exists('c')) {
	/**
	 * PHP workaround for direct usage of created class
	 *
	 * <code>
	 * // echo (new Person)->name; // does not work in PHP
	 * echo c(new Person)->name;
	 * </code>
	 *
	 * @param object $instance
	 * @return object
	 */
	function c($instance)
	{
		return $instance;
	}
}

if (!function_exists('cl')) {
	/**
	 * PHP workaround for direct usage of cloned instances
	 *
	 * <code>
	 * echo cl($startTime)->modify('+1 day')->format('Y-m-d');
	 * </code>
	 *
	 * @param object $instance
	 * @return object
	 */
	function cl($instance)
	{
		return clone $instance;
	}
}

if (!function_exists('callback')) {
	/**
	 * PHP callback workaround
	 *
	 * @param object $obj
	 * @param string $method
	 * @return array
	 */
	function callback($obj, $method)
	{
		return [$obj, $method];
	}
}

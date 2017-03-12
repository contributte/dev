<?php

use Nette\Utils\Json;
use Tracy\Debugger;
use Tracy\Helpers;

/**
 * <pre>
 *
 * @function d - dump;
 * @function dd - dump; die;
 * @function ed - echo; die;
 * @function fd - foreach dump;
 * @function fdd - foreach dump; die;
 * @function td - table dump;
 * @function tdd - table dump; die;
 * @function bd - barDump;
 * @function wc - where called (backtrace)
 * @function ss - convert to shortcut;
 * @function e - show debug bar;
 * @function l - log message
 * @function erd - throw error and dump parameters
 * @function c - return instance
 * @function cl - clone instance
 *
 * </pre>
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @author Nette Community
 */

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

/**
 * Table dump;
 *
 * @param mixed $values
 * @return void
 */
function td($values)
{
	echo "<table border=1 style='border-color:#DDD;border-collapse:collapse; font-family:Courier New; color:#222; font-size:13px' cellspacing=0 cellpadding=5>";
	$th = FALSE;
	foreach ($values as $key => $value) {
		if (!$th) {
			echo '<tr>';
			foreach ($value as $key2 => $value2) {
				echo '<th>' . $key2 . '</th>';
			}

			echo '</tr>';
		}

		$th = TRUE;

		echo '<tr>';
		foreach ($value as $key2 => $value2) {
			echo '<td>' . $value2 . '</td>';
		}

		echo '</tr>';
	}

	echo '</table>';
}

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

/**
 * Bar dump shortcut.
 *
 * @param mixed $var
 * @param string $title
 * @return mixed
 */
function bd($var, $title = NULL)
{
	if (Debugger::$productionMode) {
		return $var;
	}

	$trace = debug_backtrace();
	$traceTitle = (isset($trace[1]['class']) ? htmlspecialchars($trace[1]['class']) . '->' : NULL) .
		htmlspecialchars($trace[1]['function']) . '():' . $trace[0]['line'];

	if (!is_scalar($title) && $title !== NULL) {
		foreach (func_get_args() as $arg) {
			Debugger::barDump($arg, $traceTitle);
		}

		return $var;
	}

	return Debugger::barDump($var, $title ?: $traceTitle);
}

/**
 * Function prints from where were method/function called
 *
 * @param int $level
 * @param bool $return
 * @param bool $fullTrace
 * @return void|mixed
 */
function wc($level = 1, $return = FALSE, $fullTrace = FALSE)
{
	if (Debugger::$productionMode) {
		return;
	}

	$o = function ($t) {
		return (isset($t->class) ? htmlspecialchars($t->class) . '->' : NULL) . htmlspecialchars($t->function) . '()';
	};
	$f = function ($t) {
		return isset($t->file) ? '(' . Helpers::editorLink($t->file, $t->line) . ')' : NULL;
	};

	$trace = debug_backtrace();
	$target = (object) $trace[$level];
	$caller = (object) $trace[$level + 1];
	$message = NULL;

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

/**
 * Function prints from where were method/function called
 *
 * @param int $level
 * @param bool $return
 * @return void
 */
function fwc($level = 3, $return = FALSE)
{
	wc($level, $return, TRUE);
}

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

/**
 * Show debug bar
 *
 * @throws Exception
 * @return void
 */
function e()
{
	if (!Debugger::$productionMode) {
		throw new Exception('debug');
	}
}

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

/**
 * Show debug bar and dump $arg
 *
 * @return void
 */
function erd()
{
	if (Debugger::$productionMode) {
		return;
	}

	$e = new RuntimeException;
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
 *
 * @param object $instance
 * @return object
 */
function c($instance)
{
	return $instance;
}

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

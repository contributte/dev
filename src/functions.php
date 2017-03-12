<?php

/**
 * <pre>
 *
 * @function callback - call object method
 *
 * </pre>
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @author Nette Community
 */

/**
 * @param object $obj
 * @param string $method
 * @return array
 */
function callback($obj, $method)
{
	return [$obj, $method];
}

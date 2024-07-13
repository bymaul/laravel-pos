<?php

/**
 * Adds leading zeros to a value.
 *
 * @param mixed $value The value to add zeros to.
 * @param int|null $threshold The number of zeros to add. If not provided, the value will be returned as is.
 * @return string The value with leading zeros added.
 */
function addLeadingZero($value, $threshold = null)
{
    return sprintf('%0' . $threshold . 's', $value);
}

<?php

/**
 * Echo a translatable string (to be added later)
 * 
 * @param string $string
 * 
 * @since v0.3.1
 */
function _e($string) {
    echo __($string);
}

/**
 * Return a translatable string (to be added later)
 * 
 * @param string $string
 * @return string
 * 
 * @since v0.3.1
 */
function __($string) {
    return $string;
}
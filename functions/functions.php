<?php

function escape($string) {
    return htmlentities($string, ENT_HTML5, 'UTF-8');
}

function decode($string) {
    return htmlspecialchars_decode($string, ENT_NOQUOTES);
}
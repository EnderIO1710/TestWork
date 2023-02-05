<?php

function clean($value = "")
{
	$value = trim($value);
	$value = stripslashes($value);
	$value = strip_tags($value);
	return $value;
}

function getUrlDomain()
{
	$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$url = explode('?', $url);
	$url = $url[0];
	return  $url;
}

?>
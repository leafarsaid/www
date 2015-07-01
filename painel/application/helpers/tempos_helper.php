<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('tempo_para_segundos'))
{
    function tempo_para_segundos($t)
    {
    	$segundos = 1*(($t[0].$t[1])*3600 + ($t[3].$t[4])*60 + (int) ($t[6].$t[7])) .$t[8].$t[9].$t[10];
    	
    	return $segundos;
    }   
}

if ( ! function_exists('data_para_bd'))
{
    function data_para_bd($time)
    {
    	date_default_timezone_set('UTC');
    	return date("y-m-d", strtotime($time));
    }   
}
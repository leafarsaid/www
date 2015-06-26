<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('tempo_para_segundo'))
{
    function tempo_para_segundo($t)
    {
    	$segundos = 1*(($t[0].$t[1])*3600 + ($t[3].$t[4])*60 + (int) ($t[6].$t[7])) .$t[8].$t[9].$t[10];
    	
    	return $segundos;
    }   
}
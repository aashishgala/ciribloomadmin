<?php

//////////////////////////////////////////////////////////////
//===========================================================
// WEBUZO CONTROL PANEL
// Inspired by the DESIRE to be the BEST OF ALL
// ----------------------------------------------------------
// Started by: Pulkit
// Date:       10th Jan 2009
// Time:       21:00 hrs
// Site:       https://webuzo.com/ (WEBUZO)
// ----------------------------------------------------------
// Please Read the Terms of Use at https://webuzo.com/terms
// ----------------------------------------------------------
//===========================================================
// (c) Softaculous Ltd.
//===========================================================
//////////////////////////////////////////////////////////////


function siteheader($title = ''){

global $globals;
	
	$GLOBALS['_api']['title'] = ((empty($title)) ? $globals['site_title'] : $title);
	
}

function sitefooter(){

global $theme, $globals, $kernel, $user, $l, $error, $end_time, $start_time;

	$GLOBALS['_api']['timenow'] = time();

	if($_GET['api'] == 'json'){
	
		json_encode($GLOBALS['_api']);
	
	}

}







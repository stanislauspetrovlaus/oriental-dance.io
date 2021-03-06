<?php
	$langs = array();
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
	{
		// break up string into pieces (languages and q factors)
		preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
		if (count($lang_parse[1]))
		{
			// create a list like en => 0.8
			$langs = array_combine($lang_parse[1], $lang_parse[4]);
			// set default to 1 for any without q factor
			foreach ($langs as $lang => $val)
			{
				if ($val === '')
					$langs[$lang] = 1;
			}
			// sort list based on value
			arsort($langs, SORT_NUMERIC);
		}
	}
	//extract most important (first)
	foreach ($langs as $lang => $val) { break; }
	//if complex language simplify it
	if (stristr($lang,"-"))
	{
		$tmp = explode("-",$lang);
		$lang = $tmp[0];
	}
	switch ($lang)
	{
	case 'cs':
	case 'sk':
		$dest = "cs/index.html";
		break;
	case 'en':
		$dest = "en/index.html";
		break;
	case 'ru':
	default:
		$dest = "ru/index.html";
		break;
	}
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off")
		$proto = "https";
	else
		$proto = "http";
	header ("Location: $proto://$host$uri/$dest");
	exit;
?>

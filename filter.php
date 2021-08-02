<?php

	function check($name)
	{
		$reservedWords = array(
			'GM',		
			'Gamemaster',
			'GameMaster',
			'Retard',
			'fuck',
			'Fuck',
			'Shit',
			'Admin',
			'[]',
			'[',
			']'
		);
		$filter = str_replace($reservedWords,'',$name);
		return $filter;
	}

?>

<?
function remove_comments($src,$css_mode=false)
{
	$idx=0;
	$inside_quote=false;
	$inside_double_quote=false;
	$inside_monoline_comment=false;
	$inside_multiline_comment=false;
	$current_char='';
	$previous_char='';
	$previous_char2='';
	$result='';
	while ($idx<strlen($src))
	{
		$previous_char2=$previous_char;
		$previous_char=$current_char;
		$current_char=$src[$idx];
		if(!$inside_monoline_comment&&!$inside_multiline_comment)
			$result.=$current_char;
		if($previous_char=='/'&&$current_char=='*'&&!$inside_quote&&!$inside_double_quote&&!$inside_multiline_comment&&!$inside_monoline_comment)
		{
			$inside_multiline_comment=true;
			$result=substr($result, 0, -2);
		}
		else if($previous_char=='*'&&$current_char=='/'&&!$inside_quote&&!$inside_double_quote&&!$inside_monoline_comment&&$inside_multiline_comment)
		{
			$inside_multiline_comment=false;
		}
		if($css_mode==false)
		{
			if($previous_char2!="\\"&&$previous_char=='/'&&$current_char=='/'&&!$inside_quote&&!$inside_double_quote&&!$inside_multiline_comment&&!$inside_monoline_comment)
			{
				$inside_monoline_comment=true;
				$result=substr($result, 0, -2);
			}
			else if(($current_char=="\r"||$current_char=="\n")&&$inside_monoline_comment&&!$inside_quote&&!$inside_double_quote&&!$inside_multiline_comment)
			{
				$inside_monoline_comment=false;
			}	
			if($previous_char!="\\"&&$current_char=='"'&&!$inside_quote&&!$inside_double_quote&&!$inside_multiline_comment&&!$inside_monoline_comment)
			{
				$inside_double_quote=true;
			}
			else if($previous_char!="\\"&&$current_char=='"'&&!$inside_quote&&$inside_double_quote&&!$inside_multiline_comment&&!$inside_monoline_comment)
			{
				$inside_double_quote=false;
			}
			if($previous_char!="\\"&&$current_char=="'"&&!$inside_quote&&!$inside_double_quote&&!$inside_multiline_comment&&!$inside_monoline_comment)
			{
				$inside_quote=true;
			}
			else if($previous_char!="\\"&&$current_char=="'"&&$inside_quote&&!$inside_double_quote&&!$inside_multiline_comment&&!$inside_monoline_comment)
			{
				$inside_quote=false;
			}
		}
		$idx++;
	}
	return $result;
}

//////////////////////////////////////////////////////////////////////////////////////////////////
$js_content=file_get_contents('test.js');
echo nl2br(htmlentities(remove_comments($js_content)));

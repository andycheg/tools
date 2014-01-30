<?php

$lines = file('skype.txt');

$regexp = '/^\[(.*M)\] ([^:]+): (.*)$/';

$messages = [];
$index = 0;

foreach ($lines as $line)
{
	if (preg_match($regexp, $line, $parts))
	{
		$index++;
		$messages[$index] = [
			'time'		=> strtotime($parts[1]), 
			'author'	=> $parts[2], 
			'text'		=> $parts[3]."\n", 
		];
	}
	else
	{
		$messages[$index]['text'] .= $line;
	}
}

$authors = [];
foreach ($messages as $m)
{
	if(!in_array($m['author'], $authors))
		$authors[] = $m['author'];
}

$colors = ['#E0E0FF', '#FFE0E0'];
$date = "";

?>
<HTML>
<head>
<style>
* {
	padding: 0;
	margin: 0;
	font-family: Verdana;
	font-size: 12;
}

table {
	border-spacing: 1px;
	background-color: #a0a0a0;
}

td {
	padding: 4px;
}

tr.date {
	font-weight: bold;
	font-size: 16;
	background-color: #BBBBBB;
}

pre {
	white-space: pre-wrap;       /* css-3 */
	white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
	white-space: -pre-wrap;      /* Opera 4-6 */
	white-space: -o-pre-wrap;    /* Opera 7 */
	word-wrap: break-word;       /* Internet Explorer 5.5+ */
}
</style>
</head>
<BODY>
<TABLE>
<?foreach ($messages as $m) { ?>
<?
$dateNew = date("d.m.Y", $m['time']);
if ($dateNew != $date)
{
	$date = $dateNew;
?>
<TR class="date"><td colspan=3><?=$dateNew?></td></tr>
<?
}
?>

<TR style="background-color: <?=$colors[array_search($m['author'],$authors)]?>">
<TD style="width: 120px;"><?=$m['author']?></TD>
<TD style="width: 100px;text-align: center;"><?=strftime("%H:%M:%S",$m['time'])?></TD>
<TD style="width: 800px;"><pre><?=$m['text']?></pre></TD>
</TR>
<? } ?>
</TABLE>

<!-- part of Yeheng.org quizutils - gplv3 -->
<?php
function search($search,$full) {
if(strpos($full, $search) !== false) {
return true;
} else {
return false;
}
function get_dump($q,$a1,$a2,$a3,$a4,$ca,$eol) {
$output_str = "";
$output_str .= $q;
$output_str .= $eol;
$output_str .= $a1;
$output_str .= $eol;
$output_str .= $a2;
$output_str .= $eol;
$output_str .= $a3;
$output_str .= $eol;
$output_str .= $a4;
$output_str .= $eol;
$output_str .= $ca;
$output_str .= $eol;
return $output_str;
}
}
?>
<!doctype html>
<html>
<head>
<title>Quiz Searcher - YeHeng.org QuizUtils</title>
</head>
<body>

<h1>YeHeng.org QuizUtils - Quiz Searcher</h1>
<form action="search.aspx" method="post" enctype="multipart/form-data">
<input type="file" name="file">
<input type="hidden" name="post_good" value="yes">
<br />
Search String: <input type="text" name="search" value="" placeholder="Search string"><br />
<h3>Input Platform/Line Seperator selection</h3>
<input type="radio" name="platform" value="linux"> Unix-based platforms and applications that support the \n endings<br />
<input type="radio" name="platform" value="cr"> MS-DOS based platforms and applications that require \r\n endings<br />
<input type="radio" name="platform" value="oldmac"> Really old Macs that use the \r ending<br />
<!--
<h3>Output Platform/Line Seperator selection</h3>
<input type="radio" name="platformo" value="linux"> Unix-based platforms and applications that support the \n endings<br />
<input type="radio" name="platformo" value="cr"> MS-DOS based platforms and applications that require \r\n endings<br />
<input type="radio" name="platformo" value="oldmac"> Really old Macs that use the \r ending<br />
-->
<input type="submit" value="Search with YeHeng.org QuizUtils">
</form>
<?php
if (!isset($_POST['post_good'])) {

return;
}

$LINUX = "\n";
$CR = "\r\n";
$OLDMAC = "\r";
$PLATFORM = "\n";
$OUTPLATFORM = "\n";

//determine platform
if ($_POST["platform"] == 'cr')
$PLATFORM = $CR;
elseif ($_POST["platform"] == 'oldmac')
$PLATFORM = $OLDMAC;

if ($_POST["platformo"] == 'cr')
$OUTPLATFORM = $CR;
elseif ($_POST["platformo"] == 'oldmac')
$OUTPLATFORM = $OLDMAC;

echo "Selected in line seperator: " . $PLATFORM . "</br>";
echo "Selected out line seperator: " . $OUTPLATFORM . "</br>";

$count = 0;
$number = 1;
$qnum = 1;
$question= "";
$a1 = "";
$a2 = "";
$a3 = "";
$a4 = "";
$ca = "";
$cat = "";
$output = "";

$linearr = explode($PLATFORM,file_get_contents($_FILES['file']['tmp_name']));
//print_r($linearr);
foreach ($linearr as $LINE) {
//echo "Number = " . $number . "<br>";
if ($number == 1) {
$question = $LINE;
$number++;

//echo "Hit Line " . $number . " of Question " . $qnum . '<br>'; //not hit
continue;
} elseif ($number==2) {
$a1 = $LINE;
$number++;
//echo "Hit Line " . $number . " of Question " . $qnum . '<br>';
 
}  elseif ($number==3) {
$a2 = $LINE;
$number++;
//echo "Hit Line " . $number . " of Question " . $qnum . '<br>';
 
}  elseif ($number==4) {
$a3 = $LINE;
$number++;
//echo "Hit Line " . $number . " of Question " . $qnum . '<br>';
 
}  elseif ($number==5) {
$a4 = $LINE;
$number++;
//echo "Hit Line " . $number . " of Question " . $qnum . '<br>';
 
}  elseif ($number==6) {
$ca = $LINE;

//echo "Hit Line " . $number . " of Question " . $qnum . '<br>';
switch ($ca) {
case "a":
$cat = $a1;
break;

case "b":
$cat = $a2;
break;
case "c":
$cat = $a3;
break;
case "d":
$cat = $a4;
break;
default:
echo "Weird correct answer: Line " . (count + 1) . "<br />";
echo "Stopping...";
return;

}
if (search($_POST["search"],$question) === true) {
echo "Found match: Question at question " . $qnum . "<br />";
$output .= get_dump($question,$a1,$a2,$a3,$a4,$ca,$OUTPLATFORM);
}
if (search($_POST["search"],$cat) === true) {
echo "Found match: Correct answer at question " . $qnum . "<br />";
$output .= get_dump($question,$a1,$a2,$a3,$a4,$ca,$OUTPLATFORM);

}
$qnum++;
$number = 1;
}
$count++;
}

?>

</body>

</html>

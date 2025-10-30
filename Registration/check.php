<?php
#echo rand(0,10);

$allChars = '';
for ($i = 32; $i <= 126; $i++) {
    $allChars .= chr($i);
}
$pattern=$allChars;
$password=[];
$length=strlen($pattern)-1;

for($i=0;$i<8;$i++){
    $ind=rand(0,$length);
    $password[$i]=$pattern[$ind];
}
#print_r($password);
echo implode($password);

?>
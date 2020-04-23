<?php

$list=[];
$d = dir(".");
while (false !== ($entry = $d->read())) {
if (substr($entry,-4)!='.mkd'){continue;}
$raw=file_get_contents($entry);
extractIndex();
}
$d->close();
sort($list);
foreach($list as $value){
  print "\r\n".$value;
}
echo sizeof($list);

function extractIndex(){
  global $raw,$list;
if (strpos($raw,'\index{')===false){return;}
$p=strpos($raw,'\index{');
  $raw=substr($raw,$p+7)  ;
  $p2=strpos($raw,'}');
  $word=substr($raw,0,$p2);
  $raw=substr($raw,$p2+1);
  $list[$word]=$word;
extractIndex();
}

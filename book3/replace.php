<?php
include('rep.php');
$list=[];
$d = dir(".");
while (false !== ($entry = $d->read())) {
if (substr($entry,-4)!='.mkd'){continue;}
$raw=file_get_contents($entry);
$raw=str_replace('\index{}','',$raw);
foreach ($replace as $row){
  $f='\index{'.$row['find'].'}';
  $r='\index{'.$row['replace'].'}';
  $raw=str_replace($f,$r,$raw);
}
file_put_contents($entry,$raw);
}
$d->close();

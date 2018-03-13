#!//usr/local/bin/php
<?php
$tags=['%','\\','!'];
$filename=$argv[1];
if (substr($filename,-4)=='.mkd'){$filename=substr($filename,0,-4);}

$rows=file($filename.'.mkd');
$tagId=1;
foreach($rows as $i=>$row){
  if (in_array(substr($row,0,1),$tags)) {
    $tagsFile[$tagId]="$tagId $row";
    $rows[$i]="######$tagId\r\n";
    $tagId++;
  }
}
file_put_contents($filename.'.tag',implode("\r\n",$tagsFile));

$snippetId=1;
$snippetFounds='not-found';
foreach($rows as $i=>$row){
  if ((substr($row,0,1)=='~') && ($snippetFounds=='not-found')) {
    $snippetFounds='in-snippet';
    $snippet[]=$row;
    continue;
  }
  if ((substr($row,0,1)=='~') && ($snippetFounds=='in-snippet')) {
    $snippet[]=$row;
    @mkdir("snippet/$filename", 0777, true);
    file_put_contents("snippet/$filename/$snippetId.snippet",implode('',$snippet));

    $newText[]="~~~~$snippetId\r\n";
    unset($snippet);
    $snippetId++;
    $snippetFounds='not-found';
    continue;
  }
  if ($snippetFounds=='in-snippet'){
    $snippet[]=$row;
    continue;
  }

  if ($snippetFounds=='not-found'){
    $newText[]=$row;
  }
}

foreach($newText as $i=>$row){
  if(($i+2)<sizeof($newText)){
  if ((substr($newText[$i+1],0,1)=="=")){$finalText[]=$row;continue;}
  if ((substr($newText[$i],0,1)=="=")){$finalText[]=$row;continue;}
  if ((substr($newText[$i+1],0,1)=="-")){$finalText[]=$row;continue;}
  if ((substr($newText[$i],0,1)=="-")){$finalText[]=$row;continue;}
  if ((substr($newText[$i+1],0,1)=="#")){$finalText[]=$row;continue;}
  if ((substr($newText[$i],0,1)=="#")){$finalText[]=$row;continue;}
  if ((substr($newText[$i+1],0,1)=="~")){$finalText[]=$row;continue;}
  if ((substr($newText[$i],0,1)=="~")){$finalText[]=$row;continue;}
}

  if ((substr($row,-1)=="\n") && @(substr($newText[$i+1],1)=="\n")) {
    $finalText[]=$row;
  } else {
    $finalText[]=str_replace(["\r","\n"],'',$row).' ';
  }
}
file_put_contents($filename.'.txt',implode($finalText));

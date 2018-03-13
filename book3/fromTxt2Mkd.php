#!//usr/local/bin/php
<?php
$tags=['%','\\','!'];
$filename=$argv[1];
if (substr($filename,-4)=='.mkd'){$filename=substr($filename,0,-4);}
if (substr($filename,-4)=='.txt'){$filename=substr($filename,0,-4);}


$raw=file_get_contents($filename.'.txt');
$tagsFile=file($filename.'.tag');

foreach($tagsFile as $line){
  if (strlen($line)<3){continue;}
  $p=strpos($line,' ');
  $tagId=substr($line,0,$p);
  $tag=substr($line,$p+1);
  $raw=str_replace("######$tagId\r\n",$tag,$raw);
}
$d = dir("snippet/$filename/");
while (false !== ($entry = $d->read())) {
  if (substr($entry,-strlen('snippet'))!='snippet'){continue;}
  $snippetId=substr($entry,0,-1-strlen('snippet'));
  $snippet=file_get_contents("snippet/$filename/$entry");
  $raw=str_replace("~~~~$snippetId\r\n",$snippet."\r\n",$raw);
}
$d->close();
file_put_contents("$filename.mkd",$raw);

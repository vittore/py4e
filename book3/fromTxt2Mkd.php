#!//usr/local/bin/php
<?php
$tags=['%','\\','!'];
$filename=$argv[1];
$filenameWithoutExt=substr($filename,0,-4);
$raw=file_get_contents($filename);
$tagsFile=file('tags_'.$filenameWithoutExt.'.tag');

foreach($tagsFile as $line){
  if (strlen($line)<3){continue;}
  $p=strpos(' ',$line);
  $tagId=substr($line,0,$p+1);
  $tag=substr($line,$p+2);
  $raw=str_replace("######$tagId\r\n",$tag,$raw);
}

echo $raw;

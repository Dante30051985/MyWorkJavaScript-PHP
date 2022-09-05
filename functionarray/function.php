<?php
include 'translit.php';

function LoadNote($id, $link)
{
	$files=array();
	$query=mysqli_num_rows(mysqli_query($link, "select * from `gallery` where `id_user`='".$id."'"));
	
	if (!($query)) {return 'Нет не одного медиафайла';}
	else
	{
				$arrayfolderpath=ArrayFolderMedia($link,$id); //массив путей к файлам					
				$files=ArrayFileFolderMedia($arrayfolderpath, $file); //массив файлов
				$files=array_reverse($files);	
				
		
				echo '<div style="position:relative;clear:both;padding:10px;font:10pt tahoma;border-bottom:1px solid #b7b7b7; width:300px;margin:10px;">Последнее медиа</div>';
				for ($i=0;$i<4;$i++)
				{	echo '<div style="position:relative;float:left;">';
					$mimes=getUrlMimeType($_SERVER['DOCUMENT_ROOT'].$files[$i][1]);
					if ($mimes == "image/jpeg")
					{
						$url_media=urlMedia($files[$i][1]);
						
						echo '<a href="/view/'.$url_media.'"><img style="position:relative;float:left;margin-left:5px;margin-bottom:5px;width:165px;height:154px;" src="'.$files[$i][1].'"/></a>';
						echo '<div style="position:absolute;top:130px;color:#fff;left:10px;font:8pt arial;text-shadow:0px 0px 4px #ffe52f;">'.getDateFile($files[$i][0]).'</div>';
					}
					if ($mimes == "video/webm")
					{
						$url_media=urlMedia($files[$i][1]);		
					echo '<a href="/view/'.$url_media.'"><video style="position:relative;float:left;margin-left:5px;margin-bottom:5px;width:165px;height:154px;background:#000;"><source src="'.$files[$i][1].'" /></video></a>';
						echo '<div style="position:absolute;top:130px;color:#fff;left:10px;font:8pt arial;text-shadow:0px 0px 4px #ffe52f;">'.getDateFile($files[$i][0]).'</div>';
					}
					echo '</div>';
					
					
				}
				
			
	
	}			
}
function urlMedia($url)
{
	$re = '/\/users\/id[0-9]\/gallery\/(.*)\/(.*).(webm|jpg)/m';
	preg_match_all($re, $url, $matches, PREG_SET_ORDER, 0);
	return $matches[0][2];
}

 function getDateFile($url)
{
	
		$month_list=array(
		1 => 'янв.',
	2 => 'фев.',
	3 => 'марта',
	4 => 'апр.',
	5 => 'мая',
	6 => 'июня',
	7 => 'июля',
	8 => 'августа',
	9 => 'сент.',
	10 => 'окт.',
	11 => 'нояб.',
	12 => 'дек.'
	);
	
	 $newDate = date(('d') . ' ' . $month_list[date('n')] . ' ' . date('Y').' H:i',$url);
	 return $newDate;
 }

function getUrlMimeType($url)
    {
        $buffer = file_get_contents($url);
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        return $finfo->buffer($buffer);
    }


function ArrayFileFolderMedia($arrayfolderpath,$file)
{
		$result=[];
		for ($i=0;$i<count($arrayfolderpath['path']);$i++)
		{			
		foreach (glob($_SERVER['DOCUMENT_ROOT'].$arrayfolderpath['path'][$i].'/*.*') as $fs)
			{	
			 $result[]=[filemtime($fs),$fs];
			}
		}
		
		for($x=0;$x<count($result);$x++)
		{
			$re = '/\/users\/id[0-9]\/gallery\/(.*)\/(.*)/m';
			preg_match_all($re, $result[$x][1], $matches, PREG_SET_ORDER, 0);
			$array[]=[filemtime($result[$x][1]),$matches[0][0]];
		}
		sort($array);	
	return $array;
}

function ArrayFolderMedia($link,$id)
{
$query=mysqli_query($link, "select * from `gallery` where `id_user`='".$id."'");
		while ($mediaFile=mysqli_fetch_array($query))
			{
				$files['path'][]=$mediaFile['path_folder'];
				$files['name'][]=$mediaFile['name_folder'];
				$files['root'][]=$mediaFile['root'];
				$files['userid'][]=$mediaFile['id_user'];
			}
	return $files;
}
?>

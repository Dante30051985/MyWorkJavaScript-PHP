<?php
include $_SERVER['DOCUMENT_ROOT'].'/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/phpScript/translit.php';


if (isset($_POST['photo']) && isset($_POST['folder']) && isset($_POST['path']) && isset($_POST['userid']))
{

	$photo=htmlspecialchars($_POST['photo']);
	$folder=htmlspecialchars($_POST['folder']);
	$path=htmlspecialchars($_POST['path']);
	$userid=htmlspecialchars($_POST['userid']);


$result=createfolder($link, $photo,$folder,$path, $userid);
echo $result;

}

function createfolder($link, $photo, $folder, $path, $userid)
{	
		$query=mysqli_fetch_row(mysqli_query($link, "select * from `gallery` where `id_user`='".$userid."'"));
		
		$dir_user=$_SERVER['DOCUMENT_ROOT'].'/users/id'.$userid.'/gallery/noname';
		$small_path='/users/id'.$userid.'/gallery/noname';
		$emptyFolder='noname';
		
				if (!($query)){
				          mkdir($dir_user, 0777,true);
					      mysqli_query($link,"INSERT INTO `gallery` (`id`, `id_user`, `name_folder`, `root`,  `path_folder`) VALUES 	(NULL, '".$userid."', '".$emptyFolder."', '0','".$small_path."' )");						
					   $imgData = str_replace(' ','+',$photo);
					   $imgData =  substr($imgData,strpos($imgData,",")+1);
					   $imgData = base64_decode($imgData);	
					   $integer=random_int(100000, 999999);
					   $filePath =$dir_user.'/photo'.$integer.'.jpg';
					   $file = fopen($filePath, 'w');;
					   fwrite($file, $imgData);
					   fclose($file);	
					   return $result='Создана папка "noname" с медиафайлами."'.$namefolder.'"';
						} 
				else {
						
						if (!($folder)){	
							   $imgData = str_replace(' ','+',$photo);
							   $imgData =  substr($imgData,strpos($imgData,",")+1);
							   $imgData = base64_decode($imgData);	
						       $integer=random_int(100000, 999999);
						       $file = fopen($filePath, 'w');
									
							   fwrite($file, $imgData);
							   fclose($file);	
							   return $result='Новая фотография в папке "noname" - '.'photo.'.$integer.'.jpg';			
									  } else
									  {
							   $dir_user=$_SERVER['DOCUMENT_ROOT'].$path;
                     		   $imgData = str_replace(' ','+',$photo);
					 		   $imgData =  substr($imgData,strpos($imgData,",")+1);
					           $imgData = base64_decode($imgData);	
						       $integer=random_int(100000, 999999);
						       $filePath =$dir_user.'/photo'.$integer.'.jpg';
							   $file = fopen($filePath, 'w');
							
							   fwrite($file, $imgData);
							   fclose($file);	
							   return $result='Новая фотография в папке "photo'.$integer.'.jpg"';
									 }
						}
}


?>
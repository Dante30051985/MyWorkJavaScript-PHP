<?php
	include $_SERVER['DOCUMENT_ROOT'].'/db.php';

if (isset($_FILES) && isset($_POST['userid']) && isset($_POST['folder']) && isset($_POST['path']))
	{
		$userid=htmlspecialchars($_POST['userid']);
		$path=htmlspecialchars($_POST['path']);
		$folder=htmlspecialchars($_POST['folder']);
	
		$file=$_FILES['file']['name'];
		$typeFile=$_FILES['file']['type'];
		$tmpFile=$_FILES['file']['tmp_name'];

$result=uploadVideo($userid,$path,$folder,$file,$tmpFile);		
echo $result;

	}
	
function uploadVideo($userid,$path,$folder,$file,$tmpFile)
{
	$query=mysqli_fetch_row(mysqli_query($link, "select * from `gallery` where `id_user`='".$userid."'"));
		
		$dir_user=$_SERVER['DOCUMENT_ROOT'].'/users/id'.$userid.'/gallery/noname';
		$small_path='/users/id'.$userid.'/gallery/noname';
		$emptyFolder='noname';
	    $uploadFile=$dir_user.'/'.basename($file);
		
				if (!($query)){
				          mkdir($dir_user, 0777,true);
					      mysqli_query($link,"INSERT INTO `gallery` (`id`, `id_user`, `name_folder`, `root`,  `path_folder`) VALUES 	(NULL, '".$userid."', '".$emptyFolder."', '0','".$small_path."' )");	
						  
					if (move_uploaded_file($tmpFile, $uploadFile))
							{	return 'Видеозапись '.$file.' успешно добавлена в '.$folder;}  else {
								return 'Произошла ошибка! Во время загрузки видеозаписи'.$file;
							}
						}
						
				 else {
						
						if (!($folder)){	
							   	if (move_uploaded_file($tmpFile, $uploadFile))
							{	return 'Видеозапись '.$file.' успешно добавлена в '.$folder;}  else {
								return 'Произошла ошибка! Во время загрузки видеозаписи'.$file;
							}		
									  } else
									  {
							   	if (move_uploaded_file($tmpFile, $uploadFile))
							{	return 'Видеозапись '.$file.' успешно добавлена в '.$folder;}  else {
								return 'Произошла ошибка! Во время загрузки видеозаписи'.$file;
							}
										 }
				}

}

	
	

		
	
	
?>

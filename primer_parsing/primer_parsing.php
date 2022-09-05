<?php
require_once 'simple_html_dom.php';

$page=5;


$link=[];
$smallUrl='http://rustorrents.net/';




function pageLink(){
for($i=29;$i<41;$i++)
{
$url ='http://rustorrents.net/index.php?page='.$i.'&genre=80';
$ch = curl_init(); // Создаём запрос
curl_setopt($ch, CURLOPT_URL, $url); // Настраиваем URL запроса
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Задаём в качестве возвращаемого значение от ответа строку
$res = curl_exec($ch); // Отправляем запрос

$dom = new simple_html_dom(); // Создаём объект класса simple_html_dom
$html = str_get_html($res); // Берём из строки HTML
	
	// Находим элемент по селектору
$list = $html -> find('a.linktext_torrents');
 
// Выводим всё элементы
foreach ($list as $key => $value) {
  $arrayLink[]=$smallUrl.$value->href;
}
}
$html->clear(); 
unset($html);

return $rez=$arrayLink;
}



function pageLink2($ArrayLink){
for($i=0;$i<count($ArrayLink);$i++)
{
$url ='http://rustorrents.net/'.$ArrayLink[$i];
$res=file_get_contents($url);

//$ch = curl_init(); // Создаём запрос
//curl_setopt($ch, CURLOPT_URL, $url); // Настраиваем URL запроса
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Задаём в качестве возвращаемого значение от ответа строку
//$res = curl_exec($ch); // Отправляем запрос

$dom = new simple_html_dom(); // Создаём объект класса simple_html_dom
$html = str_get_html($res); // Берём из строки HTML
	
	// Находим элемент по селектору
$list = $html -> find('a.linktext');
 
// Выводим всё элементы
foreach ($list as $key => $value) {
 $link[]=$value->href;
}
}

return $rez=$link;

}

$ArrayLink=pageLink();
$result=pageLink2($ArrayLink);


$re = '/download.php.id=(.*)/m';

for ($a=0;$a<count($result);){
//	$str=array_search('download.php?id=33984',$result[$a]);
//	echo $str;
preg_match_all($re, $result[$a], $matches, PREG_SET_ORDER, 0);
if (!empty($matches)){$res[]=$matches;}
$a++;
}

//копирование нужных значений в массив
for ($z=1;$z<count($res);$z++)
{
	if ($res[$z-1][0][0] !== $res[$z][0][0]) {$mas[]=$res[$z];} 
	
	
}

//приводим в порядок массив для удобства работы с ним
for ($a=0;$a<count($mas);$a++)
{
	$endRez[]=$mas[$a][0][0];
}

//конечный результат
for ($ind=0;$ind<count($endRez);$ind++)
{
 echo '<input type="checkbox"/><a href="'.$smallUrl.$endRez[$ind].'" download/>'.$endRez[$ind].'</br>';
}





  


?>

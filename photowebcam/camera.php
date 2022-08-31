<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1"> 

<title>Режим фотографирования</title>
  
<link rel="stylesheet" href="/css/page.css">
<link rel="stylesheet" href="/css/camera.css">


<script src="/js/jquery.js"></script> 
 <script src="./phpScript/camera/js/camera.js"></script> 

 </head>
 <body>

<div  style="position:relative;float:left;width:100%;height:50px;background:#000;">
<img id="fscreen_camera" src="/bitmap/fullscreen.png"/>
<div id="serviceCamera"><a href="camera/service"> <img src="/bitmap/serviceCamera.png"/></a></div>
<div style="position:relative;width:35px;top:5px;left:50px;"><a style="width:inherit;" href="https://mobile.mysabrina.ru"><img style="width:inherit;" src="/bitmap/home.png"/></a></div>
</div>

<div id="containerCamera">
<video id="cameraStream"></video>
<video id="videoRecorded"></video>
</div>

<div style="position:relative;float:left;background:#000;width:100%;">
<ul id="listMode">
<li id="photos" class="ActiveMode">Фотография</li>
<li class="noActiveMode">Видео</li>
</ul>



<div id="rotateCamera"></div>

<div id="takingShot"></div>
<div class="photoSmartphone"></div>


<div id="recordShot"><div style="top:22px;left:23px;border-radius:50px;position:relative;width:40px;height:40px;background:red;"></div></div>
<div id="recrodStop"><div style="top:22px;left:23px;position:relative;width:40px;height:40px;background:#fff;"></div></div>


<div class="videoSmartphone"><video id="pRecordVideo"  style="display:none;"></video></div>
</div>
 </body>
 </html>
 

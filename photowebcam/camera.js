$(document).ready(function()
    {
        var arrayInputVideoCamera=[];
        var currentVideoCamera=[];
        var currentStream;
        var element,ActiveModeElement;
        var img;
        var CurrentRecordStream=localStorage.getItem('currentRecordStream'); 

function init()
    {
        navigator.mediaDevices.enumerateDevices().then(gotDevices).then(startCamera);

document.getElementById('takingShot').addEventListener('click', function()
    {  
	    snapShot();
    	});
	
    }

document.getElementById('listMode').addEventListener('click', function(e)
{
	element=e.path[1].children[1];
	if(element.previousElementSibling)
		element.parentNode.insertBefore(element, element.previousElementSibling);
		element.classList.remove('noActiveMode');
				element.classList.add('ActiveMode');
		ActiveModeElement=element.nextSibling;
		ActiveModeElement.classList.remove('ActiveMode');
		ActiveModeElement.classList.add('noActiveMode');
	
	if (element.outerText == 'Видео')
		{
			$('#takingShot').css('display','none');
			$('.photoSmartphone').css('display','none');
			$('#recordShot').css('display','block');
			$('.videoSmartphone').css('display','block');
			stopMediaTracks(currentStream);
			$('#cameraStream').css('display','none');
			$('#videoRecorded').css('display','block');
			
			
					if (typeof currentStream !== 'undefined') {
                    stopMediaTracks(currentStream);
        }
			$.getScript('/phpScript/camera/js/cameraRecordVideo.js')
			}
				else {
						$('#takingShot').css('display','block');
						$('.photoSmartphone').css('display','block');
						$('#recordShot').css('display','none');
						$('.videoSmartphone').css('display','none');
						$('#cameraStream').css('display','block');
						$('#videoRecorded').css('display','none');
						
						startCamera();
						}
});

document.getElementById('fscreen_camera').addEventListener('click', function()
{
	if (document.fullscreen)
			{
				document.exitFullscreen();
					document.getElementById('containerCamera').style.height='338px';
				
			}
		else
			{
				document.documentElement.requestFullscreen();
				document.getElementById('containerCamera').style.height='515px';
			}
			
});

function stopRecordMediaTracks(CurrentRecordStream) {
	CurrentRecordStream.getTracks().forEach(track => {
    track.stop();
  });
}

function stopMediaTracks(currentStream) {
	currentStream.getTracks().forEach(track => {
    track.stop();
  });
}

document.getElementById('rotateCamera').addEventListener('click', function(){			
	if (typeof currentStream !== 'undefined') {
                    stopMediaTracks(currentStream);
        }
		if (currentVideoCamera['camera'] == arrayInputVideoCamera[0])
		{	currentVideoCamera=[];
			currentVideoCamera['camera'] = arrayInputVideoCamera[1];
			startCamera();
		} else
		{
			currentVideoCamera=[];
			currentVideoCamera['camera'] = arrayInputVideoCamera[0];
			startCamera();
		}
		

	});

function startCamera()
{
	var current_camera=currentVideoCamera['camera'];
    var constraints={video: { deviceId: current_camera }, width: 8000,height:6000};
	


	
	navigator.mediaDevices.getUserMedia(constraints).then(function(mediaStream) {
		var video = document.querySelector('video');		
			currentStream =mediaStream;
			video.srcObject = currentStream;
			video.onloadedmetadata = function(e) {
			
			video.play();
			  
			};
			
			}).catch(function(err) { console.log(err.name + ": " + err.message); });           	
}

init();

async function gotDevices(mediaDevices) 
{
		arrayInputVideoCamera.length=0;
		mediaDevices.forEach(mediaDevice => {
			if (mediaDevice.kind === 'videoinput') {
			arrayInputVideoCamera.push(mediaDevice.deviceId);
			}	
		})
		currentVideoCamera['camera']=arrayInputVideoCamera[0];
	

}
   
function snapShot(count_img){
    var video = document.querySelector('video')
      , canvas; 
    var context;
    var width = video.offsetWidth
        , height = video.offsetHeight;
	var
		audioPhoto = new Audio();
		audioPhoto.src = '/mp3/photocamera.mp3';
		audioPhoto.autoplay = true;

      canvas = canvas || document.createElement('canvas');
      $('#photog').remove();
      canvas.width = width;
      canvas.height = height;
      context = canvas.getContext('2d');
	  context.clearRect(0, 0, canvas.width, canvas.height);
      context.drawImage(video, 0, 0, width, height);
      img = canvas.toDataURL('image/jpeg');
	  $('.photoSmartphone').append('<img id="photog" style="width:85px;height:85px;border-radius:45px;object-fit:fill;" src="'+img+'"/>');
	
		var fd=new FormData();
	fd.append('photo',img);
	fd.append('folder',localStorage.getItem('folder'));
	fd.append('path', localStorage.getItem('path'));
	fd.append('userid', sessionStorage.getItem('userid'));
	
	
	xhr = new XMLHttpRequest();
	xhr.open("post","/phpScript/camera/publicPhoto.php");
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
					console.log(xhr.response);
					}
		
	}
		xhr.send(fd);	
}
})


	

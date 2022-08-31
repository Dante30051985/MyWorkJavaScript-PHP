$(document).ready(function()
{   var arrayInputVideoCamera=[];
    var currentVideoCamera=[];

				var options = {mimeType: 'video/webm; codecs=vp9'};
				var recordedChunks = []; // будет держать записанный поток
				var recordedBlobs = [];
                let CurrentRecordStream;
                initVideoRecord();
                let recoder;

					
function initVideoRecord(){
    navigator.mediaDevices.enumerateDevices().then(gotDevices).then(startCamera);}

 function stopMediaTracksRecord(CurrentRecordStream) {
	CurrentRecordStream.getTracks().forEach(track => {
    track.stop();
  });
}

document.getElementById('listMode').addEventListener('click',function()
{
	     stopMediaTracksRecord(CurrentRecordStream);
	});

 
document.getElementById('rotateCamera').addEventListener('click', function(){			
	if (typeof CurrentRecordStream !== 'undefined') {
            stopMediaTracksRecord(CurrentRecordStream);
			}
	if (currentVideoCamera['camera'] == arrayInputVideoCamera[0])
		{currentVideoCamera=[];
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
    var constraints={audio:true, video: { deviceId: current_camera }, width: 8000,height:6000};
	navigator.mediaDevices.getUserMedia(constraints).then(function(mediaStream) {
	var video = document.getElementById('videoRecorded');		
		CurrentRecordStream =mediaStream;
		localStorage.setItem('currentRecordStream',CurrentRecordStream);
		video.srcObject = CurrentRecordStream;
			
		video.onloadedmetadata = function(e) {
		video.play();
		};
			
	}).catch(function(err) { console.log(err.name + ": " + err.message); });           	
}

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


function startRecord(CurrentRecordStream, recordedChunks)
{
  try {
    mediaRecorder = new MediaRecorder(CurrentRecordStream);
	recoder=mediaRecorder;
	recordedBlobs=[];
  } catch (e) {
    console.error('Exception while creating MediaRecorder: ' + e);
    return;
  }
  	
  mediaRecorder.ondataavailable = handleDataAvailable;
  mediaRecorder.start(5);

  $('#recrodStop').css('display','block');	
  $('#recordShot').css('display','none');

}

function handleDataAvailable(event) {
  if (event.data && event.data.size > 0) {
    recordedBlobs.push(event.data);
	}
}

function handleStop(event) {
  console.log('Recorder stopped: ', event);
}

function stopRecording() {
  mediaRecorder.stop();
  	$('#recordShot').css('display','block');
sendVideoGallery(recordedBlobs);
}
	
document.getElementById('recordShot').addEventListener('click', function()
{
	startRecord(CurrentRecordStream, recordedChunks);
});

document.getElementById('recrodStop').addEventListener('click', function()
{
	stopRecording(CurrentRecordStream);
	$('#recrodStop').css('display','none');
	recordSnap();
});


function recordSnap(){
    var video = document.getElementById('videoRecorded')
      , canvas; 
    var context;
    var width = video.offsetWidth
        , height = video.offsetHeight;
	var
      canvas = canvas || document.createElement('canvas');
      $('#videoPrev').remove();
      canvas.width = width;
      canvas.height = height;
      context = canvas.getContext('2d');
	  context.clearRect(0, 0, canvas.width, canvas.height);
      context.drawImage(video, 0, 0, width, height);
      img = canvas.toDataURL('image/jpeg');
	  $('.videoSmartphone').append('<img id="videoPrev" style="width:85px;height:85px;border-radius:45px;object-fit:fill;" src="'+img+'"/>');



document.getElementById('videoPrev').addEventListener('click',function()
{
	
})
}

function sendVideoGallery(recordedBlobs)
{
	var formData=new FormData();
	var blob = new Blob(recordedBlobs, {type: 'video/webm'});
	var random=Math.floor(Math.random()*100000);
	var file='video'+random+'.webm';
	formData.append('file', blob, file);
	formData.append('userid', sessionStorage.getItem('userid'));
	formData.append('path', localStorage.getItem('path'));
	formData.append('folder', localStorage.getItem('folder'));
				
	xhr = new XMLHttpRequest();
	xhr.open("post","/phpScript/camera/upload_recordvideo.php?id="+sessionStorage.getItem('userid'));
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				console.log(xhr.response);		
					}
	}

    xhr.send(formData);
  }
});

'use strict';

var chunkCounter = 0; 
var videoId = "";
var playerUrl = "";
var filename = "";
var inputField = document.getElementById("resourceFile");
	  
inputField.addEventListener('change', () => {
	const file = inputField.files[0];

	var numberofChunks = Math.ceil(file.size/chunkSize);
	var start = 0; 
	var chunkEnd = start + chunkSize;

	chunkCounter = 0;
	videoId = "";
	filename = inputField.files[0].name;

	//upload the first chunk to get the videoId
	createChunk(videoId, start);

	function createChunk(videoId, start, end)
	{
		chunkCounter++;
		chunkEnd = Math.min(start + chunkSize , file.size );
		//Slice a chunk of the file
		const chunk = file.slice(start, chunkEnd);

		//Create a form to send data
		const chunkForm = new FormData();

		//If videoId is not set then set it
		if(videoId.length != 0)
		{
			chunkForm.append('videoId', videoId);	
		}

		//Add chunk to form
		chunkForm.append('file', chunk, filename);

		uploadChunk(chunkForm, start, chunkEnd);
	}

	function uploadChunk(chunkForm, start, chunkEnd)
	{
		var httpRequest = new XMLHttpRequest();
		var blobEnd = chunkEnd-1;
		var contentRange = "bytes " + start + "-" + blobEnd + "/" + file.size;

		httpRequest.upload.addEventListener("progress", updateProgress);	
		httpRequest.open("POST", url, true);
		
		httpRequest.setRequestHeader("Content-Range",contentRange);
		httpRequest.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);

		function updateProgress (event) 
		{
			if (event.lengthComputable) 
			{  
				var percentComplete = Math.round(event.loaded / event.total * 100);
				
				var totalPercentComplete = Math.round((chunkCounter -1)/numberofChunks*100 +percentComplete/numberofChunks);

				//Update progress bar
				document.getElementById("progressBar").style.width = totalPercentComplete + "%";
			} 
		}

		httpRequest.onload = function (event) {
			console.log(httpRequest.response);


			var resp = JSON.parse(httpRequest.response)
			videoId = resp.videoId;
			
			//Create a new chunk, offset the start pointer with the chunkSize to get the next chunk
			start += chunkSize;	
			
			//If start is lower than the size of the whole file it means the file is not completley done
			if(start < file.size)
			{
				//Create a new chunk from the new start
				createChunk(videoId, start);
			}
			else
			{
				//File is fully uploaded then update the view
				document.getElementById("progressBar").style.width = "0%";
				document.getElementById("uploadedFiles").innerHTML += '<p class="card-text">' + filename + '</p>';

				if(document.getElementById("thumbnail") != null)
					document.getElementById("thumbnail").innerHTML += '<option value="' + videoId + '">' + filename + '</option>';

				if(document.getElementById("video") != null)
					document.getElementById("video").innerHTML += '<option value="' + videoId + '">' + filename + '</option>';

				if(document.getElementById("trailer") != null)
					document.getElementById("trailer").innerHTML += '<option value="' + videoId + '">' + filename + '</option>';
			}				
		};

		httpRequest.send(chunkForm);				
	}	
});

function updateFileLabel(id) 
{
	files = document.getElementById(id).value.split('\\');
	file = files[files.length - 1];

	//Update label
	document.getElementById(id).labels[0].textContent = file;
}   
'use strict';

class FileUpload {
	/**
	 * Constructor class
	 * @param {String} inputFieldId id of the input field where the user will upload the file
	 * @param {String} url API endpoint used to store the file
	 * @param {Number} chunkSize size of a single chunk (bytes)
	 */
	constructor(inputFieldId, url, chunkSize) {
		this.chunkCounter = 0;
		this.videoId = "";
		this.playerUrl = "";
		this.fileName = "";
		this.inputField = document.getElementById(inputFieldId);
		this.file = null;
		this.numberofChunks = null;
		this.start = null;
		this.chunkEnd = null;
		this.url = url;
		this.chunkSize = chunkSize;
		this.inputField.addEventListener('change', this.fileUpload.bind(this));
	}

	fileUpload() {
		this.file = this.inputField.files[0];
		this.numberofChunks = Math.ceil(this.file.size/this.chunkSize);
		this.start = 0;
		this.chunkEnd = this.start + this.chunkSize;
		this.chunkCounter = 0;
		this.videoId = "";
		this.fileName = this.file.name;
		this.createChunk();
	}

	createChunk() {
		this.chunkCounter++;
		this.chunkEnd = Math.min(this.start + this.chunkSize , this.file.size);
		//Slice a chunk of the file
		const chunk = this.file.slice(this.start, this.chunkEnd);

		//Create a form to send data
		const chunkForm = new FormData();

		//If videoId is not set then set it
		if(this.videoId.length != 0)
			chunkForm.append('videoId', this.videoId);	

		//Add chunk to form
		chunkForm.append('file', chunk, this.fileName);

		this.uploadChunk(chunkForm);
	}

	uploadChunk(chunkForm) {
		let httpRequest = new XMLHttpRequest();
		let blobEnd = this.chunkEnd - 1;
		let contentRange = "bytes " + this.start + "-" + blobEnd + "/" + this.file.size;

		httpRequest.upload.addEventListener("progress", this.updateProgress.bind(this));	
		httpRequest.open("POST", this.url, true);
		
		httpRequest.setRequestHeader("Content-Range", contentRange);
		httpRequest.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);

		//Save the class object to self, to be used inside onload (this refers to XMLHttpRequest inside the onload)
		let self = this;

		httpRequest.onload = function () {
			let resp = JSON.parse(httpRequest.response)
			self.videoId = resp.videoId;
			
			//Create a new chunk, offset the start pointer with the chunkSize to get the next chunk
			self.start += self.chunkSize;	

			//If start is lower than the size of the whole file it means the file is not completley done
			if(self.start < self.file.size)
			{
				//Create a new chunk from the new start
				self.createChunk();
			}
			else
			{
				//File is fully uploaded then update the view
				document.getElementById("progressBar").style.width = "0%";

				if(document.getElementById("uploadedFiles") != null)
					document.getElementById("uploadedFiles").innerHTML += '<p class="card-text">' + self.fileName + '</p>';

				if(document.getElementById("thumbnail") != null)
					document.getElementById("thumbnail").innerHTML += '<option value="' + self.videoId + '">' + self.fileName + '</option>';

				if(document.getElementById("video") != null)
					document.getElementById("video").innerHTML += '<option value="' + self.videoId + '">' + self.fileName + '</option>';

				if(document.getElementById("trailer") != null)
					document.getElementById("trailer").innerHTML += '<option value="' + self.videoId + '">' + self.fileName + '</option>';
			}				
		};

		//Update the data modified inside onload
		this.videoId = self.videoId;
		this.start = self.start;

		httpRequest.send(chunkForm);				
	}	

	updateProgress(event) {
		if (event.lengthComputable) 
		{  
			var percentComplete = Math.round(event.loaded / event.total * 100);
			var totalPercentComplete = Math.round((this.chunkCounter -1)/this.numberofChunks*100 +percentComplete/this.numberofChunks);

			//Update progress bar
			document.getElementById("progressBar").style.width = totalPercentComplete + "%";
		} 
	}
}
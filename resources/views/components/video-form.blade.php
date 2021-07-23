    <div class="form-group">
        <label for="platformVideo">Select video platform</label><br>

        <select name="platformVideo" class="custom-select" onchange="switchVideoOption('platformVideo', 'videoFields')" id="platformVideo">
            <option value="{{config('app.storage_disk')}}" @if (old('platformVideo') == config('app.storage_disk')) selected @endif>HTML5</option>
            <option value="vimeo" @if (old('platformVideo') == "vimeo") selected @endif>Vimeo</option>
            <option value="youtube" @if (old('platformVideo') == "youtube") selected @endif>YouTube</option>
        </select>
    </div>
</div>

<div class="col-md-6" id="videoFields">
    <div class="form-group" style="display: none" id="videoId">
        <label for="videoIdField">Video ID</label><br>
        <input type="text" name="videoId" class="form-control" id="videoIdField" value="{{ old('videoId') }}">
        @error('videoId')
            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group" id="uploadVideo">
        <label for="video">Video</label>

        <select id="video" name="video" class="custom-select" required>
            <option></option>
        </select>
        
        @error('video')
            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
        @enderror
    </div>

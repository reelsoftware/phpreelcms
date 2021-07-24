<div class="form-group" @if($content['storage'] == 'local' || $content['storage'] == 's3') style="display: none" @endif id="videoId">
    <label for="videoIdField">Video ID</label><br>
    <input type="text" name="videoId" class="form-control" id="videoIdField" @if($content['storage'] == 'youtube' || $content['storage'] == 'vimeo') value="{{ old('videoId') ? old('videoId') : $content['name'] }}" @endif>
    @error('videoId')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>

<div class="form-group" @if($content['storage'] == 'youtube' || $content['storage'] == 'vimeo') style="display: none" @endif id="uploadVideo">
    <label for="video">Video</label>

    <select id="video" name="video" class="custom-select">
        <option></option>
    </select>
    
    @error('video')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>
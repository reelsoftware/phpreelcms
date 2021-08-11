
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

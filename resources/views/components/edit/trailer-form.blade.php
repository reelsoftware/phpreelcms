<div class="form-group" @if($content['storage'] == 'local' || $content['storage'] == 's3') style="display: none" @endif id="trailerId">
    <label for="trailerIdField">Trailer video ID</label><br>
    <input type="text" name="trailerId" class="form-control" id="trailerIdField" @if($content['storage'] == 'youtube' || $content['storage'] == 'vimeo') value="{{ old('trailerId') ? old('trailerId') : $trailer['name'] }}" @endif>
    @error('trailerId')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>

<div class="form-group" @if($content['storage'] == 'youtube' || $content['storage'] == 'vimeo') style="display: none" @endif id="uploadTrailer">
    <label for="trailer">Trailer</label>

    <select id="trailer" name="trailer" class="custom-select">
        <option></option>
    </select>
    
    @error('trailer')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>
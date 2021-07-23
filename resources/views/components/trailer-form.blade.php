    <div class="form-group">
        <label for="platformTrailer">Select trailer platform</label><br>

        <select name="platformTrailer" class="custom-select" onchange="switchVideoOption('platformTrailer', 'trailerFields')" id="platformTrailer">
            <option value="{{config('app.storage_disk')}}" @if (old('platformTrailer') == config('app.storage_disk')) selected @endif>HTML5</option>
            <option value="vimeo" @if (old('platformTrailer') == "vimeo") selected @endif>Vimeo</option>
            <option value="youtube" @if (old('platformTrailer') == "youtube") selected @endif>YouTube</option>
        </select>
    </div>
</div>

<div class="col-md-6" id="trailerFields">
    <div class="form-group" style="display: none" id="trailerId">
        <label for="trailerIdField">Trailer video ID</label><br>
        <input type="text" name="trailerId" class="form-control" id="trailerIdField" value="{{ old('trailerId') }}">
        @error('trailerId')
            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group" id="uploadTrailer">
        <label for="trailer">Trailer</label>

        <select id="trailer" name="trailer" class="custom-select" required>
            <option></option>
        </select>
        
        @error('trailer')
            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
        @enderror
    </div>

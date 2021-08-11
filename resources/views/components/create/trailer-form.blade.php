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

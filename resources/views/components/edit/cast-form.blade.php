<div class="form-group">
    <label for="cast">Cast</label>
    <input type="text" name="cast" class="form-control" id="cast" value="{{ old('cast') ? old('cast') : $content['cast'] }}" required maxlength="500">
    @error('cast')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>
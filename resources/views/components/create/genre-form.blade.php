<div class="form-group">
    <label for="genre">Genre</label>
    <input type="text" name="genre" class="form-control" id="genre" value="{{ old('genre') }}" required maxlength="500">
    @error('genre')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>
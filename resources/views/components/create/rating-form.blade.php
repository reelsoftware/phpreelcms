<div class="form-group">
    <label for="rating">Rating</label>
    <input type="text" name="rating" class="form-control" id="rating" value="{{ old('rating') }}" required maxlength="25">
    @error('rating')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>
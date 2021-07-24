<div class="form-group">
    <label for="rating">Rating</label>
    <input type="text" name="rating" class="form-control" id="rating" required maxlength="25" value="{{ old('rating') ? old('rating') : $content['rating'] }}">
    @error('rating')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>
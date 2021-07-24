<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" name="description" rows="3" required maxlength="500">{{ old('description') ? old('description') : $content['description'] }}</textarea>
    @error('description')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>     
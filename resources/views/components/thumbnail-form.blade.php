<div class="form-group">
    <label for="thumbnail">Thumbnail</label>

    <select id="thumbnail" name="thumbnail" class="custom-select" required>
        <option></option>
    </select>

    @error('thumbnail')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>

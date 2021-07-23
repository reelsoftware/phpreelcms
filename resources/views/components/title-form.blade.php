<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" required maxlength="255">
    @error('title')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>

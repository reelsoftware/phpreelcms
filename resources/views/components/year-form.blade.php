<div class="form-group">
    <label for="year">Year</label>
    <input type="number" name="year" class="form-control" id="year" value="{{ old('year') }}" required min="0">
    @error('year')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>
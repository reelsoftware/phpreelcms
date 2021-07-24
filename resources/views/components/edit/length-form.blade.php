<div class="form-group">
    <label for="length">Length</label>
    <input type="text" name="length" class="form-control" id="length" required value="{{ old('length') ? Utilities::timeHMS(old('length')) : Utilities::timeHMS($content['length']) }}" required pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]" placeholder="e.g 01:20:59">
    @error('length')
        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="public">Select visibility</label><br>

    <select name="public" class="custom-select" id="platform">
        <option value="0" @if (old('public') == 0 || $content['public'] == 0) selected @endif>Private</option>
        <option value="1" @if (old('public') == 1 || $content['public'] == 1) selected @endif>Public</option>
    </select>
</div>
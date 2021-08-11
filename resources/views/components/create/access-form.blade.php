<div class="form-group">
    <label for="access">Access</label><br>

    <select name="access" class="custom-select">
        <option value="1" @if (old('access') != null && old('access') == 1) selected @endif>Requires authentication to view the content</option>
        <option value="0" @if (old('access') != null && old('access') == 0) selected @endif>Available without authentication</option>
    </select>
</div>

<div class="form-group">
    <label for="access">Access</label><br>

    <select name="access" class="custom-select">
        <option value="0" @if (old('access') == 0 || $content['access'] == 0) selected @endif>Available without authentication</option>
        <option value="1" @if (old('access') == 1 || $content['access'] == 0) selected @endif>Requires authentication to view the content</option>
    </select>
</div>
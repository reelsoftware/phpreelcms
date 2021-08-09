<div class="form-group">
    <label for="access">Access</label><br>

    <select name="access" class="custom-select">
        <option value="0" @if ($content['auth'] == 0) selected @endif>Available without authentication</option>
        <option value="1" @if ($content['auth'] == 1) selected @endif>Requires authentication to view the content</option>
    </select>
</div>
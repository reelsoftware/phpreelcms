<div class="form-group">
    <label for="availability">Availability</label><br>

    <select name="availability" class="custom-select" onchange="updateAccess()" id="availability">
        <option value="0" @if (old('availability') == 0 || $content['availability'] == 0) selected @endif>Subscription</option>
        <option value="1" @if (old('availability') == 1 || $content['availability'] == 0) selected @endif>Free</option>
    </select>
</div>
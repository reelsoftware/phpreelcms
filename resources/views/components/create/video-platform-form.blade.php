<div class="form-group">
    <label for="platformVideo">Select video platform</label><br>

    <select name="platformVideo" class="custom-select" onchange="switchVideoOption('platformVideo', 'videoFields')" id="platformVideo">
        <option value="{{config('app.storage_disk')}}" @if (old('platformVideo') == config('app.storage_disk')) selected @endif>HTML5</option>
        <option value="vimeo" @if (old('platformVideo') == "vimeo") selected @endif>Vimeo</option>
        <option value="youtube" @if (old('platformVideo') == "youtube") selected @endif>YouTube</option>
    </select>
</div>
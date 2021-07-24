<div class="form-group">
    <label for="platformTrailer">Select trailer platform</label><br>

    <select name="platformTrailer" class="custom-select" onchange="switchVideoOption('platformTrailer', 'trailerFields', true)" id="platformTrailer">
        <option value="{{config('app.storage_disk')}}" @if (old('platformTrailer') == config('app.storage_disk') || $content['storage'] == config('app.storage_disk')) selected @endif>HTML5</option>
        <option value="vimeo" @if (old('platformTrailer') == "vimeo" || $content['storage'] == "vimeo") selected @endif>Vimeo</option>
        <option value="youtube" @if (old('platformTrailer') == "youtube" || $content['storage'] == "youtube") selected @endif>YouTube</option>
    </select>
</div>
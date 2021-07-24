<div class="form-group">
    <label for="platformTrailer">Select trailer platform</label><br>

    <select name="platformTrailer" class="custom-select" onchange="switchVideoOption('platformTrailer', 'trailerFields')" id="platformTrailer">
        <option value="{{config('app.storage_disk')}}" @if (old('platformTrailer') == config('app.storage_disk')) selected @endif>HTML5</option>
        <option value="vimeo" @if (old('platformTrailer') == "vimeo") selected @endif>Vimeo</option>
        <option value="youtube" @if (old('platformTrailer') == "youtube") selected @endif>YouTube</option>
    </select>
</div>
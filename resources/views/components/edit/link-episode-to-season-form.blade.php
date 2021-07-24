<div class="form-group">
    <label for="season_id">Link episode to season</label><br>

    <select name="season_id" class="custom-select" id="season_id">
        @foreach ($seasons as $season)
            <option value="{{$season->id}}" @if (old('season_id') == $season->id || $content['season_id'] == $season->id) selected @endif>{{$season->title}}</option>   
        @endforeach
    </select>
</div>
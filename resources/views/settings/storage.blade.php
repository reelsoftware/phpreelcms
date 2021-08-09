@extends('layouts.dashboard')

@section('title')
    Storage settings - 
@endsection

@section('pageTitle')
    Storage settings
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{ route('storageStore') }}" method="POST">
                {{ csrf_field() }}

                <h2>Chunk settings</h2>
                <p><small>To upload large files, CloudFlix will chop your files into chunks and upload them separately. This is needed because web servers limit the maximum upload size of files.</small></p>
                <p><b>Important! The chunk size must be lower or equal than {{(int)ini_get("upload_max_filesize")}} MB. For instruction on how to increase it check out the documentation.</b></p>
                
                <div class="form-group">
                    <label for="chunkSize">Chunk size (MB)</label>
                    <input type="number" name="chunkSize" min="1" max="{{(int)ini_get("upload_max_filesize")}}" class="form-control" id="chunkSize" value="{{ old('chunkSize') ? old('chunkSize') : $chunkSize }}">
                    @error('chunkSize')
                        <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                    @enderror
                </div>

                <h2>Storage</h2>

                <div class="form-group">
                    <label for="storageDisk">Storage disk</label><br>

                    <select name="storageDisk" class="custom-select" id="storageDisk" onchange="switchVideoOption()">
                        <option value="local" @if (old('storageDisk') == 'local' || $storageDisk == 'local') selected @endif>Local</option>
                        <option value="s3" @if (old('storageDisk') == 's3' || $storageDisk == 's3') selected @endif>S3</option>
                    </select>
                </div>

                <div id="s3">
                    <p><small>These fields are always empty. The Amazon S3 keys are considered very sensitive information, thus this form will only let you update your keys and not view them.</small></p>

                    <div class="form-group">
                        <label for="awsAccessKeyId">AWS access key ID</label>
                        <input type="text" name="awsAccessKeyId" class="form-control" id="awsAccessKeyId">
                        @error('awsAccessKeyId')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="awsSecretAccessKey">AWS secret access key</label>
                        <input type="text" name="awsSecretAccessKey" class="form-control" id="awsSecretAccessKey">
                        @error('awsSecretAccessKey')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="awsDefaultRegion">AWS default region</label>
                              
                        <select name="awsDefaultRegion" class="custom-select" id="awsDefaultRegion">
                            <option value="us-east-2">US East (Ohio)</option>
                            <option value="us-east-1">US East (N. Virginia)</option>
                            <option value="us-west-1">US West (N. California)</option>
                            <option value="us-west-2">US West (Oregon)</option>
                            <option value="af-south-1">Africa (Cape Town)</option>
                            <option value="ap-east-1">Asia Pacific (Hong Kong)</option>
                            <option value="ap-south-1">Asia Pacific (Mumbai)</option>
                            <option value="ap-northeast-3">Asia Pacific (Osaka)</option>
                            <option value="ap-northeast-2">Asia Pacific (Seoul)</option>
                            <option value="ap-southeast-1">Asia Pacific (Singapore)</option>
                            <option value="ap-southeast-2">Asia Pacific (Sydney)</option>
                            <option value="ap-northeast-1">Asia Pacific (Tokyo)</option>
                            <option value="ca-central-1">Canada (Central)</option>
                            <option value="cn-north-1">China (Beijing)</option>
                            <option value="cn-northwest-1">China (Ningxia)</option>
                            <option value="eu-central-1">Europe (Frankfurt)</option>
                            <option value="eu-west-1">Europe (Ireland)</option>
                            <option value="eu-west-2">Europe (London)</option>
                            <option value="eu-south-1">Europe (Milan)</option>
                            <option value="eu-west-3">Europe (Paris)</option>
                            <option value="eu-north-1">Europe (Stockholm)</option>
                            <option value="me-south-1">Middle East (Bahrain)</option>
                            <option value="sa-east-1">South America (São Paulo)</option>
                        </select>
                        
                        @error('awsDefaultRegion')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="awsBucket">AWS bucket</label>
                        <input type="text" name="awsBucket" class="form-control" id="awsBucket">
                        @error('awsBucket')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
             
                <input type="submit" class="btn btn-primary my-2">
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        function switchVideoOption() {
            let storageDisk = document.getElementById('storageDisk').value;

            if(storageDisk == 's3') {
                document.getElementById('s3').style.display = 'block';
            } else {
                document.getElementById('s3').style.display = 'none';
            }
        }

        switchVideoOption();
    </script>
@endsection
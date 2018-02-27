@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (!auth()->user()->gd_tokens)
                        <a href="{{ app('GDClient')->createAuthUrl() }}" class="btn btn-primary"> Google Drive Auth</a>
                    @else
                        <a href="{{ url('load-files') }}" class=""> Load/Update your files from google drive</a>
                    @endif

                    <br>
                    <br>
                    <div class="">
                        <table class="table table-bordered">
                            <th>File name</th>
                            <th>File Type</th>
                            <th>File Size</th>
                            <th></th>

                            @foreach($files as $file)
                                <tr>
                                    <td>{{ $file->title }}</td>
                                    <td>{{ $file->mime_type }}</td>
                                    <td>{{ $file->size ?? 'unknown' }} KB</td>
                                    <td>
                                        @if($file->download_url)
                                            <a href="{{ $file->download_url }}">Download</a>
                                        @else
                                            Download
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $files->links() }}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Form </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            Plata serviciu
        </div>
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="http://sandboxsecure.mobilpay.ro">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="hidden" id="title" name="env_key" class="form-control" value="{{$env}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <input type="hidden" name="data" class="form-control" value="{{$data}}"></input>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

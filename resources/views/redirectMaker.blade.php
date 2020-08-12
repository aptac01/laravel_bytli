<html>
<head>
    <title>Laravel Form Validation From Scratch</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<style type="text/css">
    body{
        background-color: #25274d;
    }

    .col-md-3{
        background: #ff9b00;
        padding: 4%;
        border-top-left-radius: 0.5rem;
        border-bottom-left-radius: 0.5rem;
    }
    .contact-info{
        margin-top:10%;
    }
    .contact-info h2{
        margin-bottom: 10%;
    }
    .col-md-9{
        background: #fff;
        padding: 3%;
        border-top-right-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }
    .contact-form label{
        font-weight:600;
    }
    .contact-form button{
        background: #25274d;
        color: #fff;
        font-weight: 600;
        width: 25%;
    }
    .contact-form button:focus{
        box-shadow:none;
    }
</style>
<body>
<div class="container contact">
    <br><br><br>
    <div class="row">
        <div class="col-md-3">
            <div class="contact-info">
                <h1>Bytli</h1><br/><h3>proudly ripped off from bit.ly</h3>
                <h6>since 2020</h6>
            </div>
        </div>
        <div class="col-md-9">
            @if ($data)
                <div class="form-group">
                    <label class="control-label col-sm-10" for="link">Your shortened link:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" disabled="disabled" value="{{ Request::fullUrl() . '/' . $checksum }}">
                    </div>
                    <br/>
                    <form action="{{ url('/clear') }}" method="post" accept-charset="utf-8">
                        @csrf
                        <div class="contact-form">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-12">
                                    <button type="submit" class="btn btn-default">new link</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @else
            <form action="{{ url('/') }}" method="post" accept-charset="utf-8">
                @csrf
                <div class="contact-form">
                    <div class="form-group">
                        <label class="control-label col-sm-10" for="link">Link you want to shorten:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="link" placeholder="valid url" name="link">
                            <span class="text-danger">{{ $errors->first('link') }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
    <br><br><br><br>
</div>
</body>
</html>

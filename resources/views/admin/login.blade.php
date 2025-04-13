<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="bg-light">

    <div class="container">
        <div class="row my-5">
            <div class="col-md-6 mx-auto">
                @session('error')
                    <div class="alert alert-danger my-2">
                        {{ session('error') }}
                    </div>
                @endsession
                <div class="card shadow-sm p-5">
                    <div class="card-header bg-white text-center">
                        <h3 class="mt-2">
                            Login Form
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.auth') }}" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="floatingInput" name="email" placeholder="name@example.com">
                                <label for="floatingInput">Email address*</label>
                                @error('email')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="floatingPassword" name="password" placeholder="Password">
                                <label for="floatingPassword">Password*</label>
                                @error('password')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <button type="submit" class="mt-3 btn btn-lg btn-dark">
                                    Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>

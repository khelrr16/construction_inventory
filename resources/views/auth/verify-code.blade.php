<!DOCTYPE html>
<html>
<head>
    <title>Verify Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Enter Verification Code</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('password.verify.code') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ old('email') ?? session('email') }}">
                            
                            <div class="mb-3">
                                <label for="code" class="form-label">6-digit Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                    id="code" name="code" maxlength="6" required 
                                    placeholder="Enter code sent to your email">
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Verify Code</button>
                            <a href="{{ route('password.request') }}" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
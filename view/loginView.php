</body>
<body style="display: flex;
    -ms-flex-align: center;
    -ms-flex-pack: center;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;">
<div class='text-center'>
    <div id='response' style='display: none;'></div>
    <form class="form-signin" id='loginForm' method='POST'>
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

        <label for='login' class="sr-only">Login</label>
        <input id="login" class="form-control first-input" type='text' placeholder='Login' required>

        <label for='password' class="sr-only">Password</label>
        <input id="password" class="form-control last-input" type='password' placeholder='Password' required>
        <br>
        <input type='submit' class="btn btn-lg btn-primary btn-block" value='Sign in'>
        <br>
        <div class="mt-4">
            <div class="d-flex justify-content-center links">
                Don't have an account? <a href="/registration" class="ml-2">Sign up</a>
            </div>
            <div class="d-flex justify-content-center links">
                <a href="#">Forgot your password?</a>
            </div>
        </div>
    </form>
</div>
<script src='/js/login.js'></script>
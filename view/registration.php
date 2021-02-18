</body>
<body style="display: flex;
    -ms-flex-align: center;
    -ms-flex-pack: center;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;">
<div class='text-center' >
    <div id="response" class="alert" style="display: none;"></div>
    <form id="registrationForm" class="form-signin" method="POST">
        <h1 class="h3 mb-3 font-weight-normal">Sign up</h1>

        <label for='login' class="sr-only">Login</label>
        <input id="login" class="form-control first-input" type="text" placeholder="Username" required>

        <label for="password" class="sr-only">Password</label>
        <input id="password" class="form-control middle-input" type="password" placeholder="Password" required>

        <label for="confirm_password" class="sr-only">Repeat password</label>
        <input id="confirm_password" class="form-control middle-input" type="password" placeholder="Repeat password" required>

        <label for="email" class="sr-only">E-mail:</label>
        <input id="email" class="form-control last-input" type="email" placeholder="E-mail" required>
        <br>
        <input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign up">
        <br>
        <div class="mt-4">
            <div class="d-flex justify-content-center links">
                Already have an account? <a href="/login" class="ml-2">Sign in</a>
            </div>
        </div>
    </form>

</div>
<script src="/js/registration.js"></script>
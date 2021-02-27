</body>
<?php
$resetlink = explode('/', $_SERVER['REQUEST_URI'])[2];
?>
<body style="display: flex;
    -ms-flex-align: center;
    -ms-flex-pack: center;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;">
<div class='text-center'>
    <div id='response' class="alert" style='display: none;'></div>
    <form class="form-signin" id='newpassForm' method='POST'>
        <h1 class="h3 mb-3 font-weight-normal">Enter a new password</h1>
        <input id="email" class="form-control first-input" type='email' placeholder='Email' autocomplete="off">
        <input id="password" class="form-control middle-input" type='password' placeholder='New password'>
        <input id="passwordConfirm" class="form-control last-input" type="password" placeholder="Repeat password" required>
        <input type="hidden" id="resetLink" value="<?php echo $resetlink ?>">
        <br>
        <input type='submit' class="btn btn-lg btn-primary btn-block" value='Sign in'>
    </form>
</div>

<script src='/js/newpass.js'></script>
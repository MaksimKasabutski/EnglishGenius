</body>
<body style="display: flex;
    -ms-flex-align: center;
    -ms-flex-pack: center;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;">
<div class='text-center'>
    <div id='response' class="alert" style='display: none;'></div>
    <form class="form-signin" id='resetForm' method='POST'>
        <h1 class="h3 mb-3 font-weight-normal">Password recovery</h1>

        <label for='email' class="sr-only">Email</label>
        <input id="email" class="form-control" type='email' placeholder='Email'>
        <br>
        <input type='submit' class="btn btn-md btn-primary btn-block" value='Send'>
        <div class="mt-4">
            <div class="d-flex justify-content-center links">
                <a href="/login">Back</a>
            </div>
        </div>
    </form>
</div>
<script src='/js/reset.js'></script>

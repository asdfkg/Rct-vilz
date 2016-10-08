<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

if ($_SESSION['USER']->getUserId()) header('Location: /reservations/');
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Login - VILLAZZO</title>
    <link rel="stylesheet" href="/css/custom.css">
    <script src="/js/vendor/modernizr.js"></script>
</head>

<body>
	<?php require_once 'inc-header.php'; ?>
    <section id="header-section">
        <img src="/img/destination-header_all.png">
    </section>
        
    <section id="reservations-title-steps-section">
        <div class="row">
            <div class="columns">
                <h1>LOGIN</h1>
            </div>
        </div>
    </section>
    
    <section id="destination-results">
        <div class="row">
			<div class="medium-6 medium-offset-3 columns">
				<form id="login-form" onsubmit="return false;">
					<fieldset>
						<div class="row collapse prefix-radius">
							<div class="small-1 columns"><span class="prefix"><i class="fa fa-envelope"></i></span></div>
							<div class="small-11 columns"><input type="text" name="email" id="email" class="required" placeholder="Enter your email"></div>
						</div>
						<div class="row collapse prefix-radius">
							<div class="small-1 columns"><span class="prefix"><i class="fa fa-key"></i></span></div>
							<div class="small-11 columns"><input type="password" name="password" id="password" class="required" placeholder="Enter your password"></div>
						</div>
						<div class="row">
							<div class="small-6 columns">
								<input type="checkbox" name="remember" id="remember" value="1"><label for="remember">Remember me</label>
							</div>
							<div class="small-6 columns">
								<a href="#" data-reveal-id="recoverPasswordModal" class="right"><label class="underline">Forgot password?</label></a>
							</div>
						</div>
						<div class="row collapse feedback"></div>
						<div class="row collapse">
							<button class="button submit tiny radius full-width" id="loginFormBtn" onclick="query(this.form.id, id, 'login');"><span>Login</span><i class="fa fa-circle-o-notch fa-spin"></i></button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
    </section>
        
    <?php require_once 'inc-footer.php'; ?>
    
	<?php require_once 'modal/password.php'; ?>
	
	<?php require_once 'inc-js.php'; ?>
</body>

</html>
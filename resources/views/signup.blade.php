<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from social.webestica.com/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Jun 2025 13:23:34 GMT -->
<head>
	<title>Social - Network, Community and Event Theme</title>

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Webestica.com">
	<meta name="description" content="Bootstrap 5 based Social Media Network and Community Theme">

	<!-- Dark mode -->
	<script>
		const storedTheme = localStorage.getItem('theme')
 
		const getPreferredTheme = () => {
			if (storedTheme) {
				return storedTheme
			}
			return window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'light'
		}

		const setTheme = function (theme) {
			if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
				document.documentElement.setAttribute('data-bs-theme', 'dark')
			} else {
				document.documentElement.setAttribute('data-bs-theme', theme)
			}
		}

		setTheme(getPreferredTheme())

		window.addEventListener('DOMContentLoaded', () => {
		    var el = document.querySelector('.theme-icon-active');
			if(el != 'undefined' && el != null) {
				const showActiveTheme = theme => {
				const activeThemeIcon = document.querySelector('.theme-icon-active use')
				const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
				const svgOfActiveBtn = btnToActive.querySelector('.mode-switch use').getAttribute('href')

				document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
					element.classList.remove('active')
				})

				btnToActive.classList.add('active')
				activeThemeIcon.setAttribute('href', svgOfActiveBtn)
			}

			window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
				if (storedTheme !== 'light' || storedTheme !== 'dark') {
					setTheme(getPreferredTheme())
				}
			})

			showActiveTheme(getPreferredTheme())

			document.querySelectorAll('[data-bs-theme-value]')
				.forEach(toggle => {
					toggle.addEventListener('click', () => {
						const theme = toggle.getAttribute('data-bs-theme-value')
						localStorage.setItem('theme', theme)
						setTheme(theme)
						showActiveTheme(theme)
					})
				})

			}
		})
		
	</script>

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">

	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap">

	<!-- Plugins CSS -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/font-awesome/css/all.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}">

	<!-- Theme CSS -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
	 
</head>

<body>

<!-- **************** MAIN CONTENT START **************** -->
<main>
  
  <!-- Container START -->
  <div class="container">
    <div class="row justify-content-center align-items-center vh-100 py-5">
      <!-- Main content START -->
      <div class="col-sm-10 col-md-8 col-lg-7 col-xl-6 col-xxl-5">
        <!-- Sign up START -->
        <div class="card card-body rounded-3 p-4 p-sm-5">
          <div class="text-center">
            <!-- Title -->
            <h1 class="mb-2">Sign up</h1>
            <span class="d-block">Already have an account? <a href="{{url('login')}}">Sign in here</a></span>
          </div>
          <!-- Form START -->
          <form class="mt-4" method="POST">
            <!-- Email -->
			@csrf
			   <div class="mb-3 input-group-lg">
              <input type="text" name="name" class="form-control" placeholder="Enter username">
              <small>@error('name')
				{{$message}}
			  @enderror</small>
            </div>
            <div class="mb-3 input-group-lg">
              <input type="email" name="email" class="form-control" placeholder="Enter email">
              <small>@error("email")
					{{$message}}
			  @enderror</small>
            </div>
            <!-- New password -->
            <div class="mb-3 position-relative">
              <!-- Input group -->
              <div class="input-group input-group-lg">
                <input class="form-control fakepassword" name="password" type="password" id="psw-input" placeholder="Enter new password">
                <span class="input-group-text p-0">
                  <i class="fakepasswordicon fa-solid fa-eye-slash cursor-pointer p-2 w-40px"></i>
                </span>
              </div>
              <!-- Pswmeter -->
              <div id="pswmeter" class="mt-2"></div>
              <div class="d-flex mt-1">
                <div id="pswmeter-message" class="rounded"></div>
                <!-- Password message notification -->
                <div class="ms-auto">
                  <i class="bi bi-info-circle ps-1" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Include at least one uppercase, one lowercase, one special character, one number and 8 characters long." data-bs-original-title="" title=""></i>
                </div>
              </div>
            </div>
            <!-- Confirm password -->
            <div class="mb-3 input-group-lg">
              <input class="form-control" type="password" placeholder="Confirm password">
            </div>
            <!-- Keep me signed in -->
            <div class="mb-3 text-start">
              <input type="checkbox" class="form-check-input" id="keepsingnedCheck">
              <label class="form-check-label" for="keepsingnedCheck"> Keep me signed in</label>
            </div>
            <!-- Button -->
            <div class="d-grid"><button type="submit" class="btn btn-lg btn-primary">Sign me up</button></div>
            <!-- Copyright -->
            <p class="mb-0 mt-3 text-center">©2022 <a target="_blank" href="https://www.webestica.com/">Webestica.</a> All rights reserved</p>
          </form>
          <!-- Form END -->
        </div>
        <!-- Sign up END -->
      </div>
    </div> <!-- Row END -->
  </div>
  <!-- Container END -->

</main>

<!-- **************** MAIN CONTENT END **************** -->

<!-- =======================
JS libraries, plugins and custom scripts -->

<!-- Bootstrap JS -->
<script src="{{asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>

<!-- Vendors -->
<script src="{{asset('assets/vendor/pswmeter/pswmeter.min.js')}}"></script>

<!-- Theme Functions -->
<script src="{{asset('assets/js/functions.js')}}"></script>

</body>

<!-- Mirrored from social.webestica.com/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Jun 2025 13:23:34 GMT -->
</html>
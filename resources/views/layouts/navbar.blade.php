<!-- Navigation Start -->
<nav class="navbar navbar-default navbar-sticky bootsnav">
    <div class="container">
        <!-- Header Navigation -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="img/Logo1.PNG" class="logo" alt="Site Logo">
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
                  <li><a href="{{ route('register') }}">Register</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Navigation End -->

<style>
    .navbar-brand .logo {
        max-height: 85px;
        width: auto;
        margin-left: -30px;
    }

    @media (max-width: 850px) {
        .navbar-brand .logo {
            display: none;
        }

        .navbar-header {
            text-align: center;
        }

        .navbar-toggle {
            float: left;
        }
    }
</style>

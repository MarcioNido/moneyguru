<template>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="/">
                    MoneyGuru-0.1
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">

                    <router-link tag="li" to="/" exact>
                        <a>Home</a>
                    </router-link>

                    <router-link tag="li" to="/finances">
                        <a>Finances</a>
                    </router-link>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Settings <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <router-link tag="li" to="/bank-accounts">
                                <a>Bank Accounts</a>
                            </router-link>
                            <router-link tag="li" to="/categories">
                                <a>Categories (Chart of Accounts)</a>
                            </router-link>

                        </ul>

                    </li>

                    <router-link tag="li" to="/about">
                        <a>About</a>
                    </router-link>

                </ul>

            </div>

        </div>
    </nav>
</template>

<script>
    export default {
        mounted() {
            console.log('Nav Bar mounted');
        },
    }
</script>
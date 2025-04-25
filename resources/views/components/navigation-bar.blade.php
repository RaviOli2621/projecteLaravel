<div class="header-container">
    <div class="header-left">
        <a href="{{ url('/') }}" class="home-icon" title="Home">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon-home">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
        </a>
        <h1 class="header-title">Glossari de termes als jocs de lluita</h1>
    </div>
    
    <div class="navbar">
        <a class="navA" title="TodosLosArticulos" href="{{ url('/articles') }}">Tots els Articles</a>
        <div class="dropdown">
            <button class="dropbtn">
                Meus Articles 
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon-dropdown">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="dropdown-content">
                {!! $links !!}
            </div>
        </div>
        <button id="qr-upload-btn" class="dropbtn">Leer código QR</button>
        <x-login-icon></x-login-icon>
    </div>
</div>

<style>
.header{
    position:relative;
    width:100%;
    background:#26473e;
}
.header-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 0px;
    position:relative;
    z-index:99;
}
.logo img{
    width:85px;
}
.header-center{
    display:flex;
    align-items:center;
    gap:22px;
}
.header-center p{
    color:#fff;
    font-size:15px;
    font-weight:500;
}
.header-center span{
    color:#cba27b;
    font-weight:700;
    text-transform:uppercase;
}
.divider{
    width:2px;
    height:28px;
    background:rgba(255,255,255,0.5);
}
.header-right{
    display:flex;
    align-items:center;
    gap:18px;
}
.hamburger{
    cursor:pointer;
}
.hamburger span{
    width:16px;
    height:2px;
    background:#222;
    border-radius:10px;
}
.mobile-menu{
    position:absolute;
    left:0;
    top:100%;
    width:100%;
    background: #2A3238D4;
    background-size:cover;
    background-position:center;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:70px;
    overflow:hidden;
    max-height:0;
    transition:all .4s ease;
}
.mobile-menu.active{
    max-height:120px;
    padding:38px 20px;
}
.mobile-menu a{
    color:#fff;
    text-decoration:none;
    font-size:14px;
    font-weight:600;
    transition:.3s;
}
.mobile-menu a:hover{
    color:#d7af87;
}
@media(max-width:991px){
    .header-top{
        padding:18px 0px;
    }
    .header-center{
        display:none;
    }
    .faith h2 {
        font-size: 40px;
    }
    .social-icons {
        margin-top: 75px;
    }
}
@media(max-width:768px){
    .mobile-menu{
        flex-direction:column;
        gap:22px;
    }
    .mobile-menu.active{
        max-height:400px;
    }
}

</style>

<header class="header">
    <div class="container">
    <!-- TOP HEADER -->
    <div class="header-top">
        <div class="logo">
            <a href="http://localhost/WestDenverBibleChurch"><img src="assets/img/header-logo.png" alt="logo"></a>
        </div>
        <div class="header-center">
            <p><span>SERMONS</span> | Live Stream HERE - 10-11</p>
            <div class="divider"></div>
            <p><span>Prayer Request</span> Form HERE</p>
        </div>
        <div class="header-right">
            <div class="hamburger" id="hamburger">
               <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
<g filter="url(#filter0_d_92_744)">
<rect width="48" height="48" rx="9" fill="white"/>
<line x1="34.5" y1="18.5" x2="13.5" y2="18.5" stroke="#2A3238" stroke-width="3" stroke-linecap="round"/>
<line x1="34.5" y1="25.5" x2="13.5" y2="25.5" stroke="#2A3238" stroke-width="3" stroke-linecap="round"/>
<line x1="34.5" y1="32.5" x2="13.5" y2="32.5" stroke="#2A3238" stroke-width="3" stroke-linecap="round"/>
</g>
<defs>
<filter id="filter0_d_92_744" x="0" y="0" width="56" height="56" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
<feFlood flood-opacity="0" result="BackgroundImageFix"/>
<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
<feOffset dx="4" dy="4"/>
<feGaussianBlur stdDeviation="2"/>
<feComposite in2="hardAlpha" operator="out"/>
<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_92_744"/>
<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_92_744" result="shape"/>
</filter>
</defs>
</svg>
            </div>
        </div>
    </div>
    <!-- DROPDOWN MENU -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#">Home</a>
        <a href="./sermons.php">Sermons</a>
        <a href="#">About</a>
        <a href="#">Giving</a>
        <a href="#">Contact</a>
    </div>
    </div>
</header>
<script>

const hamburger = document.getElementById("hamburger");
const mobileMenu = document.getElementById("mobileMenu");

hamburger.addEventListener("click", () => {
    mobileMenu.classList.toggle("active");
});

</script>

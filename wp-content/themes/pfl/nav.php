<div class="navbar navbar-fixed-top">
    <div class="container">
        <div class="navbar-mobile navbar-mobile-leftside hidden-md hidden-lg">
        </div>
        <div class="navbar-items navbar-leftside hidden-xs hidden-sm">
            <ul>
                <li class="navLink"><a href="/">Home</a></li>
                <li>Differentiation</li>
                <li>Strengths</li>
            </ul>
        </div>
        <div class="container-logo">
            <img src="<?=getThemePath()?>/images/logo.png">
        </div>
        <div class="navbar-items navbar-rightside hidden-xs hidden-sm">
            <ul>
                <li>Resources</li>
                <li>About</li>
                <li class="search">Search</li>
            </ul>
        </div>
        <div class="navbar-mobile navbar-mobile-rightside hidden-md hidden-lg pull-right">
            <img src="<?=getThemePath()?>/images/hamburger.png" height="32" width="32" class="mobile-menu"></img>
        </div>
    </div>
    <!-- container -->
</div>

<div id="nav-menu-mast" class="hidden-xs hidden-sm">
    <div class="container">
        <div class="menu-mast menu-mast-right col-md-6 text-right">
            <ul id="navMenu-Tier2">
            </ul>
        </div>
        <div class="menu-mast menu-mast-left col-md-6">
            <ul id="navMenu-Tier3">
            </ul>
        </div>
    </div>
</div>

<div id="nav-menu-mast-mobile" class="hidden-md hidden-lg">
    <ul>
        <li>Home</li>
    </ul>
</div>


<div id="nav-menu-search">
    <div class="container">
        <div class="col-xs-12 search-container">

        <form id="searchform" method="get" action="/index.php">
        <div class="search-box">
            <input type="text" name="s" id="s" size="15" />
            <input type="submit" value="Search" />
        </div>
     </form>

        </div>
    </div>
</div>
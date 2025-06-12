<?php
global $query; 
global $made_theme;

$made_welcome_title = $made_theme['made-theme-dashboard-box-info-title'] ? $made_theme['made-theme-dashboard-box-info-title'] : 'Welcome to Restore Construction';
$made_welcome_content = $made_theme['made-theme-dashboard-box-info-content'] ? $made_theme['made-theme-dashboard-box-info-content'] : 'We are a team of developers and designers who are passionate about creating beautiful and functional websites. We are here to help you build your website and make it look great.';
$made_welcome_full = $made_theme['made-theme-dashboard-box-full-content'] ? $made_theme['made-theme-dashboard-box-full-content'] : '';
?>

<style>
#show-settings-link,
#wpbody-content h1,
#welcome-panel,
#dashboard_widget .handle-actions {
    display: none;
}
#dashboard-widgets .meta-box-sortables {
    min-height: unset !important;
}
#dashboard-widgets-wrap {
    margin: 0 ;
    width: 100%;
}

#dashboard-widgets-wrap .postbox {
    border: 5px solid #000000;
}

#dashboard_widget .postbox-header {
    user-select: none;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    cursor: default;
    pointer-events: none;
    display: none;
}

#dashboard_widget {
    width: 100%;
    margin: 0 auto 3rem auto;
}
#dashboard_widget .swelcome-panel-content * {
    box-sizing: border-box;
}
#dashboard_widget .swelcome-panel-content .icon-circle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 5rem;
    height: 5rem;
    border-radius: 50%;
    background: #000;
    color: #fff;
}
#dashboard_widget .swelcome-panel-content .icon-circle i {
    font-size: 2rem;
}
#dashboard_widget .swelcome-panel-content .nav {
    position: absolute;
    top: -11px;
    right: 0;
    margin-top: 0;
    width: 100%;
    background: #000000;
}
#dashboard_widget .swelcome-panel-content .nav a {
    background: #000000;
    color: #fff;
}
#dashboard_widget .swelcome-panel-content .nav li {
    margin-bottom: 0;
}
#dashboard_widget .swelcome-panel-content .nav a:active,
#dashboard_widget .swelcome-panel-content .nav a.active,
#dashboard_widget .swelcome-panel-content .nav a:focus {
    outline: none;
    box-shadow: none;
    background: #fff;
    color: #000;
}
#dashboard_widget .swelcome-panel-content #carouselExampleIndicators {
    border: 2px solid #000;
}
#dashboard_widget .swelcome-panel-content .carousel-caption {
    color: #fff;
    background: #000000c9;
    width: 100%;
    left: 0;
    right: 0;
    bottom: 0;
}
#dashboard_widget .swelcome-panel-content .carousel-caption h3 {
    color: #fff;
    font-size: 2em;
    margin-bottom: 0;
}
#dashboard_widget .swelcome-panel-content .carousel-control-prev span,
#dashboard_widget .swelcome-panel-content .carousel-control-next span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 5rem;
    height: 5rem;
    border-radius: 50%;
    background-color: #000;
    background-size: 50%;
    cursor: pointer;
    opacity: .5;
}
#dashboard_widget .swelcome-panel-content .carousel .carousel-control-prev,
#dashboard_widget .swelcome-panel-content .carousel .carousel-control-next {
    opacity: 0;
}
#dashboard_widget .swelcome-panel-content .carousel:hover .carousel-control-prev,
#dashboard_widget .swelcome-panel-content .carousel:hover .carousel-control-next {
    opacity: 1;
}
#dashboard_widget .swelcome-panel-content .carousel .carousel-control-prev:hover span,
#dashboard_widget .swelcome-panel-content .carousel .carousel-control-next:hover span {
    opacity: 1;
}

</style>

<div class="swelcome-panel-content p-2 p-xxl-5">

    <ul class="nav" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="javascript:void(0);" class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" role="tab" aria-controls="home-tab-pane" aria-selected="true">Overview</a>
        </li>
        <!-- <li class="nav-item" role="presentation">
            <a href="javascript:void(0);" class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery-tab-pane" role="tab" aria-controls="gallery-tab-pane" aria-selected="false">Gallery</a>
        </li> -->
        <li class="nav-item" role="presentation">
            <a href="javascript:void(0);" class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Plugins</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="javascript:void(0);" class="nav-link" id="theme-tab" data-bs-toggle="tab" data-bs-target="#theme-tab-pane" role="tab" aria-controls="theme-tab-pane" aria-selected="false">Theme</a>
        </li>
    </ul>
    <div class="container">
        
        <div class="gtabav-tabs">
            
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <div class="row text-center mt-5">
                        <div class="col-12">
                            <figure>
                                <img class="img-fluid" src="<?php echo N3COMMERCIALREALTY_CORE_URL ; ?>/dist/img/logon3cr.png" alt="Logo" style="max-width: 300px;">
                            </figure>
                            <p class="display-1 my-3"><?php echo $made_welcome_title; ?></p>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-lg-8 col-xl-6 offset-lg-2 offset-xl-3">
                            <p class="text-muted lead">
                                <?php echo $made_welcome_content; ?>
                            </p>
                        </div>
                    </div>
                    <?php if($made_welcome_full != '') { ?>
                        <?php echo $made_welcome_full; ?>
                    <?php } else { ?>
                    <div class="row mt-5 text-center">
                        <div class="col-xl-4 mt-5">
                            <div class="icon-circle">
                                <i class="bi bi-palette"></i>
                            </div>
                            <div class="content">
                                <h2>Flexible</h2>
                                <p>Our website are built with flexibility in mind. You can easily customize the theme to fit your needs.</p>
                            </div>
                        </div>
                        <div class="col-xl-4 mt-5">
                            <div class="icon-circle">
                                <i class="bi bi-cart-check"></i>
                            </div>
                            <div class="content">
                                <h2>Easy Ecommerce</h2>
                                <p>Our website are built with WooCommerce in mind. With our website, you can easily set up an online store.</p>
                            </div>
                        </div>
                        <div class="col-xl-4 mt-5">
                            <div class="icon-circle">
                                <i class="bi bi-layout-text-window-reverse"></i>
                            </div>
                            <div class="content">
                                <h2>Multi-Addons</h2>
                                <p>We design our website to be compatible with addons. Our addons make it easy for you to add new features to your website.</p>
                            </div>
                        </div>
                        <div class="col-xl-4 mt-5">
                            <div class="icon-circle">
                                <i class="bi bi-puzzle"></i>
                            </div>
                            <div class="content">
                                <h2>Google Extensions</h2>
                                <p>We have created a set of Google Extensions that will help you get the most out of your business.</p>
                            </div>
                        </div>
                        <div class="col-xl-4 mt-5">
                            <div class="icon-circle">
                                <i class="bi bi-phone"></i>
                            </div>
                            <div class="content">
                                <h2>Mobile Apps</h2>
                                <p>We can develop a mobile app for your business. Your customer base will increase as a result.</p>
                            </div>
                        </div>
                        <div class="col-xl-4 mt-5">
                            <div class="icon-circle">
                                <i class="bi bi-boxes"></i>
                            </div>
                            <div class="content">
                                <h2>Web Apps</h2>
                                <p>Our team can create a custom web app for your business. As a result, you will be able to reach larger values.</p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <!-- <div class="tab-pane fade" id="gallery-tab-pane" role="tabpanel" aria-labelledby="gallery-tab" tabindex="0">
                    <div class="mt-5"><?php include 'dashboard-widget-gallery.php'; ?></div>
                </div> -->
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <div class="row mt-5">
                        <div class="col-12">
                            <?php include 'dashboard-widget-plugins.php'; ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="theme-tab-pane" role="tabpanel" aria-labelledby="theme-tab" tabindex="0">
                    <div class="row mt-5">
                        <div class="col-12">
                            <?php include 'dashboard-widget-theme.php'; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <footer class="mt-5 text-center">
            <hr>
            <div class="row small">
                <div class="col-12">
                    <p class="text-muted mb-0">Version: <?php echo N3COMMERCIALREALTY_CORE_VERSION; ?></p>
                    <p class="text-muted m-0">This is a product of <a href="https://restoreconstruction.com" target="_blank">Restore Construction</a>. Copyright &copy; <?php echo date('Y'); ?>. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</div>
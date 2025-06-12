<?php
global $query; 
global $made_theme;

$made_welcome_title = $made_theme['made-theme-dashboard-box-info-title'] ? $made_theme['made-theme-dashboard-box-info-title'] : 'Welcome to Restore Construction';
$made_welcome_content = $made_theme['made-theme-dashboard-box-info-content'] ? $made_theme['made-theme-dashboard-box-info-content'] : 'We are a team of developers and designers who are passionate about creating beautiful and functional websites. We are here to help you build your website and make it look great.';
$made_welcome_full = $made_theme['made-theme-dashboard-box-short-content'] ? $made_theme['made-theme-dashboard-box-short-content'] : '';
?>

<style>
    [class^="col-"],
    [class^="col"] {
        width: 100%;
        max-width: 100%;
        flex: 0 0 100%;
    }
    .swelcome-panel-content .nav a {
        border-top: 2px solid transparent;
        padding: 3px 0;
        color: #aaa;
    }
    .swelcome-panel-content .nav li {
        margin-bottom: 0;
        margin-right: 10px;
    }
    .swelcome-panel-content .nav li:last-child {
        margin-right: 0;
    }
    .swelcome-panel-content .tab-content .list-group li p {
        display: none;
    }
    .swelcome-panel-content .nav a:active,
    .swelcome-panel-content .nav a.active,
    .swelcome-panel-content .nav a:focus {
        border-top: 2px solid #000;
        color: #000;
        outline: none;
        box-shadow: none;
    }
    .swelcome-panel-content * {
        box-sizing: border-box;
    }
    .swelcome-panel-content #carouselExampleIndicators {
        border: 2px solid #000;
    }
    .swelcome-panel-content .carousel-caption {
        display: none !important
    }
    .swelcome-panel-content .carousel-caption h3 {
        color: #fff;
        font-size: 2em;
        margin-bottom: 0;
    }
    .swelcome-panel-content .carousel-control-prev span,
    .swelcome-panel-content .carousel-control-next span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background-color: #000;
        background-size: 50%;
        cursor: pointer;
        opacity: .5;
    }
    .swelcome-panel-content .carousel .carousel-control-prev,
    .swelcome-panel-content .carousel .carousel-control-next {
        opacity: 0;
    }
    .swelcome-panel-content .carousel:hover .carousel-control-prev,
    .swelcome-panel-content .carousel:hover .carousel-control-next {
        opacity: 1;
    }
    .swelcome-panel-content .carousel .carousel-control-prev:hover span,
    .swelcome-panel-content .carousel .carousel-control-next:hover span {
        opacity: 1;
    }
</style>

<div class="swelcome-panel-content">
    <div class="made-welcome-box small">
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

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="mt-2">
                    <h4 class="fw-bold"><?php echo $made_welcome_title; ?></h4>
                    <?php echo $made_welcome_content; ?>
                    <?php if($made_welcome_full != '') { ?>
                        <?php echo $made_welcome_full; ?>
                    <?php } else { ?>
                    <?php } ?>
                </div>
            </div>
            <!-- <div class="tab-pane fade" id="gallery-tab-pane" role="tabpanel" aria-labelledby="gallery-tab" tabindex="0">
                <div class="mt-2"><?php include 'dashboard-widget-gallery.php'; ?></div>
            </div> -->
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <?php include 'dashboard-widget-plugins.php'; ?>
            </div>
            <div class="tab-pane fade" id="theme-tab-pane" role="tabpanel" aria-labelledby="theme-tab" tabindex="0">
                <?php include 'dashboard-widget-theme.php'; ?>
            </div>
        </div>

        <footer class="mt-3">
            <hr class="m-0">
            <div class="row small">
                <div class="col-12">
                    <p class="text-muted mb-0">Version: <?php echo N3COMMERCIALREALTY_CORE_VERSION; ?></p>
                    <p class="small text-sm text-muted m-0">This is a product of <a href="https://n3commercialrealty.com" target="_blank">Restore Construction</a>.</p>
                    <p class="small text-sm text-muted m-0">Copyright &copy; <?php echo date('Y'); ?>. All rights reserved.</p>
                </div>
            </div>
        </footer>

    </div>
</div>

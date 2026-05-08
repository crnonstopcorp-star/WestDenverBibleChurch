<?php
include('includes/config.inc.php');
include('seo/seo.inc.php');
include('includes/head.php');
include('includes/header.php');
?>

<section id="youtube-banner">
    <div class="container">
        <div class="you-gallery">
            <h1>VIDEO GALLERY</h1>
        </div>
    </div>
</section>

<section id="youtube-videos">
    <div class="container">

        <div class="video-grid" id="videoGrid">
            <p>Loading videos...</p>
        </div>

        <div id="pagination" class="pagination"></div>
    </div>
</section>

<?php include('includes/footer.inc.php'); ?>
<?php
include('includes/config.inc.php');
include('seo/seo.inc.php');
include('includes/head.php');
include('includes/header.php');
?>

<section id="banner-west"
    style="background: linear-gradient(0.43deg, rgba(0,0,0,0.78) 0.33%, rgba(0,0,0,0) 98.22%), url('assets/img/sermons.png'); background-size: cover; background-position: center; display: flex; align-items: center;">
    <div class="container">
        <div class="banner">
            <div class="bannmain">
                <h1>Biblical teaching to<br> strengthen your faith.</h1>
                <p>Our sermons explain Scripture clearly and faithfully.</p>
                <button>
                    <a href="#">Watch Latest Sermon</a>
                </button>
                <button class="plan">
                    <a href="#">Join Livestream</a>
                </button>
            </div>
            <div class="bannmain2">
            </div>
        </div>
    </div>
</section>

<?php include('includes/live.php'); ?>

<?php include('includes/footer.inc.php'); ?>


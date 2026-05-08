<?php
include('includes/config.inc.php');
include('seo/seo.inc.php');
include('includes/head.php');
include('includes/header.php');
?>

<section id="banner-west"
    style="background: linear-gradient(0.43deg, rgba(0,0,0,0.78) 0.33%, rgba(0,0,0,0) 98.22%), url('assets/img/sermon.png'); background-size: cover; background-position: center; display: flex; align-items: center;">
    <div class="container">
        <div class="banner">
            <div class="bannmain">
                <h1>Biblical teaching to<br> strengthen your faith.</h1>
                <p>Our sermons explain Scripture clearly and faithfully.</p>
                <button>
                    <a href="https://www.youtube.com/@westdenverbiblechurch" target="_blank">Watch Latest Sermon</a>
                </button>
                <!-- <button class="plan">
                    <a href="#">Join Livestream</a>
                </button> -->
            </div>
            <div class="bannmain2">
            </div>
        </div>
    </div>
</section>

<section id="latest-message">
    <div class="container">
        <div class="message">
            <h2>LATEST MESSAGE</h2>
            <p>LATEST MESSAGE</p>
              <iframe
            width="100%"
            height="70%"
            src="https://www.youtube.com/embed/videoseries?list=UUeFyxpKgF697N1JZc3feBoQ"
            title="YouTube videos"
            frameborder="0"
            allowfullscreen>
        </iframe>
        <div class="videohead">
            <div class="videotitle">
                <h3>Learning to Trust God in Difficult Times</h3>
                <h4>Pastor John Smith | March 2026</h4>
            </div>
            <div class="videobut">
                <button><a href="https://www.youtube.com/@westdenverbiblechurch" target="_blank">Watch Sermons</a></button>
            </div>
        </div>
    </div>
</section>

<section id="fellowship">
    <div class="container">
        <div class="fellow-c">
            <p>Our church incorporates God’s family into our fellowship. We provide a warm, authentic community,
                welcoming new belivers into the body of Christ through baptism.</p>
        </div>
    </div>
</section>

<!-- <section id="reading">
    <div class="container">
        <div class="reading-s row g-4">
            <div class="events col-lg-3 col-md-6 col-12">
                <img src="assets/img/reading.png" alt="Bible Reading">
                <h3>Bible Reading</h3>
                <p>Explore the bible with Us</p>
            </div>
            <div class="events col-lg-3 col-md-6 col-12">
                <img src="assets/img/events.png" alt="OUR EVENTS">
                <h3>OUR EVENTS</h3>
                <p>Take Part</p>
            </div>
            <div class="events col-lg-3 col-md-6 col-12">
                <img src="assets/img/church.png" alt="OUR CHURCH">
                <h3>OUR CHURCH</h3>
                <p>Locations</p>
            </div>
            <div class="events col-lg-3 col-md-6 col-12">
                <img src="assets/img/groups.png" alt="OUR GROUPS">
                <h3>OUR GROUPS</h3>
                <p>Join our Communities</p>
            </div>
        </div>
    </div>
</section> -->

<!-- NEW SERMONS -->

<section id="new-sermons">
    <div class="container">
        <div class="teaching">
            <div class="teaching-ser">
                <h2>NEW SERMONS</h2>
                <p>NEW SERMONS</p>
            </div>
            <div class="teaching-para">
                <p>Our teaching ministry focuses on verse-by-verse exposition of Scripture so that the meaning of the
                    text is understood in its proper context. These sermons are made available so you can continue
                    learning from God’s Word throughout the week.</p>
            </div>
        </div>
        <div class="sermon-main">
            <div class="sermon-wrapper">
                <div class="living-faith">
                    <img src="assets/img/faith.png" alt="Living By Faith">
                    <div class="sermon-content">
                        <h2>LIVING BY FAITH</h2>
                        <p>Pastor John Smith - 25 feb</p>
                        <button><a href="https://www.youtube.com/@westdenverbiblechurch" target="_blank">Watch Sermons</a></button>
                    </div>
                </div>
                <div class="power">
                    <img src="assets/img/power-grace.png" alt="Power Of Grace">

                    <div class="sermon-content">
                        <h2>THE POWER OF GRACE</h2>
                        <p>Pastor John Smith - 25 feb</p>
                        <button><a href="https://www.youtube.com/@westdenverbiblechurch" target="_blank">Watch Sermons</a></button>
                    </div>
                </div>
                <div class="god-faithful">
                    <img src="assets/img/god-faith.png" alt="God Faithfulness">

                    <div class="sermon-content">
                        <h2>GOD’S FAITHFULNESS</h2>
                        <p>Pastor John Smith - 25 feb</p>
                        <button><a href="https://www.youtube.com/@westdenverbiblechurch" target="_blank">Watch Sermons</a></button>
                    </div>
                </div>
                <!-- Extra Slides -->
                <div class="living-faith">
                    <img src="assets/img/faith.png" alt="Faith">

                    <div class="sermon-content">
                        <h2>WALK IN FAITH</h2>
                        <p>Pastor John Smith - 25 feb</p>
                        <button><a href="https://www.youtube.com/@westdenverbiblechurch" target="_blank">Watch Sermons</a></button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="slider-bottom">

            <div class="slider-line">
                <span></span>
            </div>

            <div class="slider-arrows">

                <button class="prev">
                    <i class="fa-solid fa-angle-left"></i>
                </button>

                <button class="next">
                    <i class="fa-solid fa-angle-right"></i>
                </button>

            </div>

        </div>
        <!-- <div class="watch-sun">
            <div class="watch-image">
                <img src="assets/img/watchwe.png" alt="">
            </div>
            <div class="watch-txtimg">
                <div class="watchhead">
                    <h2>LIVE</h2>
                    <p>Join Us Live</p>
                </div>
                <div class="watch-join">
                    <h3>Watch our Sunday service live from wherever you are.</h3>
                    <p>If you can not be with us in person, you are invited to join us online.</p>
                    <button><a href="#">Watch Livestream</a></button>
                </div>
            </div>
        </div> -->
    </div>
</section>


<?php include('includes/live.php'); ?>

<?php include('includes/footer.inc.php'); ?>
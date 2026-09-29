<?php
include('includes/config.inc.php');
include('seo/seo.inc.php');
include('includes/head.php');
include('includes/header.php');
?>

<section id="banner-west"
    style="background: linear-gradient(0.43deg, rgba(0,0,0,0.78) 0.33%, rgba(0,0,0,0) 98.22%), url('assets/img/sermon-s.jpeg'); background-size: cover; background-position: center; display: flex; align-items: center;">
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
            <iframe width="100%" height="70%"
                src="https://www.youtube.com/embed/videoseries?list=PLzPcTc0lM4498kytt68iuZ20JOQaoorw_" title="YouTube videos" 
                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen>
            </iframe>
            <div class="videohead">
                <div class="videotitle">
                    <h3>Learning to Trust God in Difficult Times</h3>
                    <h4>Pastor John Smith | March 2026</h4>
                </div>
                <div class="videobut">
                    <button><a href="https://www.youtube.com/@westdenverbiblechurch" target="_blank">Watch
                            Sermons</a></button>
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


<?php
$apiKey = 'AIzaSyAl2X7ekFYszRsrxAux05tKfge24p0WPu4';
$channelId = 'UCeFyxpKgF697N1JZc3feBoQ';

$apiUrl = "https://www.googleapis.com/youtube/v3/search?key={$apiKey}&channelId={$channelId}&part=snippet,id&order=date&maxResults=4&type=video";

$response = file_get_contents($apiUrl);
$data = json_decode($response, true);
?>


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
                <?php if (!empty($data['items'])): ?>
                <?php foreach ($data['items'] as $video): ?>
                <?php
            $videoId = $video['id']['videoId'];
            $title = $video['snippet']['title'];
            $thumbnail = $video['snippet']['thumbnails']['high']['url'];
            $date = date('d M Y', strtotime($video['snippet']['publishedAt']));
            ?>
                <div class="living-faith">
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo htmlspecialchars($title); ?>">
                    <div class="sermon-content">
                        <h2>
                            <?php
                            $shortTitle = mb_strimwidth($title, 0, 40, '...');
                            echo htmlspecialchars(html_entity_decode($shortTitle, ENT_QUOTES, 'UTF-8'));
                            ?>
                        </h2>
                        <p>West Denver Bible Church - <?php echo $date; ?></p>
                        <button>
                            <a href="https://www.youtube.com/watch?v=<?php echo $videoId; ?>" target="_blank">
                                Watch Sermon
                            </a>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
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
    </div>
</section>

<?php include('includes/live.php'); ?>

<?php include('includes/footer.inc.php'); ?>
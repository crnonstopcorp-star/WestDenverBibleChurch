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

<script>
async function fetchYouTubeVideos() {

    const apiKey = "AIzaSyCpCDGWkIctfM-_9xsviKpi8NaFQh_WAC4";
    const channelId = "UCeFyxpKgF697N1JZc3feBoQ";

    try {

        // =========================
        // GET UPLOADS PLAYLIST ID
        // =========================
        const channelURL =
            `https://www.googleapis.com/youtube/v3/channels?part=contentDetails&id=${channelId}&key=${apiKey}`;

        const channelResponse = await fetch(channelURL);
        const channelData = await channelResponse.json();

        const uploadsPlaylistId =
            channelData.items[0].contentDetails.relatedPlaylists.uploads;

        // =========================
        // FETCH ALL VIDEOS
        // =========================
        let nextPageToken = "";
        let allVideos = [];

        do {

            const playlistURL =
                `https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=${uploadsPlaylistId}&maxResults=50&pageToken=${nextPageToken}&key=${apiKey}`;

            const playlistResponse = await fetch(playlistURL);
            const playlistData = await playlistResponse.json();

            allVideos = allVideos.concat(playlistData.items);

            nextPageToken = playlistData.nextPageToken || "";

        } while (nextPageToken);

        // =========================
        // PAGINATION
        // =========================
        const videosPerPage = 18;
        let currentPage = 1;

        function displayVideos(page) {

            const start = (page - 1) * videosPerPage;
            const end = start + videosPerPage;

            const paginatedVideos = allVideos.slice(start, end);

            let html = "";

            paginatedVideos.forEach(video => {

                if (!video.snippet || !video.snippet.resourceId) return;

                const videoId = video.snippet.resourceId.videoId;
                const title = video.snippet.title;
                const thumbnail = video.snippet.thumbnails.high.url;

                html += `
                    <div class="video-card">

                        <a href="https://www.youtube.com/watch?v=${videoId}" target="_blank">

                            <div class="video-thumb">

                                <img src="${thumbnail}" alt="${title}">

                                <span class="play-btn"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25" x="0" y="0" viewBox="0 0 163.861 163.861" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M34.857 3.613C20.084-4.861 8.107 2.081 8.107 19.106v125.637c0 17.042 11.977 23.975 26.75 15.509L144.67 97.275c14.778-8.477 14.778-22.211 0-30.686L34.857 3.613z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg></span>

                            </div>

                        </a>

                         <a href="https://www.youtube.com/watch?v=${videoId}" target="_blank"><h3>${title}</h3></a>

                    </div>
                `;
            });

            document.getElementById("videoGrid").innerHTML = html;

            renderPagination();
        }

        function renderPagination() {

            const totalPages = Math.ceil(allVideos.length / videosPerPage);

            let paginationHTML = "";

            for (let i = 1; i <= totalPages; i++) {

                paginationHTML += `
                    <button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">
                        ${i}
                    </button>
                `;
            }

            document.getElementById("pagination").innerHTML = paginationHTML;

            document.querySelectorAll(".page-btn").forEach(button => {

                button.addEventListener("click", function() {

                    currentPage = Number(this.dataset.page);

                    displayVideos(currentPage);

                    window.scrollTo({
                        top: document.getElementById("youtube-videos").offsetTop - 100,
                        behavior: "smooth"
                    });

                });

            });

        }

        // Initial Load
        displayVideos(currentPage);

    } catch (error) {

        console.log("YouTube Error:", error);

        document.getElementById("videoGrid").innerHTML =
            "<p>Unable to load videos.</p>";
    }
}

fetchYouTubeVideos();
</script>


<script>
const videosPerPage = 12;
let currentPage = 1;
let allVideos = [];

// =========================
// DISPLAY VIDEOS
// =========================
function displayVideos(page) {

    const start = (page - 1) * videosPerPage;
    const end = start + videosPerPage;

    const paginatedVideos = allVideos.slice(start, end);

    let html = "";

    paginatedVideos.forEach(video => {

        if (!video.snippet || !video.snippet.resourceId) return;

        const videoId = video.snippet.resourceId.videoId;
        const title = video.snippet.title;
        const thumbnail = video.snippet.thumbnails.high.url;

        html += `
            <div class="video-card">

                <a href="https://www.youtube.com/watch?v=${videoId}" target="_blank">

                    <div class="video-thumb">

                        <img src="${thumbnail}" alt="${title}">

                        <span class="play-btn">▶</span>

                    </div>

                </a>

                <h3>${title}</h3>

            </div>
        `;
    });

    document.getElementById("videoGrid").innerHTML = html;

    renderPagination();
}

// =========================
// PAGINATION
// =========================
function renderPagination() {

    const totalPages = Math.ceil(allVideos.length / videosPerPage);

    let buttons = "";

    // Previous Button
    if(currentPage > 1){
        buttons += `
            <button class="page-btn" onclick="changePage(${currentPage - 1})">
                Prev
            </button>
        `;
    }

    // Page Numbers
    for(let i = 1; i <= totalPages; i++){

        buttons += `
            <button class="page-btn ${currentPage === i ? 'active' : ''}"
                onclick="changePage(${i})">
                ${i}
            </button>
        `;
    }

    // Next Button
    if(currentPage < totalPages){
        buttons += `
            <button class="page-btn" onclick="changePage(${currentPage + 1})">
                Next
            </button>
        `;
    }

    document.getElementById("pagination").innerHTML = buttons;
}

// =========================
// CHANGE PAGE
// =========================
function changePage(page){

    currentPage = page;

    displayVideos(currentPage);

    window.scrollTo({
        top: document.getElementById("youtube-videos").offsetTop - 100,
        behavior: "smooth"
    });
}
</script>


<style>
#youtube-videos{
    padding:60px 0;
}
.you-gallery h1 {
    font-family: var(--second-font);
    font-weight: 700;
    font-style: Bold;
    font-size: 90px;
    leading-trim: NONE;
    line-height: 89px;
    letter-spacing: 0%;
    color: var(--char);
    text-transform: uppercase;
    text-align: center;
}
.video-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:30px;
}

.video-card{
    background:#fff;
}

.video-thumb{
    position:relative;
    overflow:hidden;
    border-radius:12px;
}

.video-thumb img{
    width:100%;
    height:250px;
    object-fit:cover;
    display:block;
}

.play-btn{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    background:red;
    color:#fff;
    width:60px;
    height:60px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}

.video-card h3{
    font-size:20px;
    margin-top:15px;
    line-height:1.5;
}
.pagination{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
    margin-top:50px;
    flex-wrap:wrap;
}

.page-btn{
    min-width:45px;
    height:45px;
    padding:0 14px;
    border:none;
    background:#eee;
    cursor:pointer;
    border-radius:8px;
    font-size:16px;
    transition:0.3s;
}

.page-btn.active{
    background:#2F4F46;
    color:#fff;
}

.page-btn:hover{
    background:#2F4F46;
    color:#fff;
}

.page-dots{
    padding:0 5px;
    font-size:18px;
    font-weight:bold;
}

.page-btn.active{
    background:#2F4F46;
    color:#fff;
}

.page-btn:hover{
    background:#2F4F46;
    color:#fff;
}

/* Tablet */
@media(max-width:991px){

    .video-grid{
        grid-template-columns:repeat(2,1fr);
    }

}

/* Mobile */
@media(max-width:767px){

    .video-grid{
        grid-template-columns:1fr;
    }

    .video-thumb img{
        height:220px;
    }

}
</style>
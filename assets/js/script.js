// Header

$(document).ready(function () {
    $('.mobile-menu a').click(function () {

        $('.mobile-menu a').removeClass('menu-active');

        $(this).addClass('menu-active');
    });
});

$(document).ready(function () {
    $("#hamburger").click(function () {
        $("#mobileMenu").toggleClass("active");
    });
});


// Our church

document.addEventListener("DOMContentLoaded", function () {

  const items = document.querySelectorAll(".item");

  items.forEach(item => {
    const top = item.querySelector(".top");

    top.addEventListener("click", () => {

      // if already open → CLOSE it
      if (item.classList.contains("active")) {
        item.classList.remove("active");
        item.querySelector(".icon").textContent = "+";
        return;
      }

      // close all items
      items.forEach(i => {
        i.classList.remove("active");
        i.querySelector(".icon").textContent = "+";
      });

      // open clicked item
      item.classList.add("active");
      item.querySelector(".icon").textContent = "−";

    });
  });

});

// Contact Form Validation

$(document).ready(function () {

    /* ONLY ALPHABETS */
    $.validator.addMethod(
        "lettersOnly",
        function(value, element) {
            return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
        },
        "Please enter only alphabets"
    );

    /* ONLY NUMBERS */
    $.validator.addMethod(
        "numbersOnly",
        function(value, element) {
            return this.optional(element) || /^[0-9]+$/.test(value);
        },
        "Please enter only numbers"
    );
    $(".contact-form").validate({
        rules: {

            first_name: {
                required: true,
                minlength: 2,
                maxlength: 30,
                lettersOnly: true
            },

            last_name: {
                required: true,
                minlength: 2,
                maxlength: 30,
                lettersOnly: true
            },

            email: {
                required: true,
                email: true
            },

            phone: {
                required: true,
                numbersOnly: true,
                minlength: 10,
                maxlength: 10
            },

            help: {
                required: true
            },

            message: {
                required: true,
                minlength: 10,
                maxlength: 200
            }

        },

        messages: {

            first_name: {
                required: "Please enter first name",
                minlength: "Minimum 2 characters required",
                lettersOnly: "Only alphabets allowed"
            },

            last_name: {
                required: "Please enter last name",
                minlength: "Minimum 2 characters required",
                lettersOnly: "Only alphabets allowed"
            },

            email: {
                required: "Please enter email address",
                email: "Please enter valid email address"
            },

            phone: {
                required: "Please enter phone number",
                numbersOnly: "Only numbers allowed",
                minlength: "Phone number must be 10 digits",
                maxlength: "Phone number must be 10 digits"
            },

            help: {
                required: "Please select inquiry type"
            },

            message: {
                required: "Please enter message",
                minlength: "Message should be minimum 10 characters",
                maxlength: "Maximum 200 characters allowed"
            }

        },

        errorElement: "span",

        errorPlacement: function(error, element) {

            error.addClass("error-message");

            if (element.attr("type") == "radio") {
                error.appendTo(".radio-wrapper");
            } else {
                error.insertAfter(element);
            }
        },

        highlight: function(element) {
            $(element).addClass("input-error");
        },

        unhighlight: function(element) {
            $(element).removeClass("input-error");
        },

        submitHandler: function(form) {
            Swal.fire({
                title: "Confirm Submission",
                text: "Are you sure you want to submit this form?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Submit",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#355c50",
                cancelButtonColor: "#d33"
            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire({
                        title: "Submitting...",
                        text: "Please wait",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    form.submit();
                }

            });

        }
    });

});


// Sermon Slider

$(document).ready(function(){
    let currentIndex = 0;
    const wrapper = $(".sermon-wrapper");
    const slides = $(".sermon-wrapper > div");
    const progress = $(".slider-line span");

    function slidesPerView(){

        if($(window).width() <= 480){
            return 1;
        }
        else if($(window).width() <= 991){
            return 2;
        }
        else{
            return 3;
        }
    }
    function updateSlider(){
        const perView = slidesPerView();
        const slideWidth = slides.outerWidth(true);
        wrapper.css(
            "transform",
            `translateX(-${currentIndex * slideWidth}px)`
        );
        const progressWidth =
        ((currentIndex + perView) / slides.length) * 100;

        progress.css("width", progressWidth + "%");
    }
    function nextSlide(){
        const perView = slidesPerView();
        const maxIndex = slides.length - perView;
        currentIndex++;
        if(currentIndex > maxIndex){
            currentIndex = 0;
        }
        updateSlider();
    }
    function prevSlide(){
        const perView = slidesPerView();
        const maxIndex = slides.length - perView;
        currentIndex--;
        if(currentIndex < 0){
            currentIndex = maxIndex;
        }
        updateSlider();
    }
    $(".next").click(function(){
        nextSlide();
    });

    $(".prev").click(function(){
        prevSlide();
    });

    /* AUTOPLAY */

    let autoSlide = setInterval(function(){
        nextSlide();
    }, 3000);

    /* PAUSE ON HOVER */

    $(".sermon-main").hover(

        function(){
            clearInterval(autoSlide);
        },

        function(){

            autoSlide = setInterval(function(){
                nextSlide();
            }, 3000);

        }

    );

    $(window).resize(function(){
        updateSlider();
    });

    updateSlider();

});


$(document).ready(function () {

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

                                    <span class="play-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="25" height="25" viewBox="0 0 163.861 163.861">
                                            <g>
                                                <path d="M34.857 3.613C20.084-4.861 8.107 2.081 8.107 19.106v125.637c0 17.042 11.977 23.975 26.75 15.509L144.67 97.275c14.778-8.477 14.778-22.211 0-30.686L34.857 3.613z"
                                                    fill="#ffffff">
                                                </path>
                                            </g>
                                        </svg>
                                    </span>

                                </div>

                            </a>

                            <a href="https://www.youtube.com/watch?v=${videoId}" target="_blank">
                                <h3>${title}</h3>
                            </a>

                        </div>
                    `;
                });

                $("#videoGrid").html(html);

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

                $("#pagination").html(paginationHTML);

                $(".page-btn").on("click", function () {

                    currentPage = Number($(this).data("page"));

                    displayVideos(currentPage);

                    $("html, body").animate({
                        scrollTop: $("#youtube-videos").offset().top - 100
                    }, 500);

                });
            }

            // Initial Load
            displayVideos(currentPage);

        } catch (error) {

            console.log("YouTube Error:", error);

            $("#videoGrid").html("<p>Unable to load videos.</p>");
        }
    }

    fetchYouTubeVideos();

});

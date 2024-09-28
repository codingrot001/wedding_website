document.addEventListener("DOMContentLoaded", function () {
    const galleryModal = new bootstrap.Modal(
        document.getElementById("galleryModal"),
        {
            keyboard: true,
            backdrop: "static",
        }
    );
    const carousel = new bootstrap.Carousel(
        document.getElementById("carouselGallery")
    );

    //  gallery item click to show modal
    const galleryItems = document.querySelectorAll(".gallery-item");
    galleryItems.forEach((item, index) => {
        item.addEventListener("click", () => {
            galleryModal.show();
            carousel.to(index);
        });
    });

    // Dropzone configuration
    Dropzone.options.uploadDropzone = {
        url: "{{ route('upload.store') }}",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        maxFilesize: 50, // MB
        addRemoveLinks: true,
        acceptedFiles: "image/*,video/*",

        init: function () {
            this.on("error", function (file, response) {
                console.log("Error uploading file:", response);
            });

            this.on("success", function (file, response) {
                // Hide the upload modal
                const uploadModal = new bootstrap.Modal(
                    document.getElementById("uploadModal")
                );
                uploadModal.hide();

                // Refresh the page to show the new image
                setTimeout(() => {
                    location.reload();
                }, 500); // Adjust the delay as needed
            });
        },
    };

    // // Background image change functionality
    // const gallery = document.getElementById("background");
    // const imageUrls = [
    //     'url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRaxpE2FjGO1ZvnvVKz2L84h7cvoWz0PzTxxA&s")',
    //     'url("https://img.freepik.com/free-photo/beautiful-archway-decorated-with-floral-composition-outdoors_8353-10972.jpg")',
    //     'url("https://img.freepik.com/free-photo/stage-with-white-curtain-that-says-pink-white-it_1340-24739.jpg")',
    // ];

    // let currentImageIndex = 0;

    // function changeBackground() {
    //     gallery.style.backgroundImage = imageUrls[currentImageIndex];
    //     currentImageIndex = (currentImageIndex + 1) % imageUrls.length;
    // }

    // setInterval(changeBackground, 5000);

    // Refresh page when the upload modal is hidden
    const uploadModalElement = document.getElementById("uploadModal");
    uploadModalElement.addEventListener("hide.bs.modal", function () {
        location.reload();
    });
});

// Set the count down to the wedding day
const countDownDate = new Date("Dec 28, 2024 00:00:00").getTime();
// const countDownDate = new Date("Dec 28, 2022 10:00:00").getTime();

// To Update the count down every sec.
const x = setInterval(() => {
    // To get the current date and time
    const now = new Date().getTime();

    // The distance btw now and the wedding date
    const distance = countDownDate - now;

    // Calculations for days, hrs, min, sec
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hrs = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    const min = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const sec = Math.floor((distance % (1000 * 60)) / 1000);

    // Out put the result
    const count = document.getElementById("count");
    count.innerHTML = ` ${days}d ${hrs}h ${min}m ${sec}s `;
    const firstContainer = document.getElementById("firstContainer");
    const secondContainer = document.getElementById("secondContainer");
    firstContainer.style.display = "none";

    //  If the count down is over
    if (distance < 0) {
        clearInterval(x);
        secondContainer.style.display = "none";
        firstContainer.style.display = "inline";
        // count.style.display = "none";
    }
}, 1000);

const music = document.getElementById("background-music");
music.volume = 0.5;
document.addEventListener("click", () => {
    if (music.paused) {
        music.play();
    }
});

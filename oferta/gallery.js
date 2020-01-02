let isGalleryVisible = false;
let currentPhoto = 0;
let photoArray = [];

const getImages = () => {
  let tempArray = document.querySelectorAll(".photo-img");
  tempArray.forEach(item => {
    photoArray.push(item.src);
  });
};

getImages();

const showGallery = event => {
  if (!isGalleryVisible) {
    isGalleryVisible = true;
    currentPhoto = photoArray.indexOf(event.target.src);
    document.getElementById("gallery").style.display = "block";
    document.getElementById("photo-preview").src = photoArray[currentPhoto];
    currentPhoto++;
  }
};

const nextImage = () => {
  if (currentPhoto === photoArray.length) {
    currentPhoto = 0;
  }
  document.getElementById("photo-preview").src = photoArray[currentPhoto];
  currentPhoto++;
};

const prevImage = () => {
  if (currentPhoto < 0) {
    currentPhoto = photoArray.length - 1;
  }
  document.getElementById("photo-preview").src = photoArray[currentPhoto];
  currentPhoto--;
};

const galleryClose = () => {
  if (isGalleryVisible) {
    isGalleryVisible = false;
    document.getElementById("gallery").style.display = "none";
  }
};

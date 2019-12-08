let photoNum = 2;

const addAnotherPhoto = event => {
  event.preventDefault();
  let div = document.createElement("div");
  div.className = "photo-container";
  div.innerHTML = `<div class="photo-preview" id="photo-preview-${photoNum}"></div>
    <input type="file" name="photo-${photoNum}" id="photo-${photoNum}" onchange="fileChangeHandler(event);" accept="image/jpeg">`;
  document.getElementById("photos-container").appendChild(div);
  photoNum++;
};

const fileChangeHandler = event => {
  event.preventDefault();
  let id = event.target.id.split("-")[1];
  let url = URL.createObjectURL(event.target.files[0]);
  let img = document.createElement("img");
  img.src = url;
  img.className = "preview-img";
  console.log(id);
  document.getElementById(`photo-preview-${id}`).appendChild(img);
};

const switchInputEnable = event => {
  let id = event.target.id.split("-")[1];
  if (event.target.checked) {
    document.getElementById(id).disabled = false;
    event.target.value = 1;
  } else {
    document.getElementById(id).disabled = true;
    event.target.value = 0;
  }
};

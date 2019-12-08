const goToHome = () => {
  document.getElementById("link-main-page").click();
};

const goToContact = () => {
  document.getElementById("link-contact").click();
};

const openOffer = id => {
  document.getElementById(`link-${id}`).click();
};

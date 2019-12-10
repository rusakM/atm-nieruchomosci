let isMenuBarVisible = false;

const switchMenuBar = () => {
  if (!isMenuBarVisible) {
    document.getElementById("left-menu").style.display = "inline";
    isMenuBarVisible = true;
  } else {
    document.getElementById("left-menu").style.display = "none";
    isMenuBarVisible = false;
  }
};

/**
 *  custom selects
 */

let isTransactionTypeVisible = false;
let isPropertyTypeVisible = false;
let isMaketTypeVisible = false;
let isLocalizationListVisible = false;

const switchTransactionType = event => {
  event.preventDefault();
  let menu = document.getElementById("transaction-type-list");
  if (!isTransactionTypeVisible) {
    closeAll();
    menu.style.display = "block";
    isTransactionTypeVisible = true;
  } else {
    menu.style.display = "none";
    isTransactionTypeVisible = false;
  }
};

const switchPropertyType = event => {
  event.preventDefault();
  let menu = document.getElementById("property-type-list");
  if (!isPropertyTypeVisible) {
    closeAll();
    menu.style.display = "block";
    isPropertyTypeVisible = true;
  } else {
    menu.style.display = "none";
    isPropertyTypeVisible = false;
  }
};

const switchMarketType = event => {
  event.preventDefault();
  let menu = document.getElementById("market-type-list");
  if (!isMaketTypeVisible) {
    closeAll();
    menu.style.display = "block";
    isMaketTypeVisible = true;
  } else {
    menu.style.display = "none";
    isMaketTypeVisible = false;
  }
};

const switchLocalizationList = event => {
  event.preventDefault();
  let menu = document.getElementById("localization-list");
  if (!isLocalizationListVisible) {
    closeAll();
    menu.style.display = "block";
    isLocalizationListVisible = true;
  } else {
    menu.style.display = "none";
    isLocalizationListVisible = false;
  }
};

const closeAll = () => {
  document.getElementById("transaction-type-list").style.display = "none";
  document.getElementById("property-type-list").style.display = "none";
  document.getElementById("market-type-list").style.display = "none";
  document.getElementById("localization-list").style.display = "none";

  isTransactionTypeVisible = isPropertyTypeVisible = isMaketTypeVisible = isLocalizationListVisible = false;
};

const generateDescriptionForSelectButton = (functionName, desc) => {
  return `
  <span class="select-description">${desc}</span>
  <span class="close-btn" onclick="${functionName}(event);">
  <i class="fas fa-times"></i>
  </span>`;
};

const generateDefaultDescription = desc => {
  return `<i class="fas fa-chevron-down"></i>
  <span class="select-description">${desc}:</span>`;
};

const selectTransactionType = event => {
  event.stopPropagation();
  let select = document.getElementById("transaction-type");
  let button = document.getElementById("custom-transaction-type");
  let span = '<span class="select-description"></span>';
  if (event.target.id === "rent") {
    select.value = 0;
    closeAll();
    button.innerHTML = generateDescriptionForSelectButton(
      "selectTransactionType",
      "Wynajem"
    );
  } else if (event.target.id === "sell") {
    select.value = 1;
    closeAll();
    button.innerHTML = generateDescriptionForSelectButton(
      "selectTransactionType",
      "Sprzedaż"
    );
  } else {
    select.value = -1;
    closeAll();
    button.innerHTML = generateDefaultDescription("Rodzaj transakcji");
  }
};

const selectPropertyType = event => {
  event.stopPropagation();
  let select = document.getElementById("property-type");
  let button = document.getElementById("custom-property-type");

  if (event.target.id !== "") {
    select.value = parseInt(event.target.id.split("-")[2]);
    closeAll();
    button.innerHTML = generateDescriptionForSelectButton(
      "selectPropertyType",
      event.target.innerText
    );
  } else {
    select.value = -1;
    closeAll();
    button.innerHTML = generateDefaultDescription("Rodzaj nieruchomości");
  }
};

const selectMarketType = event => {
  event.stopPropagation();
  let select = document.getElementById("market-type");
  let button = document.getElementById("custom-market-type");

  if (event.target.id === "primary") {
    select.value = 0;
    closeAll();
    button.innerHTML = generateDescriptionForSelectButton(
      "selectMarketType",
      event.target.innerText
    );
  } else if (event.target.id === "aftermarket") {
    select.value = 1;
    closeAll();
    button.innerHTML = generateDescriptionForSelectButton(
      "selectMarketType",
      event.target.innerText
    );
  } else {
    select.value = -1;
    closeAll();
    button.innerHTML = generateDefaultDescription("Rynek");
  }
};

const selectLocalization = event => {
  event.stopPropagation();
  let select = document.getElementById("localization");
  let button = document.getElementById("custom-localization");

  if (event.target.id !== "") {
    select.value = parseInt(event.target.id.split("-")[1]);
    closeAll();
    button.innerHTML = generateDescriptionForSelectButton(
      "selectLocalization",
      event.target.innerText
    );
  } else {
    select.value = -1;
    closeAll();
    button.innerHTML = generateDefaultDescription("Lokalizacja");
  }
};

//funkctions for hrefs

const defaultLink = "http://localhost/atm-nieruchomosci";

const goBack = () => {
  document.getElementById("back-link").click();
};

const goToSearch = () => {
  document.getElementById("searchLink").click();
};

const scroller = id => {
  document.getElementById(`${id}`).scrollIntoView();
};

const goToHome = () => {
  let link = document.createElement("a");
  link.href = defaultLink;
  link.click();
};

const openOffer = id => {
  let offer = document.createElement("a");
  offer.href = `${defaultLink}/oferta/?id=${id}`;
  offer.click();
};

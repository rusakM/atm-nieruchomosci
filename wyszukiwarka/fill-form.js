const fill = () => {
  let url = new URL(document.URL);
  if (url.search === "") {
    return;
  }
  let transactionType = parseInt(url.searchParams.get("transaction-type"));
  let propertyType = parseInt(url.searchParams.get("property-type"));
  let marketType = parseInt(url.searchParams.get("market-type"));
  let localization = parseInt(url.searchParams.get("localization"));
  let pricemin = parseInt(url.searchParams.get("pricemin"));
  let pricemax = parseInt(url.searchParams.get("pricemax"));
  let metersmin = parseInt(url.searchParams.get("metersmin"));
  let metersmax = parseInt(url.searchParams.get("metersmax"));

  if (transactionType > -1) {
    if (transactionType === 0) {
      document.getElementById("rent").click();
    } else if (transactionType === 1) {
      document.getElementById("sell").click();
    }
  }

  if (propertyType > -1) {
    document.getElementById(`property-type-${propertyType}`).click();
  }

  if (marketType > -1) {
    if (marketType === 0) {
      document.getElementById("primary").click();
    } else if (marketType === 1) {
      document.getElementById("aftermarket").click();
    }
  }

  if (localization > -1) {
    document.getElementById(`localization-${localization}`).click();
  }

  if (pricemin > 0) {
    document.getElementById("pricemin").value = pricemin;
  }

  if ((pricemax > pricemin || Number.isNaN(pricemin)) && pricemax > 0) {
    document.getElementById("pricemax").value = pricemax;
  }

  if (metersmin > 0) {
    document.getElementById("metersmin").value = metersmin;
  }

  if ((metersmax > metersmin || Number.isNaN(metersmin)) && metersmax > 0) {
    document.getElementById("metersmax").value = metersmax;
  }
};

fill();

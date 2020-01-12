const confirmCookies = () => {
  document.getElementById("cookies-alert").style.display = "none";
  document.cookie = "cookie=close";
};

if (
  document.cookie.split(";").filter(item => item.includes("cookie=close"))
    .length
) {
  confirmCookies();
}

var topPage = Object.create(Scroll);
window.onscroll = function() {topPage.appear()};
document.getElementById("rolTop").addEventListener("click", topPage.smooth);
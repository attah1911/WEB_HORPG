// toggle class aktif
const navbarNav = document.querySelector
('.navbar-isi');
//saat di klik
document.querySelector('#menuBar').
onclick = () => {
    navbarNav.classList.toggle('active');
}
// menubar bisa pencet dimana saja 
const menubar = document.querySelector('#menuBar');

document.addEventListener('click', function (e) {
    if (!menubar.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove('active');
    }
});

// card GESER-GESER
const slider = document.querySelector('.gallery');
let isDown = false;
let startX;
let scrollLeft;

slider.addEventListener('mousedown', e => {
  isDown = true;
  slider.classList.add('active');
  startX = e.pageX - slider.offsetLeft;
  scrollLeft = slider.scrollLeft;
});
slider.addEventListener('mouseleave', _ => {
  isDown = false;
  slider.classList.remove('active');
});
slider.addEventListener('mouseup', _ => {
  isDown = false;
  slider.classList.remove('active');
});
slider.addEventListener('mousemove', e => {
  if (!isDown) return;
  e.preventDefault();
  const x = e.pageX - slider.offsetLeft;
  const SCROLL_SPEED = 3;
  const walk = (x - startX) * SCROLL_SPEED;
  slider.scrollLeft = scrollLeft - walk;
});

// sosial menghubungkan link
document.getElementById("whatsappBtn").addEventListener("click", function() {
  window.open("https://chat.whatsapp.com/invite/IJX1WpleDiR0ENnNrOIwmT", "_blank");
});

document.getElementById("discordBtn").addEventListener("click", function() {
  window.open("https://discord.gg/Nu4899hwEH", "_blank");
});

document.getElementById("instagramBtn").addEventListener("click", function() {

});

document.getElementById("registrasiButton").addEventListener("click", function() {

  window.location.href = "login.php";
});

function showConfirmation(id) {
  const popup = document.getElementById("popup");
  const confirmButton = document.getElementById("confirm-button");

  const deleteUrl = `?mod=kategori&act=hapus&id=${id}`;
  confirmButton.setAttribute("href", deleteUrl);
  console.log(Kategori,"testing");

  popup.style.display = "flex";
}

function hideConfirmation() {
  const popup = document.getElementById("popup");
  popup.style.display = "none";
}

function closePopup() {
  var popup = document.getElementById('popup');
  popup.style.display = 'none';
}

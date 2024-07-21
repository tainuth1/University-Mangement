let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
  arrow[i].addEventListener("click", (e)=>{
    let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
    arrowParent.classList.toggle("showMenu");
  });
}
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
console.log(sidebarBtn);

sidebarBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("close");
});

document.querySelector('.showDropProfile').addEventListener('click', ()=>{
  const menu = document.querySelector(".menu");
  menu.classList.toggle('popup');
});

document.addEventListener("DOMContentLoaded", function() {
  const counters = document.querySelectorAll('.value-number');

  counters.forEach(counter => {
      const target = +counter.getAttribute('data-target');
      const isDollarCounter = counter.textContent.trim().startsWith('$');
      let count = 0;
      const duration = 2000; // 2 seconds
      const increment = target / (duration / 16); // assuming 60 frames per second

      function updateCounter() {
          count += increment;
          if (count < target) {
              counter.textContent = isDollarCounter ? `$${Math.ceil(count)}` : Math.ceil(count);
              requestAnimationFrame(updateCounter);
          } else {
              counter.textContent = isDollarCounter ? `$${target}` : target;
          }
      }

      requestAnimationFrame(updateCounter);
  });
});

document.addEventListener("DOMContentLoaded", function() {
  // Show the alert box after a short delay to trigger the transition
  setTimeout(function() {
      document.getElementById("alert-box").classList.add("show");
  }, 100);

  // Hide the alert box when the close button is clicked
  document.getElementById("hide").addEventListener("click", function() {
      document.getElementById("alert-box").classList.remove("show");
      document.getElementById("alert-box").classList.add("hide");
  });
});

document.addEventListener('DOMContentLoaded', function() {
  var alertBox = document.getElementById('alert-box');
  var hideButton = document.getElementById('hide');

  // Show the alert box with animation
  if (alertBox) {
      setTimeout(function() {
          alertBox.classList.add('show');
      }, 100); // Delay to allow CSS transition
  }

  // Hide the alert box with animation when button is clicked
  if (hideButton) {
      hideButton.addEventListener('click', function() {
          alertBox.classList.remove('show');
          alertBox.classList.add('hide');

          // Optional: Remove the alert box from the DOM after the animation completes
          setTimeout(function() {
              alertBox.parentNode.removeChild(alertBox);
          }, 100); // Duration of the CSS transition
      });
  }
});

//show notification
document.getElementById('notification').addEventListener('click', ()=>{
  const notifi = document.querySelector('.notification-wrapper');
  notifi.classList.toggle('pop-noti');
});

document.getElementById('add-event').addEventListener('click', ()=>{
  document.getElementById('sub-menu').classList.toggle('show-sub-menu');
});
const minimizeBtn = document.getElementById("minimizeIcon");
minimizeBtn.addEventListener("click", () => {
  if (minimizeBtn.classList.contains("minimizeIconLeft")) {
    minimizeBtn.classList.replace("minimizeIconLeft", "minimizeIconRight");
  } else {
    minimizeBtn.classList.replace("minimizeIconRight", "minimizeIconLeft");
  }
  minSlideBar();
});

function minSlideBar() {
  const sideBar = document.querySelector("nav");
  const adminHeader = document.querySelector(".body_container");
  const mediaQuery = window.matchMedia("(max-width:640px)");

  function navcontainerChange() {
    if (sideBar.classList.contains("navbar_container")) {
      sideBar.classList.replace("navbar_container", "minbar_container");
    } else {
      sideBar.classList.replace("minbar_container", "navbar_container");
    }
  }
  navcontainerChange();
  function mediaQueryCheck(m) {
    if (m.matches) {
      adminHeader.style.marginLeft = "0";
    } else {
      if (sideBar.classList.contains("minbar_container")) {
        adminHeader.style.marginLeft = "80px";
      } else {
        adminHeader.style.marginLeft = "200px";
      }
    }
  }
  mediaQueryCheck(mediaQuery);
  mediaQuery.addEventListener("change", mediaQueryCheck);
}

// side bar hover effect
// dash board
const dashboard = document.getElementById("dashBoard");
const dashBoardImage = document.querySelector(".dashboardImg");
dashboard.addEventListener("mouseover", () => {
  dashBoardImage.src = "assect/logo/dashboard-h.png";
});
dashboard.addEventListener("mouseout", () => {
  dashBoardImage.src = "assect/logo/dashboard-n.png";
});

// students
const students = document.getElementById("students");
const studentsImage = document.querySelector(".studentImg");
students.addEventListener("mouseover", () => {
  studentsImage.src = "assect/logo/student-h.png";
});
students.addEventListener("mouseout", () => {
  studentsImage.src = "assect/logo/student-n.png";
});

//Culture Topic

const culture = document.getElementById("culture");
const cultureImage = document.querySelector(".cultureImg");
culture.addEventListener("mouseover", () => {
  cultureImage.src = "assect/logo/culture-h.png";
});
culture.addEventListener("mouseout", () => {
  cultureImage.src = "assect/logo/culture-n.png";
});

//Homework

const homework = document.getElementById("homework");
const homeworkImage = document.querySelector(".homeworkImg");
homework.addEventListener("mouseover", () => {
  homeworkImage.src = "assect/logo/homework-h.png";
});
homework.addEventListener("mouseout", () => {
  homeworkImage.src = "assect/logo/homework-n.png";
});

//Activity

const activity = document.getElementById("activity");
const activityImage = document.querySelector(".activityImg");
activity.addEventListener("mouseover", () => {
  activityImage.src = "assect/logo/activity-h.png";
});
activity.addEventListener("mouseout", () => {
  activityImage.src = "assect/logo/activity-n.png";
});

//songs

const songs = document.getElementById("songs");
const songsImage = document.querySelector(".songsImg");
songs.addEventListener("mouseover", () => {
  songsImage.src = "assect/logo/music-h.png";
});
songs.addEventListener("mouseout", () => {
  songsImage.src = "assect/logo/music-n.png";
});

//e-book

const eBook = document.getElementById("E-book");
const eBookImage = document.querySelector(".EbookImg");
eBook.addEventListener("mouseover", () => {
  eBookImage.src = "assect/logo/e-book-h.png";
});
eBook.addEventListener("mouseout", () => {
  eBookImage.src = "assect/logo/e-book-n.png";
});

//video

// const tuvideo=document.getElementById('pre-anim-video');
// const tuvideoImage=document.querySelector('.pre-anim-videoImg');
// tuvideo.addEventListener('mouseover',()=>{
//     tuvideoImage.src="assect/logo/video-h.png"
// })
// tuvideo.addEventListener('mouseout',()=>{
//     tuvideoImage.src="assect/logo/video-n.png"
// })

"use strict";
// 詳細表示画面、ポップアップの実装

const details = document.querySelector("#details");
const detailsOverlay = document.querySelector("#details-overlay");
const detailsCloseButton = document.querySelector("#details-closeButton");
const detailsOpenButton = document.querySelectorAll(".agents-detail");
// const likeCloseButton2 = document.querySelector("#likeList-closeButton2");

//閉じるボタン
detailsCloseButton.addEventListener("click", function () {
  details.classList.toggle("closed");
  detailsOverlay.classList.toggle("closed");
});

// likeCloseButton2.addEventListener("click", function () {
//     likeList.classList.toggle("closed");
//     likeListOverlay.classList.toggle("closed");
//   });

//開くボタン
detailsOpenButton.forEach(function(button) {
    button.addEventListener("click", function() {
        details.classList.toggle("closed");
        detailsOverlay.classList.toggle("closed");
    });
});

//エージェント編集のポップアップ
const editButton = document.querySelector("#edit-button");
const editForm = document.querySelector("#edit");
const editFormOverlay = document.querySelector("#edit-overlay");
const editFormCloseButton = document.querySelector("#edit-closeButton");

//閉じるボタン
editFormCloseButton.addEventListener("click", function () {
  editForm.classList.toggle("closed");
  editFormOverlay.classList.toggle("closed");
});

//開くボタン
editButton.addEventListener("click", function () {
  editForm.classList.toggle("closed");
  editFormOverlay.classList.toggle("closed");
});

// const suggestSlideOptions={
//   type:'loop',
//   gap:40,
//   perPage:3,
//   pagination:true,
//   focus:0,
//   breakpoints:{
//     768:{
//       perPage:1
//     }
//   }
// }
// new Splide('#js-suggestSlide',suggestSlideOptions).mount();
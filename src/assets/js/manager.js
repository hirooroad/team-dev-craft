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
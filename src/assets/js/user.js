"use strict";
// エージェント一覧画面、ポップアップの実装

const likeList = document.querySelector("#likeList");
const likeListOverlay = document.querySelector("#likeList-overlay");
const likeCloseButton = document.querySelector("#likeList-closeButton");
const likeOpenButton = document.querySelector("#likeList-button");
const likeCloseButton2 = document.querySelector("#likeList-closeButton2");

//閉じるボタン
likeCloseButton.addEventListener("click", function () {
  likeList.classList.toggle("likeList-closed");
  likeListOverlay.classList.toggle("likeList-closed");
});

likeCloseButton2.addEventListener("click", function () {
    likeList.classList.toggle("likeList-closed");
    likeListOverlay.classList.toggle("likeList-closed");
  });

//開くボタン
likeOpenButton.addEventListener("click", function () {
  likeList.classList.toggle("likeList-closed");
  likeListOverlay.classList.toggle("likeList-closed");
});

// FQAのアコーディオンメニュー
// {
//   const QAaccordion = document.querySelectorAll('dt');

//   QAaccordion.forEach(dt => {
//     dt.addEventListener("click", () => {
//       dt.parentNode.classList.toggle("appear");
//     });
//   });
// }

// const selectArea = document.getElementById('area');

// または、`value` プロパティを使用して選択項目を直接指定
// selectArea.value = '3';




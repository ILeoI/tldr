const titleBar = document.getElementById("page-title");
const title = document.title.replace("TLDR: ", "");

titleBar.innerText = title;
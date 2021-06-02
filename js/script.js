$(".sm-box").delay(3000).slideUp();

function togglePwd() {
  let btn = document.querySelector(".pwdInp");
  let hideIcon = document.querySelector(".fa-eye-slash");
  let showIcon = document.querySelector(".fa-eye");

  if (btn.type === "password") {
    btn.type = "text";
    showIcon.style.display = "none";
    hideIcon.style.display = "";
  } else {
    btn.type = "password";
    showIcon.style.display = "";
    hideIcon.style.display = "none";
  }
}

/////// Read More/Less fuctionality

//1. getting contents of the posts
let posts_Html_Collection = document.getElementsByClassName("adopt_card_text");
let postsArr = [...posts_Html_Collection];
let contentsArr = postsArr.map((e) => e.textContent);
let shortContentsArr = [];
let close_mode_contents_html_arr = [];
let open_mode_contents_html_arr = [];

//2. creating short contents array
contentsArr.forEach((content) => {
  let contentLength = content.length;
  let maxStrLength = 100;
  if (contentLength > maxStrLength) {
    let cutStr = content.substring(0, maxStrLength);
    let endPoint = content.lastIndexOf(" ");
    content = endPoint != -1 ? cutStr.substring(0, endPoint) : cutStr;
  } else {
    content = "";
  }
  shortContentsArr.push(content);
});

//3. creating close and open mode contents' html array
shortContentsArr.forEach((content, index) => {
  let contentHtml, longContentHtml;
  if (content) {
    contentHtml = `<span onclick="readMore(this,'more')" id="shortPost-${index}">${content}...  <span id="readMoreBtn">Read More</span></span>`;
    longContentHtml = `<span onclick="readMore(this,'less')" id="fullPost-${index}">${contentsArr[index]}  <span id="readLessBtn">Read Less</span></span>`;
  } else {
    contentHtml = `<span id="post-${index}">${contentsArr[index]}</span>`;
    longContentHtml = "";
  }
  close_mode_contents_html_arr.push(contentHtml);
  open_mode_contents_html_arr.push(longContentHtml);

  //4. diaplying the posts contents in their close version (if they are short posts to begin with, it will show the post as it is)
  e = postsArr[index];
  e.innerHTML = contentHtml;
});

function readMore(e, more_or_less) {
  let postId = e.id;
  let postIdArr = postId.split("-");
  let postNum = postIdArr[1];
  let p = e.parentElement;

  if (more_or_less === "more") {
    p.innerHTML = open_mode_contents_html_arr[postNum];
  } else if (more_or_less === "less") {
    p.innerHTML = close_mode_contents_html_arr[postNum];
  }
}

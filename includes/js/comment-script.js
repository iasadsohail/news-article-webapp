//getting DOM elements
const modal = document.getElementById("add-comment-modal");
const btn = document.getElementById("add-comment-btn");
const span = document.getElementsByClassName("close")[0];
const add_c_res = document.getElementById("add-c-res").value;
const article_id = document.getElementById('article-id').value;

//open and close modal events
btn.onclick = function () { modal.style.display = "block"; }
span.onclick = function () { modal.style.display = "none"; }
window.onclick = function (event) { if (event.target == modal) modal.style.display = "none"; }

if (add_c_res == 'success') {
    alert('Comment Has Been Added');
    window.location.assign('article.php?a_id=' + article_id);
} else if(add_c_res == 'failure') {
    alert('Comment Could Not Be Added');
    window.location.assign('article.php?a_id=' + article_id);
}


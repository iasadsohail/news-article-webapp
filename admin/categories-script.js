//getting DOM elements
const modal = document.getElementById("add-category-modal");
const btn = document.getElementById("add-category-btn");
const span = document.getElementById("close-add-modal");

const edit_modal = document.getElementById('edit-category-modal');
const edit_modal_span = document.getElementById("close-edit-modal");

const del_res = document.getElementById('del-res').value;
const add_cat_res = document.getElementById('add-cat-res').value;
const edit_cat_res = document.getElementById('edit-cat-res').value;
const edit_id = document.getElementById('edit-id').value;

if (del_res == 'success') {
    alert('Category Has Been Deleted');
    window.location.assign('categories.php');
} else if (del_res == 'failure') {
    alert('Category Could Not Be Deleted');
    window.location.assign('categories.php');
}

if (add_cat_res == 'success') {
    alert('Category Has Been Added');
    window.location.assign('categories.php');
} else if (add_cat_res == 'failure') {
    alert('Category Could Not Be Added');
    window.location.assign('categories.php');
}

if (edit_cat_res == 'success') {
    alert('Category Has Been Updated');
    window.location.assign('categories.php');
} else if (edit_cat_res == 'failure') {
    alert('Category Could Not Be Updated');
    window.location.assign('categories.php');
}

if (edit_id != '-1') {
    edit_modal.style.display = "block";
}

//open and close modal events
btn.onclick = function () { modal.style.display = "block"; }
span.onclick = function () { modal.style.display = "none"; }
edit_modal_span.onclick = function () { edit_modal.style.display = "none"; }
window.onclick = function (event) { if (event.target == modal) modal.style.display = "none"; }

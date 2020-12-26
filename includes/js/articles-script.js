const delRes = document.getElementById('del-res').value;
const addRes = document.getElementById('add-res').value;
const catId = document.getElementById('cat-id').value;
const filterInput = document.getElementById('filter-cat-id');

filterInput.value = catId;

if(delRes == 'success') {
    alert('Article Has Been Deleted.');
    window.location.assign('articles.php');
} else if(delRes == 'failure') {
    alert('Article Could Not Be Deleted.');
    window.location.assign('articles.php');
}

if(addRes == 'success') {
    alert('Article Has Been Created.');
    window.location.assign('articles.php');
}



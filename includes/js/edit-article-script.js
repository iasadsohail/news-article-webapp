const catId = document.getElementById('category-id').value;
const aId = document.getElementById('article-id').value;
const categorySelector = document.getElementById('category');
const editRes = document.getElementById('edit-res').value;

if(catId >= 0) {
    categorySelector.value = catId;
}

switch (editRes) {
    case 'failure':
        alert('Server Error! Try Again Later');
        window.location.assign('edit_article.php?edit_id='+aId);
        break;
    case 'undefined':
        alert('Something went wrong with file uploads!');
        window.location.assign('edit_article.php?edit_id='+aId);
        break;
    case 'large_size':
        alert('File Size Too Big!');
        window.location.assign('edit_article.php?edit_id='+aId);
        break;
    case 'wrong_format':
        alert('Wrong File Format!');
        window.location.assign('edit_article.php?edit_id='+aId);
        break;
}
const addRes = document.getElementById('add-res').value;

switch (addRes) {
    case 'failure':
        alert('Server Error! Try Again Later');
        window.location.assign('new_article.php');
        break;
    case 'undefined':
        alert('Something went wrong with file uploads!');
        window.location.assign('new_article.php');
        break;
    case 'large_size':
        alert('File Size Too Big!');
        window.location.assign('new_article.php');
        break;
    case 'wrong_format':
        alert('Wrong File Format!');
        window.location.assign('new_article.php');
        break;
}
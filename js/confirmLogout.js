function confirmLogout(isIndex) {
    if (confirm('Вы точно хотите выйти?')) {
       if (isIndex) window.location.href = './php/unLogin.php';
       else window.location.href = './../php/unLogin.php';
    }
}
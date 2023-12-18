function confirmLogout() {
    if (confirm('Вы точно хотите выйти?')) {
        window.location.href = '../pages/unLogin.php'; 
    }
}
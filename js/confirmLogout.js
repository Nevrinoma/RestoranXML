function confirmLogout(isIndex) {
    if (confirm('Kas sa oled kindel, et tahad välja tulla?')) {
       if (isIndex) window.location.href = './php/unLogin.php';
       else window.location.href = './../php/unLogin.php';
    }
}
function showPassword(td) {
    td.textContent = td.getAttribute('data-password');
}

function hidePassword(td) {
    td.textContent = '******'; // Замените на количество звездочек, соответствующее длине пароля
}

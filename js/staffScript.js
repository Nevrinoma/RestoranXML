function showPassword(td) {
    td.textContent = td.getAttribute('data-password');
}

function hidePassword(td) {
    td.textContent = '******'; 
}

function editStaff(username, name, password, role) {
    document.getElementById('editUsername').value = username;
    document.getElementById('editName').value = name;
    document.getElementById('editPassword').value = password.replace(/./g, '*');
    document.getElementById('editPassword').setAttribute('data-password', password);
    document.getElementById('editRole').value = role;
    document.getElementById('editModal').style.display = 'block';
}


document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    fetch('php/editStaff.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        hideModal();
        var staffTable = document.getElementById("staffTable");
        staffTable.getElementsByTagName("tbody")[0].innerHTML = "";
        loadStaffData();
    })
    .catch(error => alert('Ошибка: ' + error));
});



function showModal(editButton) {
    var row = editButton.parentNode.parentNode;
    document.getElementById('editName').value = row.cells[0].innerText;
    document.getElementById('editUsername').value = row.cells[1].innerText;
    document.getElementById('editPassword').setAttribute('data-password', row.cells[2].getAttribute('data-password'));
    document.getElementById('editPassword').value = row.cells[2].getAttribute('data-password').replace(/./g, '*');
    document.getElementById('editRole').value = row.cells[3].innerText;

    document.getElementById('editModal').style.display = 'block';
}

function hideModal() {
    document.getElementById('editModal').style.display = 'none';
}
function togglePasswordVisibility(passwordCell) {
    if (passwordCell.innerText.indexOf('*') >= 0) {
        passwordCell.innerText = passwordCell.getAttribute('data-password');
    } else {
        passwordCell.innerText = passwordCell.innerText.replace(/./g, '*');
    }
}

document.getElementById('editForm').onsubmit = function(event) {
    event.preventDefault();


    var formData = new FormData(this);
    

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/editStaff.php', true);
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Информация о сотруднике обновлена');
            hideModal();
            
        } else {
            alert('Произошла ошибка при обновлении информации о сотруднике');
        }
    };
    
    xhr.send(formData);
};


function deleteStaff(deleteButton) {
    if (confirm('Вы уверены, что хотите удалить этого сотрудника?')) {
        var row = deleteButton.parentNode.parentNode;
        var username = row.cells[1].innerText;

        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/deleteStaff.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                
                alert('Сотрудник удален');
                
            } else {
                alert('Произошла ошибка при удалении сотрудника');
            }
        };

        xhr.send('username=' + encodeURIComponent(username));
    }
}

function loadStaffData() {
    fetch('../php/loadStuff.php')
    .then(response => response.text())
    .then(data => {
        var staffTable = document.getElementById("staffTable");
        staffTable.getElementsByTagName("tbody")[0].innerHTML = data;
    })
    .catch(error => console.error('Ошибка:', error));
}


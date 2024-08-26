document.addEventListener("DOMContentLoaded", function () {
    loadUsers();

    document.getElementById('userForm').addEventListener('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let user = {};
        formData.forEach((value, key) => { user[key] = value });

        fetch('/api/' + (user.id ? 'update' : 'create') + '.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(user)
        }).then(response => response.json()).then(data => {
            alert(data.message || data.error);
            loadUsers();
        });
    });
});

function loadUsers() {
    fetch('/api/read.php')
        .then(response => response.json())
        .then(users => {
            let tbody = document.querySelector('#userTable tbody');
            tbody.innerHTML = '';
            users.forEach(user => {
                let row = `<tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.phone}</td>
                    <td>${user.email}</td>
                    <td>
                        <button onclick="editUser(${user.id})" class="btn btn-warning btn-sm">Редактировать</button>
                        <button onclick="deleteUser(${user.id})" class="btn btn-danger btn-sm">Удалить</button>
                    </td>
                </tr>`;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        });
}

function editUser(id) {
    fetch('/api/read.php')
        .then(response => response.json())
        .then(users => {
            let user = users.find(u => u.id === id);
            document.getElementById('id').value = user.id;
            document.getElementById('name').value = user.name;
            document.getElementById('phone').value = user.phone;
            document.getElementById('email').value = user.email;
        });
}

function deleteUser(id) {
    if (confirm('Вы уверены?')) {
        fetch('/api/delete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id })
        }).then(response => response.json()).then(data => {
            alert(data.message || data.error);
            loadUsers();
        });
    }
}
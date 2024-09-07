document.addEventListener('DOMContentLoaded', function () {
    const userForm = document.getElementById('userForm');
    const userTableBody = document.querySelector('#userTable tbody');
    let editingUserId = null;

    // Загрузка всех пользователей при загрузке страницы
    fetchUsers();

    // Обработка отправки формы для добавления/редактирования пользователя
    userForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(userForm);
        const user = {
            name: formData.get('name'),
            phone: formData.get('phone'),
            email: formData.get('email'),
        };

        if (editingUserId) {
            // Редактирование пользователя
            updateUser(editingUserId, user);
        } else {
            // Добавление нового пользователя
            addUser(user);
        }
    });

    // Функция загрузки пользователей
    function fetchUsers() {
        fetch('/users')
            .then(response => response.json())
            .then(users => {
                userTableBody.innerHTML = '';
                users.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.phone}</td>
                        <td>${user.email}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" data-id="${user.id}">Изменить</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${user.id}">Удалить</button>
                        </td>
                    `;
                    userTableBody.appendChild(row);
                });

                // Привязка событий для кнопок редактирования и удаления
                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const userId = button.getAttribute('data-id');
                        fetchUser(userId);
                    });
                });

                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const userId = button.getAttribute('data-id');
                        deleteUser(userId);
                    });
                });
            })
            .catch(error => console.error('Ошибка загрузки пользователей:', error));
    }

    // Добавление пользователя
    function addUser(user) {
        fetch('/users', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(user)
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert(data.message);
                    fetchUsers();
                    userForm.reset();
                }
            })
            .catch(error => console.error('Ошибка добавления пользователя:', error));
    }

    // Загрузка данных пользователя для редактирования
    function fetchUser(id) {
        fetch(`/users/${id}`)
            .then(response => response.json())
            .then(user => {
                if (user.error) {
                    alert(user.error);
                } else {
                    document.getElementById('name').value = user[0].name;
                    document.getElementById('phone').value = user[0].phone;
                    document.getElementById('email').value = user[0].email;
                    editingUserId = id;
                }
            })
            .catch(error => console.error('Ошибка загрузки пользователя:', error));
    }

    // Обновление пользователя
    function updateUser(id, user) {
        fetch(`/users/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(user),
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert(data.message);
                    fetchUsers();
                    userForm.reset();
                    editingUserId = null;
                }
            })
            .catch(error => console.error('Ошибка обновления пользователя:', error));
    }

    // Удаление пользователя
    function deleteUser(id) {
        if (confirm('Вы уверены, что хотите удалить этого пользователя?')) {
            fetch(`/users/${id}`, {
                method: 'DELETE',
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert(data.message);
                        fetchUsers();
                    }
                })
                .catch(error => console.error('Ошибка удаления пользователя:', error));
        }
    }
});

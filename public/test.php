<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h3 class="mb-4">Manage Users</h3>
    <form id="userForm" class="row g-3 d-flex align-items-end">
        <input type="hidden" id="id" name="id">
        <div class="col-md-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" id="phone" name="phone" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary btn-m">Сохранить</button>
        </div>
    </form>
</div>

<hr>
<div class="container mt-5">
    <h3 class="mb-4">User List</h3>
    <table id="userTable" class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <!-- Пользователи -->
        </tbody>
    </table>
</div>

<script src="js/main.js"></script>
</body>
</html>

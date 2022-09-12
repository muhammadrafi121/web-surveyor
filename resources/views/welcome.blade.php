<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  </head>
  <body>
    <div class="container">
      <form class="row g-3" method="POST" action="/user">
        @csrf
        <div class="col-md-6">
          <label for="name" class="form-label">Nama</label>
          <input type="text" class="form-control" id="name" name="name" />
        </div>
        <div class="col-md-6">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" />
        </div>
        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" />
        </div>
        <div class="col-md-6">
          <label for="role" class="form-label">Role</label>
          <select id="role" class="form-select" name="role">
            <option selected>Pilih</option>
            <option value="Administrator">Administrator</option>
            <option value="Surveyor">Surveyor</option>
            <option value="Client">Client</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" />
        </div>
        <div class="col-md-6">
          <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" />
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>

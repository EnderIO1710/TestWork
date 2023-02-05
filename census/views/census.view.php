<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <title>Document</title>
</head>
<body>
  <div class="container">
    <div class="row mt-4">
      <div class="col-6">
        <form action="#" method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="name" name="name" value="<?=$form['name'];?>">
          </div>
          <div class="mb-3">
            <label for="age" class="form-label">Возраст</label>
            <input type="text" class="form-control" id="age" name="age" value="<?=$form['age'];?>">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-6">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Имя</th>
              <th scope="col">Возраст</th>
              <th scope="col">Редактирование</th>
              <th scope="col">Удаление</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $num = 1;
              foreach ($personsList as $row) {
                echo '<tr>';
                echo '<th scope="row">'.$num.'</th>';
                echo "<th> $row[name] </th>";
                echo "<th> $row[age] </th>";
                echo '<th><a href="' . getUrlDomain() . '?id=' . $row['id'] . '">Edit</a></th>';
                echo '<th><a href="' . getUrlDomain() . '?del=' . $row['id'] . '">Delete</a></th>';
                echo '</tr>';
                $num++;
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-6">
        <div class="text-start">Переписано всего:  <?=$stat['count']?></div>
        <div class="text-start">Общий возраст: <?=$stat['ageSum']?></div>
      </div>
    </div>
  </div> 
</body>
</html>
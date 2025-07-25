<?php
$mysqli = new mysqli("localhost", "root", "", "info");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $name = $mysqli->real_escape_string($_POST['name']);
    $age = (int)$_POST['age'];
    if (!empty($name) && $age > 0) {
        $mysqli->query("INSERT INTO user (name, age) VALUES ('$name', $age)");
    }
}

// Fetch all user
$user = $mysqli->query("SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Form with AJAX Toggle</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { display: flex; gap: 10px; margin-bottom: 20px; }
        input[type="text"], input[type="number"] { padding: 5px; }
        table { width: 30%; border-collapse: collapse; }
        th, td { padding: 7px; border: 1px solid #ccc; text-align: center; }
        .toggle-btn { padding: 5px 10px; cursor: pointer; background: #eee; border: 1px solid #aaa; }
    </style>
</head>
<body>

<form method="POST" action="">
    <div style="display: flex;  gap: 10px;">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" style="width: 100px;" required>

        <label for="age">Age</label>
        <input type="number" name="age" id="age" min="1" style="width: 70px;" required>
    </div>

    <divv style=  "display: flex;  gap: 10px; "> 
        <input type="submit" name="submit" value="Submit" style="margin-left: 20px; width: 75px" >
    </divv>
</form>

<table id="userTable" style="margin-top: 40px;">
    <thead>
        <tr>
            <th>ID</th><th>Name</th><th>Age</th><th>Status</th><th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $user->fetch_assoc()): ?>
        <tr id="row-<?= $row['id'] ?>">
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['age'] ?></td>
            <td class="status"><?= $row['status'] ?></td>
            <td>
                <button class="toggle-btn" data-id="<?= $row['id'] ?>">Toggle</button>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<script>
document.querySelectorAll('.toggle-btn').forEach(button => {
    button.addEventListener('click', function () {
        const userId = this.getAttribute('data-id');
        fetch('toggle_status.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: id=${userId}
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById('row-' + userId);
                row.querySelector('.status').innerText = data.new_status;
            }
        });
    });
});
</script>

</body>
</html>





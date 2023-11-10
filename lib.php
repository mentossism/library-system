<?php
session_start();

// Check if the library array is set in the session
if (!isset($_SESSION['library'])) {
    // Initialize the library array if it's not set
    $_SESSION['library'] = [];
}

// Function to add a book to the library
function addBook($title, $author, $genre) {
    $book = [
        'title' => $title,
        'author' => $author,
        'genre' => $genre,
    ];

    $_SESSION['library'][] = $book;
}

// Function to remove a book from the library
function removeBook($index) {
    if (isset($_SESSION['library'][$index])) {
        unset($_SESSION['library'][$index]);
        // Reset array keys to avoid gaps in the array
        $_SESSION['library'] = array_values($_SESSION['library']);
    }
}

// Check if the form is submitted to add a book
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_add'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre'];

        // Validate input (you can add more validation)
        if (!empty($title) && !empty($author) && !empty($genre)) {
            addBook($title, $author, $genre);
        }
    } elseif (isset($_POST['submit_remove'])) {
        $index = $_POST['remove_index'];
        removeBook($index);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <title>LIBRARY SYSTEM</title>
    <style>
        body {
          
            text-align: center;
            margin: 50px;
        }

        h1 {
            color: #BEADFA;
            font-size: 100px;
            font-weight:bold;
            font-family: 'Anton', sans-serif;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size:30px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size:30px;
        }

        th {
            background-color: #D0BFFF;
            color: white;
            font-size:30px;
        }

        form {
            margin-top: 20px;
            display: inline-block;
        }

        input, select {
            padding: 10px;
            font-size:20px;
        }

        button {
            padding: 5px 10px;
            background-color: #BEADFA;
            color: #fff;
            border: none;
            cursor: pointer;
            
        }
        .button {
          transition-duration: 0.4s;
          }

        .button:hover {
            background-color: #04AA6D; /* Green */
            color: white;
        }
        label{
            font-size:20px;


        }
        

        .remove-form {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1> LIBRARY SYSTEM</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="title">Title: </label>
        <input type="text" name="title" id="title" required>
        <label for="author">Author: </label>
        <input type="text" name="author" id="author" required>
        <label for="genre">Genre: </label>
        <input type="text" name="genre" id="genre" required>
        <button type="submit" name="submit_add">Add Book</button>
    </form>

    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Action</th>
        </tr>
        <?php foreach ($_SESSION['library'] as $index => $book) : ?>
            <tr>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td><?php echo $book['genre']; ?></td>
                <td>
                    <form class="remove-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="remove_index" value="<?php echo $index; ?>">
                        <button type="submit" name="submit_remove">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
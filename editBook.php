<?php
require_once "library.php";
$bookObj = new Library();

if (!isset($_GET['id'])) {
    die("No book ID provided.");
}

$id = $_GET['id'];
$book = $bookObj->getBookById($id);

if (!$book) {
    die("Book not found.");
}


$title = $book['title'];
$author = $book['author'];
$genre = $book['genre'];
$publication_year = $book['publication_year'];
$publisher = $book['publisher'];
$copies = $book['copies'];

$error_title = $error_author = $error_genre = $error_year = $error_publisher = $error_copies = "";
$submit_success = $submit_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];
    $publication_year = $_POST["publication_year"];
    $publisher = $_POST["publisher"];
    $copies = $_POST["copies"];

    if ($title == "") $error_title = "Title is required";
    if ($author == "") $error_author = "Author is required";
    if ($genre == "") $error_genre = "Genre is required";
    if ($publication_year == "") {
        $error_year = "Publication year is required";
    } elseif (!is_numeric($publication_year)) {
        $error_year = "Publication year must be a number";
    } elseif ($publication_year > date("Y")) {
        $error_year = "Publication year must not be in the future";
    }
    if ($publisher == "") $error_publisher = "Publisher is required";
    if ($copies == "") {
        $error_copies = "Copies is required";
    } elseif (!is_numeric($copies)) {
        $error_copies = "Copies must be a number";
    }

    if ($error_title == "" && $error_author == "" && $error_genre == "" && $error_year == "" && $error_publisher == "" && $error_copies == "") {
        $bookObj->title = $title;
        $bookObj->author = $author;
        $bookObj->genre = $genre;
        $bookObj->publication_year = $publication_year;
        $bookObj->publisher = $publisher;
        $bookObj->copies = $copies;

        if ($bookObj->updateBook($id)) {
            $submit_success = "Book updated successfully.";
            $book = $bookObj->getBookById($id);
        } else {
            $submit_error = "Failed to update book.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" type="text/css" href="addbook.css">
</head>
<body>
    <h1>Edit Book</h1>
    <form method="post" action="">
        <label>Title *</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>"><br>
        <span style="color:red"><?php echo $error_title; ?></span><br><br>

        <label>Genre *</label><br>
        <select name="genre">
            <option value="">--Select Genre--</option>
            <option value="history" <?php if ($genre=="history") echo "selected"; ?>>history</option>
            <option value="science" <?php if ($genre=="science") echo "selected"; ?>>science</option>
            <option value="fiction" <?php if ($genre=="fiction") echo "selected"; ?>>fiction</option>
        </select><br>
        <span style="color:red"><?php echo $error_genre; ?></span><br><br>
        <label>Author *</label><br>
        <input type="text" name="author" value="<?php echo htmlspecialchars($author); ?>"><br>
        <span style="color:red"><?php echo $error_author; ?></span><br><br>
        <label>Publication Year *</label><br>
        <input type="text" name="publication_year" value="<?php echo htmlspecialchars($publication_year); ?>"><br>
        <span style="color:red"><?php echo $error_year; ?></span><br><br>
        <label>Publisher *</label><br>
        <input type="text" name="publisher" value="<?php echo htmlspecialchars($publisher); ?>"><br>
        <span style="color:red"><?php echo $error_publisher; ?></span><br><br>
        <label>Copies *</label><br>
        <input type="text" name="copies" value="<?php echo htmlspecialchars($copies); ?>"><br>
        <span style="color:red"><?php echo $error_copies; ?></span><br><br>
        <input type="submit" value="Update Book"><br><br>
        <span style="color:red"><?php echo $submit_error; ?></span><br>
        <span style="color:green"><?php echo $submit_success; ?></span>
    </form>
    <br>
    <a href="viewBook.php">Back to Book List</a>
</body>
</html>

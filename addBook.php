<?php
require_once "library.php";
$bookObj = new Library();

//prepare variables
$title = "";
$author = "";
$genre = "";
$publication_year = "";
$publisher = "";
$copies = "";
//error messages
$error_title = "";
$error_author = "";
$error_genre = "";
$error_publisher = "";
$error_year = "";
$error_copies = "";
//submission messages
$submit_error = "";
$submit_success = "";

//validation and form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];
    $publication_year = $_POST["publication_year"];
    $publisher = $_POST["publisher"];
    $copies = $_POST["copies"];

    //sanitation
    if ($title == "") {
        $error_title = "Title is required";
    }
    if ($author == "") {
        $error_author = "Author is required";
    }
    if ($genre == "") {
        $error_genre = "Genre is required";
    }
    if ($publication_year == "") {
        $error_year = "Publication year is required";
    } else if (!is_numeric($publication_year)) {
        $error_year = "Publication year must be a number";
    } else if ($publication_year > date("Y")) {
        $error_year = "Publication year must not be in the future";
    }
    if($publisher == "") {
        $error_publisher ="Book publisher is required";
    }
    if ($copies == "") {
        $error_copies = "Copies is required";
    } else if (!is_numeric($copies)) {
        $error_copies = "Copies must be a number";
    }

    if ($error_title == "" && $error_author == "" && $error_genre == "" && $error_publisher == "" && $error_year == "" && $error_copies == "") {
        $viewBook = new Library();
        $duplicate = false;

        foreach ($viewBook->viewBook() as $b) {
            if ($b["title"] == $title) {
                $duplicate = true;
                break;
            }
        }
        if ($duplicate) {
            $submit_error = "This title is already in the database";
        } else {
            $bookObj->title = $title;
            $bookObj->author = $author;
            $bookObj->genre = $genre;
            $bookObj->publication_year = $publication_year;
            $bookObj->publisher = $publisher;
            $bookObj->copies = $copies;
            if ($bookObj->addBook()) {
                $submit_success = "Book was added successfully";
                $title = $author = $genre = $publication_year = $publisher = $copies = "";
            }
        }
    } else {
        $submit_error = "You must fill out the required forms";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link rel="stylesheet" type="text/css" href="addbook.css">
</head>
<body>
    <h1>BOOK FORM</h1>
    <form method="post" action="">
        <label>Title *</label><br>
        <input type="text" name="title" value="<?php echo $title; ?>"><br>
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
        <input type="text" name="author" value="<?php echo $author; ?>"><br>
        <span style="color:red"><?php echo $error_author; ?></span><br><br>
        <label>Publication Year *</label><br>
        <input type="text" name="publication_year" value="<?php echo $publication_year; ?>"><br>
        <span style="color:red"><?php echo $error_year; ?></span><br><br>
        <label>Publisher *</label><br>
        <input type="text" name="publisher" value="<?php echo $publisher; ?>"><br><br>
        <span style="color:red"><?php echo $error_year; ?></span><br><br>
        <label>Copies *</label><br>
        <input type="text" name="copies" value="<?php echo $copies; ?>"><br>
        <span style="color:red"><?php echo $error_copies; ?></span><br><br>
        <input type="submit" value="Add Book"><br><br>
        <span style="color:red"><?php echo $submit_error; ?></span><br>
        <span style="color:green"><?php echo $submit_success; ?></span>
    </form>
    <br><br>
    <h2>Search & Filter</h2>
    <form method="get" action="viewBook.php">
        <input type="text" name="search" placeholder="Search by title or author"><br><br>
        <select name="filter_genre">
            <option value="">--Filter by Genre--</option>
            <option value="history">history</option>
            <option value="science">science</option>
            <option value="fiction">fiction</option>
        </select><br><br>
        <input type="submit" value="Search">
    </form>

    <br>
    <a href="viewBook.php">View Full Book List</a>
</body>
</html>


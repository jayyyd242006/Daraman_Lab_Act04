<?php
require_once "library.php";
$bookObj = new Library();

$search = "";
$filter_genre = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
}
if (isset($_GET["filter_genre"])) {
    $filter_genre = $_GET["filter_genre"];
}
$books = $bookObj->viewBook();
$newBooks = [];
foreach ($books as $b) {
    $matchSearch = true;
    $matchGenre = true;
    if ($search != "") {
        if (stripos($b["title"], $search) === false && stripos($b["author"], $search) === false) {
            $matchSearch = false;
        }
    }
    if ($filter_genre != "") {
        if ($b["genre"] != $filter_genre) {
            $matchGenre = false;
        }
    }
    if ($matchSearch && $matchGenre) {
        $newBooks[] = $b;
    }
}
$books = $newBooks;
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Books</title>
    <link rel="stylesheet" type="text/css" href="viewbook.css">
</head>
<body>
    <h1>Book List</h1>
    <form method="get" action="">
        <input type="text" name="search" placeholder="Search by title or author" 
               value="<?php echo $search; ?>" 
               oninput="this.form.submit()">
        <select name="filter_genre" onchange="this.form.submit()">
            <option value="">Filter by Genre</option>
            <option value="history" <?php if ($filter_genre=="history") echo "selected"; ?>>history</option>
            <option value="science" <?php if ($filter_genre=="science") echo "selected"; ?>>science</option>
            <option value="fiction" <?php if ($filter_genre=="fiction") echo "selected"; ?>>fiction</option>
        </select>
    </form>
    <br>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Publication Year</th>
            <th>Publisher</th>
            <th>Copies</th>
        </tr>
        <?php if (count($books) > 0): ?>
            <?php foreach ($books as $b): ?>
                <tr>
                    <td><?php echo $b["title"]; ?></td>
                    <td><?php echo $b["author"]; ?></td>
                    <td><?php echo $b["genre"]; ?></td>
                    <td><?php echo $b["publication_year"]; ?></td>
                    <td><?php echo $b["publisher"]; ?></td>
                    <td><?php echo $b["copies"]; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No books found.</td>
            </tr>
        <?php endif; ?>
    </table>
    <br>
    <a href="addBook.php" class="btn">Back to Add Book</a>
</body>
</html>

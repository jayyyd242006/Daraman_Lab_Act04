<?php
require_once "library.php";
$bookObj = new Library();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($bookObj->deleteBook($id)) {
        header("Location: viewBook.php?msg=Book+deleted+successfully");
        exit;
    } else {
        echo "Failed to delete the book.";
    }
} else {
    echo "No book ID provided.";
}
?>

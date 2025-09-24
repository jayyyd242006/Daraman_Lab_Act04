<?php

require_once "database.php";

class Library
{
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication_year = "";
    public $publisher = "";
    public $copies = "";

    protected $db = "";

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addBook()
    {
        $sql = "INSERT INTO book(title, author, genre, publication_year, publisher, copies) VALUE(:title, :author, :genre, :publication_year, :publisher, :copies)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        $query->bindParam(":publisher", $this->publisher);
        $query->bindParam(":copies", $this->copies);

        return $query->execute();
    }

    public function viewBook()
    {
        $sql = "SELECT * FROM book";
        $query = $this->db->connect()->prepare($sql);

        return $query->execute() ? $query->fetchAll() : null;
    }

}
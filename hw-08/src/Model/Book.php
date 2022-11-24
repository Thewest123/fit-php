<?php declare(strict_types=1);

namespace Books\Model;

use Books\Database\Database as Db;

class Book
{
    public function __construct(
        protected ?int $id,
        protected string $name,
        protected string $author,
        protected string $publisher,
        protected string $isbn,
        protected int $pages
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Book
     */
    public function setName(string $name): Book
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return Book
     */
    public function setAuthor(string $author): Book
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublisher(): string
    {
        return $this->publisher;
    }

    /**
     * @param string $publisher
     * @return Book
     */
    public function setPublisher(string $publisher): Book
    {
        $this->publisher = $publisher;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     * @return Book
     */
    public function setIsbn(string $isbn): Book
    {
        $this->isbn = $isbn;
        return $this;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @param int $pages
     * @return Book
     */
    public function setPages(int $pages): Book
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * Creates DB table using CREATE TABLE ...
     */
    public static function createTable(): void
    {
        $db = Db::getConnection();
        $db->query('CREATE TABLE IF NOT EXISTS `book`
            (
                id        INTEGER not null
                            constraint book_pk
                            primary key autoincrement,
                name      TEXT,
                author    TEXT,
                publisher TEXT,
                isbn      TEXT,
                pages     INTEGER
            )
        ');
    }

    /**
     * Drops DB table using DROP TABLE ...
     */
    public static function dropTable(): void
    {
        $db = Db::getConnection();
        $db->query('DROP TABLE IF EXISTS `book`');
    }

    /**
     * Get all entities in database
     * @return Book[]|null
     */
    public static function all(): ?array
    {
        // prepare query
        $query = "SELECT * FROM `book`";

        // prepare statement
        $statement = Db::getConnection()->prepare($query);

        // execute query with parameters
        if (!$statement->execute()) {
            return null;
        }

        // fetch data from executed statement
        $data = $statement->fetchAll();

        return array_map(fn(array $result): Book => new Book(
            intval($result["id"]),
            $result["name"],
            $result["author"],
            $result["publisher"],
            $result["isbn"],
            intval($result["pages"])
        ), $data);
    }


    /**
     * Find book by id
     */
    public static function findById(int $id): ?self
    {
        $db = Db::getConnection();

        // Build query
        $query = 'SELECT * FROM `book` WHERE id = :id';
        $state = $db->prepare($query);

        // Validate and execute
        if (!$state) return null;
        if (!$state->execute(["id" => $id])) return null;

        // Fetch result
        $result = $state->fetch();

        // Check result
        if (empty($result)) return null;

        // Return new instance of Book
        return new Book(
            intval($result["id"]),
            $result["name"],
            $result["author"],
            $result["publisher"],
            $result["isbn"],
            intval($result["pages"])
        );

    }

    /**
     * Delete entity from database by its identifier
     * @return bool
     */
    public function delete(): bool
    {
        // prepare query
        $query = "DELETE FROM `book` WHERE id = :id";

        // prepare statement
        $statement = Db::getConnection()->prepare($query);

        // execute query with parameters
        if (!$statement->execute(['id' => $this->id]))
        {
            return false;
        }

        return true;
    }

    /**
     * Save entity
     * @return bool
     */
    public function save(): bool
    {
        // if current entity has no identifier, create it, update it otherwise
        if ($this->id === null)
        {
            // prepare create query
            $query = "INSERT INTO `book` (name, author, publisher, isbn, pages) VALUES (:name, :author, :publisher, :isbn, :pages)";

            // prepare statement
            $statement = Db::getConnection()->prepare($query);

            // execute query with parameters
            if (!$statement->execute([
                "name"      => $this->name,
                "author"    => $this->author,
                "publisher" => $this->publisher,
                "isbn"      => $this->isbn,
                "pages"     => $this->pages,
            ]))
            {
                return false;
            }
        }
        else
        {
            // prepare update query
            $query = "UPDATE `book` SET (name, author, publisher, isbn, pages) = (:name, :author, :publisher, :isbn, :pages) WHERE id = :id";

            // prepare statement
            $statement = Db::getConnection()->prepare($query);

            // execute query with parameters
            if (!$statement->execute([
                "id"        => $this->id,
                "name"      => $this->name,
                "author"    => $this->author,
                "publisher" => $this->publisher,
                "isbn"      => $this->isbn,
                "pages"     => $this->pages,
            ]))
            {
                return false;
            }
        }

        // set identifier generated by database
        if ($this->id === null)
        {
            $this->id = (int)Db::getConnection()->lastInsertId("book");
        }

        return true;
    }

    public function toArray(): array
    {
        return [
            "id"        => $this->id,
            "name"      => $this->name,
            "author"    => $this->author,
            "publisher" => $this->publisher,
            "isbn"      => $this->isbn,
            "pages"     => $this->pages
        ];
    }

    public function toArraySimple(): array
    {
        return [
            "id"        => $this->id,
            "name"      => $this->name,
            "author"    => $this->author
        ];
    }

}
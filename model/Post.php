<?php
class Post{
    //DB staff
    private $conn;
    private $table = 'posts';

    // Post properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    //Define Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Query
    public function read(){
        $query = 'SELECT 
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
        FROM
        '.$this->table.' p
        LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute statement
        $stmt->execute();
        return $stmt;
    }

    //Single post read
    public function readSingle()
    {
        $query = 'SELECT 
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
        FROM
        '.$this->table.' p
        LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind id
        $stmt->bindParam(1,$this->id);

        //Execute statement
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->created_at = $row['created_at'];
        $this->category_name = $row['category_name'];
    }

    //Create post
    public function create(){
        //create query
        $query = 'INSERT INTO '.$this->table.'
        SET
           title = :title,
           body = :body,
           author = :author,
           category_id = :category_id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //Bind param
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        //Execute statement
        if ($stmt->execute()){
            return true;
        }

        return false;

    }

    //Update post
    public function update(){
        //create query
        $query = 'UPDATE '.$this->table.'
        SET
           title = :title,
           body = :body,
           author = :author,
           category_id = :category_id
           WHERE id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind param
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        //Execute statement
        if ($stmt->execute()){
            return true;
        }

        return false;

    }

    //Delete post
    public function delete(){

        //query
        $query = 'DELETE FROM '.$this->table.'
                  WHERE id = :id
        ';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind param
        $stmt->bindParam(':id', $this->id);

        //execute query
        if ($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

}
?>
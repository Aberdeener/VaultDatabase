<?php
require 'vendor/autoload.php';

if ((!isset($_SESSION["role"]) && (!$_SESSION["role"] == "admin")) || !isset($_GET["id"])) {
    header("location: https://vaultmc.net?page=home&alert=no-permission");
}

if (!is_numeric($_GET["id"])) {
    header('Location: https://vaultmc.net/?page=home&alert=blog-invalid-id');
}

if ($result = $mysqli_d->query("SELECT id, title, md_content FROM blog_posts WHERE id = " . $_GET["id"])) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            $original_title = $row->title;
            $original_md_content = $row->md_content;
        }
    } else {
        header('Location: https://vaultmc.net/?page=home&alert=blog-invalid-id');
    }
}

$title_err = $content_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    }

    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter content.";
    } else {
        $Parsedown = new Parsedown();

        $post_title = htmlspecialchars($_POST["title"]);
        $post_md_content = $_POST["content"];
        $post_html_content = $Parsedown->text($_POST["content"]);

        $id = $_GET["id"];

        $sql = "UPDATE blog_posts SET title='$post_title', md_content='$post_md_content', html_content='$post_html_content' WHERE id = '$id'";

        if ($mysqli_d->query($sql) === TRUE) {
            header('Location: https://vaultmc.net/?page=home&alert=blog-edited');
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli_d->error;
        }
        $mysqli_d->close();
    }
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">

<div class="row">
    <div class="col-md-12">
        <h2 class="text-center">Edit Blog Post</h2>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6" style="background-color: #303030; border-radius:10px; padding:10px;">
        <form action="" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo $original_title ?>">
                <span style="color:red"><?php echo $title_err; ?></span>
                <br>
                <textarea name="content" id="content"><?php echo $original_md_content ?></textarea>
                <span style="color:red"><?php echo $content_err; ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
    var simplemde = new SimpleMDE({
        element: document.getElementById("content"),
        status: false,
    });
</script>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php find_selected_page(); ?>
<?php 
    if(!$current_page) {
        redirect_to("manage_content.php");
    }
?>

<?php 
    if(isset($_POST['submit'])) {

        $id = $current_page["id"];
        $menu_name = mysql_prep($_POST["menu_name"]);
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];
        $content = mysql_prep($_POST["content"]);

        // validations
        $required_fields = array("menu_name", "position", "visible", "content");
        validate_presences($required_fields);

        $fields_with_max_lengths = array("menu_name" => 30);
        validate_max_lengths($fields_with_max_lengths);

        if(empty($errors)) {
                // perform update
            $query  = "UPDATE pages SET ";
            $query .= "menu_name = '{$menu_name}', ";
            $query .= "position = {$position}, ";
            $query .= "visible = {$visible}, ";
            $query .= "content = '{$content}' ";
            $query .= "WHERE id = {$id} ";
            $query .= "LIMIT 1";

            $result = mysqli_query($connection, $query);

            if($result && mysqli_affected_rows($connection) >= 0) {
                $_SESSION["message"] = "Subject updated.";
                redirect_to("manage_content.php?page={$id}");
            } else {
                $_SESSION["message"] = "Subject update.";
                redirect_to("manage_content.php?page={$id}");
            }
        }
    } else {
        // probably a GET request
    } // end: if(isset($_POST['submit'])) 
?>


<?php include("../includes/layouts/header.php") ?>


<div id="main">
            <div id="navigation">
                <?php  echo navigation($current_subject, $current_page); ?>
            </div>
            <div id="page">
                <?php if(!empty($message)) {
                    echo "<div class=\"message\">" . htmlentities($message) ,"</div>";
                } ?>
                <?php echo form_errors($errors); ?>
                <h2>Edit Page: <?php echo htmlentities($current_page["menu_name"]); ?></h2>

                <form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
                    <p>Menu name:
                        <input type="text" name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]); ?>" />
                    </p>
                    <p>
                        Position:
                        <select name="position">
                                <?php 
                                $page_set = find_pages_for_subject($current_page["subject_id"]);
                                $page_count = mysqli_num_rows($page_set);
                                for($count = 1; $count <= $page_count; $count++) {
                                    echo "<option value=\"{$count}\"";
                                    if($current_page["position"] == $count) {
                                        echo " selected";
                                    }
                                    echo ">{$count}</option>";
                                }
                                ?>
                        </select>
                    </p>
                    <p>Visible
                        <input type="radio" name="visible" value="0" <?php if($current_page["visible"] == 0) { echo "checked";}; ?>/> No
                        &nbsp;
                        <input type="radio" name="visible" value="1" <?php if($current_page["visible"] == 1) { echo "checked";}; ?>/> Yes
                    </p>
                    <p> Content: <br/>
                        <textarea name="content" rows="20" cols="80"><?php echo
                        htmlentities($current_page["content"]); ?></textarea>
                    </p>
                    <input type="submit" name="submit" value="Edit Page"  />
                </form>
                <br />
                <a href="manage_content.php?page=<?php echo
                urlencode($current_page["id"]); ?>">Cancel</a>
                &nbsp;
                &nbsp;
                <a href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure you want to delete?')">Delete page</a>
            </div>
</div>

<?php  include("../includes/layouts/footer.php") ?>

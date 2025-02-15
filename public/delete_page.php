<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php $current_page = find_page_by_id($_GET["page"]);

    if (!$current_page) {
        // page id was missing or invalid or
        // page couln't be found in database
        redirect_to("manage_content.php");
    }

        $id = $current_page["id"];
        $query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
        $result = mysqli_query($connection, $query);
        if($result && mysqli_affected_rows($connection) >= 0) {
            $_SESSION["message"] = "Page deleted.";
            redirect_to("manage_content.php");
        } else {
            $_SESSION["message"] = "Page delete failed.";
            redirect_to("manage_content.php?page={$id}");
        }
        
?>
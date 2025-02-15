<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php include("../includes/layouts/header.php") ?>

<?php 
    find_selected_page();
?>

<div id="main">
            <div id="navigation">
                <?php  echo navigation($current_subject, $current_page); ?>
            </div>
            <div id="page">
                <?php echo message(); ?>
                <?php $errors = errors(); ?>
                <?php echo form_errors($errors); ?>
                <h2>Create Subject</h2>

                <form action="create_subject.php" method="post">
                    <p>Menu name:
                        <input type="text" name="menu_name" value="" />
                    </p>
                    <p>
                        Position:
                        <select name="position">
                                <?php 
                                $subject_set = find_all_subjects();
                                $subject_count = mysqli_num_rows($subject_set) + 1;
                                for($count = 1; $count <= $subject_count; $count++) {
                                    echo "<option value=\"{$count}\">{$count}</option>";
                                }
                                ?>

                                <?php 
                                
                                ?>

                        </select>
                    </p>
                    <p>Visible
                        <input type="radio" name="visible" value="0" /> No
                        &nbsp;
                        <input type="radio" name="visible" value="1" /> Yes
                    </p>
                    <input type="submit" name="submit" value="Create Subject"  />
                </form>
                <br />
                <a href="manage_content.php">Cancel</a>
            </div>
</div>

<?php  include("../includes/layouts/footer.php") ?>

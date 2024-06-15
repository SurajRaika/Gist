<style>
    .iblize_pre {
        overflow: hidden;
    }

    .clickable-card {
        text-decoration: none; /* Remove underline */
        color: inherit; /* Inherit text color */
    }
</style>

<?php

include 'utils/global.php';

function createCard($userid, $description, $filename, $content, $username)
{
    $editor_id = "editor" . $userid;
    $numberOfNewlines = substr_count($content, "\n") + 2;
    $height = $numberOfNewlines * 30;

    ?>

<a href="./gist.php?id=<?php safePrint( $userid) ?>" class="clickable-card  mb-0 ">
        <div class="my-3">

            <h5 class="text-capitalize m-2 " for="<?php safePrint( $editor_id) ?>"><?php safePrint( $description) ?></h5>

            <div class="border">
                <!-- Iblize Editor Integration -->
                <div id="<?php safePrint( $editor_id) ?>" style="width: 100%; height:<?php safePrint( $height) ?>px;">
                    <!--
                    <?php echo htmlspecialchars($content); ?>
                    -->
                </div>
            </div>
        </div>
        </a>

    <script>
        // Initialize Iblize editor
        new Iblize("#<?php safePrint( $editor_id) ?>", {
            language: "python",
            readOnly: true // Set the editor to be read-only
        }).setValue(<?php echo json_encode($content); ?>).onUpdate((value) => {
            // Handle the updated value
            console.log(value);
        });
    </script>

<?php } ?>

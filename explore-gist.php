<?php
session_start();


require_once "./config.php";
require_once "model/GIST.php";
require_once "components/card.php";
$gist = new GIST($link);

$defaultPage = true;

if (isset($_GET['page']) && isset($_GET['search'])) {
    header("Location: 404.php");
    exit;
}

$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$searchText = isset($_GET['search']) ? $_GET['search'] : "";

if ($searchText !== "") {
    $gistCards = $gist->searchGists($searchText);
    $defaultPage = false;
} else {
    $gistCards = $gist->getGistCardsByPage($currentPage);
    $defaultPage = true;
}

$page = "Explore Page";
ob_start();
?>
<script src="https://cdn.jsdelivr.net/npm/iblize/dist/iblize.min.js"></script>

<style>
    .iblize_pre {
        overflow: hidden;
    }
</style>

<div class="container mt-4 ">
    <?php foreach ($gistCards as $gistCard): ?>


        <?php createCard($gistCard['id'], $gistCard['description'], $gistCard['filename'], $gistCard['content'], $gistCard['username']); ?>


    <?php endforeach; ?>

    <nav aria-label="Page navigation" class="d-flex justify-content-center mt-4">
        <ul class="pagination">
            <?php
            $totalPages = 5; // Replace this with the actual total number of pages
            $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            ?>

            <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link"
                    href="<?php echo $currentPage > 1 ? './explore-gist.php?page=' . ($currentPage - 1) : '#'; ?>">Previous</a>
            </li>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                    <a class="page-link" href="./explore-gist.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                <a class="page-link"
                    href="<?php echo $currentPage < $totalPages ? './explore-gist.php?page=' . ($currentPage + 1) : '#'; ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>

<script defer src="./js/explore.js"></script>

<?php $slot = ob_get_clean();
include 'layout/base.php';
?>
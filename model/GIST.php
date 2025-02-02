<?php

// include_once "./model/USER.php";
class Gist
{
    private $link;
    private $user;

    public function __construct($link)
    {
        $this->link = $link;
        $this->user = isset($_SESSION["id"]) ? $_SESSION["id"] : null;

    }
    

public function createGist( $description, $filename, $content)
{
    $sql = "INSERT INTO gists (userid, description, filename, content) VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($this->link, $sql)) {
        mysqli_stmt_bind_param($stmt, "isss", $param_userid, $param_description, $param_filename, $param_content);
        $param_userid = $this->user;
        $param_description = $description;
        $param_filename = $filename;
        $param_content = $content;

        if (mysqli_stmt_execute($stmt)) {
            $gistId = mysqli_insert_id($this->link); // Get the ID of the newly created gist
            $this->redirect("./gist.php?id=$gistId", "Gist created successfully");
        } else {
            $this->redirectWithError('./index.php');
        }
    }
}

public function getGist($id)
{
    $sql = "SELECT content , description , filename FROM gists WHERE id = ?";
    if ($stmt = mysqli_prepare($this->link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id;
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $content = $row['content'];
                mysqli_stmt_close($stmt); // Close the statement
                return $row;
            } else {
                mysqli_stmt_close($stmt); // Close the statement
                return false;
            }
        } else {
            mysqli_stmt_close($stmt); // Close the statement
            return false;
        }
    } else {
        return false;
    }
}

public function getGistCardsByPage($pageNumber)
{
    $gistsPerPage = 10;
    $offset = ($pageNumber - 1) * $gistsPerPage;

    $sql = "SELECT g.id, g.filename, g.description, g.content ,u.username 
            FROM gists g
            INNER JOIN users u ON g.userid = u.id
            ORDER BY g.id DESC
            LIMIT ?, ?";
            
    if ($stmt = mysqli_prepare($this->link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $offset, $gistsPerPage);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $gistCards = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $additionalText = $this->getAdditionalText($row['content'], '');
                $row['content'] = $additionalText;
                $gistCards[] = $row;
            }
            return $gistCards;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

public function searchGists($searchText)
{
    $sql = "SELECT id, description, filename, content FROM gists WHERE description LIKE ? OR content LIKE ?";
    if ($stmt = mysqli_prepare($this->link, $sql)) {
        $searchPattern = "%$searchText%";
        mysqli_stmt_bind_param($stmt, "ss", $searchPattern, $searchPattern);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $matchedGists = [];
            while ($row = mysqli_fetch_assoc($result)) {
                // Extract additional text
                $additionalText = $this->getAdditionalText($row['content'], $searchText);
                $row['content'] = $additionalText;
                $matchedGists[] = $row;
            }
            return $matchedGists;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

private function getAdditionalText($content, $searchText)
{
    // Escape HTML characters
    $escapedContent = $content;
        $escapedSearchText = htmlspecialchars($searchText, ENT_QUOTES, 'UTF-8');
    
    // Split content into lines
    $lines = explode("\n", $escapedContent);

    // If no search text, return the first four lines
    if (empty($escapedSearchText)) {
        $firstFourLines = array_slice($lines, 0, 4);
        return implode("\n", $firstFourLines);
    }

    // Find the line containing the search text
    $text_foundin = -1;
    for ($i = 0; $i < count($lines); $i++) {
        if (stripos($lines[$i], $escapedSearchText) !== false) {
            $text_foundin = $i;
            break;
        }
    }

    // If search text is found, extract the desired lines
    if ($text_foundin >= 0) {
        $startPosition = max(0, $text_foundin - 1);
        $endPosition = min(count($lines), $text_foundin + 3);
        $extractedLines = array_slice($lines, $startPosition, $endPosition - $startPosition);

        // Highlight the search text in the extracted lines
       

        return implode("\n", $extractedLines);
    }

    // If search text is not found, return the first four lines
    $firstFourLines = array_slice($lines, 0, 4);
    return implode("\n", $firstFourLines);
}



    private function redirect($location, $message)
    {
        //store message in session so that when  user go to new location there we can show that message notification
        setcookie('message', $message, time() + 600, '/');
        echo "<script>window.location.href='$location';</script>";
        exit;
    }

    private function redirectWithError($location)
    {
        echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
        echo "<script>window.location.href='$location';</script>";
        exit;
    }
}
<?php

function safePrint($userInput) {
    echo htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8');
}
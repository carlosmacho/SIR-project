<?php

// Get the current section tag
$section_tag = $_POST['section_tag'];

// Update the section visit count
$query = $pdo->prepare("UPDATE section_visits SET visits = visits + 1 WHERE tag = ?");
$query->execute([$section_tag]);

// Get the section visit counts
$query = $pdo->query("SELECT tag, visits FROM section_visits ORDER BY visits DESC LIMIT 10");
$section_visits = $query->fetchAll();

?>
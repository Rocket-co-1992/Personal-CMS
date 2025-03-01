<?php
require 'functions.php';

$sliderContent = getSectionContent('slider');
$teamsContent = getSectionContent('teams');
$newsContent = getSectionContent('news');
$galleryContent = getSectionContent('gallery');
$contactContent = getSectionContent('contact');

$teamMembers = getTeamMembers();
$newsList = getNews();
$galleryImages = getImages();
$currentTheme = getCurrentTheme();
$themeStructure = getThemeStructure($currentTheme);

echo $twig->render('index.html.twig', [
    'sliderContent' => $sliderContent,
    'teamsContent' => $teamsContent,
    'newsContent' => $newsContent,
    'galleryContent' => $galleryContent,
    'contactContent' => $contactContent,
    'teamMembers' => $teamMembers,
    'newsList' => $newsList,
    'galleryImages' => $galleryImages,
    'currentTheme' => $currentTheme,
    'themeStructure' => $themeStructure
]);
?>

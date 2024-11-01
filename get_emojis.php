<?php
$emojiCategories = ['people','arm','flag','animals','food']; // Добавьте сюда ваши категории
$emojis = [];

foreach ($emojiCategories as $category) {
    $emojiPath = "emoje/$category/";
    if (is_dir($emojiPath)) {
        $files = array_diff(scandir($emojiPath), array('..', '.')); // Убираем . и ..
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'png') {
                $emojis[$category][] = $emojiPath . $file; // Сохраняем путь к эмодзи
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($emojis);
?>

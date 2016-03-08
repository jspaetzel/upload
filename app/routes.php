<?php
// Routes

$app->get('/{key}', function ($request, $response) {
    $db = $this->Db;
    return $response;
});

$app->post('/', function ($request, $response) {
    $newImage = new Image($this->Db);
    $id = $newImage->insert();

    $name = NameGenerator::alphaID($id);
    $_SERVER['HTTP_CONTENT_DISPOSITION'] = $name;

    $uploadHandler = new UploadHandler([
        'upload_dir' => __DIR__ . '/images/',
        'upload_url' => null,
        'accept_file_types' => '/\.(' . Image::getAllowedExtensions(true) . ')$/i',
        'image_library' => 0,
        'image_versions' => [
            '' => ['auto_orient' => false]
        ],
        'print_response' => false
    ]);
});
<?php

namespace App\Modules\RichGenerator\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class ParseHtmlService
{
    public function downloadArchive($id): ?BinaryFileResponse
    {
        // 1. Получаем данные из БД
        $data = DB::table('rich_documents')->where('id', $id)->first();
        if (!$data) {
            Log::error('Rich Documents not found');
            return null;
        }

        $item = $data->item; // Имя папки
        $lang = $data->lang_id; // Имя вложенной папки
        $htmlContent = $data->html; // HTML-код

        // 2. Создаём временную папку
        $tempDir = storage_path("app/public/export_" . uniqid());
        mkdir($tempDir, 0777, true);
        mkdir("$tempDir/$item", 0777, true);
        mkdir("$tempDir/$item/$lang", 0777, true);

        // 3. Обрабатываем HTML (изменяем пути к картинкам)
        $updatedHtml = $this->updateImagePaths($htmlContent, $tempDir, $item, $lang);

        // 4. Сохраняем изменённый index.html в корень архива
        file_put_contents("$tempDir/index.html", $updatedHtml);

        // 5. Создаём ZIP-архив
        $zipFileName = storage_path("app/public/export.zip");
        $zip = new ZipArchive();
        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            Log::error('Failed to create ZIP');
            return null;
        }

        // Добавляем файлы в архив
        $this->addFolderToZip($tempDir, $zip, $tempDir);
        $zip->close();

        // 6. Отдаём ZIP пользователю
        $response = response()->download($zipFileName)->deleteFileAfterSend(true);

        // 7. Удаляем временные файлы
        $this->deleteFolder($tempDir);

        return $response;
    }

    /**
     * Функция для замены путей к изображениям в HTML
     */
    private function updateImagePaths($htmlContent, $tempDir, $item, $lang): string
    {
        $crawler = new Crawler($htmlContent);

        $crawler->filter('img')->each(function (Crawler $node) use ($tempDir, $item, $lang) {
            $src = $node->attr('src');
            if (!$src) return;

            $imageData = @file_get_contents($src);
            if ($imageData) {
                $imageName = basename(parse_url($src, PHP_URL_PATH));
                $localPath = "$tempDir/$item/$lang/$imageName";
                file_put_contents($localPath, $imageData);

                // Меняем src на локальный путь
                $node->getNode(0)->setAttribute('src', "$item/$lang/$imageName");
            }
        });

        return $crawler->html();
    }

    /**
     * Рекурсивно добавляем папку в ZIP
     */
    private function addFolderToZip($folder, $zip, $baseFolder): void
    {
        $files = scandir($folder);
        foreach ($files as $file) {
            if ($file == "." || $file == "..") continue;
            $filePath = "$folder/$file";
            $zipPath = str_replace($baseFolder . "/", "", $filePath);

            if (is_dir($filePath)) {
                $this->addFolderToZip($filePath, $zip, $baseFolder);
            } else {
                $zip->addFile($filePath, $zipPath);
            }
        }
    }

    /**
     * Удаляем временную папку рекурсивно
     */
    private function deleteFolder($folder): void
    {
        if (!is_dir($folder)) return;
        $files = scandir($folder);
        foreach ($files as $file) {
            if ($file == "." || $file == "..") continue;
            $filePath = "$folder/$file";
            if (is_dir($filePath)) {
                $this->deleteFolder($filePath);
            } else {
                unlink($filePath);
            }
        }
        rmdir($folder);
    }
}

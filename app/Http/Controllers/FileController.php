<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    //
    private $rootPath = 'public/Главная';

    public function index()
    {
        return $this->show($this->rootPath);
    }

    public function show($path)
    {
        // Ограничить доступ только к папке "Общая" и её подпапкам
        if (strpos($path, $this->rootPath) !== 0) {
            $path = $this->rootPath;
        }

        $directories = Storage::directories($path);
        $files = Storage::files($path);
        $currentPath = $path;
        return view('files', compact('directories', 'files', 'currentPath'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $request->input('path', $this->rootPath);
            if (strpos($path, $this->rootPath) !== 0) {
                $path = $this->rootPath;
            }
            $file->storeAs($path, $file->getClientOriginalName());
        }
        return back()->with('success', 'File uploaded successfully!');
    }

    public function createFolder(Request $request)
    {
        $path = $request->input('path', $this->rootPath);
        $folderName = $request->input('folder_name');
        if (strpos($path, $this->rootPath) !== 0) {
            $path = $this->rootPath;
        }
        Storage::makeDirectory($path . '/' . $folderName);
        return back()->with('success', 'Folder created successfully!');
    }

    public function goBack($path)
    {
        // Ограничить возврат только до папки "Общая"
        $parentPath = dirname($path);
        if ($parentPath === '.' || strpos($parentPath, $this->rootPath) !== 0) {
            $parentPath = $this->rootPath;
        }
        return redirect()->route('files_show', $parentPath);
    }

    public function download(Request $request)
    {
        // Получаем путь из запроса
        $path = $request->input('path');

        // Генерируем полный путь к файлу
        $fullPath = storage_path('app/public/Главная/' . urldecode($path));

        // Проверяем, существует ли файл
        if (file_exists($fullPath)) {
            return response()->download($fullPath);
        } else {
            return redirect()->back()->with('error', 'Файл не найден.');
        }
    }

}

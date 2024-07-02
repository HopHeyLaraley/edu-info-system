<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Файлы') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <style>
                        .directory, .file {
                            width: 100%;
                            text-align: left;
                            padding: 10px;
                            border: 1px solid #ccc;
                            margin-bottom: 5px;
                            cursor: pointer;
                        }
                        .file-upload {
                            margin-top: 20px;
                        }
                        .drop-zone {
                            border: 2px dashed #ccc;
                            padding: 10px;
                            text-align: center;
                            cursor: pointer;
                        }
                        .highlight {
                            background-color: #e9ecef;
                        }
                        .button-container {
                            margin-bottom: 20px;
                        }
                    </style>

                    <div class="container">
                        <div class="button-container">
                            <button class="btn btn-primary" id="back-button">
                                <img src="{{ asset('back.png') }}" style="width: 40px; float:left; margin-right: 20px;">
                            </button>
                            @if(Auth::user()->role == 'user')
                                <button class="btn btn-success" id="create-folder-button">
                                    <img src="{{ asset('newfolder.png') }}" style="width: 40px; float:left; margin-right: 20px;">
                                </button>
                            @endif
                        </div>

                        @if(Auth::user()->role == 'user')
                            <div class="drop-zone" id="drop-zone">
                                Перетащите файл сюда или нажмите, чтобы выбрать файл
                            </div>
                        @endif

                        <div class="directories mt-4">
                            @foreach($directories as $directory)
                                <div class="directory" data-path="{{ $directory }}">
                                    <img src="{{ asset('folder.png') }}" style="width: 30px; float:left; margin-right: 20px;">
                                    {{ basename($directory) }}
                                </div>
                            @endforeach
                        </div>

                        <div class="files">
                            @foreach($files as $file)
                                <form method="POST" action="{{ route('files_download') }}" class="download-form">
                                    @csrf
                                    <input type="hidden" name="path" value="{{ basename($file) }}">
                                    <button type="submit" class="file">
                                        <img src="{{ asset('download.png') }}" style="width: 30px; float:left; margin-right: 20px;">
                                        {{ basename($file) }}
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>

                    <form id="upload-form" action="{{ route('files_upload') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" name="file" id="file-input">
                        <input type="hidden" name="path" id="path-input" value="{{ $currentPath }}">
                    </form>

                    <form id="create-folder-form" action="{{ route('files_createFolder') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="path" id="create-folder-path" value="{{ $currentPath }}">
                        <input type="text" name="folder_name" id="folder-name-input">
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const dropZone = document.getElementById('drop-zone');
                            const fileInput = document.getElementById('file-input');
                            const pathInput = document.getElementById('path-input');
                            const uploadForm = document.getElementById('upload-form');
                            const backButton = document.getElementById('back-button');
                            const createFolderButton = document.getElementById('create-folder-button');
                            const createFolderForm = document.getElementById('create-folder-form');
                            const folderNameInput = document.getElementById('folder-name-input');
                            const currentPath = "{{ $currentPath }}";

                            dropZone.addEventListener('click', () => fileInput.click());

                            dropZone.addEventListener('dragover', (e) => {
                                e.preventDefault();
                                dropZone.classList.add('highlight');
                            });

                            dropZone.addEventListener('dragleave', () => dropZone.classList.remove('highlight'));

                            dropZone.addEventListener('drop', (e) => {
                                e.preventDefault();
                                dropZone.classList.remove('highlight');
                                if (e.dataTransfer.files.length) {
                                    fileInput.files = e.dataTransfer.files;
                                    uploadForm.submit();
                                }
                            });

                            fileInput.addEventListener('change', () => {
                                if (fileInput.files.length) {
                                    uploadForm.submit();
                                }
                            });

                            const directories = document.querySelectorAll('.directory');
                            directories.forEach(directory => {
                                directory.addEventListener('click', () => {
                                    const path = directory.dataset.path;
                                    pathInput.value = path;
                                    window.location.href = `/files/${path}`;
                                });
                            });

                            backButton.addEventListener('click', () => {
                                window.location.href = `/files-back/${currentPath}`;
                            });

                            createFolderButton.addEventListener('click', () => {
                                const folderName = prompt('Введите название папки:');
                                if (folderName) {
                                    folderNameInput.value = folderName;
                                    createFolderForm.submit();
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

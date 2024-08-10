<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Selamat datang di e-Library</h1>

                    <div class="mb-4 flex justify-between">
                        <h2 class="text-xl font-semibold mb-2">Buku Anda</h2>
                        <button id="openModal" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Tambah Buku
                        </button>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Nomor
                                    </th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Cover
                                    </th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Judul
                                    </th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="px-4 py-4 text-sm text-gray-900">1</td>
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        <img src="cover-url" alt="Cover" class="w-16 h-16 object-cover rounded-md">
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-900">Contoh Judul Buku</td>
                                    <td class="px-4 py-4 text-sm text-gray-900">10</td>
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                            Download
                                        </a>
                                        <a href="#" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 ml-4">
                                            Edit
                                        </a>
                                        <a href="#" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 ml-4">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="bookModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Tambah Buku Baru</h2>
            <form id="bookForm">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Buku</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        placeholder="Masukkan judul buku"
                    >
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                        name="description"
                        id="description"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"
                        placeholder="Masukkan deskripsi buku"
                    ></textarea>
                </div>
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        placeholder="Masukkan quantity buku"
                    >
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select
                        id="category"
                        name="category_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    >
                        <option value="">Pilih kategori</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="cover" class="block mb-2 text-sm font-medium text-gray-700">Cover Buku</label>
                    <input
                        id="cover"
                        name="cover_image"
                        class="block w-full mb-5 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        type="file"
                        accept="image/*"
                    >
                </div>
                <div class="mb-4">
                    <label for="pdf_file" class="block mb-2 text-sm font-medium text-gray-700">File Buku</label>
                    <input
                        id="pdf_file"
                        name="pdf_file"
                        class="block w-full mb-5 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        type="file"
                        accept=".pdf"
                    >
                </div>
                <div class="flex justify-end">
                    <button
                        type="button"
                        id="closeModal"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
                    >
                        Tutup
                    </button>
                    <button
                        type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 ml-4"
                    >
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/categories')
                .then(response => response.json())
                .then(data => {
                    const categorySelect = document.getElementById('category');
                    data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching categories:', error));
        });

        document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('bookModal').classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('bookModal').classList.add('hidden');
        });

        document.getElementById('bookForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);

            const categorySelect = document.getElementById('category');
            formData.append('category_id', categorySelect.value);

            const userId = "{{ auth()->user()->id }}";
            formData.append('user_id', userId);

            fetch('/api/books', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.messages.description[0]);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
                document.getElementById('bookModal').classList.add('hidden');
            })
            .catch(error => {
                console.error('Error:', error.message);
                alert(error.message);
            });
        });
    </script>
</x-app-layout>

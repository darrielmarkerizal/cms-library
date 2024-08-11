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

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
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
                                        Deskripsi
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
                                @foreach($books as $book)
                                    <tr class="border-b">
                                        <td class="px-4 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            <img src="{{ $book->cover_url }}" alt="Cover" class="w-16 h-16 object-cover rounded-md">
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-900">{{ $book->title }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">{{ $book->description }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">{{ $book->quantity }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            <form method="POST" action="{{ route('books.destroy', $book->id) }}" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
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
            <form id="bookForm" method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

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
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
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
                        onclick="document.getElementById('bookModal').classList.add('hidden')"
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
        document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('bookModal').classList.remove('hidden');
        });

        document.getElementById('bookForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            formData.append('user_id', '{{ Auth::id() }}');

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                if (response.status === 201) {
                    document.getElementById('bookModal').classList.add('hidden');
                    location.reload();
                } else {
                    return response.json();
                }
            })
            .then(data => {
                if (data && !data.success) {
                    console.error('Error:', data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</x-app-layout>

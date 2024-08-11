<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Kategori Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Selamat datang di e-Library - Kategori Buku</h1>

                    <div class="mb-4 flex justify-between items-center">
                        <h2 class="text-xl font-semibold mb-2">Kategori Buku Anda</h2>
                        <button id="openModal" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Tambah Kategori
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
                                        Nama Kategori
                                    </th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr class="border-b">
                                        <td class="px-4 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">{{ $category->name }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 space-x-2">
                                            <button class="text-red-600 hover:text-red-900" onclick="deleteCategory({{ $category->id}})">Delete</button>
                                            <button class="text-blue-600 hover:text-blue-900" onclick="openEditModal({{ json_encode($category)}})">Edit</button>
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

    <div id="categoryModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Tambah Kategori Buku Baru</h2>
            <form id="categoryForm">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" id="name" name="name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        placeholder="Masukkan nama kategori">
                </div>

                <div class="flex justify-end">
                    <button type="button" id="closeModal"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
                        onclick="document.getElementById('categoryModal').classList.add('hidden')">
                        Tutup
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 ml-4">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Edit Kategori</h2>
            <form id="editCategoryForm">
                <input type="hidden" id="editCategoryId">
                <div class="mb-4">
                    <label for="editCategoryName" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" id="editCategoryName" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 mr-2" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>    

    <script>
        document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('categoryModal').classList.remove('hidden');
        });

        document.getElementById('categoryForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            fetch('{{ route('categories.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.message);
                } else {
                    let tableBody = document.querySelector('table tbody');
                    let newRow = document.createElement('tr');
                    newRow.classList.add('border-b');
                    newRow.innerHTML = `
                        <td class="px-4 py-4 text-sm text-gray-900">${tableBody.children.length + 1}</td>
                        <td class="px-4 py-4 text-sm text-gray-900">${data.name}</td>
                        <td class="px-4 py-4 text-sm text-gray-900 space-x-2">
                            <button class="text-red-600 hover:text-red-900">Delete</button>
                            <button class="text-blue-600 hover:text-blue-900">Edit</button>
                        </td>
                    `;
                    tableBody.appendChild(newRow);
                    document.getElementById('categoryModal').classList.add('hidden');
                    document.getElementById('categoryForm').reset();
                }
            })
            .catch(error => console.error('Error:', error));
        });

        function deleteCategory(categoryId) {
        if (confirm('Are you sure you want to delete this category?')) {
            console.log(`Deleting category with ID: ${categoryId}`);
            fetch(`/api/categories/${categoryId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Failed to delete category');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete category');
            });
        }
    }

    function openEditModal(category) {
        document.getElementById('editCategoryId').value = category.id;
        document.getElementById('editCategoryName').value = category.name;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    document.getElementById('editCategoryForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const categoryId = document.getElementById('editCategoryId').value;
        const categoryName = document.getElementById('editCategoryName').value;

        fetch(`/api/categories/update/${categoryId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name: categoryName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.message);
            } else {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update category');
        });
    });
    </script>
</x-app-layout>
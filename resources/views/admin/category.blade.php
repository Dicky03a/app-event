@extends('layouts.app')

@section('title', 'Categories - Dashboard Admin')

@section('content')
<div class="p-4 mx-auto max-w-screen-2xl md:p-6">
    <div class="grid grid-cols-12 gap-4 mb-10 md:gap-6">
        <div class="col-span-12 space-y-6 xl:col-span-7">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Category Management</h1>
            <p class="text-gray-500 dark:text-gray-400">Manage your categories here</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Create Category Form -->
    <div class="mb-10 p-6 bg-white rounded-xl border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03]">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Add New Category</h2>
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name *</label>
                    <input type="text" name="name" id="name" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div>
                <div>
                    <label for="icon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Icon</label>
                    <input type="file" name="icon" id="icon" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" accept="image/*">
                </div>
                <div>
                    <label for="contact_person" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Person</label>
                    <input type="text" name="contact_person" id="contact_person" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div>
                    <label for="telephone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telephone</label>
                    <input type="text" name="telephone" id="telephone" class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Add Category
                </button>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto">
            <table class="min-w-full">
                <!-- table header start -->
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Name
                                </p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Icon
                                </p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Contact Person
                                </p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Telephone
                                </p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    Actions
                                </p>
                            </div>
                        </th>
                    </tr>
                </thead>
                <!-- table header end -->
                <!-- table body start -->
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($categories as $category)
                    <tr>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $category->name }}
                                </p>
                            </div>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                                @if($category->icon)
                                <img src="{{ $category->icon }}" alt="{{ $category->name }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                <span class="text-gray-400 text-sm">No icon</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $category->contact_person ?? '-' }}
                                </p>
                            </div>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $category->telephone ?? '-' }}
                                </p>
                            </div>
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="openEditModal({{ $category->id }})" class="text-yellow-600 hover:text-yellow-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this category?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-4 sm:px-6 text-center text-gray-500">
                            No categories found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <!-- table body end -->
            </table>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center 
           bg-white/10 backdrop-blur-sm">

    <div class="relative w-full max-w-2xl max-h-full p-4">
        <div class="relative p-6 bg-white rounded-xl 
                    shadow-[0_0_15px_rgba(0,0,0,0.18)]
                    dark:bg-gray-800">

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Edit Category
                </h3>
                <button type="button" onclick="closeEditModal()"
                    class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 
                           rounded-lg text-sm w-8 h-8 inline-flex justify-center 
                           items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="edit_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name *</label>
                        <input type="text" name="name" id="edit_name"
                            class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 
                                   focus:ring-blue-500 focus:border-blue-500 
                                   dark:bg-gray-700 dark:border-gray-600 
                                   dark:placeholder-gray-400 dark:text-white" required>
                    </div>

                    <div>
                        <label for="edit_icon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Icon</label>
                        <input type="file" name="icon" id="edit_icon"
                            class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 
                                   focus:ring-blue-500 focus:border-blue-500 
                                   dark:bg-gray-700 dark:border-gray-600" accept="image/*">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank to keep current icon</p>
                        <div id="current_icon_container" class="mt-2">
                            <img id="current_icon" src="" alt="Current icon"
                                class="w-16 h-16 rounded object-cover hidden">
                        </div>
                    </div>

                    <div>
                        <label for="edit_contact_person" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Person</label>
                        <input type="text" name="contact_person" id="edit_contact_person"
                            class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 
                                   focus:ring-blue-500 focus:border-blue-500 
                                   dark:bg-gray-700 dark:border-gray-600">
                    </div>

                    <div>
                        <label for="edit_telephone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telephone</label>
                        <input type="text" name="telephone" id="edit_telephone"
                            class="w-full p-2.5 border border-gray-300 rounded-lg bg-gray-50 
                                   focus:ring-blue-500 focus:border-blue-500 
                                   dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white 
                               border border-gray-300 rounded-lg hover:bg-gray-100 
                               dark:bg-gray-600 dark:text-white">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-700 
                               hover:bg-blue-800 focus:ring-blue-300 rounded-lg 
                               dark:bg-blue-600 dark:hover:bg-blue-700">
                        Update Category
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>



<script>
    function openEditModal(categoryId) {
        // Make an AJAX request to get category data
        fetch(`/admin/categories/${categoryId}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_contact_person').value = data.contact_person || '';
                document.getElementById('edit_telephone').value = data.telephone || '';

                // Set current icon if exists
                const currentIcon = document.getElementById('current_icon');
                const currentIconContainer = document.getElementById('current_icon_container');
                if (data.icon) {
                    currentIcon.src = data.icon;
                    currentIcon.style.display = 'block';
                } else {
                    currentIcon.style.display = 'none';
                }

                document.getElementById('editForm').action = `/admin/categories/${categoryId}`;
                document.getElementById('editModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading category data');
            });
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
</script>
@endsection
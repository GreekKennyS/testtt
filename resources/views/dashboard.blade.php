<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Task Lists') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <button onclick="document.getElementById('createListForm').classList.toggle('hidden')" 
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Create New List
                        </button>
                    </div>

                    <form id="createListForm" class="hidden mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded" 
                          action="{{ route('task-lists.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="title">Title</label>
                            <input type="text" name="title" id="title" required
                                   class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="description">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Create List
                        </button>
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($taskLists as $list)
                            <div class="border dark:border-gray-700 rounded-lg p-4">
                                <h2 class="text-xl font-semibold mb-2">{{ $list->title }}</h2>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $list->description }}</p>
                                
                                <div class="mb-4">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" 
                                             style="width: {{ $list->tasks_count ? ($list->completed_tasks / $list->tasks_count) * 100 : 0 }}%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $list->completed_tasks }}/{{ $list->tasks_count }} tasks completed
                                    </p>
                                </div>

                                <a href="{{ route('task-lists.show', $list) }}" 
                                   class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    View Tasks
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

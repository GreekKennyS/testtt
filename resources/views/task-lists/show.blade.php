<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $taskList->title }}
            </h2>
            <button onclick="document.getElementById('createTaskForm').classList.toggle('hidden')" 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add New Task
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Section -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Task Progress</h3>
                    <div class="mb-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="bg-blue-600 h-2.5 rounded-full" 
                                 style="width: {{ $tasks->count() > 0 ? ($tasks->where('completed', true)->count() / $tasks->count() * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $tasks->where('completed', true)->count() }} of {{ $tasks->count() }} tasks completed
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Priority Breakdown</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">High Priority</span>
                            <span class="text-sm font-semibold text-red-600 dark:text-red-400">
                                {{ $tasks->where('priority', 'high')->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Medium Priority</span>
                            <span class="text-sm font-semibold text-yellow-600 dark:text-yellow-400">
                                {{ $tasks->where('priority', 'medium')->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Low Priority</span>
                            <span class="text-sm font-semibold text-green-600 dark:text-green-400">
                                {{ $tasks->where('priority', 'low')->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Deadline Status</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Upcoming Tasks</span>
                            <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                                {{ $tasks->where('completed', false)->where('deadline', '>', now())->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Overdue Tasks</span>
                            <span class="text-sm font-semibold text-red-600 dark:text-red-400">
                                {{ $tasks->where('completed', false)->where('deadline', '<', now())->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">No Deadline</span>
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">
                                {{ $tasks->whereNull('deadline')->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Create Task Form -->
                    <form id="createTaskForm" class="hidden mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded" 
                          action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="task_list_id" value="{{ $taskList->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-2" for="title">Title</label>
                                <input type="text" name="title" id="title" required
                                       class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-2" for="priority">Priority</label>
                                <select name="priority" id="priority" required
                                        class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-2" for="deadline">Deadline</label>
                                <input type="datetime-local" name="deadline" id="deadline"
                                       class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 dark:text-gray-300 mb-2" for="description">Description</label>
                                <textarea name="description" id="description" rows="3"
                                          class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white"></textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Create Task
                            </button>
                        </div>
                    </form>

                    <!-- Filters and Sorting -->
                    <div class="mb-6 flex gap-4">
                        <select id="priorityFilter" onchange="filterTasks()" 
                                class="px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">All Priorities</option>
                            <option value="high">High Priority</option>
                            <option value="medium">Medium Priority</option>
                            <option value="low">Low Priority</option>
                        </select>
                        
                        <select id="statusFilter" onchange="filterTasks()" 
                                class="px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                        </select>

                        <select id="sortBy" onchange="sortTasks()" 
                                class="px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="deadline">Sort by Deadline</option>
                            <option value="priority">Sort by Priority</option>
                            <option value="title">Sort by Title</option>
                            <option value="created">Sort by Created Date</option>
                        </select>
                    </div>

                    <!-- Tasks List -->
                    <div id="tasksList" class="space-y-4">
                        @foreach($tasks as $task)
                            <div class="task-item border dark:border-gray-700 rounded-lg p-4"
                                 data-priority="{{ $task->priority }}"
                                 data-status="{{ $task->completed ? 'completed' : 'pending' }}"
                                 data-title="{{ $task->title }}"
                                 data-deadline="{{ $task->deadline ? $task->deadline->format('Y-m-d H:i:s') : '' }}"
                                 data-created="{{ $task->created_at->format('Y-m-d H:i:s') }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <form action="{{ route('tasks.toggle-complete', $task) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="mt-1">
                                                <div class="w-6 h-6 border-2 rounded {{ $task->completed ? 'bg-green-500 border-green-500' : 'border-gray-400' }}">
                                                    @if($task->completed)
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                            </button>
                                        </form>
                                        
                                        <div>
                                            <h3 class="font-semibold {{ $task->completed ? 'line-through text-gray-500' : '' }}">
                                                {{ $task->title }}
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-400">{{ $task->description }}</p>
                                            <div class="mt-2 text-sm">
                                                <span class="px-2 py-1 rounded 
                                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                                       ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 
                                                        'bg-green-100 text-green-800') }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                                @if($task->deadline)
                                                    <span class="ml-2 text-gray-500 dark:text-gray-400">
                                                        Due: {{ $task->deadline->format('M d, Y H:i') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex space-x-2">
                                        <button onclick="openEditModal({{ $task->toJson() }})" 
                                                class="text-blue-500 hover:text-blue-700">
                                            Edit
                                        </button>
                                        <form action="{{ route('tasks.destroy', $task) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this task?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div id="editTaskModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">Edit Task</h3>
                <form id="editTaskForm" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="edit_title">Title</label>
                            <input type="text" name="title" id="edit_title" required
                                   class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="edit_priority">Priority</label>
                            <select name="priority" id="edit_priority" required
                                    class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="edit_deadline">Deadline</label>
                            <input type="datetime-local" name="deadline" id="edit_deadline"
                                   class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="edit_description">Description</label>
                            <textarea name="description" id="edit_description" rows="3"
                                      class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Update Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(task) {
            document.getElementById('editTaskModal').classList.remove('hidden');
            document.getElementById('editTaskForm').action = "{{ url('/tasks') }}/" + task.id;
            document.getElementById('edit_title').value = task.title;
            document.getElementById('edit_description').value = task.description || '';
            document.getElementById('edit_priority').value = task.priority;
            if (task.deadline) {
                document.getElementById('edit_deadline').value = task.deadline.slice(0, 16);
            }
        }

        function closeEditModal() {
            document.getElementById('editTaskModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('editTaskModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Filtering and Sorting Functions
        function filterTasks() {
            const priority = document.getElementById('priorityFilter').value;
            const status = document.getElementById('statusFilter').value;
            const tasks = document.querySelectorAll('.task-item');

            tasks.forEach(task => {
                const matchesPriority = !priority || task.dataset.priority === priority;
                const matchesStatus = !status || task.dataset.status === status;
                task.style.display = matchesPriority && matchesStatus ? 'block' : 'none';
            });
        }

        function sortTasks() {
            const sortBy = document.getElementById('sortBy').value;
            const tasksList = document.getElementById('tasksList');
            const tasks = Array.from(tasksList.children);

            const priorityValues = { high: 3, medium: 2, low: 1 };

            tasks.sort((a, b) => {
                switch(sortBy) {
                    case 'deadline':
                        const aDeadline = a.dataset.deadline || '9999-12-31';
                        const bDeadline = b.dataset.deadline || '9999-12-31';
                        return aDeadline.localeCompare(bDeadline);
                    case 'priority':
                        return priorityValues[b.dataset.priority] - priorityValues[a.dataset.priority];
                    case 'title':
                        return a.dataset.title.localeCompare(b.dataset.title);
                    case 'created':
                        return b.dataset.created.localeCompare(a.dataset.created);
                    default:
                        return 0;
                }
            });

            tasksList.innerHTML = '';
            tasks.forEach(task => tasksList.appendChild(task));
        }
    </script>
</x-app-layout> 
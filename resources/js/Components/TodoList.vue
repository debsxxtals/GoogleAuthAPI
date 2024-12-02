<template>
    <div class="min-h-screen bg-gray-100 p-4 flex flex-col items-center">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">My To-Do List</h2>

        <!-- Form for adding tasks -->
        <form
            @submit.prevent="addTask"
            class="flex items-center space-x-4 w-full max-w-md"
        >
            <input
                v-model="newTask"
                type="text"
                placeholder="Add a new task"
                required
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <button
                type="submit"
                class="px-6 py-2 bg-blue-500 text-white font-medium rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
                Add Task
            </button>
        </form>

        <!-- List of tasks -->
        <ul
            class="mt-6 w-full max-w-md bg-white rounded-lg shadow-md p-4 space-y-3"
        >
            <li
                v-for="task in tasks"
                :key="task.id"
                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100"
            >
                <div class="flex items-center space-x-3">
                    <input
                        type="checkbox"
                        v-model="task.completed"
                        @change="updateTask(task)"
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                    />
                    <span
                        :class="{
                            'line-through text-gray-400': task.completed,
                            'text-gray-800': !task.completed,
                        }"
                        class="text-lg font-medium"
                    >
                        {{ task.task }}
                    </span>
                </div>
                <button
                    @click="deleteTask(task.id)"
                    class="px-4 py-2 bg-red-500 text-white font-medium rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                >
                    Delete
                </button>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tasks: [],
            newTask: "",
        };
    },
    mounted() {
        this.fetchTasks();
    },
    methods: {
        fetchTasks() {
            axios.get("/api/tasks").then((response) => {
                this.tasks = response.data;
            });
        },
        addTask() {
            // Sanitize and validate input
            const sanitizedTask = this.newTask.trim(); // Remove leading/trailing spaces
            const isValid =
                sanitizedTask.length > 0 && !/<[^>]*>/.test(sanitizedTask); // Ensure input is not empty and doesn't contain HTML tags

            if (!isValid) {
                alert(
                    "Invalid task. Please enter valid text without HTML tags."
                );
                return;
            }

            // Proceed with adding the task
            axios
                .post("/api/tasks", { task: sanitizedTask })
                .then((response) => {
                    this.tasks.push(response.data);
                    this.newTask = "";
                })
                .catch((error) => {
                    console.error("Error adding task:", error);
                });
        },

        deleteTask(id) {
            axios.delete(`/api/tasks/${id}`).then(() => {
                this.tasks = this.tasks.filter((task) => task.id !== id);
            });
        },
        updateTask(task) {
            axios.put(`/api/tasks/${task.id}`, { completed: task.completed });
        },
    },
};
</script>

<style>
/* You can add additional custom CSS here if needed */
</style>

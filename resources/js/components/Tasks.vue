<template>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Completed</th>
                <th class="px-4 py-2">Created At</th>
                <th class="px-4 py-2">Last Modified</th>
                <th class="px-4 py-2">Priority</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <!-- <tbody> -->
        <draggable v-model="draggableTasks" tag="tbody" @end="handleMoved">
            <!-- <transition-group> -->
            <tr
                v-for="task in draggableTasks"
                :key="task.id"
                class="cursor-pointer"
            >
                <td class="border px-4 py-2">{{ task.name }}</td>
                <td class="border px-4 py-2">
                    {{ task.is_completed ? "Yes" : "No" }}
                </td>
                <td class="border px-4 py-2">{{ task.created_at }}</td>
                <td class="border px-4 py-2">{{ task.updated_at }}</td>
                <td class="border px-4 py-2">#{{ task.priority }}</td>
                <td class="border px-4 py-2 flex justify-center space-x-2">
                    <a
                        :href="`/projects/${project.id}/tasks/${task.id}/edit`"
                        class="bg-gray-300 text-gray-600 px-3 py-3"
                        >Edit</a
                    >
                    <form
                        method="POST"
                        :action="
                            `/projects/${project.id}/completed-tasks/${task.id}`
                        "
                    >
                        <input type="hidden" name="_token" :value="csrf" />
                        <input type="hidden" name="_method" value="PUT" />
                        <button
                            type="submit"
                            class="bg-teal-400 text-white px-3 py-3"
                        >
                            Complete
                        </button>
                    </form>

                    <form
                        method="POST"
                        :action="`/projects/${project.id}/tasks/${task.id}`"
                    >
                        <input type="hidden" name="_token" :value="csrf" />
                        <input type="hidden" name="_method" value="DELETE" />
                        <button
                            type="submit"
                            class="bg-red-400 text-white px-3 py-3"
                        >
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            <!-- </transition-group> -->
        </draggable>

        <!-- </tbody> -->
    </table>
</template>

<script>
import draggable from "vuedraggable";

export default {
    props: ["tasks", "project"],

    components: {
        draggable
    },

    mounted() {
        this.draggableTasks = this.$props.tasks;
    },

    data() {
        return {
            loading: false,
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            draggableTasks: []
        };
    },

    methods: {
        handleMoved() {
            const tasks = this.draggableTasks.map((task, index) => {
                task["newPriority"] = index + 1;
                return task;
            });

            axios.post(`tasks/sync-priorities`, { tasks }).then(res => {
                this.loading = false;
                window.location.reload();
            });
        }
    }
};
</script>

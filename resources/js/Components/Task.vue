<template>
  <div
    class="px-4 py-5 rounded-md flex border items-center mb-2"
    :class="task.is_completed ? 'bg-gray-100' : 'bg-white'"
    @mouseover="showDeleteButton = true"
    @mouseleave="showDeleteButton = false"
  >
    <div class="flex items-center flex-grow">
      <div class="flex items-center h-5">
        <input
          :id="task.identifier"
          type="checkbox"
          class="
            focus:ring-gray-500
            h-6
            w-6
            text-gray-600
            border-gray-300
            rounded
          "
          :checked="task.is_completed"
          @change="updateTask(task.identifier, todolist)"
        />
      </div>
      <div class="ml-3">
        <label
          :for="task.identifier"
          class="text-gray-700"
          :class="{ 'line-through': task.is_completed }"
          >{{ task.title }}</label
        >
      </div>
    </div>
    <div class="ml-3" v-show="showDeleteButton">
      <button @click="deleteTask(task.identifier)">
        <i class="far fa-trash-alt"></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    task: {
      type: Object,
      default: null,
    },
    todolist: {
      type: Object,
    },
  },

  data() {
    return {
      showDeleteButton: false,
    };
  },

  methods: {
    updateTask(identifier, todolist) {
      this.$inertia.put(
        route("tasks.update", {task: identifier}),
        {
          is_completed: !this.task.is_completed,
        },
        {
          preserveScroll: true,
          onSuccess: () => {
            document.activeElement.blur();
          },
        }
      );
    },

    deleteTask(identifier) {
      this.$inertia.delete(route("tasks.destroy", identifier), {
        preserveScroll: true,
        onSuccess: () => {
          document.activeElement.blur();
        },
      });
    },
  },
};
</script>
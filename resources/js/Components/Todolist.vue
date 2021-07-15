<template>
  <div
    class="px-4 py-5 rounded-md flex border items-center mb-2 bg-gray-100"
    @mouseover="showViewButton = true"
    @mouseleave="showViewButton = false"
  >
    <div class="flex items-center flex-grow">
      <div class="ml-3">
        <label
          :for="todolist.identifier"
          class="text-gray-700"
          >{{ todolist.title }}
        </label>
      </div>
    </div>
    <div class="ml-3">
      <button @click="viewTasks(todolist)" v-show="showViewButton">
        <i class="fas fa-eye"></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    todolist: {
      type: Object,
      default: null,
    },
  },

  data() {
    return {
      showViewButton: false,
    };
  },

  methods: {
    updateTodolist(identifier) {
      this.$inertia.put(
        route("todolists.update", identifier),
        {
          is_completed: !this.todolist.is_completed,
        },
        {
          preserveScroll: true,
          onSuccess: () => {
            document.activeElement.blur();
          },
        }
      );
    },
    viewTasks(todolist){
      console.log(todolist);
      this.$inertia.get(route('tasksview.index', todolist.id));
    }
  },
};
</script>
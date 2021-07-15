<template>
  <div>
    <app-layout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Dashboard
        </h2>
      </template>

      <div class="px-12 pb-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
          <contenteditable
            tag="h1"
            class="
              text-5xl
              leading-none
              font-extrabold
              text-gray-900
              tracking-tight
              mb-4
              editable
              p-4
            "
            :contenteditable="true"
            v-model="formTitle.title"
            :noNL="true"
            :noHTML="true"
            @returned="enterPressedOnTitle"
            @blur="blurOnTitle"
            ref="title"
          />
          <div class="flex mb-4">
            <contenteditable
              tag="p"
              class="
                text-lg
                leading-none
                text-gray-900
                bg-gray-200
                tracking-tight
                p-4
                flex-grow
              "
              :contenteditable="true"
              v-model="formNewTask.title"
              :noNL="true"
              :noHTML="true"
              @returned="enterPressedOnNewTask(todolist)"
              @focus="formNewTask.title = null"
              @blur="formNewTask.title = 'Add a task - enter to submit'"
            />
          </div>
          <div>
            <task
              :task="task"
              :todolist = "todolist"
              v-for="task in availableTasks"
              :key="task.identifier"
            ></task>
          </div>
          <hr class="my-4" />
          <div>
            <task
              :task="task"
              v-for="task in completedTasks"
              :key="task.identifier"
            ></task>
          </div>
        </div>
      </div>
    </app-layout>
  </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import JetInput from "@/Jetstream/Input";
import contenteditable from "vue-contenteditable";
import JetButton from "@/Jetstream/Button";
import Task from '../../Components/Task.vue';

export default {
  components: {
    AppLayout,
    Welcome,
    JetInput,
    JetButton,
    contenteditable,
    Task,
  },

  props: {
    tasks: {
      type: Array,
      default: [],
    },
    todolist: {
      type: Object
    }
  },

  data() {
    return {
      formTitle: this.$inertia.form({
        title: "My Tasks - " + "Todolist ("+this.todolist.title+")",
      }),
      formNewTask: this.$inertia.form({
        title: "Add a task - enter to submit",
      }),
    };
  },

  computed: {
    availableTasks() {
      return this.tasks.filter((task) => {
        return !task.is_completed;
      });
    },
    completedTasks() {
      return this.tasks.filter((task) => {
        return task.is_completed;
      });
    },
  },

  methods: {
    enterPressedOnTitle() {
      document.activeElement.blur();
    },

    blurOnTitle() {
      console.log("blurred");
    },

    enterPressedOnNewTask(todolist) {
      this.formNewTask.post(route("tasks.store", todolist), {
        preserveScroll: true,
        onSuccess: () => {
          this.formNewTask.title = "Add a task - enter to submit";
          document.activeElement.blur();
        },
      });
    },
  },
};
</script>

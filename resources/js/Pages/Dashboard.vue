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
              v-model="formNewTodolist.title"
              :noNL="true"
              :noHTML="true"
              @returned="enterPressedOnNewTodolist"
              @focus="formNewTodolist.title = null"
              @blur="formNewTodolist.title = 'Add a todolist - enter to submit'"
            />
          </div>
          <div>
            <todolist
              :todolist="todolist"
              v-for="todolist in availableTodolists"
              :key="todolist.identifier"
            ></todolist>
          </div>
          <hr class="my-4" />
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
import Todolist from '../Components/Todolist.vue';

export default {
  components: {
    AppLayout,
    Welcome,
    JetInput,
    JetButton,
    contenteditable,
    Todolist,
  },

  props: {
    todolists: {
      type: Array,
      default: [],
    },
  },

  data() {
    return {
      formTitle: this.$inertia.form({
        title: "My Todolists",
      }),
      formNewTodolist: this.$inertia.form({
        title: "Add a todolist - enter to submit",
      }),
    };
  },

  computed: {
    availableTodolists() {
      return this.todolists 
    },
    // completedTasks() {
    //   return this.tasks.filter((task) => {
    //     return task.is_completed;
    //   });
    // },
  },

  methods: {
    enterPressedOnTitle() {
      document.activeElement.blur();
    },

    blurOnTitle() {
      console.log("blurred");
    },

    enterPressedOnNewTodolist() {
      this.formNewTodolist.post(route("todolists.store"), {
        preserveScroll: true,
        onSuccess: () => {
          this.formNewTodolist.title = "Add a todolist - enter to submit";
          document.activeElement.blur();
        },
      });
    },
  },
};
</script>

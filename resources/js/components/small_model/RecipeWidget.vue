<script setup lang="ts">
import { Notebook } from 'lucide-vue-next';
import Heading from '../Heading.vue';
import Button from '../ui/button/Button.vue';
import Input from '../ui/input/Input.vue';
import Label from '../ui/label/Label.vue';
import Select from 'primevue/select';

defineProps<{
  title: string,
  subtitle: string,
  recipes: [];
  state?: boolean //true -> is + money // false-> is - storage
}>();

</script>

<template>
  <div class="flex flex-row items-start">
    <div class="justify-self-stretch w-full">
      <Heading class="mb-0" :title="title" :description="subtitle" />
    </div>
    <Button type="button" :tabindex="1" v-if="!state">
      <Notebook />
    </Button>


  </div>
  <div class="flex flex-row">
    <form action="" class="flex flex-row ">
      <div class="grid gap-4">
        <div class="grid grid-flow-col auto-cols-fr gap-2">
          <div class="">
            <Label for="quantity">Receta*</Label>
            <div class="border-2 bg-[#ffffff] dark:bg-[#000000] p-2 rounded-md">
              <Select :tabindex="1" name="recipe" :options="recipes" optionLabel="name" option-value="id"
                placeholder="Receta" class="w-full border" />
            </div>

          </div>
          <div class="">
            <Label for="quantity">Cantidad*</Label>
            <Input min="1" id="quantity" type="number" required autofocus :tabindex="2" placeholder="1" />
            <!-- <InputError :message="form.errors.quantity" /> -->
          </div>

        </div>
        <!-- TODO: Boton funcional -->
        <div class="">
          <Button class="mt-4 rounded-full absolute bottom-0 inset-x-0 mx-8 mb-8" :tabindex="6">
            Guardar
          </Button>
        </div>

      </div>
    </form>
  </div>
</template>
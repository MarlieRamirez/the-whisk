<script setup lang="ts">
import { LoaderCircle, X } from 'lucide-vue-next';
import Heading from '../Heading.vue';
import { useForm } from '@inertiajs/vue3';
import Label from '../ui/label/Label.vue';
import Input from '../ui/input/Input.vue';
import Select from 'primevue/select';
import Button from '../ui/button/Button.vue';
import { reactive } from 'vue';

defineProps<{
  recipes: [];
}>();

const predictions:[any] = reactive([{}]);

const form = useForm({
  recipe_id: 0,
  quantity: 1
});

const submit = () => {
  form.recipe_id = 0;
  form.quantity = 1;
};

const addToList = () =>{

  if(predictions[0].recipe_id == undefined){
    predictions.pop()
  }
  predictions.push({recipe_id: form.recipe_id, quantity: form.quantity})
  
  console.log(predictions)
}

const removeFromList = (index:number) => {
  
}

</script>
<template>
  <div class="">
    <div class="flex flex-row items-start">
      <div class="justify-self-stretch w-full">
        <Heading title="Predicciones" description="Predecir si hay para n recetas" />
      </div>
    </div>
    
    <div class="">
      <form class="flex flex-row w-full">
        <div class="grid gap-4 w-full">

          <div class="grid grid-flow-col auto-cols-fr gap-2 justify-items-stretch place-items-end">
            <div class="">
              <Label for="quantity">Receta*</Label>
              <div class="border-2 bg-[#ffffff] dark:bg-[#000000] p-2 rounded-md">
                <Select :tabindex="1" name="recipe" :options="recipes" optionLabel="name" option-value="id"
                  placeholder="Receta" class="w-full border" v-model="form.recipe_id" />
              </div>

            </div>
            <div class="">
              <Label for="quantity">Cantidad*</Label>
              <Input min="1" id="quantity" type="number" required autofocus :tabindex="2" placeholder="1"
                v-model="form.quantity" />
              <!-- <InputError :message="form.errors.quantity" /> -->
            </div>

            <div class="">
              <Button class="rounded-full w-full mb-1" :tabindex="3" type="button"
                v-on:click="addToList()" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Siguiente
              </Button>
            </div>
          </div>

          <!-- TODO: Boton funcional -->
          <div class="">
            <Button class="mt-4 rounded-full absolute bottom-0 inset-x-0 mx-8 mb-8" :tabindex="3" v-on:click="submit()"
              :disabled="form.processing">
              <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
              Predicción
            </Button>
          </div>

        </div>
      </form>
    </div>

    <ul class="flex flex-row"  v-if="predictions && predictions[0].recipe_id != undefined">
      <li class="flex flex-row align-middle p-2 rounded-full border mx-2 border-rose-950 dark:border-rose-100 bg-rose-100 dark:bg-rose-950/50 " v-for="item, index in predictions" v-bind:key="item.id">
        <p class="mr-8"> {{ item.quantity }} {{ recipes.find((e)=> e.id == item.recipe_id).name || '' }}</p>
        <X height="20" class="my-auto cursor-pointer" v-on:click="predictions.splice(index,1)" />
      </li>
    </ul>
  </div>


</template>
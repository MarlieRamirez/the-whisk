<script setup lang="ts">
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head,useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';



const props = defineProps<{
    model?: {id: string, name:string };
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Secciones de recetas',
        href: '/types'
    },
    {
        title: props.model ? 'Actualizar': 'Agregar',
        href: '/types/new'
    },
];

const title = props.model ? 'Actualizar Sección' : 'Nueva Sección';

const form = useForm({
    id: props.model ? props.model.id : '',
    name: props.model ? props.model.name : ''
});

const submit = () => {
    if(props.model){
        form.put('/types/'+form.id, {});
    }else{
        form.post(route('types.store'), {});
    }
    
};
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbItems" >
        <Head title="Secciones" />
        <div class=" m-3 flex flex-row justify-center">
            
            <form @submit.prevent="submit" class="flex flex-col gap-6 md:w-1/2 border rounded-3xl border-neutral-400 m-3 p-6">
                <p class="text-center text-2xl font-bold">{{ title }}</p>
                <div class="grid gap-6">
                <div class="grid gap-2 ">
                    <Label for="name">Nombre*</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        v-model="form.name"
                        placeholder="Ej. Masa"
                    />
                    <InputError :message="form.errors.name" />
                </div>

            </div>
            <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Insertar
            </Button>
        </form>
        </div>
        
    </AppLayout>
</template>
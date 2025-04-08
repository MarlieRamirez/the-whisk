<script setup lang="ts">
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head,useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { LoaderCircle } from 'lucide-vue-next';

const props= defineProps<{
    model?:{ id:string,name:string, description?:string };
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Categorias',
        href: '/category'
    },
    {
        title: props.model ? 'Actualizar': 'Agregar',
        href: '/category/add'
    },
];

const title = props.model ? 'Actualizar Categoria' : 'Nueva Categoria';

const form = useForm({
    id: props.model ? props.model.id : '',
    name: props.model ? props.model.name : '',
    description: props.model ? props.model.description : '',
});

const submit = () => {
    if(props.model){
        form.put('/category/'+form.id, {});
    }else{
        form.post(route('category.store'), {});
    }
    
};

</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbItems" >
        <Head title="Agregar Categorias" />
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
                        placeholder="Ej. Harinas"
                    />
                    <InputError :message="form.errors.name" />
                </div>

            </div>
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Detalles</Label>
                    <Input
                        id="description"
                        type="description"
                        autofocus
                        :tabindex="1"
                        v-model="form.description"
                        placeholder="Algún detalle"
                    />
                    <InputError :message="form.errors.description" />
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Insertar
                </Button>
            </div>
        </form>
        </div>
        
    </AppLayout>
</template>
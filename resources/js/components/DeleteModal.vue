<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

// Components
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Trash2 } from 'lucide-vue-next';

const props = defineProps<{
    link: string;
    id:string
}>();

const form = useForm({
    password: '',
});

const deleteUser = (e: Event) => {
    e.preventDefault();

    form.delete(route( props.link+'.destroy', props.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <div class="cursor-pointer bg-red-500 hover:bg-red-800 dark:bg-red-200 dark:hover:bg-red-400 rounded-full p-2 mt-4"><Trash2  :size="25" class="stroke-pink-100 dark:stroke-pink-800" /></div>
        </DialogTrigger>
        
        <DialogContent>
            <form class="space-y-6" @submit="deleteUser">
                <DialogHeader class="space-y-3">
                    <DialogTitle>Está seguro que quiere eliminar el registro?</DialogTitle>
                    <DialogDescription>
                        Esta acción es permanente y solo se llevará a cabo si no está siendo usado
                    </DialogDescription>
                </DialogHeader>

                

                <DialogFooter class="gap-2">
                    <DialogClose as-child>
                        <Button variant="secondary" @click="closeModal"> Cancelar </Button>
                    </DialogClose>

                    <Button variant="destructive" :disabled="form.processing">
                        <button type="submit">Eliminar</button>
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>

</template>

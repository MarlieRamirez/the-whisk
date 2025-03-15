<script setup lang="ts">
import { useCurrencyInput } from "vue-currency-input";
import { Input } from '@/components/ui/input';

const props = defineProps({ modelValue: Number});

const { inputRef, formattedValue } = useCurrencyInput(
    {
        currency: 'NIO',
        hideCurrencySymbolOnFocus: false,
        hideGroupingSeparatorOnFocus: false,
        precision: 2,
        valueRange: { min: 0 },
    }
);

</script>

<template>
    <Input ref="inputRef" v-model="formattedValue" />
</template>
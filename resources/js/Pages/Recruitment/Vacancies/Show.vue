<script setup lang="ts">
import {Application, Vacancy} from '../../../types'

defineProps<{
    vacancy: Vacancy,
    contact: {
        name: string,
        email: string
    },
    applications: Application[]
}>()
</script>

<template>
    Show Vacancy
</template>
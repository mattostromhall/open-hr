<template>
    <div class="flex justify-between items-center py-5 px-8 border-b border-gray-200">
        <h3 class="text-xl font-bold leading-6 text-gray-900">
            <slot />
        </h3>
        <slot name="link" />
    </div>
</template>
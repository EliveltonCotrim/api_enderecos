<template>
    <div class="mb-3">
        <label :for="id" class="form-label">{{ title }}</label>
        <slot></slot>

        <div :id="idHelp" class="invalid-feedback">{{ textHelp }}</div>
    </div>
</template>

<script>
export default {
    props: ['id', 'title', 'idHelp', 'textHelp'],

}
</script>

<style></style>

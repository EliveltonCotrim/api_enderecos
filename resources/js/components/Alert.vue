<template>
    <div :class="estilo" role="alert">
        {{ title }}
        <hr>
        <p>{{ detalhes.mensagem }}</p>
        <!-- <br> -->
        <ul v-if="detalhes.dados">
            <li v-for="e, key in detalhes.dados" :key="key">{{ e[0] }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ['tipo', 'mensagem', 'estilo', 'title', 'detalhes'],
    computed: {
        estilo() {
            return 'alert alert-dismissible fade show alert-' + this.tipo
        }
    }
}

</script>

<style></style>


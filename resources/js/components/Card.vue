<template>
    <div class="col">
        <div class="card h-100">
            <div class="card-body">
                <slot></slot>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title', 'subtitle', 'text', 'link1', 'link2'],
    data() {
        return {

        }
    },
}
</script>

<style></style>

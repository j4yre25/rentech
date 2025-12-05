<template>
    <nav class="pagination">
        <ul>
            <li v-for="link in links" :key="link.url" :class="{ active: link.active }">
                <button @click="$emit('navigate', link.url)" :disabled="!link.url">
                    {{ link.label }}
                </button>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        links: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style scoped>
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination ul {
    list-style: none;
    display: flex;
    gap: 5px;
    padding: 0;
}

.pagination ul li {
    margin: 0;
}

.pagination ul li button {
    padding: 5px 10px;
    border: 1px solid #ddd;
    background-color: #fff;
    cursor: pointer;
    border-radius: 4px;
}

.pagination ul li button:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

.pagination ul li.active button {
    background-color: #ffcc00;
    color: #fff;
}
</style>
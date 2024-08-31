<template>
    <td>{{item.id}}</td>
    <td>
        <span :class="[item.completed ? 'completed' : '', 'itemText']">
            {{item.name}}
        </span>
    </td>
    <td>
        <span v-if="item.completed === 1">Done</span>
        <span v-else>Not Done</span>
    </td>
    <td>
        <input type="checkbox" v-show="item.completed == 0" @change="updateCheck()" v-model="item.completed" ref="inputRef" />
        <button @click="openDeleteModal" class="trashcan">
            <font-awesome-icon icon="trash" />
        </button>
    
        <!-- Modal Component -->
        <DeleteModal
        :visible="isModalVisible"
        @confirm="handleDelete"
        @cancel="closeDeleteModal"
        />
    </td>
</template>

<script>
import DeleteModal from './DeleteModal.vue';
export default {
    props: ["item"],
    components: {
        DeleteModal
    },
    data() {
        return {
            isModalVisible: false,
        };
    },
    methods: {
        updateCheck() {
            axios
                .put("api/tasks/" + this.item.id, {
                    completed: 1,
                })
                .then((response) => {
                    if (response.status == 200) {
                        this.$emit('itemChanged');
                    }
                })
                .catch((error) => {
                    return;
                });
        },
        openDeleteModal() {
            this.isModalVisible = true;
        },
        closeDeleteModal() {
            this.isModalVisible = false;
        },
        handleDelete() {
            this.isModalVisible = false;
            axios
                .delete("api/tasks/" + this.item.id)
                .then((response) => {
                    if (response.status == 200) {
                        this.$emit("itemChanged");
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },

    mounted() {
        this.item.completed ? this.$refs.inputRef.checked = true : '';
    },

};
</script>

<style scoped>
.completed {
    text-decoration: line-through;
    color: #999;
}

.itemText {
    width: 100%;
    margin-left: 20px;
}

.item {
    display: flex;
    justify-content: center;
    align-items: center;
}

.trashcan {
    background: #e6e6e6;
    border: none;
    color: #ff0000;
    outline: none;
    cursor: pointer;
}
</style>
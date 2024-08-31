<template>
    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">Php-Simple To Do List App</h2>
            <addItemForm @reloadlist="getList()" />
        </div>
        <listView :items="items" @reloadlist="getList()" />
    </div>
</template>

<script>
import addItemForm from './addItemForm.vue';
import listView from './listView.vue';
import axios from "axios";
export default {
    data() {
        return {
            items: []
        }
    },
    components: {
        addItemForm,
        listView
    },
    methods: {
        getList() {
            axios.get('api/tasks').then((response)=> {
                this.items = response.data.results
            }).catch((error) => {
                console.log(error);
            })
        }
    },
    mounted() {
        this.getList();
    }
}
</script>

<style scoped>
.todoListContainer {
    width: 350px;
    margin: auto;
}

.heading {
    background: #e6e6e6;
    padding: 10px
}

#title {
    text-align: center;
}
</style>